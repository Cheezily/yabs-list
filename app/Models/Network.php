<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Server;

class Network extends Model
{
    use HasFactory;

    protected $fillable = [
        'server_id',
        'provider',
        'ipv4',
        'location',
        'send_speed',
        'receive_speed'
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
