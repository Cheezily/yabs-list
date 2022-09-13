<?php

namespace Database\Factories;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Server>
 */
class ServerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

//        $table->string('provider_name');
//        $table->dateTime('when');
//        $table->string('city');
//        $table->string('cpu');
//        $table->integer('cores');
//        $table->integer('ram');
//        $table->integer('swap');
//        $table->string('distro');
//        $table->string('kernel');
//        $table->boolean('AES-NI')->default(false);
//        $table->boolean('VM-x/AMD-V')->default(false);
//        $table->bigInteger('disk-4k-read-speed');
//        $table->integer('disk-4k-read-iops');
//        $table->bigInteger('disk-4k-write-speed');
//        $table->integer('disk-4k-write-iops');
//        $table->bigInteger('disk-4k-total-speed');
//        $table->integer('disk-4k-total-iops');
//        $table->bigInteger('disk-64k-read-speed');
//        $table->integer('disk-64k-read-iops');
//        $table->bigInteger('disk-64k-write-speed');
//        $table->integer('disk-64k-write-iops');
//        $table->bigInteger('disk-64k-total-speed');
//        $table->integer('disk-64k-total-iops');
//        $table->bigInteger('disk-512k-read-speed');
//        $table->integer('disk-512k-read-iops');
//        $table->bigInteger('disk-512k-write-speed');
//        $table->integer('disk-512k-write-iops');
//        $table->bigInteger('disk-512k-total-speed');
//        $table->integer('disk-512k-total-iops');
//        $table->bigInteger('disk-1m-read-speed');
//        $table->integer('disk-1m-read-iops');
//        $table->bigInteger('disk-1m-write-speed');
//        $table->integer('disk-1m-write-iops');
//        $table->bigInteger('disk-1m-total-speed');
//        $table->integer('disk-1m-total-iops');
//        $table->integer('geekbench-5-single');
//        $table->integer('geekbench-5-multi');
//        $table->integer('geekbench-5-link');
//        $table->string('virtualization');
//        $table->string('note')->nullable();
        $user_count = User::count();

        $cities = [
            'Tokyo', 'Delhi', 'Shanghai', 'Cairo', 'Tampa', 'Los Angeles', 'Chicago', 'Atlanta', 'Singapore',
            'Frankfurt', 'Amsterdam', 'Hong Kong', 'Chennai', 'Paris', 'London', 'Lagos', 'Buenos Aires',
            'Istanbul', 'Osaka'
        ];

        $cpus = [
            'Intel Xeon E3-2640 v3', 'Intel Xeon E5-2680 v2', 'Intel Xeon E5-2680 v4', 'Intel Xeon E3-2370 v3',
            'Intel Xeon E3-1270 v3', 'AMD Ryzen 7 3700x', 'AMD Ryzen 5 3500x', 'AMD Ryzen 7 5800x',
            'AMD EPYC 7702', 'AMD EPYC 7352', 'AMD EPYC 7501'
        ];

        $cores = mt_rand(1,16);

        $ram = [
            128, 256, 512, 1024, 2048, 4096, 8192, 16000, 32000, 64000
        ];

        $swap = [
            128, 256, 512, 1024, 2048, 4096
        ];

        $distros = [
            'Centos 7', 'Centos 8', 'Ubuntu 16.04', 'Ubuntu 18.04', 'Ubuntu 20.04', 'Ubuntu 22.04',
            'Debian 9', 'Debian 10', 'Debian 11', 'AlmaLinux'
        ];

        $kernels = [
            '5.2.20', '5.15.65', '3.13.11', '4.11.12'
        ];

        $disk_4k_read_speed = mt_rand(40, 50000000) * 1000;
        $disk_4k_write_speed = mt_rand(40, 50000000) * 1000;
        $disk_4k_total_speed = $disk_4k_read_speed + $disk_4k_write_speed;
        $disk_4k_read_iops = mt_rand(15, 200000);
        $disk_4k_write_iops = mt_rand(15, 200000);
        $disk_4k_total_iops = $disk_4k_read_iops + $disk_4k_write_iops;

        $disk_64k_read_speed = mt_rand(40, 50000000) * 1000;
        $disk_64k_write_speed = mt_rand(40, 50000000) * 1000;
        $disk_64k_total_speed = $disk_64k_read_speed + $disk_64k_write_speed;
        $disk_64k_read_iops = mt_rand(15, 200000);
        $disk_64k_write_iops = mt_rand(15, 200000);
        $disk_64k_total_iops = $disk_64k_read_iops + $disk_64k_write_iops;

        $disk_512k_read_speed = mt_rand(40, 50000000) * 1000;
        $disk_512k_write_speed = mt_rand(40, 50000000) * 1000;
        $disk_512k_total_speed = $disk_512k_read_speed + $disk_512k_write_speed;
        $disk_512k_read_iops = mt_rand(15, 200000);
        $disk_512k_write_iops = mt_rand(15, 200000);
        $disk_512k_total_iops = $disk_512k_read_iops + $disk_512k_write_iops;

        $disk_1m_read_speed = mt_rand(40, 50000000) * 1000;
        $disk_1m_write_speed = mt_rand(40, 50000000) * 1000;
        $disk_1m_total_speed = $disk_1m_read_speed + $disk_1m_write_speed;
        $disk_1m_read_iops = mt_rand(15, 200000);
        $disk_1m_write_iops = mt_rand(15, 200000);
        $disk_1m_total_iops = $disk_1m_read_iops + $disk_1m_write_iops;

        $geekbench_5_single = mt_rand(75, 3500);
        $geekbench_5_multi = $geekbench_5_single * $cores * (mt_rand(75, 95) / 100);

        $type = mt_rand(0,1) == 1 ? 'vps' : 'dedi';
        $virt_types = explode(',', Setting::first()->virt_types);
        $virtualization = $virt_types[array_rand($virt_types)];

        return [
            'user_id' => mt_rand(0,3) > 1 ? mt_rand(1, $user_count - 1) : null,
            'provider_name' => fake()->words(mt_rand(1,4), true),
            'when' => strval(date('Y-m-d H:i:s')),
            'city' => $cities[array_rand($cities)],
            'cpu' => $cpus[array_rand($cpus)],
            'cores' => $cores,
            'clock_speed' => mt_rand(1100, 4500),
            'ram' => $ram[array_rand($ram)],
            'swap' => $swap[array_rand($swap)],
            'distro' => $distros[array_rand($distros)],
            'kernel' => $kernels[array_rand($kernels)],
            'aes_ni' => mt_rand(0,1) == 1,
            'vm_x' => mt_rand(0,1) == 1,
            'disk_4k_read_speed' => $disk_4k_read_speed,
            'disk_4k_write_speed' => $disk_4k_write_speed,
            'disk_4k_total_speed' => $disk_4k_total_speed,
            'disk_4k_read_iops' => $disk_4k_read_iops,
            'disk_4k_write_iops' => $disk_4k_write_iops,
            'disk_4k_total_iops' => $disk_4k_total_iops,
            'disk_64k_read_speed' => $disk_64k_read_speed,
            'disk_64k_write_speed' => $disk_64k_write_speed,
            'disk_64k_total_speed' => $disk_64k_total_speed,
            'disk_64k_read_iops' => $disk_64k_read_iops,
            'disk_64k_write_iops' => $disk_64k_write_iops,
            'disk_64k_total_iops' => $disk_64k_total_iops,
            'disk_512k_read_speed' => $disk_512k_read_speed,
            'disk_512k_write_speed' => $disk_512k_write_speed,
            'disk_512k_total_speed' => $disk_512k_total_speed,
            'disk_512k_read_iops' => $disk_512k_read_iops,
            'disk_512k_write_iops' => $disk_512k_write_iops,
            'disk_512k_total_iops' => $disk_512k_total_iops,
            'disk_1m_read_speed' => $disk_1m_read_speed,
            'disk_1m_write_speed' => $disk_1m_write_speed,
            'disk_1m_total_speed' => $disk_1m_total_speed,
            'disk_1m_read_iops' => $disk_1m_read_iops,
            'disk_1m_write_iops' => $disk_1m_write_iops,
            'disk_1m_total_iops' => $disk_1m_total_iops,
            'geekbench_5_single' => $geekbench_5_single,
            'geekbench_5_multi' => $geekbench_5_multi,
            'type' => $type,
            'virtualization' => $type == 'vps' ? $virtualization : null,
        ];
    }
}
