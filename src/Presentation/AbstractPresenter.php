<?php

namespace Bekwoh\LaravelDbDoc\Presentation;

use Bekwoh\LaravelDbDoc\Contracts\Presenter;
use Bekwoh\LaravelDbDoc\Facades\LaravelDbDoc;
use Illuminate\Support\Facades\Storage;

abstract class AbstractPresenter implements Presenter
{
    protected string $connection;

    abstract public function getContents();

    public function __construct(protected array $contents)
    {
    }

    public function getDisk()
    {
        return LaravelDbDoc::disk(strtolower(class_basename($this)));
    }

    public function getFilename()
    {
        return LaravelDbDoc::filename(strtolower(class_basename($this)));
    }

    public function getStub()
    {
        $path = file_exists(
            base_path('stubs/db-doc.stub')
        ) ? base_path('stubs/db-doc.stub') : __DIR__ . '/../../stubs/db-doc.stub';

        return file_get_contents($path);
    }

    public function write()
    {
        Storage::disk($this->getDisk())
            ->put(
                $this->getFilename(),
                $this->getContents()
            );
    }

    public function read()
    {
        return Storage::disk($this->getDisk())
            ->get($this->getFilename());
    }

    public function connection(string $connection): self
    {
        $this->connection = $connection;

        return $this;
    }
}
