<?php

namespace Bekwoh\LaravelDbDoc\Contracts;

interface Presenter
{
    public static function make(array $contents): self;
    
    public function getDisk();

    public function getFilename();

    public function getContents();

    public function getStub();

    public function write();

    public function read();
}
