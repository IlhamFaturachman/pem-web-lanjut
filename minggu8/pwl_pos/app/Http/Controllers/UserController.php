<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Monolog\Level;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'User',
            'list' => ['Home', 'User'],
        ];
        $page = (object)[
            'title' => 'Daftar User yang terdaftar pada sistem',
        ];

        $activeMenu = 'user';

        $level = LevelModel::all();

        return view('user.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu,
        ]);
    }


    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'profile_pic', 'username', 'nama', 'level_id')
            ->with('level');

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('foto', function ($user) {
                $url = $user->profile_pic
                    ? asset('uploads/profile/' . $user->profile_pic)
                    : asset('placeholder.png'); // pastikan placeholder ini ada

                return '<img src="' . $url . '" width="40" height="40" style="object-fit: cover; border-radius: 50%;">';
            })
            ->addColumn('aksi', function ($user) {
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['foto', 'aksi']) // jangan lupa tambahkan 'foto' di sini!
            ->make(true);
    }


    // Menampilkan halaman form tambah user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah User']
        ];

        $page = (object) [
            'title' => 'Tambah User baru'
        ];

        $level = LevelModel::all();
        $activeMenu = 'user';

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_name')->get();

        return view('user.create_ajax')->with('level', $level);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'User berhasil ditambahkan');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id'    => 'required|integer',
                'username'    => 'required|string|min:3|unique:m_user,username',
                'nama'        => 'required|string|max:100',
                'password'    => 'required|min:6',
                'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // optional
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            // Proses penyimpanan user baru
            $user = new UserModel();
            $user->level_id = $request->level_id;
            $user->username = $request->username;
            $user->nama = $request->nama;
            $user->password = $request->password;

            // Jika ada file profile_pic yang diunggah
            if ($request->hasFile('profile_pic')) {
                $file = $request->file('profile_pic');

                // Buat nama file unik
                $filename = 'profile_' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

                // Simpan ke folder public/uploads/profile/
                $file->move(public_path('uploads/profile'), $filename);

                // Simpan nama file ke kolom profile_pic
                $user->profile_pic = $filename;
            }

            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }

        return redirect('/');
    }


    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail User']
        ];

        $page = (object) [
            'title' => 'Detail User'
        ];

        $activeMenu = 'user';

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }



    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Ubah User',
            'list' => ['Home', 'User', 'Ubah User']
        ];

        $page = (object) [
            'title' => 'Ubah User'
        ];

        $activeMenu = 'user';

        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_name')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama'     => 'required|string|max:100', //harus, string, maksimal 100 karakter
            'password' => 'nullable|min:5', //tidak wajib
            'level_id' => 'required|integer' //harus, angka
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'User berhasil diubah');
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:6|max:20',
                'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:2048' // validasi foto
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $user = UserModel::find($id);
            if ($user) {
                // Hapus password dari input jika kosong
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }

                // Jika ada file profile_pic yang diunggah
                if ($request->hasFile('profile_pic')) {
                    $file = $request->file('profile_pic');

                    // Buat nama file unik
                    $filename = 'profile_' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

                    // Simpan ke folder public/uploads/profile/
                    $file->move(public_path('uploads/profile'), $filename);

                    // Simpan nama file ke kolom profile_pic
                    $user->profile_pic = $filename;
                }

                // Update data lainnya
                $user->fill($request->except('profile_pic')); // hindari overwrite jika tidak upload
                $user->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }


    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id);
            return redirect('/user')->with('success', 'User berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'User tidak dapat dihapus karena masih terhubung dengan data lain');
        }
    }

    public function confirm_ajax(string $id)
    {
        $user = UserModel::find($id);

        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }
}
