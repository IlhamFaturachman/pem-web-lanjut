# Laporan Jobsheet 7

**Nama**  : Ilham Faturachman  
**NIM**   : 244107023001  
**No Absen** : 12  
**Kelas** : TI - 2A  

---

## 📌 Praktikum 1 - Membuat form login menggunakan template adminlte

### 📝Deskripsi
Pada praktikum kali ini, saya menambahkan form  untuk login menggunakan template adminlte

![Login](Screenshot%20Laporan/Praktikum1/p-1.png)


## 📌 Tugas 1 - Implementasi login dan logout pada program saya

### 📝Deskripsi
Pada tugas kali ini, saya telah melakukan implementasi login dan logout, dimana step step nya adalah

1. user membuka halaman login
![Login](Screenshot%20Laporan/Tugas1/t-1.png)

2. user melakukan proses login
![Login](Screenshot%20Laporan/Tugas1/t-2.png)

3. user melakukan proses logout
![Login](Screenshot%20Laporan/Tugas1/t-3.png)


## 📌 Praktikum 2 - Mengimplementasikan middleware Authorization untuk tiap user yang login

### 📝Deskripsi
Pada praktikum kali ini, saya menambahkan middleware Authorization untuk tiap user yang login, agar user yang tidak sesuai rolenya tidak bisa mengakses halaman yang sudah saya set rolenya

![Login](Screenshot%20Laporan/Praktikum2/p-1.png)


## 📌 Tugas 2 - Implementasi middleware Authorization pada program saya

### 📝Deskripsi
Pada tugas kali ini, saya telah melakukan implementasi middleware Authorization pada program saya, dan yang bisa saya pahami adalah saya berhasil memberikan authorization alias halaman apa saja dan route apa saja yang bisa diakses oleh role user tertentu. dimana step step nya adalah

1. Saya Menambahkan middleware authorization untuk setiap user yang login
2. Saya Menambahkan authorization pada routing saya, agar saya bisa mengatur halaman apa saja dan route apa saja yang bisa diakses oleh role user tertentu
3. Dan jika user yang login authorization nya tidak sesuai maka yang akan terjadi adalah muncul halaman 403 forbidden

![Forbidden](Screenshot%20Laporan/Praktikum2/p-1.png)

## 📌 Praktikum 3 - Mengimplementasikan middleware Multi - Authorization untuk tiap user yang login

### 📝Deskripsi
Pada praktikum kali ini, saya menambahkan middleware Multi - Authorization untuk tiap user yang login, agar user yang tidak sesuai rolenya tidak bisa mengakses halaman yang sudah saya set rolenya, dan pada praktikum kali ini saya berhasil menambah role lain agar bisa mengakses halaman tersebut

![Multi Level Auth](Screenshot%20Laporan/Praktikum3/p-1.png)

## 📌 Tugas 3 - Implementasi middleware Multi - Authorization pada program saya

### 📝Deskripsi
Pada tugas kali ini, saya telah melakukan implementasi middleware Multi - Authorization pada program saya, dimana step step nya adalah

1. Saya Menambahkan middleware multi - authorization untuk setiap user yang login
2. Saya Menambahkan authorization pada routing saya, agar saya bisa mengatur halaman apa saja dan route apa saja yang bisa diakses oleh role user tertentu
3. Dan jika user yang login authorization nya tidak sesuai maka yang akan terjadi adalah muncul halaman 403 forbidden


## 📌 Tugas 4 - Menambahkan proses register

### 📝Deskripsi
Pada tugas kali ini, saya telah melakukan implementasi proses register pada program saya, dimana step step nya adalah

1. Saya Menambahkan halaman register
2. Saya Menambahkan proses register pada controller
3. Saya Menambahkan routing pada web.php untuk register user
4. dan saya juga menambahkan beberapa validasi seperti re-type password
5. Saya membuat ketika user pertama kali login otomatis menjadi customer, dan nantinya bisa diubah rolenya oleh admin

![Register](Screenshot%20Laporan/Tugas4/t-1.png)


