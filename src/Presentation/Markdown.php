<?php

namespace Bekwoh\LaravelDbDoc\Presentation;

use Bekwoh\LaravelDbDoc\Contracts\Presenter;
use Illuminate\Support\Str;

class Markdown extends AbstractPresenter implements Presenter
{
    public function getContents()
    {
        $contents = $this->contents;
        $output = [];
        foreach ($contents as $table => $properties) {
            $table = preg_replace('/[^A-Za-z0-9]/', ' ', $table);
            $output[] = '### '.Str::title($table).PHP_EOL.PHP_EOL;
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
        $database_config = config('database.connections.'.$this->database_connection);
        $host = isset($database_config['host']) ? $database_config['host'] : null;
        $port = isset($database_config['port']) ? $database_config['port'] : null;

        return str_replace([
            'APP_NAME',
            'DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE',
            'SCHEMA_CONTENT',
        ], [
            config('app.name'),
            $this->database_connection, $host, $port, $database_config['database'],
            $schema,
        ], $stub);
    }
}
