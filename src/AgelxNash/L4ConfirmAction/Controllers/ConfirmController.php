<?php namespace AgelxNash\L4ConfirmAction\Controllers;

use AgelxNash\L4ConfirmAction\Models\ConfirmUser;
use AgelxNash\L4ConfirmAction\Exception as Exception;

class ConfirmController extends \Controller
{
    public function check($hash)
    {
        $out = null;
        if (is_scalar($hash)) {
            $confirumObj = ConfirmUser::findHash($hash);
            if (!$confirumObj->exists()) {
                throw new Exception\ConfirmHashNotFoundException('Confirm hash ' . $hash . ' not found');
            }
            $confirumObj = $confirumObj->first();

            if (is_callable($confirumObj->getCallback())) {
                $out = call_user_func($confirumObj->getCallback(), $confirumObj->user, $confirumObj->getConfigField());
                $confirumObj->delete();
            } else {
                throw new Exception\ConfirmCallbackException('Callback ' . $confirumObj->action . ' not found');
            }
        } else {
            throw new Exception\ConfirmIncorrectHashException('Incorrect confirm hash');
        }
        return $out;
    }
}