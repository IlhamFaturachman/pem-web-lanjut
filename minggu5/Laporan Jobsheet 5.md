# Laporan Jobsheet 5

**Nama**  : Ilham Faturachman  
**NIM**   : 244107023001  
**No Absen** : 12  
**Kelas** : TI - 2A  

---

## 📌 Praktikum 1 - Instalasi AdminLTE  

### 1️⃣ Instalasi AdminLTE ✅
Dengan menggunakan `composer require jeroennoten/laravel-adminlte` maka akan mendownload adminlte ke dalam project Laravel. setelah kita bisa menjalankan `php artisan adminlte:install` untuk menginstal adminlte.

![Hasil dengan composer](Screenshot%20Laporan/Praktikum1/praktikum1.png)

---

## 📌 Praktikum 2 - Integrasi Laravel DataTable  

### 1️⃣ Instalasi Laravel DataTable ✅
Dengan menggunakan `composer require yajra/laravel-datatables` maka akan mendownload laravel-datatables ke dalam project Laravel. 

### 2️⃣ Integrasi DataTable ✅
dengan menggunakan perintah `php artisan make:datatables KategoriDataTable` maka akan membuat file `KategoriDataTable.php` di dalam folder `app/DataTables`. dan itu bisa digunakan untuk menampilkan data kategori dalam tabel.

![Hasil dengan DataTable](Screenshot%20Laporan/Praktikum2/praktikum2.png)

---

## 📌 Praktikum 3 - Melakukan Proses create pada tabel Kategori dari datatable

### 1️⃣ Melakukan Proses create pada tabel Kategori dari datatable ✅
dengan menggunakan KategoriModel::create() pada controller kategori yang ada pada function store, kita bisa menambahkan data kategori baru ke dalam database.

![Hasil dengan insert data baru ke database](Screenshot%20Laporan/Praktikum3/praktikum3.png)


## 📌 Tugas Praktikum

### 1️⃣ Menambahkan tombol untuk mengarahkan ke halaman create ✅

![Hasil dengan tombol create](Screenshot%20Laporan/Tugas%20Praktikum/TP1.png)

### 2️⃣ Menambahkan tombol pada sidebar untuk mengarahkan ke halaman kategori ✅
dengan mengedit file adminlte, dan menambahkan opsi ke halaman kategori, saya bisa menambahkan tombol pada sidebar untuk mengarahkan ke halaman kategori.

![Hasil dengan tombol kategori](Screenshot%20Laporan/Tugas%20Praktikum/TP2.png)

### 3️⃣ Menambahkan tombol edit pada tabel dan menambahkan proses edit ✅

![Hasil dengan tombol edit](Screenshot%20Laporan/Tugas%20Praktikum/TP3.png)





