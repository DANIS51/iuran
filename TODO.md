# TODO: Fix Pembayaran Form Submission Issue

## Steps to Complete
- [x] Check resources/views/pembayaran/edit.blade.php for similar field name and status mismatches
- [ ] Update resources/views/pembayaran/create.blade.php: Change name="jumlah_bayar" to name="jumlah", and status options to "belum" and "lunas"
- [ ] Update app/Http/Controllers/PembayaranController.php: Change status validation to 'in:belum,lunas'
- [ ] Update resources/views/pembayaran/edit.blade.php: Change name="jumlah_bayar" to name="jumlah", and status options to "belum" and "lunas"
- [ ] Test the form submission to ensure it works
