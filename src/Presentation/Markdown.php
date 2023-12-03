<?php

namespace CleaniqueCoders\LaravelDbDoc\Presentation;

use CleaniqueCoders\LaravelDbDoc\Contracts\Presenter;

class Markdown extends AbstractPresenter implements Presenter
{
    public static function make(array $contents): self
    {
        return new self($contents);
    }

    public function getContents()
    {
        $contents = $this->contents;
        $output = [];
        foreach ($contents as $table => $properties) {
            $output[] = '### '.$table.PHP_EOL.PHP_EOL;
            $output[] = '| Column | Type | Length | Default | Nullable | Comment |'.PHP_EOL;
            $output[] = '|--------|------|--------|---------|----------|---------|'.PHP_EOL;
            foreach ($properties as $key => $value) {
                $fields = [];
                foreach ($value as $k => $v) {
                    $fields[] = "{$v}";
                }
                $output[] = '| '.implode(' | ', $fields).' |'.PHP_EOL;
            }
            $output[] = PHP_EOL;
        }

        $schema = implode('', $output);
        $stub = $this->getStub();
        $database_config = config('database.connections.'.$this->connection);
        $host = isset($database_config['host']) ? $database_config['host'] : null;
        $port = isset($database_config['port']) ? $database_config['port'] : null;

        return str_replace([
            'APP_NAME',
            'DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE',
            'SCHEMA_CONTENT',
        ], [
            config('app.name'),
            $this->connection, $host, $port, $database_config['database'],
            $schema,
        ], $stub);
    }
}
