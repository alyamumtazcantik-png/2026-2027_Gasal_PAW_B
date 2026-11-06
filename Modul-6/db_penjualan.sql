-- ==========================================
-- 1. MEMBUAT DATABASE
-- ==========================================

CREATE DATABASE IF NOT EXISTS db_master_detail_baru;

USE db_master_detail_baru;


-- ==========================================
-- 2. TABEL SUPPLIER
-- ==========================================

CREATE TABLE supplier (
    id_supplier INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(20),
    alamat VARCHAR(150)
);


-- ==========================================
-- 3. TABEL BARANG
-- ==========================================

CREATE TABLE barang (
    kode_barang VARCHAR(10) PRIMARY KEY,
    nama_barang VARCHAR(100) NOT NULL,
    harga DECIMAL(12,2) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    id_supplier INT NULL,

    FOREIGN KEY (id_supplier)
        REFERENCES supplier(id_supplier)
        ON DELETE SET NULL
);


-- ==========================================
-- 4. TABEL USER
-- ==========================================

CREATE TABLE `user` (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);


-- ==========================================
-- 5. TABEL TRANSAKSI
-- ==========================================

CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    nama_pelanggan VARCHAR(100) NOT NULL,
    total DECIMAL(12,2) DEFAULT 0
);


-- ==========================================
-- 6. TABEL TRANSAKSI DETAIL
-- ==========================================

CREATE TABLE transaksi_detail (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT NOT NULL,
    kode_barang VARCHAR(10) NOT NULL,
    qty INT NOT NULL,
    harga DECIMAL(12,2) NOT NULL,

    FOREIGN KEY (id_transaksi)
        REFERENCES transaksi(id_transaksi)
        ON DELETE CASCADE,

    FOREIGN KEY (kode_barang)
        REFERENCES barang(kode_barang)
        ON DELETE RESTRICT,

    UNIQUE (id_transaksi, kode_barang)
);


-- ==========================================
-- 7. INSERT DATA SUPPLIER
-- ==========================================

INSERT INTO supplier (nama, telp, alamat) VALUES
('PT Sumber Makmur','081234567801','Surabaya'),
('CV Berkah Jaya','081234567802','Madura'),
('UD Maju Lancar','081234567803','Bangkalan'),
('PT Sejahtera','081234567804','Sidoarjo'),
('CV Sentosa','081234567805','Gresik');


-- ==========================================
-- 8. INSERT DATA BARANG
-- ==========================================

INSERT INTO barang (kode_barang, nama_barang, harga, stok) VALUES
('B001','Laptop Asus',7500000,10),
('B002','Laptop Lenovo',6500000,15),
('B003','Mouse Logitech',150000,30),
('B004','Keyboard Logitech',250000,20),
('B005','Monitor Samsung',2000000,12);


-- ==========================================
-- 9. INSERT DATA USER
-- ==========================================

INSERT INTO `user` (nama, username, password) VALUES
('Alya Mumtaz','alya','12345'),
('Naila Rahmah','naila','12345'),
('Hilda Uyun','hilda','12345'),
('Viona Paradila','viona','12345'),
('Gebriela Chantika','gebriela','12345');


-- ==========================================
-- 10. INSERT DATA TRANSAKSI
-- ==========================================

INSERT INTO transaksi (tanggal, nama_pelanggan) VALUES
('2026-11-01','Alya'),
('2026-11-02','Naila'),
('2026-11-03','Hilda'),
('2026-11-04','Viona'),
('2026-11-05','Gebriela'),
('2026-11-06','Dina'),
('2026-11-07','Rani'),
('2026-11-08','Sinta'),
('2026-11-09','Putri'),
('2026-11-10','Dewi');


-- ==========================================
-- 11. CEK DATABASE DAN TABEL
-- ==========================================

USE db_master_detail_baru;

SHOW TABLES;

SELECT * FROM supplier;

SELECT * FROM barang;

SELECT * FROM `user`;

SELECT * FROM transaksi;

SELECT * FROM transaksi_detail;

