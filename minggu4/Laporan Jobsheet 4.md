# Laporan Praktikum 1 - $fillable

**Nama**  : Ilham Faturachman  
**NIM**   : 244107023001  
**No Absen** : 12  
**Kelas** : TI - 2A  

---

## 📌 Praktikum 1 - $fillable  

### 1️⃣ Insert Data dengan Fillable ✅  
Pada saat kita membuat user baru, proses akan berhasil karena semua data pada array `UserController` akan tersimpan dalam tabel `m_user` berdasarkan atribut yang telah didefinisikan di `$fillable`.  

![Hasil dengan fillable lengkap](Screenshot%20Laporan/Praktikum%201/Praktikum%201%20-%201.png)

---

### 2️⃣ Insert Data tanpa Memenuhi Fillable ❌  
Ketika kita mencoba menambahkan user, tetapi tidak sesuai dengan `$fillable`, maka akan terjadi error karena Laravel hanya menerima data yang sudah ditentukan dalam model.  

![Hasil dengan fillable tidak lengkap](Screenshot%20Laporan/Praktikum%201/Praktikum%201%20-%202.png)

---

✅ **Kesimpulan**:  
- `$fillable` digunakan untuk menentukan field mana yang boleh diisi saat melakukan proses penambahan data pada database.  
- Jika sebuah field tidak termasuk dalam `$fillable`, maka Laravel akan menolak input tersebut untuk mencegah menambah data yang tidak sesuai dengan atribut yang diizinkan pada database.  

---

## 📌 Praktikum 2.1 - Retrieving Single Models

### 3️⃣ Menggunakan $user = UserModel::find($id); ✅
dengan menggunakan `find` maka akan mengambil data dari database berdasarkan id yang diinputkan, contoh $user = UserModel::find(1);

![Hasil dengan find](Screenshot%20Laporan/Praktikum%202/Menggunakan%20Find.png)

### 5️⃣ Menggunakan $user = UserModel::where('level_id', 1)->first(); ✅
dengan menggunakan `where` maka akan mengambil data dari database berdasarkan level_id yang diinputkan, contoh $user = UserModel::where('level_id', 1)->first();

![Hasil dengan where](Screenshot%20Laporan/Praktikum%202/no-5.png)

### 7️⃣ Menggunakan $user = UserModel::firstWhere('level_id', 1); ✅
dengan menggunakan `firstWhere` maka akan mengambil data dari database berdasarkan level_id yang diinputkan, contoh $user = UserModel::firstWhere('level_id', 1); secaara lebih ringkas.

![Hasil dengan firstWhere](Screenshot%20Laporan/Praktikum%202/no-7.png)

### 9️⃣ Menggunakan $user = UserModel::findOr(1, ['username', 'nama'], function () { abort(404); }); ✅
dengan menggunakan `findOr` maka akan mengambil data dari database berdasarkan id yang diinputkan, contoh $user = UserModel::findOr(1, ['username', 'nama'], function () { abort(404); }); tetapi pada kode saya, hanya mendapatkan data dari username dan nama.

![Hasil dengan findOr](Screenshot%20Laporan/Praktikum%202/no-9.png)

### 1️⃣2️⃣ Menggunakan $user = UserModel::findOr(20, ['username', 'nama'], function () { abort(404); }); ✅
dengan menggunakan `findOr` maka akan mengambil data dari database berdasarkan id yang diinputkan, contoh $user = UserModel::findOr(20, ['username', 'nama'], function () { abort(404); }); tetapi pada kode saya, tidak ada data user yang memiliki id 20, jadi tidak ada data yang ditemukan

![Hasil dengan findOr](Screenshot%20Laporan/Praktikum%202/no-12.png)

---

## 📌 Praktikum 2.2 - Not Found Exception ✅

### 3️⃣ Menggunakan $user = UserModel::findOrFail($id); ✅
Dengan menggunakan `findOrFail` maka akan mengambil data dari database berdasarkan id yang diinputkan, contoh $user = UserModel::findOrFail(1);

![Hasil dengan findOr](Screenshot%20Laporan/Praktikum%202/2-2/2.png)

### 5️⃣ Contoh error gagal mendapat data ✅

![Hasil dengan findOr](Screenshot%20Laporan/Praktikum%202/2-2/5.png)

---

## 📌 Praktikum 2.3 - Retrieving Aggregations ✅

### 2️⃣ Menampilkan jumlah user berdasarkan level_id ✅
Dengan menggunakan `count` maka akan menghitung jumlah data user berdasarkan level_id. dan karena kita menggunakan die dump, atau dd() pada laravel, otomatis maka prosesnya akan terhenti ketika dd() berlangsung.

