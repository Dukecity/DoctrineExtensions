<?php

namespace DoctrineExtensions\Query\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * @author Vincent Mariani <mariani.v@sfeir.com>
 */
class Quarter extends FunctionNode
{
    public $quarter;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return "CAST(((STRFTIME('%m', {$sqlWalker->walkArithmeticPrimary($this->quarter)}) + 2) / 3) as NUMBER)";
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->quarter = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
