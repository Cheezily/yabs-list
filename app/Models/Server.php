<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Server extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'user_id',
    //     'provider_name',
    //     'type',
    //     'virtualization',
    //     'when',
    //     'city',
    //     'cpu',
    //     'cores',
    //     'clock_speed',
    //     'note',
    //     'ram',
    //     'swap',
    //     'distro',
    //     'kernel',
    //     'aes_ni',
    //     'vm_x',
    //     'disk_4k_read_speed',
    //     'disk_4k_write_speed',
    //     'disk_4k_total_speed',
    //     'disk_4k_read_iops',
    //     'disk_4k_write_iops',
    //     'disk_4k_total_iops',
    //     'disk_64k_read_speed',
    //     'disk_64k_write_speed',
    //     'disk_64k_total_speed',
    //     'disk_64k_read_iops',
    //     'disk_64k_write_iops',
    //     'disk_64k_total_iops',
    //     'disk_512k_read_speed',
    //     'disk_512k_write_speed',
    //     'disk_512k_total_speed',
    //     'disk_512k_read_iops',
    //     'disk_512k_write_iops',
    //     'disk_512k_total_iops',
    //     'disk_1m_read_speed',
    //     'disk_1m_write_speed',
    //     'disk_1m_total_speed',
    //     'disk_1m_read_iops',
    //     'disk_1m_write_iops',
    //     'disk_1m_total_iops',
    //     'geekbench_5_single',
    //     'geekbench_5_multi',
    //     'average_network_speed'
    // ];


    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }


    public function networks()
    {
        return $this->hasMany(\App\Models\Network::class);
    }


    public static function check_for_duplicates($fields)
    {
        return self::where('cpu', '=', $fields['cpu'])
            ->where('provider_name', '=', $fields['provider_name'])
            ->where('cores', '=', $fields['cores'])
            ->where('clock_speed', '=', $fields['clock_speed'])
            ->where('ram', '=', $fields['ram'])
            ->where('geekbench_5_single', '=', $fields['geekbench_5_single'])
            ->where('geekbench_5_multi', '=', $fields['geekbench_5_multi'])
            ->where('disk_4k_read_speed', '=', $fields['disk_4k_read_speed'])
            ->where('disk_4k_write_speed', '=', $fields['disk_4k_write_speed'])
            ->where('disk_4k_read_iops', '=', $fields['disk_4k_read_iops'])
            ->where('disk_4k_write_iops', '=', $fields['disk_4k_write_iops'])
            ->where('disk_1m_read_speed', '=', $fields['disk_1m_read_speed'])
            ->where('disk_1m_write_speed', '=', $fields['disk_1m_write_speed'])
            ->where('disk_1m_read_iops', '=', $fields['disk_1m_read_iops'])
            ->where('disk_1m_write_iops', '=', $fields['disk_1m_write_iops'])
            ->exists();
    }
}
