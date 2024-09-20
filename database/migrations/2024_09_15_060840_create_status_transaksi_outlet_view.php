<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateStatusTransaksiOutletView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW status_transaksi_outlet AS
            SELECT
                transaksi.outlet_id,
                SUM(CASE WHEN transaksi.status = 'baru' THEN 1 ELSE 0 END) AS baru,
                SUM(CASE WHEN transaksi.status = 'diproses' THEN 1 ELSE 0 END) AS diproses,
                SUM(CASE WHEN transaksi.status = 'selesai' THEN 1 ELSE 0 END) AS selesai,
                SUM(CASE WHEN transaksi.status = 'diambil' THEN 1 ELSE 0 END) AS diambil,
                SUM(CASE WHEN transaksi.status = 'pending' THEN 1 ELSE 0 END) AS pending,
                SUM(CASE WHEN transaksi.status = 'pengambilan' THEN 1 ELSE 0 END) AS pengambilan,
                SUM(CASE WHEN transaksi.status = 'diantar' THEN 1 ELSE 0 END) AS diantar,
                SUM(CASE WHEN transaksi.status = 'batal' THEN 1 ELSE 0 END) AS batal
            FROM
                transaksi
            GROUP BY
                transaksi.outlet_id, transaksi.created_at, transaksi.updated_at
            ORDER BY
                transaksi.created_at DESC
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS status_transaksi_outlet');
    }
}
