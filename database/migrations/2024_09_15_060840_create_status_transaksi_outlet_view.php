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
                `laundrymu_prod`.`transaksi`.`outlet_id` AS `outlet_id`,
                sum((
                    CASE WHEN (`laundrymu_prod`.`transaksi`.`status` = 'baru') THEN
                        1
                    ELSE
                        0
                    END)) AS `baru`,
                sum((
                    CASE WHEN (`laundrymu_prod`.`transaksi`.`status` = 'diproses') THEN
                        1
                    ELSE
                        0
                    END)) AS `diproses`,
                sum((
                    CASE WHEN (`laundrymu_prod`.`transaksi`.`status` = 'selesai') THEN
                        1
                    ELSE
                        0
                    END)) AS `selesai`,
                sum((
                    CASE WHEN (`laundrymu_prod`.`transaksi`.`status` = 'diambil') THEN
                        1
                    ELSE
                        0
                    END)) AS `diambil`,
                sum((
                    CASE WHEN (`laundrymu_prod`.`transaksi`.`status` = 'pending') THEN
                        1
                    ELSE
                        0
                    END)) AS `pending`,
                sum((
                    CASE WHEN (`laundrymu_prod`.`transaksi`.`status` = 'pengambilan') THEN
                        1
                    ELSE
                        0
                    END)) AS `pengambilan`,
                sum((
                    CASE WHEN (`laundrymu_prod`.`transaksi`.`status` = 'diantar') THEN
                        1
                    ELSE
                        0
                    END)) AS `diantar`,
                sum((
                    CASE WHEN (`laundrymu_prod`.`transaksi`.`status` = 'batal') THEN
                        1
                    ELSE
                        0
                    END)) AS `batal`,
                sum((
                    CASE WHEN (`laundrymu_prod`.`transaksi`.`status` = 'close'
                               AND MONTH(`laundrymu_prod`.`transaksi`.`created_at`) = MONTH(CURRENT_DATE())
                               AND YEAR(`laundrymu_prod`.`transaksi`.`created_at`) = YEAR(CURRENT_DATE())) THEN
                        1
                    ELSE
                        0
                    END)) AS `close`
            FROM
                `laundrymu_prod`.`transaksi`
            GROUP BY
                `laundrymu_prod`.`transaksi`.`outlet_id`
            ORDER BY
                max(`laundrymu_prod`.`transaksi`.`created_at`) DESC;
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
