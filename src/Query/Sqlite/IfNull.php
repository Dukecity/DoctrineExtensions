<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * @author winkbrace <winkbrace@gmail.com>
 */
class IfNull extends FunctionNode
{
    private $expr1;

    private $expr2;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'IFNULL('
            . $sqlWalker->walkArithmeticPrimary($this->expr1)
            . ', '
            . $sqlWalker->walkArithmeticPrimary($this->expr2)
            . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_COMMA);
        $this->expr2 = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
