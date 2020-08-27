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
        }, explode(',', 'outbox,inbox'));

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

                $this->upOutboxTable($prefix);
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
        $prefix = config('sms.tablePrefix') ?? $this->tablePrefix;
        $this->downOutboxTable($prefix);
    }

    private function upOutboxTable($prefix)
    {
        Schema::create($prefix.'outbox', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('recipient_id')->unsigned()->nullable(true);
            $table->string('recipient_group', 191)->nullable(true);
            $table->string('phone', 50)->nullable(false);
            $table->text('message')->nullable(false);
            $table->enum('status', ['DRAFT', 'PENDING', 'SENT'])->nullable(false)->default('DRAFT');
            $table->dateTime('sent_at')->nullable(true);
            $table->dateTime('delivered_at')->nullable(true);
            $table->timestamps();
        });
    }

    private function downOutboxTable($prefix)
    {
        Schema::dropIfExists($prefix.'outbox');
    }
}
