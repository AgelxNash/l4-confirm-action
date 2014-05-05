<?php namespace AgelxNash\L4ConfirmAction;

use AgelxNash\L4ConfirmAction\Models\ConfirmUser;

class ConfirmUserExampleCallback
{
    public static function registration(\User $user)
    {
        $user->active = 1;
        $user->save();
        return 'active';
    }

    public static function newMail(\User $user, $newMail = null)
    {
        $out = 'Incorrect email';
        if (!empty($newMail) && is_scalar($newMail)) {
            if( ! \User::where('email', $newMail)->where('id', '!=', $user->id)->exists()){
                $user->email = $newMail;
                $user->save();
                $out = 'save new email';
            }else{
                $out = 'New email '.$newMail.' adress is already in use';
            }
        }
        return $out;
    }

    public static function oldMail(\User $user, $oldMail = null)
    {
        $out = 'Incorrect email';
        if (!empty($newMail) && is_scalar($oldMail)) {
            if( ! \User::where('email', $oldMail)->where('id', '!=', $user->id)->exists()){
                $user->email = $oldMail;
                $user->save();
                $out = 'return old email';
            }else{
                $out = 'Old email '.$oldMail.' adress is already in use';
            }
        }
        ConfirmUser::where('action', 'newMail')->where('user_id', $user->id)->delete();
        return $out;
    }
}