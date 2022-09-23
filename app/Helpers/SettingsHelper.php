<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class SettingsHelper {

    protected static $table = 'settings';

    public static function virt_types()
    {
        return DB::table(self::$table)->first()->virt_types;
    }

    public static function allow_anonymous_submissions()
    {
        return DB::table(self::$table)->first()->anonymous_submissions;
    }

    public function all()
    {
        return DB::table(self::$table)->first();
    }

    public static function getTableName()
    {
        return self::$table;
    }
}