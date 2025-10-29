<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\Pembayaran;
use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    //
    #untuk menampilkan dashboard
    public function dashboard()
    {
        $totalWarga = Warga::count();
        $totalIuran = Iuran::count();
        $totalPembayaran = Pembayaran::sum('jumlah');
        $pembayaranLunas = Pembayaran::where('status', 'lunas')->count();
        $pembayaranTerbaru = Pembayaran::with(['warga', 'iuran'])
            ->latest()
            ->take(5)
            ->get();

        // Hitung total pemasukan dari pembayaran dan keuangan
        $totalPemasukan = $totalPembayaran + \App\Models\Keuangan::where('tipe', 'masuk')->sum('jumlah');
        $totalPengeluaran = \App\Models\Keuangan::where('tipe', 'keluar')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // Ambil semua transaksi keuangan (pembayaran + keuangan)
        $transaksiPembayaran = Pembayaran::with(['warga', 'iuran'])
            ->orderBy('tanggal_bayar', 'desc')
            ->get()
            ->map(function ($p) {
                return [
                    'tanggal' => $p->tanggal_bayar,
                    'tipe' => 'masuk',
                    'keterangan' => 'Pembayaran ' . ($p->iuran->nama_iuran ?? 'Iuran') . ' - ' . ($p->warga->nama ?? 'Warga'),
                    'jumlah' => $p->jumlah,
                    'sumber' => 'pembayaran',
                ];
            });

        $transaksiKeuangan = \App\Models\Keuangan::orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($k) {
                return [
                    'tanggal' => $k->tanggal,
                    'tipe' => $k->tipe,
                    'keterangan' => $k->keterangan,
                    'jumlah' => $k->jumlah,
                    'sumber' => 'keuangan',
                ];
            });

        // Gabungkan dan urutkan berdasarkan tanggal
        $semuaTransaksi = $transaksiPembayaran->concat($transaksiKeuangan)
            ->sortByDesc('tanggal')
            ->take(10); // Ambil 10 terbaru

        return view('warga.dashboard', compact(
            'totalWarga',
            'totalIuran',
            'totalPembayaran',
            'pembayaranLunas',
            'pembayaranTerbaru',
            'semuaTransaksi',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir'
        ));
    }
    #Menampilkan seluruh data warga
    public function index(){
        $wargas = Warga::all();
        return view('warga.index', compact('wargas'));
    }
    #Menampilkan form tambah warga
    public function create(){
        return view('warga.create');
    }

    #Membuat data warga
    public function store(Request $request){
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon'=> 'required|string|max:13'
        ]);
        Warga::create($request->all());
        return redirect()->route('warga.index')->with('Berhasil', 'berhasil menambahkan data');
    }
    #untuk menampilkan form edit
    public function edit($id){
        $warga = Warga::findOrFail($id);
        return view('warga.update', compact('warga'));
    }

    #untuk mengupdate data warga
    public function update(Request $request, $id){
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon'=> 'required|string|max:13',
            'jenis_kelamin'=> 'nullable|in:Laki-Laki,Perempuan',

        ]);

        $warga = Warga::findOrFail($id);
        $warga->update($request->all());
        return redirect()->route('warga.index')->with('Berhasil', 'berhasil mengupdate data');
    }
    #Menghapus data warga
    public function destroy($id){
        $warga = Warga::findOrFail($id);
        $warga->delete();
        return redirect()->route('warga.index')->with('Berhasil', 'berhasil menghapus data');
    }
}
