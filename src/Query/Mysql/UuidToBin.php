<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class UuidToBin extends FunctionNode
{
    public $stringUuid = null;

    public $swapFlag = null;

    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->stringUuid = $parser->ArithmeticPrimary();

        if (Lexer::T_COMMA === $parser->getLexer()->lookahead->type) {
            $parser->match(Lexer::T_COMMA);
            $this->swapFlag = $parser->Literal();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        $sql = 'UUID_TO_BIN(' . $this->stringUuid->dispatch($sqlWalker);
        if ($this->swapFlag !== null) {
            $sql .= ', ' . $this->swapFlag->dispatch($sqlWalker);
        }
        $sql .= ')';

        return $sql;
    }
}
