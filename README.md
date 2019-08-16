<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></a></p><p align="center">X</p>
<p align="center"><a href="https://www.datadoghq.com" target="_blank"><img width="80" height="80" src="https://imgix.datadoghq.com/img/dd_logo_70x75.png?fm=png&auto=format&lossless=1%22"></a></p>

<p align="center">
<a href="https://travis-ci.org/myLocalInfluence/laravel-datadog-logger"><img src="https://travis-ci.org/myLocalInfluence/laravel-datadog-logger.svg" alt="Build Status"></a>
<a href="https://codeclimate.com/github/myLocalInfluence/laravel-datadog-logger/maintainability"><img src="https://api.codeclimate.com/v1/badges/5ce73ef2de5fdebeee39/maintainability" /></a>
<a href="https://codeclimate.com/github/myLocalInfluence/laravel-datadog-logger/test_coverage"><img src="https://api.codeclimate.com/v1/badges/5ce73ef2de5fdebeee39/test_coverage" /></a>
<img alt="GitHub release" src="https://img.shields.io/github/release/myLocalInfluence/laravel-datadog-logger">
<a href="https://packagist.org/packages/myli/laravel-datadog-logger"><img src="https://poser.pugx.org/myli/laravel-datadog-logger/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/myli/laravel-datadog-logger"><img src="https://poser.pugx.org/myli/laravel-datadog-logger/license.svg" alt="License"></a>
</p>

# Getting started

Simply launch this command in your root laravel project : 

`composer require myli/laravel-datadog-logger`

I would highly suggest you to use the DataDog Agent Style rather than the Api Style because one laravel log = one api call which is bad for performances.

## 1) How to use in DataDog Agent Style (Example for an ubuntu installation)

1) Firstly, install the agent by <a href="https://app.datadoghq.com/account/settings#agent">following this guide here</a>

2) Add in your `config/logging.php` the following under `channels` tab:

        'datadog-agent' => [
            'driver'     => 'single',
            'path'       => storage_path('logs/laravel-json-datadog-' . php_sapi_name() . '.log'),
            'tap'        => [\Myli\DatadogLogger\DataDogFormatter::class,],
            'permission' => 0664,
            'level'      => 'info', // choose your minimum level of logging.
        ],
3) Add `LOG_CHANNEL="datadog-agent"` in your `.env` file OR include `datadog-agent` channel into your stack log channel.
4) Enable logs by setting `logs_enabled: true` in the default `/etc/datadog-agent/datadog.yaml` file on the server where the project is hosted.
5) Choose only one config between those 3 files to put in `/etc/datadog-agent/conf.d/laravel.d/` (create the `laravel.d` folder if it doesn't exist) : 
    1) <a href="https://github.com/myLocalInfluence/laravel-datadog-logger/blob/master/conf/cli-only/conf.yaml">Logging only php-cli</a>
    2) <a href="https://github.com/myLocalInfluence/laravel-datadog-logger/blob/master/conf/fpm-only/conf.yaml">Logging only php-fpm</a>
    3) <a href="https://github.com/myLocalInfluence/laravel-datadog-logger/blob/master/conf/cli-fpm/conf.yaml">Logging php-fpm and php-cli</a>
6) Restart your DataDog Agent and watch your result <a href="https://app.datadoghq.com/logs/livetail">here</a>.

Notes: At this time the `source` metadata from the DataDogFormatter is not taken care by DataDog so that's why we are specifying it in the `/etc/datadog-agent/conf.d/laravel.d/conf.yaml` file.

## 2) How to use in API Style

1) Add in your `config/logging.php` the following under `channels` tab:

       'datadog-api'    => [
            'driver' => 'custom',
            'via'    => \Myli\CreateDataDogLogger::class,
            'apiKey' => env('DATADOG_API_KEY'),
            'region' => 'eu', // eu or us
            'level'  => 'info',  // choose your minimum level of logging.
            'bubble' => true,
        ],
            
2) And finally add `LOG_CHANNEL="datadog-api"` in your `.env` file OR include `datadog-api` channel into your stack log channel.
3) The only custom options are `region` (values can be `us|eu`) and `apiKey` which you can find <a href="https://app.datadoghq.com/account/settings#api">here</a>

## If you ❤️ open-source software, give the repos you use a ⭐️.
We have included the awesome `symfony/thanks` composer package as a dev
dependency. Let your OS package maintainers know you appreciate them by starring
the packages you use. Simply run composer thanks after installing this package.
(And not to worry, since it's a dev-dependency it won't be installed in your
live environment.)

## License

The Laravel DataDog Logger is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

<p align="center">Repository proudly created by</p><p align="center"><a href="https://www.myli.io" target="_blank"><img width="100" height="25" src="https://www.myli.io/wp-content/uploads/2016/12/LOGO-MYLI.png"></a></p>
