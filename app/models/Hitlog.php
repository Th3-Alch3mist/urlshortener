<?php
class Hitlog extends Eloquent {
	protected $table = 'hitlogs';
  protected $fillable = array('shorturl', 'hit_time', 'ip', 'user_agent', 'referrer', 'country'); 
  public $timestamps = false;
}