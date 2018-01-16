<?php

namespace Pine\Translatable\Tests;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Pine\Translatable\TranslatableServiceProvider;

class TestCase extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/migrations'),
        ]);
        $this->loadLaravelMigrations(['--database' => 'testing']);

        $this->withFactories(__DIR__.'/factories');
        $this->artisan('migrate', ['--database' => 'testing']);

        View::addNamespace('translatable', __DIR__.'/views');
        Route::view('/translatable', 'translatable::translatable');
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:tjr4OdXhohUfIUhfVeZcmg+psaPkfTaKgl9GuW1FjY8=');
    }

    protected function getPackageProviders($app)
    {
        return [
            ConsoleServiceProvider::class,
            TranslatableServiceProvider::class,
        ];
    }
}
