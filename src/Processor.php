<?php

namespace Bekwoh\LaravelDbDoc;

use Bekwoh\LaravelDbDoc\Contracts\Presenter;
use Bekwoh\LaravelDbDoc\Data\Schema;
use Illuminate\Support\Facades\DB;

class Processor
{
    protected array $data;

    protected Presenter $presenter;

    public function __construct()
    {
        logger()->info('Start processing at '.now()->format('Y-m-d H:i:s'));
    }

    public function __destruct()
    {
        logger()->info('End processing at '.now()->format('Y-m-d H:i:s'));
    }

    public static function make()
    {
        return new self();
    }

    public function process()
    {
        $this->data = Schema::make($this->tables, $this->schema)->getData();

        return $this;
    }

    public function render()
    {
        $this->presenter::make($this->data)->write();
    }

    public function connect(string $connection, string $format): self
    {
        $this->database_connection = $connection;
        $this->presenter = config('db-doc.presentations.'.$format.'.class');

        throw_if(! class_exists($this->format), 'RuntimeException', "$this->format not exists.");

        $this->connection = DB::connection($this->database_connection)->getDoctrineConnection();
        $this->schema = $this->connection->getSchemaManager();
        $this->tables = $this->schema->listTableNames();

        return $this;
    }
}
