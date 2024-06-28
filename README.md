Cara install :

File Laravel :
- Unzip / extract file
- Buka terminal di folder laravel projectnya
- Ketik composer install
- Ketik php artisan key:generate
- Ketik php artisan serve

Database :
- Install PostgreSQL
- Setelah berhasil diinstall, buka aplikasi pgAdmin
- Klik server "Servers" yang ada di sebelah kiri
- Masukkan password postgreSQL yang pada waktu install dibuat
- Membuat username "Login/Group Roles" menggunakan nama "laundrymgm"
- Create database "laundry_db" ke "Databases" dengan nama Owner "laundrymgm"
- Di file env. yang ada di file laravel, ganti DB_USERNAME=laundrymgm dan DB_PASSWORD=laundrymgm
- Di bagian "Login/Group Roles" klik yang usernamenya "laundrymgm"
- Lalu klik kanan, pilih Properties
- Di bagian tab definition tulis password laundrymgm
- Di privileges semua bagian kecuali bagian "Can intiate streaming reaplication and backups?"
