<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class BinToUuid extends FunctionNode
{
    private Node|string|null $firstExpression = null;

    private Node|string|null $secondExpression = null;

    public function parse(Parser $parser): void
    {
        $lexer = $parser->getLexer();
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->firstExpression = $parser->ArithmeticPrimary();

        // parse second parameter if available
        if (Lexer::T_COMMA === $lexer->lookahead['type']) {
            $parser->match(Lexer::T_COMMA);
            $this->secondExpression = $parser->ArithmeticPrimary();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        if (null !== $this->secondExpression) {
            return 'BIN_TO_UUID('
                . $this->firstExpression->dispatch($sqlWalker)
                . ', '
                . $this->secondExpression->dispatch($sqlWalker)
                . ')';
        }

        return 'BIN_TO_UUID(' . $this->firstExpression->dispatch($sqlWalker) . ')';
    }
}
