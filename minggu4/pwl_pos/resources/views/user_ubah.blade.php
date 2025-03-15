<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah User</title>
</head>
<body>
    <h1>Form Ubah User</h1>
    <a href="/user">Kembali</a>
    <form action="/user/ubah_simpan/{{ $data->user_id }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Masukkan Username" value="{{ $data->username }}">
        <br>
        <label for="nama">Nama User:</label>
        <input type="text" name="nama" id="nama" placeholder="Masukkan Nama User" value="{{ $data->nama }}">
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Masukkan Password" value="{{ $data->password }}">
        <br>
        <label for="level_id">ID Level:</label>
        <input type="number" name="level_id" id="level_id" placeholder="Masukkan ID Level" value="{{ $data->level_id }}">
        <br>
        <input type="submit" value="Ubah" class="btn btn-success">
    </form>
</body>
</html>