<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSmsTables extends Migration
{
    private $tablePrefix = 'sms_';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix = config('sms.tablePrefix') ?? $this->tablePrefix;

        $tables = array_map(function($i) use($prefix) {
            return $prefix.$i;
        }, explode(',', 'outbox,inbox,draft,sent,recipients,gateways'));

        try {
            $dbname=DB::connection()->getDatabaseName();
            $pdo=DB::connection()->getPDO();
            $stm=$pdo->query("SHOW TABLES FROM $dbname");
            $rs=$stm->fetchAll(PDO::FETCH_COLUMN);
            if(count($rs) > 1)
            {
                foreach ($rs as $table) {
                    if(in_array($table, $tables))
                    {
                        throw new \Exception("Sms module seems to have been installed already!");
                    }
                }

                // create schema
            }
        } catch(Exception $e) {
            // do nothing
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $prefix = $this->tablePrefix;
    }
}
