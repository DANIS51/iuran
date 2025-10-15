<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use App\Models\User;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    public function index()
    {
        $officers = Officer::with('user')->get();
        return view('officer.index', compact('officers'));
    }

    public function create()
    {
        $users = User::all(); // untuk dropdown pilih user
        return view('officer.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Officer::create($request->only('name', 'user_id'));

        return redirect()->route('officer.index')->with('success', 'Petugas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $officer = Officer::findOrFail($id);
        $users = User::all();
        return view('officer.edit', compact('officer', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $officer = Officer::findOrFail($id);
        $officer->update($request->only('name', 'user_id'));

        return redirect()->route('officer.index')->with('success', 'Data petugas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Officer::findOrFail($id)->delete();
        return redirect()->route('officer.index')->with('success', 'Petugas berhasil dihapus!');
    }
}
