<?php 

namespace Bekwoh\LaravelDbDoc\Presentation;

use Illuminate\Support\Facades\Storage;

class Json
{
    public function __construct(protected array $contents)
    {
        
    }

    public function getDisk()
    {
        return config('db-doc.presentations.json.disk');
    }

    public function getContents()
    {
        return json_encode($this->contents, JSON_PRETTY_PRINT);
    }

    public function write()
    {
        Storage::disk($this->getDisk())
            ->put(
                config('app.name') . ' Database Schema.json', 
                $this->getContents(),
            );
    }
}