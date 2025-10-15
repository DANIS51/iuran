<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use Illuminate\Http\Request;

class IuranController extends Controller
{
    //
    #menampilkan semua data iuran
    public function index() {
        $iurans = Iuran::all();
        return view('iuran.index', compact('iurans'));
    }
    #menampilkan data create iuran
    public function create(){
        return view('iuran.create');
    }

    #menambahkan data iuran
    public function store(Request $request) {
        $request->validate([
            'nama_iuran' => 'required|string|max:200',
            'jumlah' => 'required|numeric|min:0',
            'periode' => 'required',
            'keterangan' => 'nullable|string'

        ]);
        Iuran::create($request->all());

        return redirect()->route('iuran.index')->with('berhasil','menambahkan data');
    }

    #menampilkan edit
    public function edit($id){
        $iuran = Iuran::findOrFail($id);

        return view('iuran.edit', compact('iuran'));

    }

    #menampilkan edit
    public function update(Request $request, $id)
    {
        $iuran = Iuran::findOrFail($id);

        $request->validate([
            'nama_iuran' => 'required|string|max:200',
            'jumlah' => 'required|numeric|min:0',
            'periode' => 'required',
            'keterangan' => 'nullable|string'
        ]);

        $iuran->update($request->all());
        return redirect()->route('iuran.index')->with('berhasil','edit ');
    }

    #menghapus iuran
    public function destroy($id){
        $iuran = Iuran::findOrFail($id);
        $iuran->delete();
        return redirect()->route('iuran.index')->with('data berhasil di hapus');
    }
}
