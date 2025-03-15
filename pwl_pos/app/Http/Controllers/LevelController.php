<?php

namespace App\Http\Controllers;

use App\DataTables\LevelDataTable;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index(LevelDataTable $dataTable)
    {
        return $dataTable->render('level.index');
    }

    public function create()
    {
        return view('level.create');
    }

    public function store(Request $request)
    {
        LevelModel::create([
            'level_kode' => $request->kodeLevel,
            'level_name' => $request->namaLevel,
        ]);

        return redirect('/level');
    }
    public function edit($id)
    {
        $level = LevelModel::findOrFail($id);
        return view('level.edit', compact('level'));
    }

    public function update(Request $request, $id)
    {
        $level = LevelModel::findOrFail($id);
        $level->update([
            'level_kode' => $request->kodeLevel,
            'level_name' => $request->namaLevel,
        ]);
        return redirect('/level');
    }

    public function destroy($id)
    {
        $level = LevelModel::findOrFail($id);
        $level->delete();
        return redirect('/level');
    }
}
