# tx-account
快速对接天星教育用户管理系统

[[说明文档](https://showdoc.tesoon.com/web/#/23?page_id=4087)]

版本规划说明：
- v1.0.* 适用php7.2及以上版本
- v1.1.* 最低兼容php7.4

## 快速开始

### 1. 安装
- 通过composer安装
```composer
//如果项目环境为php7.4及以上版本
composer require tx/account ~1.1

//如果项目环境为php7.2到php7.4之间版本
composer require tx/account ~1.0

```

### 2. 组件配置

- 在实际项目中实现`InterfaceRequestSend`,参考文档[[https://showdoc.tesoon.com/web/#/23/4088](https://showdoc.tesoon.com/web/#/23/4088)]
- 在使用本组件前先进行如下配置

```php
use Tesoon\Account\AccountConfig;
use Tesoon\Account\ParamConfig\DefaultParamConfig;

//此处的DefaultParamConfig也可自行根据业务逻辑实现
AccountConfig::setParamConfig(new DefaultParamConfig([
    'configs' => [
        'domain' => 'https://*****',//用户服务器域名
            'appID' => '*****',//本系统应用的appID
            'appSecret' => '*****',//本系统应用的appsecret
            'jwtToken' => [
                'key' => '*****',//jwt加密密钥
                'validate' => true,//验证token有效截至时间，如不验证则设置为false
                'verify' => true,//验证token的合法性，如不验证设置为false
                'jtiInterval' => 70,//向token签发服务器验证jti有效性的时间间隔
            ],
    ]
]));
//ExampleRequestSend为自行实现的InterfaceRequestSend
AccountConfig::setSendRequest(new ExampleRequestSend());
```
### 3. 快速使用

- 调用接口进行交互

```php
use Tesoon\Account\ApiHelper;

//获取单个用户信息
$userInfo = ApiHelper::userGetUserByID(37290);

//获取多个用户信息
$userInfos = ApiHelper::userGetUserByIDs([1,2,3,4]);

//...具体接口参考接口文档或ApiHelper中方法
```
- 使用jwt生成一个加密的token

```php
use Tesoon\Account\AccountConfig;

$token = AccountConfig::getToken()->generateToken([
    'key' => '*****',//自定义加密key
    'jti' => 'VKTRshgYfxIonM6MuMMx09Z9aBXDcwJE',
    'exp' => time() + 3600,//有效截至时间
    'claims' => [
        //需要解密出来使用的业务逻辑数据
        'a' => 'a',
        'b' => [
            'c' => [
                'd' => '333'
            ]
        ]
    ]
]);
echo $token;//eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiI....
```

- 对登录生成的token进行解密并验证校验

```php
use Tesoon\Account\AccountConfig;

$tokenStr = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiI....';
$token = AccountConfig::getToken()->validateToken($tokenStr);

$jti = $token->getClaim('jti');
$identity = $token->getClaim('identity');
```
