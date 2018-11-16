<?php
// 加载 OAuth2 Server 对象
require_once __DIR__.'/server.php';

/**
 * 1） 客户端模式（client credentials）
 * 访问地址：http://localhost/oauth2/token.php
 * 传递方法：POST
 * 传参：
 *  {
 *      grant_type:client_credentials,
 *      client_id:client_id,
 *      client_secret:testpass
 *  }
 *
 * 返回参数：
 *  {
 *      "access_token": "a8cca68328f971641d39658de3709cf50327889a",
 *      "expires_in": 3600,
 *      "token_type": "Bearer",
 *      "scope": null
 *  }
 *
 *=================================================================================
 *
 * 2）密码模式（resource owner password credentials）
 * 访问地址：http://localhost/oauth2/token.php
 * 传递方法：POST
 * 传参：
 *  {
 *      grant_type:password,
 *      client_id:client_id,
 *      client_secret:testpass,
 *      username:bshaffer,
 *      password:brent123
 *  }
 *
 * 返回参数：
 *  {
 *      "access_token": "41c0841b0211b4a57a3682e8d7d47e8dadab2321",
 *      "expires_in": 3600,
 *      "token_type": "Bearer",
 *      "scope": null,
 *      "refresh_token": "95c4720261c15e3f506be8b4428ea2b1e97ae4d3"
 *  }
 *
 * @Author:@inoro
 * @Date:2018-11-16
 */

// 请求OAuth2.0 Access Token 并且返回Access Token到客户端
$server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();