# REST

REST 是一個方便呼叫 REST API 的函式庫。它可以使用 [Rest](/src/Rest.php) 類別，加上 API 設定，即可成為一個客製化的 SDK。

## 快速開始

使用 Composer 將套件加入

    composer require 104corp/rester

接著使用 Rest：

```php
use MilesChou\Rest\Rest;

// 初始化 Rest 物件
$rest = new Rest($psr18client, $psr17Factories);
$rest->addApi('foo', 'GET', 'http://somewhere/{path}');

// GET http://somewhere/some-path
$response = $rest->call('foo', 'some-path')->send();

// PSR-7 Response
echo (string)$response->getBody();
```

接著就能看得到 response 的內容。
