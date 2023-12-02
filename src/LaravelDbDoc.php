<?php

namespace Bekwoh\LaravelDbDoc;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LaravelDbDoc
{
    public static function routes()
    {
        Route::get('doc/db-schema', function () {
            $format = request()->query('format', 'markdown');
            $content = self::content($format);

            if ($format == 'json') {
                return response()->json([
                    'content' => json_decode($content),
                ]);
            }

            if ($format == 'csv') {
                $filename = date('Ymd').self::filename($format);

                return response($content, 200, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                ]);
            }

            return view('laravel-db-doc::markdown', [
                'content' => Str::markdown(
                    $content
                ),
            ]);
        })->middleware(
            config('db-doc.middleware')
        )->name('doc.db-schema');
    }

    public static function content($format)
    {
        throw_if(! in_array($format, ['json', 'markdown', 'csv']));

        return Storage::disk(self::disk($format))->get(self::filename($format));
    }

    public static function disk($format)
    {
        throw_if(! in_array($format, ['json', 'markdown', 'csv']));

        return config("db-doc.presentations.$format.disk");
    }

    public static function filename($format)
    {
        throw_if(! in_array($format, ['json', 'markdown', 'csv']));

        $extension = match ($format) {
             'markdown' => 'md',
             'csv' => 'csv',
             default => 'json',
        };

        return config('app.name')." Database Schema.$extension";
    }
}
