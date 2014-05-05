<?php namespace AgelxNash\L4ConfirmAction\Models;

use AgelxNash\L4ConfirmAction\Exception as Exception;

class ConfirmUser extends \Eloquent
{
    protected $table = 'confirm_user';

    protected $fillable = array(
        'user_id',
        'hash',
        'action',
        'config',
        'created_at',
        'updated_at'
    );

    protected $_configField = null;

    public function user()
    {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function scopeCheckRecord($query, $userID, $action)
    {
        return $query->where('user_id', $userID)->where('action', $action);
    }
    public function scopefindHash($query, $hash){
        return $this->where('hash', $hash);
    }
    public function getConfigField()
    {
        if ($this->config && is_null($this->_configField)) {
            $this->_configField = unserialize($this->config);
        }
        return $this->_configField;
    }

    public function getCallback()
    {
        return '\ConfirmUserCallback::' . $this->action;
    }

    public function save(array $options = array())
    {
        $this->config = serialize($this->config);

        $this->checkUser()
            ->checkAction()
            ->checkHash();
        return parent::save($options);
    }

    public function update(array $options = array()){
        $this->config = serialize($this->config);
        return parent::update($options);
    }

    protected function checkAction()
    {
        if (!is_scalar($this->action)) {
            $this->action = null;
        }
        if (empty($this->action)) {
            throw new Exception\ConfirmModelSaveException('Empty action field');
        }
        return $this;
    }

    protected function checkHash()
    {
        if (!is_scalar($this->hash)) {
            $this->hash = null;
        }
        if (empty($this->hash)) {
            throw new Exception\ConfirmModelSaveException('Empty hash field');
        }

        return $this;
    }

    protected function checkUser()
    {
        $this->user_id = is_scalar($this->user_id) ? intval($this->user_id) : null;
        if (empty($this->user_id) && \Auth::user()) {
            $this->user_id = \Auth::user()->id;
        }
        if (empty($this->user_id)) {
            throw new Exception\ConfirmModelSaveException('Empty user_id field');
        } else {
            if (!\User::find($this->user_id)) {
                throw new Exception\ConfirmModelSaveException('User not found');
            }
        }
        return $this;
    }
}