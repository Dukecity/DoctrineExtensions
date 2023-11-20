<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * @example SELECT REGEXP_SUBSTR('abc def ghi', '[a-z]+');
 * @link https://dev.mysql.com/doc/refman/8.0/en/regexp.html#function_regexp-substr
 */
class RegexpSubStr extends FunctionNode
{
    public $field = null;

    public $regex = null;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'REGEXP_SUBSTR(' .
            $this->field->dispatch($sqlWalker) . ', ' .
            $this->regex->dispatch($sqlWalker) .
        ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->field = $parser->StringPrimary();

        $parser->match(TokenType::T_COMMA);

        $this->regex = $parser->StringExpression();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
