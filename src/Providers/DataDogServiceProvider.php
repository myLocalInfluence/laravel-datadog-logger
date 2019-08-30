<?php

namespace Myli\DatadogLogger\Providers;

use App\Console\Commands\DeleteDataDogLog;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

/**
 * Class DataDogServiceProvider
 *
 * @author    Aurélien SCHILTZ <aurelien@myli.io>
 * @copyright 2016-2019 Myli
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class DataDogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DeleteDataDogLog::class,
            ]);
            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class);
                $schedule->command('delete:datadog:log')->at('00:00');
            });
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/logging.php',
            'logging.channels'
        );
    }
}
