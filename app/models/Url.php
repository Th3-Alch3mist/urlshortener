<?php
class Url extends Eloquent {
	protected $table = 'urls';
  protected $fillable = array('uid', 'shorturl', 'title', 'longurl', 'created_at', 'ip', 'hits'); 
  public $timestamps = false;
}