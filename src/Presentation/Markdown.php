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

        foreach ($contents as $table => $rows) {
            // Normalize & de-duplicate rows for this table
            // Supports both list-style rows and associative rows.
            $order = ['column', 'type', 'length', 'default', 'nullable', 'comment'];

            $unique = [];
            foreach ($rows as $row) {
                if (is_array($row) && array_is_list($row)) {
                    // Already positional
                    $cells = array_map(fn ($v) => trim((string) $v), $row);
                } else {
                    // Map associative row to the expected column order
                    $cells = [];
                    foreach ($order as $k) {
                        $cells[] = isset($row[$k]) ? trim((string) $row[$k]) : '';
                    }
                }

                // Key for dedupe (stable & whitespace-normalized)
                $key = implode('||', $cells);
                if (! isset($unique[$key])) {
                    $unique[$key] = $cells;
                }
            }

            // Render table
            $output[] = '### '.$table.PHP_EOL.PHP_EOL;
            $output[] = '| Column | Type | Length | Default | Nullable | Comment |'.PHP_EOL;
            $output[] = '|--------|------|--------|---------|----------|---------|'.PHP_EOL;

            foreach ($unique as $cells) {
                // Ensure exactly 6 cells
                $cells = array_pad($cells, 6, '');
                $output[] = '| '.implode(' | ', $cells).' |'.PHP_EOL;
            }

            $output[] = PHP_EOL;
        }

        $schema = implode('', $output);
        $stub = $this->getStub();

        $database_config = config('database.connections.'.$this->connection);
        $host = $database_config['host'] ?? null;
        $port = $database_config['port'] ?? null;

        return str_replace(
            [
                'APP_NAME',
                'DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE',
                'SCHEMA_CONTENT',
            ],
            [
                config('app.name'),
                $this->connection, $host, $port, $database_config['database'],
                $schema,
            ],
            $stub
        );
    }
}
