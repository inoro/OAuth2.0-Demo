<?php
/**
 * 验证token
 * 传参：{access_token:d1b32335f5a23f1c60a288db17cff0a4ad60721f}
 * 返回：true/false
 *
 * @Author:@inoro
 * @Date:2018-11-16
 **/

// 加载 OAuth2 Server 对象
require_once __DIR__.'/server.php';

// 处理对资源的请求并验证 access token
if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    $server->getResponse()->send();
    die;
}
echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));
