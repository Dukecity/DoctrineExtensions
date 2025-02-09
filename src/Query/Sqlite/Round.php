<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * @author winkbrace <winkbrace@gmail.com>
 */
class Round extends FunctionNode
{
    private $firstExpression = null;

    private $secondExpression = null;

    public function getSql(SqlWalker $sqlWalker): string
    {
        // use second parameter if parsed
        if (null !== $this->secondExpression) {
            return 'ROUND('
                . $this->firstExpression->dispatch($sqlWalker)
                . ', '
                . $this->secondExpression->dispatch($sqlWalker)
                . ')';
        }

        return 'ROUND(' . $this->firstExpression->dispatch($sqlWalker) . ')';
    }

    public function parse(Parser $parser): void
    {
        $lexer = $parser->getLexer();
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->firstExpression = $parser->SimpleArithmeticExpression();

        // parse second parameter if available
        if (TokenType::T_COMMA === $lexer->lookahead->type) {
            $parser->match(TokenType::T_COMMA);
            $this->secondExpression = $parser->ArithmeticPrimary();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
