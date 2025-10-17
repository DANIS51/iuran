<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        // ambil data keuangan terbaru
        $keuangans = Keuangan::orderBy('tanggal', 'desc')->get();

        // hitung total masuk & keluar dari keuangan
        $totalMasukKeuangan = Keuangan::where('tipe', 'masuk')->sum('jumlah');
        $totalKeluar = Keuangan::where('tipe', 'keluar')->sum('jumlah');

        // hitung total dari pembayaran (uang masuk dari pembayaran)
        $totalPembayaran = \App\Models\Pembayaran::sum('jumlah');

        // total masuk = pembayaran + keuangan masuk
        $totalMasuk = $totalPembayaran + $totalMasukKeuangan;

        // saldo akhir = total masuk - total keluar
        $saldoAkhir = $totalMasuk - $totalKeluar;

        // kirim ke view
        return view('keuagan.index', [
            'keuangans' => $keuangans,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'saldoAkhir' => $saldoAkhir,
        ]);
    }

    public function create()
    {
        return view('keuagan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:masuk,keluar',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:100',
            'tanggal' => 'required|date',
        ]);

        Keuangan::create($request->only(['tipe', 'keterangan', 'jumlah', 'tanggal']));

        return redirect()->route('keuangan.index')
            ->with('success', 'Data keuangan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        Keuangan::findOrFail($id)->delete();

        return redirect()->route('keuangan.index')
            ->with('success', 'Data keuangan berhasil dihapus.');
    }
}
