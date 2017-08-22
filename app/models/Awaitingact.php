<?php
class Awaitingact extends Eloquent {
	protected $table = 'awaitingacts';
  protected $fillable = array('email', 'username', 'password', 'token'); 
  public $timestamps = false;
}