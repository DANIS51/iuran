# TODO: Tambahkan Fitur Pembayaran untuk Beberapa Periode (Bulan, Minggu, Tahunan)

## Tugas

- [x] Edit `resources/views/pembayaran/create.blade.php`:
  - Tambahkan field "Jumlah Periode" (input number, default 1, min 1) untuk menentukan berapa periode yang ingin dibayar.
  - Tetap ada field "Jumlah Bayar (Rp)" untuk memungkinkan cicilan atau pembayaran penuh beberapa periode.

- [x] Update `app/Http/Controllers/PembayaranController.php`:
  - Tambahkan validasi untuk field baru 'jumlah_periode' (required, integer, min:1).
  - Dalam method store, hitung jumlah_bayar = jumlah_periode * iuran->jumlah, lalu gunakan logika existing untuk memproses pembayaran.

- [ ] File Dependensi:
  - resources/views/pembayaran/create.blade.php (utama).
  - app/Http/Controllers/PembayaranController.php.
  - Jika diperlukan, update resources/views/pembayaran/edit.blade.php dengan perubahan serupa.

- [ ] Langkah Selanjutnya:
  - Test form untuk memastikan controller menghitung jumlah bayar dengan benar dan memproses pembayaran untuk multiple periode.
  - Pastikan pembayaran untuk beberapa periode dibuat sebagai record terpisah dengan tanggal yang sesuai periode.
