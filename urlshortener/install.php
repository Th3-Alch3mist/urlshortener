<?php
      $homeurl = Input::get('url');
      if($homeurl[strlen($homeurl) - 1] != '/')
          $homeurl = $homeurl.'/';
      $get = @file_get_contents('../app/config/database.php');
      $get = str_replace('{{ host }}', Input::get('dbhost'), $get);
      $get = str_replace('{{ dbname }}', Input::get('dbname'), $get);
      $get = str_replace('{{ dbuname }}', Input::get('dbuname'), $get);
      $get = str_replace('{{ dbpass }}', Input::get('dbpass'), $get);
      $get = str_replace('{{ tblprefix }}', Input::get('tblprefix'), $get);
      $hand = fopen('../app/config/database.php', 'w');
      fwrite($hand, $get);
      fclose($hand);
      $success = 0;      
      $query = $conn->prepare("CREATE TABLE IF NOT EXISTS `".$tblprefix."awaitingacts` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `email` varchar(30) DEFAULT NULL,
                               `username` varchar(20) DEFAULT NULL,
                               `password` char(60) DEFAULT NULL,
                               `token` char(40) DEFAULT NULL,
                               PRIMARY KEY (`id`)
                               ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
      $success = ($query->execute()) ? ($success+1) : $success;
      $query = $conn->prepare("CREATE TABLE IF NOT EXISTS `".$tblprefix."hitlogs` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `shorturl` varchar(13) DEFAULT NULL,
                               `hit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                               `ip` varchar(41) DEFAULT NULL,
                               `user_agent` varchar(255) NOT NULL,
                               `referrer` varchar(200) NOT NULL,
                               `country` char(2) NOT NULL,
                               PRIMARY KEY (`id`)
                               ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
      $success = ($query->execute()) ? ($success+1) : $success;
      $query = $conn->prepare("CREATE TABLE IF NOT EXISTS `".$tblprefix."sitedata` (
                               `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                               `siteurl` varchar(255) DEFAULT NULL,
                               `hits` int(11) DEFAULT NULL,
                               `nexturl` varchar(13) NOT NULL,
                               PRIMARY KEY (`id`)
                               ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
      $success = ($query->execute()) ? ($success+1) : $success;
      $query = $conn->prepare("INSERT INTO `".$tblprefix."sitedata` (`siteurl`, `hits`, `nexturl`) VALUES (?, ?, ?)");
      $success = ($query->execute(array($homeurl, 0, '1'))) ? ($success+1) : $success;
      $query = $conn->prepare("CREATE TABLE IF NOT EXISTS `".$tblprefix."urls` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `uid` int(11) NOT NULL,
                               `shorturl` varchar(13) DEFAULT NULL,
                               `title` text NOT NULL,
                               `longurl` text,
                               `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                               `ip` varchar(41) NOT NULL,
                               `hits` int(11) NOT NULL,
                               PRIMARY KEY (`id`)
                               ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
      $success = ($query->execute()) ? ($success+1) : $success;
      $query = $conn->prepare("CREATE TABLE IF NOT EXISTS `".$tblprefix."users` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `email` varchar(30) NOT NULL,
                               `username` varchar(20) NOT NULL,
                               `password` char(60) NOT NULL,
                               `token` char(40) NOT NULL,
                               `regip` varchar(41) NOT NULL,
                               `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                               PRIMARY KEY (`id`)
                               ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
      $success = ($query->execute()) ? ($success+1) : $success;
?>