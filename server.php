<?php
/***
 * 整体配置文件
 * 包括数据库与类乎
 * @Author:@inoro
 * @Data:2018-11-16
 */
$dsn      = 'mysql:dbname=mangfeng;host=localhost';
$username = 'root';
$password = 'root';

// error reporting (this is a demo, after all!)
ini_set('display_errors',1);error_reporting(E_ALL);

/**
 * 加载自动加载文件
 * Autoloading (composer is preferred, but for this example let's just do this)
 */
require_once('oauth2-server-php/src/OAuth2/Autoloader.php');
OAuth2\Autoloader::register();

/**
 * 配置数据库与对应表
 * $dsn is the Data Source Name for your database, for exmaple "mysql:dbname=my_oauth2_db;host=localhost"
 */
$storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));
// 传递storage对象到 OAuth2 Server 类
$server = new OAuth2\Server($storage);

/**
 * 配置 GrantType OAuth2.0 认证模式之客户端模式（Client Credentials Grant）
 * Add the "Client Credentials" grant type (it is the simplest of the grant types)
 */
$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));

/**
 * 配置 GrantType OAuth2.0 认证模式之授权码模式（authorization code）
 * Add the "Authorization Code" grant type (this is where the oauth magic happens)
 */
$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

/**
 * 配置 GrantType OAuth2.0 认证模式之密码模式（resource owner password credentials）
 * 通过用户名密码获取授权
 */
$users = array('bshaffer' => array('password' => 'brent123', 'first_name' => 'Brent', 'last_name' => 'Shaffer'));
$storage = new OAuth2\Storage\Memory(array('user_credentials' => $users)); // create a storage object
$server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));


/**
 * 配置更新令牌(RefreshToken)
 * RefreshToken 再次获取access_token
 */
$server->addGrantType(new OAuth2\GrantType\RefreshToken($storage));


