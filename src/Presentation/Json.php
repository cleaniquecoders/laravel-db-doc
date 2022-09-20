<?php

namespace Bekwoh\LaravelDbDoc\Presentation;

use Bekwoh\LaravelDbDoc\Contracts\Presenter;

class Json extends AbstractPresenter implements Presenter
{
    public function getContents()
    {
        return json_encode($this->contents, JSON_PRETTY_PRINT);
    }
}
