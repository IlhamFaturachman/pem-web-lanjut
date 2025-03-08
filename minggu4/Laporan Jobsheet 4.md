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
