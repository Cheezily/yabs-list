<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'when',
        'city',
        'cpu',
        'cores',
        'ram',
        'swap',
        'distro',
        'kernel',
        'aes_ni',
        'vm_x',
        'disk_4k_read_speed',
        'disk_4k_write_speed',
        'disk_4k_total_speed',
        'disk_4k_read_iops',
        'disk_4k_write_iops',
        'disk_4k_total_iops',
        'disk_64k_read_speed',
        'disk_64k_write_speed',
        'disk_64k_total_speed',
        'disk_64k_read_iops',
        'disk_64k_write_iops',
        'disk_64k_total_iops',
        'disk_512k_read_speed',
        'disk_512k_write_speed',
        'disk_512k_total_speed',
        'disk_512k_read_iops',
        'disk_512k_write_iops',
        'disk_512k_total_iops',
        'disk_1m_read_speed',
        'disk_1m_write_speed',
        'disk_1m_total_speed',
        'disk_1m_read_iops',
        'disk_1m_write_iops',
        'disk_1m_total_iops',
        'geekbench-5-single',
        'geekbench_5_multi',
    ];


    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }


    public function networks()
    {
        return $this->hasMany(\App\Models\Network::class);
    }
}
