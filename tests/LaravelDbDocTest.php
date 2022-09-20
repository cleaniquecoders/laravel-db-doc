<?php

use Illuminate\Support\Facades\Artisan;

it('has db:schema command', function () {
    $this->assertTrue(in_array('db:schema', array_keys(Artisan::all())));
});
