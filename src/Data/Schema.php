<?php 

namespace Bekwoh\LaravelDbDoc\Data;

class Schema 
{
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
                    $columnType = 'FK -> ' . $foreignTable;
                }
                $length = $column->getLength();

                $details['column'] = $columnName;
                $details['type'] = $columnType . $this->determineUnsigned($column);
                $details['length'] = $length != 0 ? $length : null;
                $details['default'] = $this->getDefaultValue($column);
                $details['nullable'] = $this->getExpression(true === ! $column->getNotNull());
                $details['comment'] = $column->getComment();
                $this->collections[$table][] = $details;
            }
        }

        return $this->collections;
    }

    private function determineUnsigned($column)
    {
        return (true === $column->getUnsigned()) ? '(unsigned)' : '';
    }

    private function getDefaultValue($column)
    {
        if ('boolean' == $column->getType()->getName()) {
            return $column->getDefault() ? 'true' : 'false';
        }

        return $column->getDefault();
    }

    private function getExpression($status)
    {
        return $status ? 'Yes' : 'No';
    }
}