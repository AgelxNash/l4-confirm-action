<?php namespace AgelxNash\L4ConfirmAction;

use AgelxNash\L4ConfirmAction\Models\ConfirmUser;
use \Illuminate\Support\Str;

class ConfirmUserAction
{
    public function createHash($user_id, $action, $config = null)
    {
        $hash = Str::random($this->hashLen());
        if (ConfirmUser::findHash($hash)->exists()) {
            $hash = self::createHash($user_id, $action, $config);
        } else {
            $data = compact('user_id', 'hash', 'action', 'config');
            //$record = ConfirmUser::firstOrNew(compact('user_id','action'));
            $record = ConfirmUser::CheckRecord($user_id, $action);
            if (($record->exists() && !$record->first()->update($data)) || (!$record->exists() && !ConfirmUser::create($data))) {
                throw new Exception\ConfirmModelSaveException('Error save or update model');
            }
        }
        return $hash;
    }

    public function hashLen()
    {
        return \Config::get('l4-confirm-action::hash_len');
    }
}