<?php

namespace Harish\LaravelDuckdb\Schema;

use Illuminate\Database\Schema\Grammars\PostgresGrammar;
use Illuminate\Support\Fluent;

class Grammar extends PostgresGrammar
{
    protected $transactions = false;

    public function __construct($connection = null)
    {
        if ($connection) {
            parent::__construct($connection);
        }
    }

    protected function typeInteger(Fluent $column)
    {
        return 'integer';
    }

    protected function typeBigInteger(Fluent $column)
    {
        return 'bigint';
    }

    protected function typeSmallInteger(Fluent $column)
    {
        return 'smallint';
    }
}
