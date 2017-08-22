<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
class User extends Eloquent implements UserInterface, RemindableInterface {
	protected $table = 'users';
  protected $hidden = array('password');
  protected $fillable = array('email', 'username', 'password', 'token', 'regip', 'created_at'); 
  public $timestamps = false;
  public function getAuthIdentifier()
	{
		return $this->getKey();
	}
	public function getAuthPassword()
	{
		return $this->password;
	}
	public function getReminderEmail()
	{
		return $this->email;
	}
}