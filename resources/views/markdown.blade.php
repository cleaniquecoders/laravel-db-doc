<!DOCTYPE html>
{{--
    Self-contained schema documentation page. Deliberately free of host-app
    Blade components (layouts, Jetstream, etc.) so the package renders — and
    the host app's `view:cache` compiles — in any application.
--}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ config('app.name') }} · Database Schema</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f4f5; color: #18181b; font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; }
        .wrap { max-width: 56rem; margin: 0 auto; padding: 2.5rem 1rem 4rem; }
        .card { background: #ffffff; border: 1px solid #e4e4e7; border-radius: 0.5rem; padding: 2rem; overflow-x: auto; }
        .card h1 { font-size: 1.5rem; margin-top: 0; }
        .card h2 { font-size: 1.25rem; margin-top: 2rem; border-bottom: 1px solid #e4e4e7; padding-bottom: 0.25rem; }
        .card h3 { font-size: 1.05rem; }
        .card table { width: 100%; border-collapse: collapse; font-size: 0.875rem; margin: 1rem 0; }
        .card th, .card td { border: 1px solid #e4e4e7; padding: 0.4rem 0.6rem; text-align: left; vertical-align: top; }
        .card th { background: #fafafa; }
        .card code { background: #f4f4f5; border-radius: 0.25rem; padding: 0.1rem 0.35rem; font-size: 0.85em; }
        .card pre { background: #f4f4f5; border-radius: 0.375rem; padding: 0.75rem; overflow-x: auto; }
        .card pre code { background: transparent; padding: 0; }
        .card a { color: #059669; }
        .meta { text-align: center; font-size: 0.75rem; color: #71717a; margin-top: 1.5rem; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            {!! $content !!}
        </div>
        <p class="meta">{{ config('app.name') }} — generated {{ now()->toDayDateTimeString() }}</p>
    </div>
</body>
</html>
