<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\ASTException;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

class Ilike extends FunctionNode
{
    /** @var Node */
    protected $field;

    /** @var Node */
    protected $query;

    /**
     * @param SqlWalker $sqlWalker
     *
     * @throws ASTException
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker): string
    {
        return '(' . $this->field->dispatch($sqlWalker) . ' ILIKE ' . $this->query->dispatch($sqlWalker) . ')';
    }

    /**
     * @param Parser $parser
     *
     * @throws QueryException
     */
    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->field = $parser->StringExpression();
        $parser->match(TokenType::T_COMMA);
        $this->query = $parser->StringExpression();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
