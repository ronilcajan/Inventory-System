<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

$route['default_controller'] = 'inventory';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['item'] = 'item/index';
$route['release'] = 'release/index'; 
$route['logs'] = 'logs/index'; 
$route['login_submit'] = 'login/login_submit'; 
$route['submit_category'] = 'category/submit_category';
$route['edit_category'] = 'category/edit_category';
$route['add_item'] = 'item/add_item';
$route['submit_item'] = 'item/submit_item';
$route['login'] = 'login/index';
