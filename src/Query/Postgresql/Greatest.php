<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * @author Vas N <phpvas@gmail.com>
 * @author Guven Atbakan <guven@atbakan.com>
 * @author Leonardo B Motyczka <leomoty@gmail.com>
 */
class Greatest extends FunctionNode
{
    private $field = null;

    private $values = [];

    /**
     * @param SqlWalker $sqlWalker
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker): string
    {
        $query = 'GREATEST(';

        $query .= $this->field->dispatch($sqlWalker);

        $query .= ', ';

        for ($i = 0, $iMax = count($this->values); $i < $iMax; $i++) {
            if ($i > 0) {
                $query .= ', ';
            }

            $query .= $this->values[$i]->dispatch($sqlWalker);
        }

        $query .= ')';

        return $query;
    }

    /**
     * @param Parser $parser
     */
    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->field = $parser->ArithmeticExpression();
        $lexer = $parser->getLexer();

        while (count($this->values) < 1 ||
            $lexer->lookahead->type != TokenType::T_CLOSE_PARENTHESIS) {
            $parser->match(TokenType::T_COMMA);
            $this->values[] = $parser->ArithmeticExpression();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
