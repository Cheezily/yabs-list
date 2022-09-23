<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('provider_name');
            $table->string('type');
            $table->dateTime('when');
            $table->string('city');
            $table->string('cpu');
            $table->integer('cores');
            $table->integer('clock_speed');
            $table->bigInteger('ram');
            $table->bigInteger('swap');
            $table->string('distro')->nullable();
            $table->string('kernel')->nullable();
            $table->boolean('aes_ni')->default(false);
            $table->boolean('vm_x')->default(false);
            $table->bigInteger('disk_4k_read_speed');
            $table->integer('disk_4k_read_iops');
            $table->bigInteger('disk_4k_write_speed');
            $table->integer('disk_4k_write_iops');
            $table->bigInteger('disk_4k_total_speed');
            $table->integer('disk_4k_total_iops');
            $table->bigInteger('disk_64k_read_speed');
            $table->integer('disk_64k_read_iops');
            $table->bigInteger('disk_64k_write_speed');
            $table->integer('disk_64k_write_iops');
            $table->bigInteger('disk_64k_total_speed');
            $table->integer('disk_64k_total_iops');
            $table->bigInteger('disk_512k_read_speed');
            $table->integer('disk_512k_read_iops');
            $table->bigInteger('disk_512k_write_speed');
            $table->integer('disk_512k_write_iops');
            $table->bigInteger('disk_512k_total_speed');
            $table->integer('disk_512k_total_iops');
            $table->bigInteger('disk_1m_read_speed');
            $table->integer('disk_1m_read_iops');
            $table->bigInteger('disk_1m_write_speed');
            $table->integer('disk_1m_write_iops');
            $table->bigInteger('disk_1m_total_speed');
            $table->integer('disk_1m_total_iops');
            $table->integer('geekbench_5_single');
            $table->integer('geekbench_5_multi');
            $table->string('virtualization');
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers');
    }
};
