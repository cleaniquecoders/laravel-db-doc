<?php

namespace CleaniqueCoders\LaravelDbDoc\Data;

class Schema
{
    protected array $collections;

    public function __construct(protected $tables, protected $schema)
    {
    }

    public static function make($tables, $schema)
    {
        return new self($tables, $schema);
    }

    public function getData()
    {
        $tables = $this->tables;
        $schema = $this->schema;

        $this->collections = [];
        foreach ($tables as $table) {
            $columns = $schema->listTableColumns($table);
            $foreignKeys = collect($schema->listTableForeignKeys($table))->keyBy(function ($foreignColumn) {
                return $foreignColumn->getLocalColumns()[0];
            });

            foreach ($columns as $column) {
                $columnName = $column->getName();
                $columnType = $column->getType()->getName();
                if (isset($foreignKeys[$columnName])) {
                    $foreignColumn = $foreignKeys[$columnName];
                    $foreignTable = $foreignColumn->getForeignTableName();
                    $columnType = 'FK -> '.$foreignTable;
                }
                $length = $column->getLength();

                $details['column'] = $columnName;
                $details['type'] = $columnType.$this->determineUnsigned($column);
                $details['length'] = $length != 0 ? $length : null;
                $details['default'] = $this->getDefaultValue($column);
                $details['nullable'] = $this->getExpression(! $column->getNotNull() === true);
                $details['comment'] = $column->getComment();

                $this->collections[$table][] = $details;
            }
        }

        return $this->collections;
    }

    private function determineUnsigned($column)
    {
        return ($column->getUnsigned() === true) ? '(unsigned)' : '';
    }

    private function getDefaultValue($column)
    {
        if ($column->getType()->getName() == 'boolean') {
            return $column->getDefault() ? 'true' : 'false';
        }

        return $column->getDefault();
    }

    private function getExpression($status)
    {
        return $status ? 'Yes' : 'No';
    }
}
