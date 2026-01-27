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

    protected function typeTimestamp(Fluent $column)
    {
        return 'timestamp';
    }

    protected function typeTimestampTz(Fluent $column)
    {
        return 'timestamp with time zone';
    }

    protected function typeSerial(Fluent $column)
    {
        return 'integer';
    }
    
    protected function typeBigSerial(Fluent $column)
    {
        return 'bigint';
    }

    protected function compileUnique(Blueprint $blueprint, Fluent $command)
    {
        // DuckDB не підтримує ALTER TABLE ADD CONSTRAINT UNIQUE
        // Використовуємо CREATE UNIQUE INDEX натомість
        return sprintf('create unique index %s on %s (%s)',
            $this->wrap($command->index),
            $this->wrapTable($blueprint),
            $this->columnize($command->columns)
        );
    }
}
