<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Iuran;
use App\Models\Warga;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // ===================== INDEX =====================
    public function index()
    {
        $pembayarans = Pembayaran::with(['warga', 'iuran'])->get();
        return view('pembayaran.index', compact('pembayarans'));
    }

    // ===================== CREATE =====================
    public function create()
    {
        $wargas = Warga::all();
        $iurans = Iuran::all();
        return view('pembayaran.create', compact('wargas', 'iurans'));
    }

    // ===================== STORE =====================
    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'iuran_id' => 'required|exists:iurans,id',
            'tanggal_bayar' => 'required|date',
            'jumlah' => 'required|numeric|min:100',
        ]);

        $iuran = Iuran::findOrFail($request->iuran_id);
        $totalIuran = (int) $iuran->jumlah;

        // Hitung total pembayaran sebelumnya
        $totalBayarSebelumnya = Pembayaran::where('warga_id', $request->warga_id)
            ->where('iuran_id', $request->iuran_id)
            ->sum('jumlah');

        // Jika sudah lunas, tidak boleh tambah lagi
        if ($totalBayarSebelumnya >= $totalIuran) {
            return redirect()->back()
                ->with('error', 'Iuran ini sudah lunas, tidak bisa menambah pembayaran lagi.');
        }

        $jumlahBaru = (int) $request->jumlah;
        $totalBayarBaru = $totalBayarSebelumnya + $jumlahBaru;

        // Jika total bayar melebihi jumlah iuran
        if ($totalBayarBaru > $totalIuran) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Total pembayaran melebihi jumlah iuran yang harus dibayar!');
        }

        // Tentukan status otomatis
        $status = $totalBayarBaru >= $totalIuran ? 'lunas' : 'belum';

        Pembayaran::create([
            'warga_id' => $request->warga_id,
            'iuran_id' => $request->iuran_id,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah' => $jumlahBaru,
            'status' => $status,
        ]);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    // ===================== EDIT =====================
    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $wargas = Warga::all();
        $iurans = Iuran::all();
        return view('pembayaran.edit', compact('pembayaran', 'wargas', 'iurans'));
    }

    // ===================== UPDATE =====================
    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'iuran_id' => 'required|exists:iurans,id',
            'tanggal_bayar' => 'required|date',
            'jumlah' => 'required|numeric|min:100',
        ]);

        $iuran = Iuran::findOrFail($request->iuran_id);
        $totalIuran = (int) $iuran->jumlah;

        // Hitung total pembayaran sebelumnya (kecuali yang sedang diedit)
        $totalBayarSebelumnya = Pembayaran::where('warga_id', $request->warga_id)
            ->where('iuran_id', $request->iuran_id)
            ->where('id', '!=', $id)
            ->sum('jumlah');

        $jumlahBaru = (int) $request->jumlah;
        $totalBayarBaru = $totalBayarSebelumnya + $jumlahBaru;

        // Jika total melebihi iuran
        if ($totalBayarBaru > $totalIuran) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Total pembayaran melebihi jumlah iuran yang harus dibayar!');
        }

        // Tentukan status otomatis
        $status = $totalBayarBaru >= $totalIuran ? 'Lunas' : 'Belum Lunas';

        $pembayaran->update([
            'warga_id' => $request->warga_id,
            'iuran_id' => $request->iuran_id,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah' => $jumlahBaru,
            'status' => $status,
        ]);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    // ===================== DESTROY =====================
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus.');
    }
}
