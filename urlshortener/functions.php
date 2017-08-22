<?php

function get_urls()
{
  $urls = NULL;
  if(Url::whereuid(Auth::user()->id)->count() > 0)
  {
    $urls = DB::table('urls')
                  ->where('uid', Auth::user()->id)
                  ->get();
  }
  return $urls;
}

function get_short_url($id)
{
  if(Url::whereshorturl($id)->count() == 0)
  {
    $next = base_convert((base_convert($id, 36, 10) + 1), 10, 36);
    DB::table('sitedata')
          ->update(array('nexturl' => $next));
    return $id;
  }
  else
  {
    $id = base_convert((base_convert($id, 36, 10) + 1), 10, 36);
    return get_short_url($id);
  }
}

function rand_password($len)
{
  $password='';
  $i=1;
  $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_.';
  while($i<=$len)
  {
    $password.=$chars[rand(0,strlen($chars))];
    $i++;
  }
  return $password; 
}

?>