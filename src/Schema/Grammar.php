<?php

namespace Harish\LaravelDuckdb\Schema;

use Illuminate\Database\Schema\Blueprint;
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

    protected function typeBigSerial(Fluent $column)
    {
        return 'bigint';
    }

    protected function typeBigInteger(Fluent $column)
    {
        return 'bigint';
    }

    protected function typeSerial(Fluent $column)
    {
        return 'integer';
    }

    protected function typeInteger(Fluent $column)
    {
        return 'integer';
    }

    protected function typeSmallInteger(Fluent $column)
    {
        return 'smallint';
    }

    protected function typeString(Fluent $column)
    {
        //DuckDB supports VARCHAR with or without length
        return $column->length ? "varchar({$column->length})" : 'varchar';
    }

    /*** DuckDB does not support precision in TIMESTAMP through parentheses ***/
    protected function typeTimestamp(Fluent $column)
    {
        return 'timestamp'; // Default microsecond precision
    }

    protected function typeTimestampMs(Fluent $column)
    {
        return 'timestamp_ms';
    }

    protected function typeTimestampS(Fluent $column)
    {
        return 'timestamp_s';
    }

    protected function typeTimestampNs(Fluent $column)
    {
        return 'timestamp_ns';
    }

    protected function typeTimestampTz(Fluent $column)
    {
        // DuckDB uses timestamptz or timestamp with time zone
        return 'timestamptz';
    }

    protected function modifyDefault(Blueprint $blueprint, Fluent $column)
    {
        if (! is_null($column->default)) {
            return ' default '.$this->getDefaultValue($column->default);
        }

        return '';
    }

    protected function modifyNullable(Blueprint $blueprint, Fluent $column)
    {
        if ($column->nullable) {
            return '';
        }

        return ' not null';
    }

    public function compileUnique(Blueprint $blueprint, Fluent $command)
    {
        // DuckDB does not support ALTER TABLE ADD CONSTRAINT UNIQUE
        // Using CREATE UNIQUE INDEX instead
        return sprintf('create unique index %s on %s (%s)',
            $this->wrap($command->index),
            $this->wrapTable($blueprint),
            $this->columnize($command->columns)
        );
    }
}
