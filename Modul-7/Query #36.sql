CREATE DATABASE db_penjualan;

USE db_penjualan;

CREATE TABLE pelanggan (
    pelanggan_id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pelanggan VARCHAR(100) NOT NULL,
    alamat VARCHAR(200),
    no_hp VARCHAR(20)
);

CREATE TABLE transaksi (
    transaksi_id INT AUTO_INCREMENT PRIMARY KEY,
    pelanggan_id INT NOT NULL,
    waktu_transaksi DATETIME NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (pelanggan_id)
        REFERENCES pelanggan(pelanggan_id)
);

INSERT INTO pelanggan
(nama_pelanggan, alamat, no_hp)
VALUES
('Alya', 'Pamekasan', '081234567890'),
('Budi', 'Surabaya', '081234567891'),
('Citra', 'Pamekasan', '081234567892'),
('Dina', 'Sampang', '081234567893'),
('Eko', 'Sumenep', '081234567894');

INSERT INTO transaksi
(pelanggan_id, waktu_transaksi, total)
VALUES
(1, '2026-11-01 09:00:00', 150000),
(2, '2026-11-01 11:30:00', 200000),
(3, '2026-11-02 10:00:00', 175000),
(1, '2026-11-02 13:00:00', 250000),
(4, '2026-11-03 09:30:00', 300000),
(5, '2026-11-03 14:00:00', 125000),
(2, '2026-11-04 10:15:00', 400000),
(3, '2026-11-04 15:00:00', 100000),
(1, '2026-11-05 08:30:00', 225000),
(4, '2026-11-05 12:00:00', 350000),
(5, '2026-11-06 10:00:00', 275000),
(2, '2026-11-06 16:00:00', 180000),
(3, '2026-11-07 09:00:00', 320000),
(1, '2026-11-07 13:30:00', 150000),
(4, '2026-11-08 11:00:00', 500000);
