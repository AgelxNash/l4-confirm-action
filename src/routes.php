<?php

Route::get(Config::get('l4-confirm-action::route.path').'{hash}', array(
        'as' => Config::get('l4-confirm-action::route.name'),
        'uses'=>'AgelxNash\L4ConfirmAction\Controllers\ConfirmController@check'
    )
)->where(array('hash' => '[0-9A-Za-z]{'.\Config::get('l4-confirm-action::hash_len').'}'));