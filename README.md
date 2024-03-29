<p align="center">
    <img src="https://github.com/riyan-amanda/lingkaran-web-news/blob/master/public/assets/logo/lingkaran.png?raw=true" alt="Lingkaran Web News" width="350px" height="100px">
    <hr/>
</p>

## Tentang Lingkaran

Lingkaran adalah website untuk memberikan berita-berita terbaru yang ada di Indonesia. Website ini dibangun menggunakan Framework Laravel dan terdapat beberapa package untuk mendukung jalannya website ini. List package yang terdapat pada website lingkaran dapat dilihat pada link dibawah.  

List package Website Lingkaran, diantaranya adalah:  

- Framework [Laravel](https://laravel.com/docs/7.x) v7.
- Design website menggunakan Framework [Bootstrap](https://getbootstrap.com/docs/4.5/getting-started/introduction/) v4.5.
- Template CMS menggunakan [Admin Bootstrap Gentelella](https://github.com/ColorlibHQ/gentelella).
- Hak akses dan Level User menggunakan [Spatie Laravel Permission](https://github.com/spatie/laravel-permission).
- Manipulasi gambar pada website menggunakan [Image Intervension](http://image.intervention.io/).
- Handle viewer menggunakan [Eloquent-Viewable](https://github.com/cyrildewit/eloquent-viewable) v5.2.
- Search post menggunakan [Livewire](https://laravel-livewire.com/).
- Deteksi lokasi berdasarkan IP menggunakan [Location](https://github.com/stevebauman/location) dari Stevebauman.
- Data table menggunakan [Yajra DataTables](https://datatables.yajrabox.com/).

### Instalasi
Instal [Composer](https://getcomposer.org/) pada Sistem Operasi agar command artisan dapat dijalankan. Masuk ke folder root aplikasi dan jalankan perintah instal pada terminal untuk download vendor yang dibutuhkan.

```javascript
//Download vendor untuk aplikasi
composer install
```

Jalankan perintah berikut untuk copy file `.env`, atau bisa juga copy secara manual. Sesuaikan pengaturan DATABASE dengan local sistem anda pada file `.env` ini.

```javascript
cp .env.example .env
```

Jalankan artisan command untuk generate key untuk keamanan aplikasi.

```javascript
//Generate key baru
php artisan key:generate
```
Jalankan artisan migration dan seeder pada terminal untuk membuat database dan default user.

```javascript
//Generate database baru dan user default
php artisan migrate --seed

```

Jalankan artisan serve pada terminal untuk jalankan server default laravel.

```javascript
//Local server default laravel
php artisan serve

```

### User Default Akses

```javascript
//Email login
superadmin@email.com

//Pass login
12345678
```

<hr/>
<p align="center">
NOTE: Website ini masih dalam pengembangan. Lingkaran @2020.
</p>