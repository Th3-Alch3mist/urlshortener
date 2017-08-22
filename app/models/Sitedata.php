<?php
class Sitedata extends Eloquent {
	protected $table = 'sitedata';
  protected $fillable = array('siteurl', 'hits', 'nexturl'); 
  public $timestamps = false;
}