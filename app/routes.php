<?php

Route::get('/', function()
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if (Auth::check())
  {
    return Redirect::to('profile');
  }
  else
  {
	  $view = array('title' => 'URL Shortener',
                  'metadesc' => 'URL Shortener - Home',
                  'clicks' => Sitedata::first()->hits,
                  'users' => User::all()->count());
    return View::make('home', $view);
  }
});

Route::get('/install', function()
{
  require_once('../urlshortener/installed.php');
  if($installed)
    return Redirect::to('/');
  else
  {
    $view = array('title' => 'URL Shortener - Install',
                  'metadesc' => 'Install URL Shortener in your website');
    return View::make('install', $view);
  }
});

Route::post('/install', function()
{
  require_once('../urlshortener/installed.php');
  if($installed)
    return Redirect::to('/');
  else
  {
    $view = array('title' => 'URL Shortener - Install',
                  'metadesc' => 'Install URL Shortener in your website');
    $validator = Validator::make(array('URL' => Input::get('url'),
                                       'Database Host' => Input::get('dbhost'),
                                       'Database Name' => Input::get('dbname'),
                                       'Database Username' => Input::get('dbuname'),
                                       'Table Prefix' => Input::get('tblprefix')),
                                 array('URL' => 'required|url',
                                       'Database Host' => 'required',
                                       'Database Name' => 'required|alpha_dash',
                                       'Database Username' => 'required|alpha_dash',
                                       'Table Prefix' => 'alpha_dash'));
    if($validator->passes() && htmlspecialchars(Input::get('url')) == Input::get('url'))
    {
      try
      {
        $conn = new PDO("mysql:host=".Input::get('dbhost').";dbname=".Input::get('dbname'), Input::get('dbuname'), Input::get('dbpass'));
      }
      catch(PDOException $e)
      {
        $view['message'] = $e->getMessage();
        return View::make('install', $view);
      }
      $tblprefix = Input::get('tblprefix');
      require_once('../urlshortener/install.php');
      if($success == 6)
      {
        $get = @file_get_contents('../urlshortener/installed.php');
        $get = str_replace('false', 'true', $get);
        $hand = fopen('../urlshortener/installed.php', 'w');
        fwrite($hand, $get);
        fclose($hand);
        $home = Sitedata::first()->siteurl;
        echo '<h1 align="center">Successfully Installed</h1><br />';
        echo "<p align=\"center\">Click <a href=\"$home\">HERE</a></p>";
        exit();
      }
      else
      {
        return View::make('install', $view);
      }
    }
    else
    {
      $view['message'] = "";
      foreach($validator->messages()->all() as $message)
      {
        $view['message'] .= $message.'<br />';
      }
    }
    return View::make('install', $view);
  }
});

Route::get('/activate-{token}', function($token)
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  $values = DB::table('awaitingacts')
                  ->wheretoken($token)
                  ->first();
  if(!empty($values))
  {
      User::create(array('email' => $values->email,
                         'username' => $values->username,
                         'password' => $values->password,
                         'token' => $values->token,
                         'regip' => $_SERVER['REMOTE_ADDR']));
      DB::table('awaitingacts')
            ->wheretoken($token)->delete();
      $view = array('title' => 'Successfully Signed Up!!',
                    'metadesc' => 'Successfully Signed Up!!',
                    'home' => Sitedata::first()->siteurl);
      return View::make('signup', $view);
  }
});

Route::get('/login', function()
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if(Auth::check())
  {
    return Redirect::to('profile');
  }
  $view = array('title' => 'URL Shortener - Log In',
                'metadesc' => 'Login to your URL Shortener Account',
                'home' => Sitedata::first()->siteurl);
  return View::make('login', $view);
});

Route::post('/login', function()
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if(Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'))))
  {
    return Redirect::to('profile');
  }
  else
  {
    $view = array('title' => 'URL Shortener - Log In',
                  'metadesc' => 'Login to your URL Shortener Account',
                  'loginerror' => 'Invalid username or password!!',
                  'home' => Sitedata::first()->siteurl);
    return View::make('login', $view); 
  }  
});

Route::get('/signup', function()
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if(Auth::check())
  {
    return Redirect::to('profile');
  }
  $view = array('title' => 'URL Shortener - Sign Up',
                'willsign' => true,
                'metadesc' => 'Create a new URL Shortener Account',
                'home' => Sitedata::first()->siteurl);
  return View::make('signup', $view);
});

