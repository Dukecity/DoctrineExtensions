<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * @link https://dev.mysql.com/doc/refman/8.0/en/spatial-convenience-functions.html#function_st-distance-sphere
 */
class StDistanceSphere extends FunctionNode
{
    public $origin;

    public $remote;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'ST_DISTANCE_SPHERE(%s, %s)',
            $this->origin->dispatch($sqlWalker),
            $this->remote->dispatch($sqlWalker)
        );
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->origin = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->remote = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
