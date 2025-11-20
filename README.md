# Nova Custom Errors

Custom error pages for Laravel Nova, provided as a small middleware package.

- Package: `next-tecnology/nova-custom-errors`
- PHP: ^8.2 | ^8.3 | ^8.4
- Nova: ^4.0 | ^5.0

## 1) Install

```bash
composer require next-tecnology/nova-custom-errors
```

The service provider is auto-discovered via Composer; no manual registration is needed.

## 2) Add the middleware to Nova

Edit `config/nova.php` and add the middleware to Nova's middleware stack. Place it after the standard Nova middleware so it can intercept responses and render the appropriate error views.

```php
// config/nova.php
return [
    // ...
    'middleware' => [
        'web',
       .....
        \NextTecnology\NovaCustomErrors\Http\Middleware\HandleNovaErrors::class,
        .....
    ],
    // ...
];
```

That’s it. The middleware will check the response status code and, if it is greater than 400, attempt to render a matching view from this package.

## 3) Customizing the error views (optional)

By default, the package ships with views that are used immediately without any publishing. If you want to customize them, publish the views to your application and edit them as needed:

```bash
php artisan vendor:publish \
  --provider="NextTecnology\\NovaCustomErrors\\NovaCustomErrorsServiceProvider" \
  --tag="nova-custom-errors-views"
```

This will copy the views to:

```
resources/views/vendor/nova-custom-errors/
```

Available default views in the package:

- `401.blade.php`
- `402.blade.php`
- `403.blade.php`
- `404.blade.php`
- `419.blade.php`
- `429.blade.php`
- `500.blade.php`
- `503.blade.php`

The middleware looks up views by status code using the namespace `nova-custom-errors::`. For example, a 404 response will try to render `nova-custom-errors::404` (or your published override at `resources/views/vendor/nova-custom-errors/404.blade.php`).

## How it works

The middleware `HandleNovaErrors` inspects the response returned by Nova and, for status codes > 400, tries to render a view named after that status code:

```php
$view = 'nova-custom-errors::' . $response->getStatusCode();
if (view()->exists($view)) {
    return response()->view($view);
}
```

If no matching view exists, the original response is returned unchanged.

## Verifying

- Trigger a known error within Nova (e.g., visit a non-existent Nova resource) and you should see the corresponding custom error page.
- If you customized views, ensure your edited versions appear under `resources/views/vendor/nova-custom-errors/`.

## Troubleshooting

- "Class not found" for the middleware: run `composer dump-autoload` and ensure the fully-qualified class name is correct: `\\NextTecnology\\NovaCustomErrors\\Http\\Middleware\\HandleNovaErrors::class`.
- View not found: ensure the view exists in the package (it does by default), or, if you published views, confirm they are under `resources/views/vendor/nova-custom-errors/` with the correct filename (e.g., `404.blade.php`).
- Config cache: after changing `config/nova.php`, run `php artisan config:clear`.

## License

MIT


## Note about assets in the minimal layout

The bundled minimal layout view (`resources/views/vendor/nova-custom-errors/minimal.blade.php` after publishing, or the package view `resources/views/minimal.blade.php`) includes this line:

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

This expects Laravel Vite to build your assets into `public/build` (the default). If those files are not available in your project, you have two options:

1) Provide the assets via Vite (recommended)
- Install dependencies and build once for production:
  ```bash
  npm install
  npm run build
  ```
  This will produce the `public/build` directory and the `@vite` directive will work.
- Or run the Vite dev server during local development:
  ```bash
  npm run dev
  ```
  Ensure your app is configured to connect to the Vite dev server as usual for your Laravel version.

2) Customize the layout to fit your asset pipeline
- Publish the views if you haven’t already:
  ```bash
  php artisan vendor:publish \
    --provider="NextTecnology\\NovaCustomErrors\\NovaCustomErrorsServiceProvider" \
    --tag="nova-custom-errors-views"
  ```
- Then edit `resources/views/vendor/nova-custom-errors/minimal.blade.php` and either remove the `@vite(...)` line or replace it with whatever your project uses (CDN, compiled static files, Mix, etc.). For example:
  ```blade
  <!-- Replace Vite with direct files or CDN as needed -->
  <link rel="stylesheet" href="/css/app.css">
  <script src="/js/app.js" defer></script>
  ```

If your project doesn’t need any custom CSS/JS for these error pages, you can safely remove the `@vite([...])` line.
