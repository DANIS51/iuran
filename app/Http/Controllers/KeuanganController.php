<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function index()
    {
        // ambil data keuangan terbaru
        $keuangans = Keuangan::orderBy('tanggal', 'desc')->get();
    // hitung total masuk & keluar dari keuangan secara eksplisit
    $totalMasukKeuangan = Keuangan::where('tipe', 'masuk')->sum('jumlah');
    $totalKeluar = Keuangan::where('tipe', 'keluar')->sum('jumlah');

    // hitung total dari pembayaran (uang masuk dari pembayaran)
    $totalPembayaran = \App\Models\Pembayaran::sum('jumlah');

    // hitung net keuangan (masuk - keluar) menggunakan CASE di DB untuk menghindari
    // kebalikan tanda jika ada penyimpanan/format yang tidak konsisten
    $keuanganNet = Keuangan::selectRaw("SUM(CASE WHEN tipe = 'masuk' THEN jumlah WHEN tipe = 'keluar' THEN -jumlah ELSE 0 END) as net")->value('net') ?? 0;

    // total masuk untuk tampilan = pembayaran + keuangan masuk
    $totalMasuk = $totalPembayaran + $totalMasukKeuangan;

    // saldo akhir = pembayaran + (keuangan masuk - keuangan keluar)
    $saldoAkhir = $totalPembayaran + $keuanganNet;

        // Data yang akan dikirim ke view (tambahkan breakdown agar blade bisa menampilkan detail)
        $viewData = [
            'keuangans' => $keuangans,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'saldoAkhir' => $saldoAkhir,
            'totalPembayaran' => $totalPembayaran,
            'totalMasukKeuangan' => $totalMasukKeuangan,
            'keuanganNet' => $keuanganNet,
        ];

        // Cek role user dan arahkan ke view yang sesuai
        if(Auth::user()->role == 'officer') {
            return view('officer.keuangan', $viewData);
        }
        
        return view('keuagan.index', $viewData);
    }

    public function create()
    {
        if(Auth::user()->role == 'officer') {
            return view('officer.keuangan.create');
        }
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

    // Normalisasi input: pastikan tipe lowercase dan jumlah selalu disimpan sebagai nilai positif
    $data = $request->only(['tipe', 'keterangan', 'jumlah', 'tanggal']);
    $data['tipe'] = strtolower($data['tipe']);
    $data['jumlah'] = abs($data['jumlah']);

    Keuangan::create($data);

        return redirect()->route(Auth::user()->role == 'officer' ? 'officer.keuangan' : 'keuangan.index')
            ->with('success', 'Data keuangan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        Keuangan::findOrFail($id)->delete();

        return redirect()->route(Auth::user()->role == 'officer' ? 'officer.keuangan' : 'keuangan.index')
            ->with('success', 'Data keuangan berhasil dihapus.');
    }
}
