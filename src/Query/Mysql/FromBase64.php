<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * "FROM_BASE64" "(" "$fieldIdentifierExpression" ")"
 *
 * @example SELECT FROM_BASE64(foo) FROM dual;
 *
 * @link https://dev.mysql.com/doc/refman/en/string-functions.html#function_from-base64
 */
class FromBase64 extends FunctionNode
{
    public $field = null;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'FROM_BASE64(' . $this->field->dispatch($sqlWalker) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->field = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
