# Plugins

* [Laravel-mix](https://laravel-mix.com/docs/2.1/installation) : 資源任務編譯器

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