Route::post('/signup', function()
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if(Auth::check())
  {
    return Redirect::to('profile');
  }
  $validator = Validator::make(array('username' => Input::get('username'),
                                     'password' => Input::get('password'),
                                     'confirm password' => Input::get('cpassword'),
                                     'email' => Input::get('email')),
                               array('username' => 'required|alpha_num|between:6,20',
                                     'password' => 'required|between:6,20',
                                     'confirm password' => 'required|same:password',
                                     'email' => 'required|email|unique:users,email'));
  if($validator->passes())
  {
    $token = sha1(Input::get('email').Input::get('username').Hash::make(Input::get('password')));
    Awaitingact::create(array('email' => Input::get('email'),
                              'username' => Input::get('username'),
                              'password' => Hash::make(Input::get('password')),
                              'token' => $token));
    $siteurl = Sitedata::first()->siteurl;
    $subject = "URL Shortener - Account Activation";
    $message = "Hello,\nYour account creation request in URL Shortener has been accepted.";
    $message = $message."\nVisit this link to activate your account : {$siteurl}activate-{$token}";
    $headers = "From: \"URL Shortener\"";
    mail(Input::get('email'), $subject, $message, $headers);
    $view = array('willactivate' => true,
                  'title' => 'Account Created - Awaiting Activation',
                  'metadesc' => 'Account Created - Awaiting Activation',
                  'home' => Sitedata::first()->siteurl);
  }
  else
  {
    $view = array('title' => 'URL Shortener - Sign Up',
                  'willsign' => true,
                  'metadesc' => 'Create a new URL Shortener Account',
                  'home' => Sitedata::first()->siteurl);
    $view['signuperror'] = "";
    foreach($validator->messages()->all() as $message)
    {
      $view['signuperror'] .= $message.'<br />';
    }
  }
  return View::make('signup', $view);
});

Route::get('/profile', function()
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if (!Auth::check())
  {
     return Redirect::to('login');
  }
  require_once('../urlshortener/functions.php');
  $urls = get_urls();
  $view = array('title' => 'URL Shortener - Profile',
                'metadesc' => 'Profile',
                'token' => Auth::user()->token,
                'id' => Auth::user()->username,
                'urls' => $urls,
                'home' => Sitedata::first()->siteurl);
  return View::make('profile', $view);
});

Route::get('/logout', function()
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if (!Auth::check() || Input::get('token') != Auth::user()->token)
  {
     return Redirect::to('login');
  }
  Auth::logout();
  return Redirect::to('login');
});

Route::post('/profile', function()
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if (!Auth::check())
  {
    return Redirect::to('/');
  }
  require_once('../urlshortener/functions.php');
  $validator = Validator::make(array('url' => Input::get('url'),
                                     'customkey' => Input::get('customkey')),
                               array('url' => 'required|url|unique:urls,longurl,NULL,id,uid,'.Auth::user()->id,
                                     'customkey' => 'alpha_dash|max:13|unique:urls,shorturl'));
  if($validator->passes() && htmlspecialchars(Input::get('url')) == Input::get('url')
    && !strstr(Input::get('url'), substr(Sitedata::first()->siteurl, 0, strlen(Sitedata::first()->siteurl) - 1)))
  {
    if(strlen(Input::get('customkey')) == 0)
    {
      $id = Sitedata::first()->nexturl;
      $url = get_short_url($id);
    }
    else
    {
      $url = Input::get('customkey');
    }
    Url::create(array('shorturl' => $url,
                      'title' => Input::get('title'),
                      'longurl' => Input::get('url'),
                      'uid' => Auth::user()->id,
                      'ip' => $_SERVER['REMOTE_ADDR'],
                      'hits' => 0));
    return Redirect::to('profile');
  }
  else
  {
    $errmessages = "The url entered was invalid.<br />";
    foreach($validator->messages()->all() as $message)
    {
      $errmessages .= $message.'<br />';
    }
    $urls = get_urls();
    $view = array('title' => 'URL Shortener - Profile',
                  'metadesc' => 'Profile',
                  'token' => Auth::user()->token,
                  'id' => Auth::user()->username,
                  'urlerror' => $errmessages,
                  'urls' => $urls,
                  'home' => Sitedata::first()->siteurl);
    return View::make('profile')->with($view);
  }
});

Route::post('/forgot-password', function()
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if (Auth::check())
  {
    return Redirect::to('profile');
  }
  else
  {
	  $view = array('title' => 'URL Shortener - Forgot Password',
                  'metadesc' => 'Forgot Password',
                  'home' => Sitedata::first()->siteurl);
    $validator = Validator::make(array('email' => Input::get('email')),
                                 array('email' => 'required|email|exists:users,email'));
    if($validator->passes())
    {
      require_once('../urlshortener/functions.php');
      $newpass = rand_password(7);
      DB::table('users')
            ->whereemail(Input::get('email'))
            ->update(array('password' => Hash::make($newpass)));
      $headers = "From: \"URL Shortener\"";
      mail(Input::get('email'), 'URL Shortener - Forgot Password', "Your new password for your URL Shortener account it is {$newpass}", $headers);
      $view['message'] = 'Your new password has been emailed to '.Input::get('email');
    }
    else
    {
      $view['message'] = 'The entered email id is invalid!!';
    }
    return View::make('forgotpwd', $view);
  }
});

