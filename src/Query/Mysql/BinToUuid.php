<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

class BinToUuid extends FunctionNode
{
    public $binaryUuid = null;

    public $swapFlag = null;

    public function getSql(SqlWalker $sqlWalker): string
    {
        $sql = 'BIN_TO_UUID(' . $this->binaryUuid->dispatch($sqlWalker);
        if ($this->swapFlag !== null) {
            $sql .= ', ' . $this->swapFlag->dispatch($sqlWalker);
        }
        $sql .= ')';

        return $sql;
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->binaryUuid = $parser->ArithmeticPrimary();

        if (TokenType::T_COMMA === $parser->getLexer()->lookahead->type) {
            $parser->match(TokenType::T_COMMA);
            $this->swapFlag = $parser->Literal();
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
