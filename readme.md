# Plugins

* [Laravel-mix](https://laravel-mix.com/docs/2.1/installation) : 資源任務編譯器
* [Laravel-lang](https://github.com/overtrue/laravel-lang/) : 語言包  
* [Sweetalert](http://mishengqiang.com/sweetalert/) : 美化瀏覽器彈出視窗 (npm)  

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
