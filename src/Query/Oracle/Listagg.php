<?php

namespace DoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\AST\OrderByClause;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * @link https://docs.oracle.com/en/database/oracle/oracle-database/19/sqlrf/LISTAGG.html#GUID-B6E50D8E-F467-425B-9436-F7F8BF38D466
 * @author Alexey Kalinin <nitso@yandex.ru>
 */
class Listagg extends FunctionNode
{
    public ?Node $separator = null;

    public ?Node $listaggField = null;

    public OrderByClause $orderBy;

    /**
     * @var Node[]
     */
    public array $partitionBy = [];

    /**
     * @inheritdoc
     */
    public function parse(Parser $parser): void
    {
        $lexer = $parser->getLexer();

        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->listaggField = $parser->StringPrimary();

        if ($lexer->isNextToken(TokenType::T_COMMA)) {
            $parser->match(TokenType::T_COMMA);
            $this->separator = $parser->StringExpression();
        }
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);

        if (!$lexer->isNextToken(TokenType::T_IDENTIFIER) || strtolower($lexer->lookahead->value) != 'within') {
            $parser->syntaxError('WITHIN GROUP');
        }
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_GROUP);

        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->orderBy = $parser->OrderByClause();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);

        if ($lexer->isNextToken(TokenType::T_IDENTIFIER)) {
            if (strtolower($lexer->lookahead->value) != 'over') {
                $parser->syntaxError('OVER');
            }
            $parser->match(TokenType::T_IDENTIFIER);
            $parser->match(TokenType::T_OPEN_PARENTHESIS);

            if (!$lexer->isNextToken(TokenType::T_IDENTIFIER) || strtolower($lexer->lookahead->value) != 'partition') {
                $parser->syntaxError('PARTITION BY');
            }
            $parser->match(TokenType::T_IDENTIFIER);
            $parser->match(TokenType::T_BY);

            $this->partitionBy[] = $parser->StringPrimary();

            while ($lexer->isNextToken(TokenType::T_COMMA)) {
                $parser->match(TokenType::T_COMMA);
                $this->partitionBy[] = $parser->StringPrimary();
            }

            $parser->match(TokenType::T_CLOSE_PARENTHESIS);
        }
    }

    /**
     * @inheritdoc
     */
    public function getSql(SqlWalker $sqlWalker): string
    {
        $result = 'LISTAGG(' . $this->listaggField->dispatch($sqlWalker);
        if ($this->separator) {
            $result .= ', ' . $sqlWalker->walkStringPrimary($this->separator) . ')';
        } else {
            $result .= ')';
        }

        $result .= ' WITHIN GROUP (' . ltrim($sqlWalker->walkOrderByClause($this->orderBy)) . ')';

        if (count($this->partitionBy)) {
            $partitionBy = [];
            foreach ($this->partitionBy as $part) {
                $partitionBy[] = $part->dispatch($sqlWalker);
            }

            $result .= ' OVER (PARTITION BY ' . implode(', ', $partitionBy) . ')';
        }

        return $result;
    }
}
