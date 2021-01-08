Cara Instalasi .

Note: Jalankan ==  Tulis pada gitbash /  cmd kesayangan .

0. Clone git ini , bisa dari gitbash , ataupun donwload dari repo ini langsung
1. Jalankan composer install
2. jalankan  npm install 
3. jalankan cp .env.example .env
4. bikin databasenya , sesuaikan dengan yang di .env
5. jalankan php artisan migrate 
6. jalankan php artisan key:generate
7. jalankan php artisan passport:install



Aplikasi ini sangatlah sederhana , aplikasi ini adalah hasil rebuild dari amr-sispenbb.herokuapp.com yang asalnya hanya di bangun tanpa api 
dan di rebuild kembali menggunakan api . 
Yang saya pelajari saat membangun aplikasi ini :

1. Penerapan manajemen routing pada vue js yang terbagi menjadi beberapa bagian diantaranb
    a. public router = dibangun untuk user yang tidak login ,
    b. client router  = dibangun untuk user yang login dengan akses client (user biasa)
    c. admin router  = dibangun untuk user yang login dengan akses admin 
2. pendekatan kepada repositori pattern dengan laravel , 
    a.  untuk pendekatanya ini saya hanya sebatas membuat class repositori ext : produkRepos yang bertujuan untuk memahami tentang repositori pattern 
3. Penedekatan kepada cleancode yang di fokuskan kepada vue js.
    a. yang saya tekankan dalam clean code disini adalah , contoh :
        penggunaan sweetalert se efektif mungkin dalam  dnengan membuat kan beberapa class pada js diantaranya :
               1 .  Toast Class :  bertujuan untuk memanggil toast / pop up di pojok kanan atas hanya dengan memanggil function .  
                                    contoh :  this.$toast.df102().
                                   102 ada kode http request yang artinya memproses sesuatu 
               2.   Error Catch Class : untuk menangani toast error bisa memanggil function 
                                                this.$error.catch(dataResponError)
                                        dengan demikian beberapa error seperti 404, 500, 400  dapat diatasi hanya dengan menggunakan function itu.
4. selain itu juga disini penulis mencoba menggunakan teknik loadmore dari pada pagination pada vue js , dengan tetap menggunakan fungsi paginate pada laravel itu sendiri 

5. mengkonsumsi api dari rajaOnkir dalam menentukan biaya pengiriman , walau masih starterpack namun tidak ada salahnya .

6. menggunakan verifikasi im not robot oleh reCaptcha google versi 2 .
            a. dalam penggunaan reCaptcha ini , jika tidak dapat muncul verikasinya maka  programer harus membuat akun sendiri untuk mendapatkan key dari reCapt 
                itu , penulis sendiri disini hanya mendaftarkan 127.0.0.1:8000 yang dapat menggunakan reCapt secara lokal
                
selebihnya blm inget apa lagi yang udah di terapkan ,atau yang harus di tulis .  
            
