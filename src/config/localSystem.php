<?php

/*
 * Setup a Database session
 */
//$config['session.driver'] = 'Tk\Session\Database';
//$config['session.database.table'] = 'session';
//$config['session.database.config'] = 'db.connect.default';
//$config['session.regenerate'] = 0; // Does not work for DB sessions yet
//$config['session.gc_probability'] = 1;
//$config['session.gc_divisor'] = 10; // lower this for high traffic sites.


$config['system.auth.loginAdapters'] = array(
    //'Config' => '\Tk\Auth\Adapter\Config',
    'User' => '\Usr\Auth\Adapter\User'
    //,'Unimelb (LDAP)' => '\Usr\Auth\Adapter\Unimelb'
);

// Set a user class here for the login system EG: \Usr\Db\User
$config['system.auth.userClass'] = '\Usr\Db\User';

$config['system.theme.default.name'] = 'default';
$config['system.theme.default.themeFile'] = 'public.tpl';


/*
 * LDAP Config Options
 */
$config['system.auth.ldap.enable'] = true;
$config['system.auth.ldap.uri']    = 'ldap://centaur.unimelb.edu.au';
$config['system.auth.ldap.port']   = 389;
$config['system.auth.ldap.baseDn'] = 'ou=people,o=unimelb';


// Set these when using admin only authentication
// This is a simple one user auth used for small sites.
//$config['site.auth.username'] = 'admin';
//z$config['site.auth.password'] = 'password';







