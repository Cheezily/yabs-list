<?php

namespace Database\Factories;

use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\network>
 */
class NetworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
//        $table->id();
//        $table->unsignedBigInteger('server_id');
//        $table->string('provider');
//        $table->boolean('ipv4')->default(false);
//        $table->string('location');
//        $table->bigInteger('send_speed')->nullable();
//        $table->bigInteger('receive_speed')->nullable();
//        $table->timestamps();

        $cities = [
            'Tokyo', 'Delhi', 'Shanghai', 'Cairo', 'Tampa', 'Los Angeles', 'Chicago', 'Atlanta', 'Singapore',
            'Frankfurt', 'Amsterdam', 'Hong Kong', 'Chennai', 'Paris', 'London', 'Lagos', 'Buenos Aires',
            'Istanbul', 'Osaka'
        ];

        return [
            'server_id' => mt_rand(1, Server::count()),
            'provider' => fake()->words(mt_rand(1,4), true),
            'ipv4' => mt_rand(0,1) == 1,
            'location' => $cities[array_rand($cities)],
            'send_speed' => mt_rand(100000, 3000000000),
            'receive_speed' => mt_rand(100000, 3000000000)
        ];
    }
}
