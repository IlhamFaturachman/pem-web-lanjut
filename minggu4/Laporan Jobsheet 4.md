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

![Hasil dengan find](Screenshot%20Laporan/Praktikum%202.1/Menggunakan%20Find.png)

### 5️⃣ Menggunakan $user = UserModel::where('level_id', 1)->first(); ✅
dengan menggunakan `where` maka akan mengambil data dari database berdasarkan level_id yang diinputkan, contoh $user = UserModel::where('level_id', 1)->first();

![Hasil dengan where](Screenshot%20Laporan/Praktikum%202.1/no-5.png)

### 7️⃣ Menggunakan $user = UserModel::firstWhere('level_id', 1); ✅
dengan menggunakan `firstWhere` maka akan mengambil data dari database berdasarkan level_id yang diinputkan, contoh $user = UserModel::firstWhere('level_id', 1); secaara lebih ringkas.

![Hasil dengan firstWhere](Screenshot%20Laporan/Praktikum%202.1/no-7.png)

### 9️⃣ Menggunakan $user = UserModel::findOr(1, ['username', 'nama'], function () { abort(404); }); ✅
dengan menggunakan `findOr` maka akan mengambil data dari database berdasarkan id yang diinputkan, contoh $user = UserModel::findOr(1, ['username', 'nama'], function () { abort(404); }); tetapi pada kode saya, hanya mendapatkan data dari username dan nama.

![Hasil dengan findOr](Screenshot%20Laporan/Praktikum%202.1/no-9.png)

### 1️⃣2️⃣ Menggunakan $user = UserModel::findOr(20, ['username', 'nama'], function () { abort(404); }); ✅
dengan menggunakan `findOr` maka akan mengambil data dari database berdasarkan id yang diinputkan, contoh $user = UserModel::findOr(20, ['username', 'nama'], function () { abort(404); }); tetapi pada kode saya, tidak ada data user yang memiliki id 20, jadi tidak ada data yang ditemukan

![Hasil dengan findOr](Screenshot%20Laporan/Praktikum%202.1/no-11.png)





