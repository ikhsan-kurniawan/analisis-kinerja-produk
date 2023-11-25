select `a`.`no_transaksi_penjualan` AS `no_transaksi_penjualan`, `a`.`tanggal_transaksi_penjualan` AS `tanggal_transaksi` from (((`barang`.`transaksi_penjualan` `a` JOIN `barang`.`detail_transaksi_penjualan` `b`) JOIN `barang`.`harga_barang` `c`) JOIN `barang`.`barang` `d`)where ...


SELECT YEAR(tanggal_transaksi_penjualan) AS tahun, MONTH(tanggal_transaksi_penjualan) AS bulan, SUM(laba) AS total_penjuala FROM v_detail_penjualan GROUP BY tahun, bulan;


select 
`a`.`no_transkasi_penjualan` AS `no_transkasi_penjualan`,
`b`.`nama_barang` AS `nama_barang`,
`c`.`tanggal_transaksi_penjualan` AS `tanggal_transaksi_penjualan`,
`a`.`id_detail_transaksi_penjualan` AS `id_detail_transaksi_penjualan`,
`a`.`id_harga_barang` AS `id_harga_barang`,
`a`.`kode_barang` AS `kode_barang`,
`a`.`qty` AS `qty`,
`a`.`diskon` AS `diskon`,
`a`.`sub_harga` AS `sub_harga`,
`a`.`sub_harga_beli` AS `sub_harga_beli`,round(`a`.`qty` * (`a`.`sub_harga` - `a`.`sub_harga_beli`),2) AS `laba` 
from ((`barang`.`detail_transaksi_penjualan` `a` 
join `barang`.`barang` `b`) 
join `barang`.`transaksi_penjualan` `c`) 
where `a`.`no_transkasi_penjualan` = `c`.`no_transaksi_penjualan` and `a`.`kode_barang` = `b`.`kode_barang`

SELECT
	kode_barang,
    YEAR(tanggal_transaksi_penjualan) AS tahun,
    MONTH(tanggal_transaksi_penjualan) AS bulan,
    SUM(sub_harga) AS sub_harga
FROM detail_transaksi_penjualan
GROUP BY tahun, bulan, kode_barang;

SELECT 'Pembelian' AS transaksi, 
       b.tanggal_transaksi AS tanggal_transaksi, 
       a.kode_barang,
       c.nama_barang,
       a.qty AS qty,
       a.harga_beli
FROM (detail_transaksi_pembelian a JOIN transaksi_pembelian b ON a.nomor_transaksi = b.nomor_transaksi) 
JOIN barang c ON a.kode_barang = c.kode_barang
UNION ALL
SELECT 'Penjualan' AS transaksi, 
       e.tanggal_transaksi_penjualan AS tanggal_transaksi, 
       d.kode_barang,
        f.nama_barang,
       d.qty AS qty,
       d.sub_harga,
       d.sub_harga_beli
FROM (detail_transaksi_penjualan d JOIN transaksi_penjualan e ON d.no_transkasi_penjualan = e.no_transaksi_penjualan) 
JOIN barang f ON d.kode_barang = f.kode_barang
ORDER BY tanggal_transaksi;


select `b`.`tanggal_transaksi_penjualan` AS `tanggal_transaksi`,`a`.`kode_barang` AS `kode_barang`,`b`.`no_transaksi_penjualan` AS `nomor_transaksi`,`b`.`kode_customer` AS `customer_or_supplier`,`a`.`qty` * `c`.`jumlah_satuan` AS `jumlah_pcs`,'Penjualan' AS `keterangan` from ((`barang`.`detail_transaksi_penjualan` `a` join `barang`.`transaksi_penjualan` `b`) join `barang`.`harga_barang` `c`) where `a`.`no_transkasi_penjualan` = `b`.`no_transaksi_penjualan` and `a`.`id_harga_barang` = `c`.`id_harga_barang`


select 'Pembelian' AS `transaksi`,
`b`.`tanggal_transaksi` AS `tanggal_transaksi`,
`a`.`kode_barang` AS `kode_barang`,
`c`.`nama_barang` AS `nama_barang`,
`a`.`qty` AS `qty`,
`d`.`jumlah_satuan`,
`a`.`harga_beli` AS `harga_beli`,
(`a`.`qty` * `d`.`jumlah_satuan`) AS `jumlah_pcs`
from     `barang`.`detail_transaksi_pembelian` `a`
    JOIN `barang`.`transaksi_pembelian` `b` ON `a`.`nomor_transaksi` = `b`.`nomor_transaksi`
    JOIN `barang`.`barang` `c` ON `a`.`kode_barang` = `c`.`kode_barang`
    JOIN `harga_barang` `d` ON `a`.`kode_barang` = `d`.`kode_barang`;