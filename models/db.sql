-- Active: 1709030200372@@127.0.0.1@3306@prediksi_pertumbuhan_penduduk
CREATE TABLE data_periode(
  id_periode INT AUTO_INCREMENT PRIMARY KEY,
  periode VARCHAR(15)
);

CREATE TABLE data_variabel(
  id_variabel INT AUTO_INCREMENT PRIMARY KEY,
  nama_variabel VARCHAR(25)
);

CREATE TABLE dataset(
  id_dataset INT AUTO_INCREMENT PRIMARY KEY,
  id_periode INT,
  id_variabel INT,
  jumlah INT,
  FOREIGN KEY (id_periode) REFERENCES data_periode(id_periode) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (id_variabel) REFERENCES data_variabel(id_variabel) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE data_uji(
  id_uji INT AUTO_INCREMENT PRIMARY KEY,
  periode INT,
  variabel_dependen VARCHAR(10),
  variabel_independen VARCHAR(10)
);

CREATE TABLE hasil_rl(
  id_rl INT AUTO_INCREMENT PRIMARY KEY,
  periode INT,
  jumlah_migrasi CHAR(10),
  var_independen VARCHAR(50),
  var_dependen VARCHAR(50),
  hasil_prediksi CHAR(10),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE hasil_es(
  id_rl INT AUTO_INCREMENT PRIMARY KEY,
  periode INT,
  nilai_alpha CHAR(10),
  var_dependen VARCHAR(50),
  hasil_prediksi CHAR(10),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE tentang(
  id INT AUTO_INCREMENT PRIMARY KEY,
  deskripsi TEXT
);

CREATE TABLE kontak (
  id_kontak INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(75),
  email VARCHAR(50),
  phone CHAR(12),
  pesan TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);