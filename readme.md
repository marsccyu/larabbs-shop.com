# Plugins

* [Laravel-mix](https://laravel-mix.com/docs/2.1/installation) : 資源任務編譯器
* [Laravel-lang](https://github.com/overtrue/laravel-lang/) : 語言包  
* [Sweetalert](http://mishengqiang.com/sweetalert/) : 美化瀏覽器彈出視窗 (npm)  
* [Laravel-Admin](https://github.com/z-song/laravel-admin) : 管理後台  
* [Redis](https://redis.io/) : Redis (6.5節中隊列驅動需使用)
* [Yansongda/pay](https://github.com/yansongda/pay) : 封裝了支付寶和微信支付的接口

<br>

## Laravel-mix
 編譯 SASS 及 JS ，使用方式參考[文檔](https://laravel-china.org/docs/laravel/5.5/mix/1307)
 
#### Installation
```
npm install
```
<br />

edit `webpack.mix.js file` : 

```js
mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .version();
```


<br><br>

## Laravel-lang

#### Installation

將訊息轉換成不同地區語言的語言包。

```
composer require "overtrue/laravel-lang:~3.0"
```
<br />

`config/app.php`

```
'locale' => 'zh-CN',
```

<br><br>

## Laravel-Admin

#### Installation


```
composer require encore/laravel-admin
```
<br />

Then run these commands to publish assets and config：

```
php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
```
<br />

At last run following command to finish install.

```
php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
```

<br><br>

## Redis

#### Installation

```
composer require predis/predis
```

change `.env` file option : 

```php
QUEUE_DRIVER=redis
```


