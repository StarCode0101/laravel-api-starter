<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/ laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## A Larave API starter kit using Fortify and Sanctum
- Check here for full documentation
- [Laravel Fortify](https://laravel.com/8.x/fortify).
- [Sanctum](https://laravel.com/8.x/sanctum).


Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Sanctum !!!

- During dev, when you run the local SPA make sure the URL is http://127.0.0.1:3000 as some browser take this domain as diffrent from http://localhost which causes token mistmatch.

- You should add Sanctum's middleware to your api middleware group within your app/Http/Kernel.php file. This middleware is responsible for ensuring that incoming requests from your SPA can authenticate using Laravel's session cookies, while still allowing requests from third parties or mobile applications to authenticate using API tokens:

```php
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```

## Fortify Setup
- After setting up, make sure the App\Providers\FortifyServiceProvider is registered within the providers array of your application's config/app.php configuration file.

## Fortify Feature 
- Laravel Fortify comes with many features found in the config/fotify.php comment out the feature to use 
```php
 'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        //Features::updateProfileInformation(),
        //Features::updatePasswords(),
      /*   Features::twoFactorAuthentication([
            'confirmPassword' => true,
        ]), */
    ],
```
- Have the views disable in the config/fotify.php
```php
 'views' => false,
```
- Specify which prefix Fortify will assign to all the routes.
```php
 'prefix' => 'api',
 ```

## Registration of new users
- The user validation and creation process may be customized by modifying the App\Actions\Fortify\CreateNewUser action that was generated when you installed Laravel Fortify.
- When registering new users Fortify uses the 'home' field in config/fortify.php to ridirect user to a default route '/home', However it's best to specify the domain of the SPA home and the request could also be an ajax, so redirection is done from the Middleware RiderirectIfAuthenticated.php
```php
///...
 public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
              //return redirect(RouteServiceProvider::HOME);
              if($request->expectsJson()){
                return response()->json('Logged in', 200);
            }

            return redirect(url(env('SPA_URL')));
            }
        }

        return $next($request);
    }
```

## Email Verification
- By defualt fortify doesn't use auth:sanctum for protecting routes, so we'll create a custom e-mail verification controller(App\Http\Auth\VerifyEmailCntroller).

## Password Reset
- To reset passwords, by default uses the address of the api, but we are going to generate a custom url using the frontend address, to do this we use the ResetPassword notification of Laravel and register it in a binding in the FortifyServiceProvider.

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[CMS Max](https://www.cmsmax.com/)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**
- **[Romega Software](https://romegasoftware.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
