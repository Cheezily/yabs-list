<?php

use App\Helpers\SettingsHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('anonymous_submissions')->default(false);
            $table->string('virt_types');
            $table->timestamps();
        });

        DB::table(SettingsHelper::getTableName())
            ->insert([
                'virt_types' => 'KVM,OpenVZ 6,OpenVZ 7,LXC'
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
