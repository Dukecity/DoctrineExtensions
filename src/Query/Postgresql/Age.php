<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

class Age extends FunctionNode
{
    public $date1 = null;

    public $date2 = null;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'AGE('.$this->date1->dispatch($sqlWalker).', '.$this->date2->dispatch($sqlWalker).')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->date1 = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->date2 = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
