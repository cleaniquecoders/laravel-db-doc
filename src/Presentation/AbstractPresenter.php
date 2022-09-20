<?php

namespace Bekwoh\LaravelDbDoc\Presentation;

use Bekwoh\LaravelDbDoc\Contracts\Presenter;
use Bekwoh\LaravelDbDoc\Facades\LaravelDbDoc;
use Illuminate\Support\Facades\Storage;

abstract class AbstractPresenter implements Presenter
{
    abstract public function getContents();

    public function __construct(protected array $contents)
    {
    }

    public static function make(array $contents): self
    {
        return new self($contents);
    }

    public function getDisk()
    {
        return LaravelDbDoc::disk(strtolower(basename(__CLASS__)));
    }

    public function getFilename()
    {
        return LaravelDbDoc::filename(strtolower(basename(__CLASS__)));
    }

    public function getStub()
    {
        return file_get_contents(
            base_path('stubs/db-doc.stub')
        );
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
}