Route::get('/forgot-password', function()
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if (Auth::check())
  {
    return Redirect::to('profile');
  }
  else
  {
    $view = array('title' => 'URL Shortener - Forgot Password',
                  'metadesc' => 'Forgot Password',
                  'home' => Sitedata::first()->siteurl);
    return View::make('forgotpwd', $view);
  }
});

Route::get('/stats-{id}', function($id)
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if (!Auth::check())
  {
    return Redirect::to('login');
  }
  if(Url::whereshorturl($id)->whereuid(Auth::user()->id)->count() > 0)
  {
    $url = Url::whereshorturl($id)->first();
    $view = array('title' => "URL Shortener - Stats",
                  'metadesc' => "Statistics for shorturl ".$id,
                  'token' => Auth::user()->token,
                  'shorturl' => Sitedata::first()->siteurl.$url->shorturl,
                  'longurl' => $url->longurl,
                  'hits' => $url->hits,
                  'created_at' => $url->created_at,
                  'ip' => $url->ip,
                  'home' => Sitedata::first()->siteurl);
    $traffic = null;
    if($url->hits > 0)
    {
      $traffic = array();
      $traf = array();
      $traff = Hitlog::whereshorturl($id)->get();
      foreach($traff as $value)
      {
        if(isset($traf[$value->country]))
          $traf[$value->country]++;
        else
          $traf[$value->country] = 1;
      }
      foreach($traf as $country => $hits)
      {
        $traffic[] = array('country' => $country, 'hits' => $hits);
      }
    }
    $view['traffic'] = $traffic;
    return View::make('stats', $view);
  }
  return Redirect::to('profile');
});

Route::get('/delete-{id}', function($id)
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if(Url::whereshorturl($id)->whereuid(Auth::user()->id)->count() > 0)
  {
    Url::whereshorturl($id)->whereuid(Auth::user()->id)->delete();
    Hitlog::whereshorturl($id)->delete();
    return Redirect::to('profile');
  }
});

Route::get('/change-password', function()
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if (!Auth::check())
  {
    return Redirect::to('login');
  }
  else
  {
    $view = array('title' => 'URL Shortener - Change Password',
                  'metadesc' => 'Change Password',
                  'token' => Auth::user()->token,
                  'home' => Sitedata::first()->siteurl);
    return View::make('changepwd', $view);
  }
});

Route::post('/change-password', function()
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if (!Auth::check())
  {
    return Redirect::to('login');
  }
  else
  {
    $view = array('title' => 'URL Shortener - Change Password',
                  'metadesc' => 'Change Password',
                  'token' => Auth::user()->token,
                  'home' => Sitedata::first()->siteurl);
    $validator = Validator::make(array('password' => Input::get('password'),
                                       'new password' => Input::get('npassword'),
                                       'confirm password' => Input::get('cnpassword')),
                                 array('password' => 'required',
                                       'new password' => 'required',
                                       'confirm password' => 'required|same:new password'));
    if($validator->passes())
    {
      if(Hash::check(Input::get('password'), User::whereid(Auth::user()->id)->first()->password))
      {
        DB::table('users')
              ->whereid(Auth::user()->id)
              ->update(array('password' => Hash::make(Input::get('npassword'))));
        $view['message'] = "Password has been changed successfully.";
      }
      else
        $view['message'] = "You have entered incorrect password.";
    }
    else
    {
      $view['message'] = "";
      foreach($validator->messages()->all() as $message)
      {
        $view['message'] .= $message.'<br />';
      }
    }
    return View::make('changepwd', $view);
  }
});

Route::get('/{url}', function($url)
{
  require_once('../urlshortener/installed.php');
  if(!$installed)
    return Redirect::to('install');
  if(Url::whereshorturl($url)->count() > 0)
  {
    require_once('../urlshortener/geoiploc.php');
    require_once('../urlshortener/functions.php');
    $redirurl = Url::whereshorturl($url)->first();
    if(Hitlog::whereshorturl($url)->whereip($_SERVER['REMOTE_ADDR'])->count() == 0)
    {
      Hitlog::create(array('shorturl' => $url,
                           'ip' => $_SERVER['REMOTE_ADDR'],
                           'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                           'referrer' => ((isset($_SERVER['HTTP_REFERER']))? $_SERVER['HTTP_REFERER'] : ''),
                           'country' => strtolower(getCountryFromIP($_SERVER['REMOTE_ADDR']))));
      DB::table('urls')
            ->whereshorturl($url)
            ->update(array('hits' => Hitlog::whereshorturl($url)->count()));
      DB::table('sitedata')
            ->update(array('hits' => Sitedata::first()->hits + 1));
    } 
    return Redirect::to($redirurl->longurl);
  }
  else
  {
    return View::make('404');
  }  
});