<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*

    Change db


    'hostname' => 'localhost',
	'username' => 'wilopoca_office',
	'password' => 'wilopoca2019',
	'database' => 'wilopoca_office',

	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'titip_transfer',
*/
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'wilopoca_wcnew',
	'password' => 'wilopoca2019',
	'database' => 'wilopoca_office',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
