# Event / Listeners 

參考[這篇](https://laravel-china.org/articles/20712)

laravel的事件功能實際上更傾向是一種管理手段，並不是沒了它我們就做不到了，只是它能讓我們做得更加好，更加優雅。

註冊事件 : `app/Providers/EventServiceProvider.php`

事件 :     `app/Events/OrderReviewed.php`

監聽器 :   `app/Listeners/UpdateProductRating.php`

觸發 : 客戶對訂單(**Order**)內的資料留下評價(**OrdersController::sendReview()**)後，觸發計算並更新商品的評價及評分(**UpdateProductRating**)。

透過註冊事件將"事件"綁定"監聽器"，並在監聽器的 **handle** 方法中進行邏輯處理。

> 事件用處在"解耦"，例如用戶註冊完成(Event)後須完成的事項(Listeners) : 寄送 Mail、發送簡訊等等。
>
> 透過 註冊完成>事件>監聽器 將事件解耦成小單元，以利管理及維護。

# Job / Queue

任務 : `app/Jobs/CloseOrder.php`

觸發 : 訂單建立時會扣庫存，若不關閉未付款訂單則會造成庫存不足但未正確銷售的異常，故透過進行"延遲任務"在延遲 N 秒後將未付款訂單關閉。

Laravel 會用當前時間加上任務的延遲時間計算出任務應該被執行的時間戳，然後將這個時間戳和任務信息序列化之後存入隊列，Laravel 的隊列處理器會不斷查詢並執行隊列中滿足預計執行時間等於或早於當前時間的任務。

將訂單成立邏輯包裝於 **Services/Services/OrderService::store()** 內，若在 Controller 中透過 **CloseOrder::dispatch();** 分發任務，

在 Services 內直接用 **dispatch(new CloseOrder())** 分發任務，最後啟動隊列處理器 : 

```
php artisan queue:work
```

> 生產環境中透過進程工具[Supervisor](https://laravel-china.org/docs/laravel/5.5/queues#supervisor-configuration)持續執行隊列處理。

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


