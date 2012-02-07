<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$config['modules']['admin'] = 'admin';
$config['actions']['admin.userlist.edit'] = 'admin|self:id@get|self:id@post';

$config['modules']['feed'] = 'everyone';

$config['modules']['home'] = 'everyone';
$config['actions']['home.home.buy'] = 'registered';
$config['actions']['home.home.cancel_transaction'] = 'registered';

$config['actions']['product.product.view'] = 'everyone';
$config['actions']['product.product.add_comment'] = 'registered';
$config['actions']['product.product.edit_comment'] = 'admin';
$config['actions']['product.product.remove_comment'] = 'admin';
$config['modules']['product'] = 'admin';

$config['modules']['seller'] = 'seller';

$config['modules']['user'] = 'unregistered#home';
$config['actions']['user.user.access_denied'] = 'everyone';
$config['actions']['user.user.logout'] = 'everyone';
$config['controllers']['user.transactions'] = 'registered#user/login';

