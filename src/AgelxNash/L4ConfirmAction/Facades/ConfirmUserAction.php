<?php namespace AgelxNash\L4ConfirmAction\Facades;

use Illuminate\Support\Facades\Facade;

class ConfirmUserAction extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'confirm-action';
    }
}