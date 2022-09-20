<?php

namespace Bekwoh\LaravelDbDoc;

use Bekwoh\LaravelDbDoc\Contracts\Presenter;
use Bekwoh\LaravelDbDoc\Data\Schema;
use Illuminate\Support\Facades\DB;

class Processor
{
    protected array $data;

    protected $schema;

    protected $tables;

    protected $connection;

    protected $database_connection;

    protected string $presenter;

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
        throw_if(! in_array(Presenter::class, class_implements($this->presenter)));

        $this->presenter::make($this->data)
            ->connection($this->database_connection)
            ->write();
    }

    public function connect(string $database_connection, string $format): self
    {
        $this->database_connection = $database_connection;
        $this->presenter = config('db-doc.presentations.'.$format.'.class');

        throw_if(! class_exists($this->presenter), 'RuntimeException', "$this->presenter not exists.");

        $this->connection = DB::connection($this->database_connection)->getDoctrineConnection();
        $this->schema = $this->connection->createSchemaManager();
        $this->tables = $this->schema->listTableNames();

        return $this;
    }
}
