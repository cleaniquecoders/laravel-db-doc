<?php

namespace Bekwoh\LaravelDbDoc;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LaravelDbDoc
{
    public static function routes()
    {
        if(app()->environment() != 'production') {
            Route::get('doc/db-schema', function () {

                $format = request()->query('format', 'markdown');

                $filename = self::filename($format);
                $view = self::view($format);
                $content = self::content($format);

                $filepath = config('database.doc_schema_path') . DIRECTORY_SEPARATOR . $filename;
        
                abort_if(! file_exists($filepath), 404, 'Database schema document not yet generated. Do run php artisan db:schema to generate the schema document.');
        

                if($format == 'json') {
                    return response()->json([
                        'content' => json_decode($content)
                    ]);
                }

                return view('db-doc::markdown', [
                    'content' => Str::markdown(
                        $content
                    ),
                ]);
            });
        }
    }

    public function content($format)
    {
        throw_if(!in_array($format, ['json', 'markdown']));

        return Storage::disk(self::disk($format))->get(self::filename($format));
    }

    public static function disk($format)
    {
        throw_if(!in_array($format, ['json', 'markdown']));

        return config("db-doc.presentations.$format.disk");
    }

    public static function filename($format)
    {
        throw_if(!in_array($format, ['json', 'markdown']));

        $extension = $format != 'markdown' ? 'json' : 'md';

        return config('app.name'). " Database Schema.$extension";
    }

    public static function view($format)
    {
        throw_if(!in_array($format, ['json', 'markdown']));

        return config("db-doc.presentations.$format.view");
    }
}
