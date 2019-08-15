<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></a></p><p align="center">X</p>
<p align="center"><a href="https://www.datadoghq.com" target="_blank"><img width="80" height="80" src="https://imgix.datadoghq.com/img/dd_logo_70x75.png?fm=png&auto=format&lossless=1%22"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://codeclimate.com/github/myLocalInfluence/laravel-datadog-logger/maintainability"><img src="https://api.codeclimate.com/v1/badges/5ce73ef2de5fdebeee39/maintainability" /></a>
<a href="https://codeclimate.com/github/myLocalInfluence/laravel-datadog-logger/test_coverage"><img src="https://api.codeclimate.com/v1/badges/5ce73ef2de5fdebeee39/test_coverage" /></a>
<img alt="GitHub release" src="https://img.shields.io/github/release/myLocalInfluence/laravel-datadog-logger">
<a href="https://packagist.org/packages/myli/laravel-datadog-logger"><img src="https://poser.pugx.org/myli/laravel-datadog-logger/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/myli/laravel-datadog-logger"><img src="https://poser.pugx.org/myli/laravel-datadog-logger/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/myli/laravel-datadog-logger"><img src="https://poser.pugx.org/myli/laravel-datadog-logger/license.svg" alt="License"></a>
</p>

## How to use

Add in your `config/logging.php` the following under `channels` tab:

       
       'datadog'    => [
            'driver' => 'custom',
            'via'    => \Myli\CreateDataDogLogger::class,
            'apiKey' => env('DATADOG_API_KEY'),
            'region' => 'eu',
            'level'  => 'debug',
            'bubble' => true,
        ],
            
        
Refer to Monolog for the options, the only custom options are `region` (values can be `us|eu`) and `apiKey` which you can find <a href="https://app.datadoghq.com/account/settings#api">here</a>

## If you ❤️ open-source software, give the repos you use a ⭐️.
We have included the awesome `symfony/thanks` composer package as a dev
dependency. Let your OS package maintainers know you appreciate them by starring
the packages you use. Simply run composer thanks after installing this package.
(And not to worry, since it's a dev-dependency it won't be installed in your
live environment.)

## License

The Laravel DataDog Logger is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

<p align="center">Repository proudly created by</p><p align="center"><a href="https://www.myli.io" target="_blank"><img width="100" height="25" src="https://www.myli.io/wp-content/uploads/2016/12/LOGO-MYLI.png"></a></p>
