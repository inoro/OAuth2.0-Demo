<?php
/**
 * 3）授权码模式（authorization code）
 * **注意：事先加入MYSQL调试的数据 (INSERT INTO oauth_clients (client_id, client_secret, redirect_uri) VALUES ("testclient", "testpass", "http://fake/");)
 * 
 * 访问地址如下： http://localhost/oauth2/authorize.php?response_type=code&client_id=testclient&state=xyz
 * 拿到 授权code 后可在 http://localhost/oauth2/token.php 获取access_token
 * 传递类型：POST
 *
 * 传参如下：
 *
 * {
 *      grant_type:authorization_code,
 *      client_id:testclient,
 *      client_secret:testpass,
 *      code:63f961fba14c2ce6300f2b864171170ca91ac1dc
 * }
 *
 * 返回参数如下：
 *
 * {
 *      "access_token": "d1b32335f5a23f1c60a288db17cff0a4ad60721f",
 *      "expires_in": 3600,
 *      "token_type": "Bearer",
 *      "scope": null,
 *      "refresh_token": "757e69b5668fbf5f2b162acb7f0a36d1b78b94f4"
 *  }
 *
 * 注：postman 访问模式为 x-www-form-urlencoded
 *
 * @User: @inoro
 * @Date: 2018/11/16
 */

require_once __DIR__.'/server.php';

//获取组合的传参
$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

// 验证参数请求
if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}

// 显示认证的按钮
if (empty($_POST)) {
    exit('
<form method="post">
  <label>Do You Authorize TestClient?</label><br />
  <input type="submit" name="authorized" value="yes">
  <input type="submit" name="authorized" value="no">
</form>');
}

// 判断确认认证
$is_authorized = ($_POST['authorized'] === 'yes');
// 获取授权code 并且跳转到 客户端的URL（http://fake/?code=1e60c868f6f91a60b2a26096a63d4b795fb540de&state=xyz）
$server->handleAuthorizeRequest($request, $response, $is_authorized);

// 调试代码 获取code 不会跳转
if ($is_authorized) {
    $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);
    exit("SUCCESS! Authorization Code: $code");
}
// 返回内容
$response->send();