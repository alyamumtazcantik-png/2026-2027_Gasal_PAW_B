USE db_penjualan;

SELECT
    transaksi.transaksi_id,
    pelanggan.nama_pelanggan,
    transaksi.waktu_transaksi,
    transaksi.total
FROM transaksi
JOIN pelanggan
ON transaksi.pelanggan_id = pelanggan.pelanggan_id;