![Hasil dengan count](Screenshot%20Laporan/Praktikum%202/2-3/2.png)

### 4️⃣ Menampilkan jumlah user pada view ✅
Untuk menampilkan datanya, kita hanya perlu menghapus dd() dan mengganti dengan return view. lalu sesuaikan halaman bladenya agar sesuai dengan data yang diinginkan.

![Hasil dengan max](Screenshot%20Laporan/Praktikum%202/2-3/4.png)

---

## 📌 Praktikum 2.4 - Retrieving or Creating Models ✅

### 3️⃣ Menggunakan firstOrCreate ✅
Dengan menggunakan `firstOrCreate` maka akan mengambil data dari database berdasarkan id yang diinputkan, contoh $user = UserModel::firstOrCreate(['username' => 'manager'], ['nama' => 'Manager']); dan jika tidak ada data yang ditemukan, maka akan membuat data baru.

![Hasil dengan firstOrCreate](Screenshot%20Laporan/Praktikum%202/2-4/3.png)

### 5️⃣ Menggunakan firstOrCreate dengan data yang belum ada ✅
Dengan menggunakan `firstOrCreate` maka akan mengambil data dari database berdasarkan id yang diinputkan, dan jika tidak ada data yang ditemukan, maka akan membuat data baru. disini saya mencoba cari data manager 22, namun tidak ada jadi diputuskan untuk membuat record baru pada database

![Hasil dengan firstOrCreate](Screenshot%20Laporan/Praktikum%202/2-4/5.png)

### 7️⃣ Menggunakan firstOrNew ✅
Dengan menggunakan `firstOrNew` maka akan mengambil data dari database berdasarkan id yang diinputkan, dan jika tidak ada data yang ditemukan, maka akan membuat data baru.

![Hasil dengan firstOrNew](Screenshot%20Laporan/Praktikum%202/2-4/7.png)

### 9️⃣ Menggunakan firstOrNew dengan data yang belum ada tanpa save() ✅
Dengan menggunakan `firstOrNew` maka akan mengambil data dari database berdasarkan id yang diinputkan, dan jika tidak ada data yang ditemukan, maka akan membuat data baru. disini saya mencoba cari data manager 33, namun tidak ada jadi diputuskan untuk membuat record baru pada database, tapi dikarenakan tidak ada save() maka tidak akan melakukan proses penginputan ke database, melainkan hanya datanya yang terkirim ke view

![Hasil dengan firstOrNew](Screenshot%20Laporan/Praktikum%202/2-4/9.png)

### 1️⃣1️⃣ Menggunakan firstOrNew dengan data yang belum ada dengan save() ✅
Dengan menggunakan `firstOrNew` maka akan mengambil data dari database berdasarkan id yang diinputkan, dan jika tidak ada data yang ditemukan, maka akan membuat data baru. disini saya mencoba cari data manager 33, namun tidak ada jadi diputuskan untuk membuat record baru pada database, nah karena ada save() maka akan melakukan proses penginputan ke database

![Hasil dengan firstOrNew](Screenshot%20Laporan/Praktikum%202/2-4/11.png)

---

✅ **Kesimpulan**:  
- `firstOrCreate` digunakan untuk mengambil data dari database berdasarkan id yang diinputkan, dan jika tidak ada data yang ditemukan, maka akan membuat data baru.  
- `firstOrNew` digunakan untuk mengambil data dari database berdasarkan id yang diinputkan, dan jika tidak ada data yang ditemukan, maka akan membuat data baru, dengan catatan harus menggunakan `save()`.  
- `save()` digunakan untuk menyimpan data ke database.

---

## 📌 Praktikum 2.5 - Attribute changes ✅

### 2️⃣ Menggunakan $user->isDirty(); ✅
Dengan menggunakan `isDirty` yang akan mengembalikan boolean true jika ada attribute yang berubah, dan false jika tidak ada attribute yang berubah.

![Hasil dengan isDirty](Screenshot%20Laporan/Praktikum%202/2-5/2.png)

### 4️⃣ Menggunakan $user->wasChanged(); ✅
Dengan menggunakan `wasChanged` yang akan mengembalikan boolean true jika ada attribute yang berubah, dan false jika tidak ada attribute yang berubah. dalam hal ini, username berubah menjadi manager11.

![Hasil dengan wasChanged](Screenshot%20Laporan/Praktikum%202/2-5/4.png)

---

✅ **Kesimpulan**:  
- `isDirty` digunakan untuk mengembalikan boolean true jika ada attribute yang berubah, dan false jika tidak ada attribute yang berubah.  
- `wasChanged` digunakan untuk mengembalikan boolean true jika ada attribute yang berubah, dan false jika tidak ada attribute yang berubah.













