<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Tables\Columns\IconColumn;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
            IconColumn::macro('toggle', function() {
                $this->action(function($record, $column) {
                    $name = $column->getName();
                    $record->update([
                        $name => !$record->$name
                    ]);
                });
                return $this;
            });
        
        if (env('FORCE_SSL', false)) {
            URL::forceScheme('https');
        }

    }
}
