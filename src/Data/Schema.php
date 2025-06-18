<?php

namespace CleaniqueCoders\LaravelDbDoc\Data;

class Schema
{
    protected array $collections;

    public function __construct(protected $tables, protected $schema) {}

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
            $columns = method_exists($schema, 'listTableColumns')
                ? $schema->listTableColumns($table)
                : $schema->getColumns($table);
            $foreignKeys = collect(
                method_exists($schema, 'listTableForeignKeys')
                ? $schema->listTableForeignKeys($table)
                : $schema->getForeignKeys($table)
            )->keyBy(function ($foreignColumn) {
                if (is_object($foreignColumn) && method_exists($foreignColumn, 'getLocalColumns')) {
                    return $foreignColumn->getLocalColumns()[0];
                }

                return data_get($foreignColumn, 'columns.0');
            });

            foreach ($columns as $column) {
                $columnName = is_object($column) && method_exists($column, 'getName') ? $column->getName() : data_get($column, 'name');
                $columnType = is_object($column) && method_exists($column, 'getType') ? $column->getType()->getName() : data_get($column, 'type_name');
                if (isset($foreignKeys[$columnName])) {
                    $foreignColumn = $foreignKeys[$columnName];
                    $foreignTable = is_object($foreignColumn) && method_exists($foreignColumn, 'getForeignTableName')
                        ? $foreignColumn->getForeignTableName()
                        : data_get($foreignColumn, 'foreign_table');
                    $columnType = 'FK -> '.$foreignTable;
                }
                $length = is_object($column) && method_exists($column, 'getLength') ? $column->getLength() : count($columns);

                $details['column'] = $columnName;
                $details['type'] = $columnType.$this->determineUnsigned($column);
                $details['length'] = $length != 0 ? $length : null;
                $details['default'] = $this->getDefaultValue($column);
                $details['nullable'] = $this->getExpression(
                    is_object($column) && method_exists($column, 'getNotNull')
                    ? ! $column->getNotNull() === true
                    : ! data_get($column, 'nullable')
                );
                $details['comment'] = is_object($column) && method_exists($column, 'getComment')
                    ? $column->getComment()
                    : data_get($column, 'comment');

                $this->collections[$table][] = $details;
            }
        }

        return $this->collections;
    }

    private function determineUnsigned($column)
    {
        if (is_object($column) && method_exists($column, 'getUnsigned')) {
            return ($column->getUnsigned() === true) ? '(unsigned)' : '';
        }

        return str_contains(
            data_get($column, 'type'), 'unsigned'
        ) === true ? '(unsigned)' : '';
    }

    private function getDefaultValue($column)
    {
        if (is_object($column) && method_exists($column, 'getType') && $column->getType()->getName() == 'boolean') {
            return $column->getDefault() ? 'true' : 'false';
        }

        if (is_object($column) && method_exists($column, 'getDefault')) {
            return $column->getDefault();
        }

        return data_get($column, 'default') ? 'true' : 'false';
    }

    private function getExpression($status)
    {
        return $status ? 'Yes' : 'No';
    }
}
