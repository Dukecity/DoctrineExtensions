<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * @author Toni Uebernickel <tuebernickel@gmail.com>
 */
class Std extends FunctionNode
{
    public $arithmeticExpression;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf('STD(%s)', $sqlWalker->walkSimpleArithmeticExpression($this->arithmeticExpression));
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->arithmeticExpression = $parser->SimpleArithmeticExpression();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
