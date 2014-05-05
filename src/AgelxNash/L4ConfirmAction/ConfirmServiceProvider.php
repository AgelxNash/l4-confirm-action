<?php namespace AgelxNash\L4ConfirmAction;

use Illuminate\Support\ServiceProvider;

class ConfirmServiceProvider extends ServiceProvider{
    protected $defer = false;

    public function boot()
    {
        $this->package('agelxnash/l4-confirm-action');
        $rootDir = dirname(dirname(dirname(__FILE__)));

        include $rootDir . '/routes.php';
    }

    public function register(){
        $this->app['l4-confirm-action'] = $this->app->share(function($app) {
            return new ConfirmUserAction;
        });
        $this->app->booting(function() {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('ConfirmUserAction', 'AgelxNash\L4ConfirmAction\Facades\ConfirmUserAction');
            $loader->alias('ConfirmUserCallback', \Config::get('l4-confirm-action::classname'));
        });
    }

    public function provides()
    {
        return array();
    }
}