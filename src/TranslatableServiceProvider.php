<?php

namespace Pine\Translatable;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class TranslatableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load the migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Register the custom blade directive
        Blade::directive('translate', function ($expression) {
            $params = explode (', ', $expression);

            $params[2] = isset($params[2]) ? $params[2] : null;

            return "<?php echo with($params[1])->translate($params[2])->content[$params[0]] ?? with($params[1])[$params[0]]; ?>";
        });
    }
}
