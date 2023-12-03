<?php

namespace CleaniqueCoders\LaravelDbDoc\Presentation;

use CleaniqueCoders\LaravelDbDoc\Contracts\Presenter;

class Json extends AbstractPresenter implements Presenter
{
    public static function make(array $contents): self
    {
        return new self($contents);
    }

    public function getContents()
    {
        return json_encode($this->contents, JSON_PRETTY_PRINT);
    }
}
