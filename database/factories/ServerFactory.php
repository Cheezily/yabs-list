<?php

namespace Database\Factories;

use App\Helpers\SettingsHelper;
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

        $user_count = User::count();

        $provider_names = [
            'Smith, Langosh and Bernier',
            'Wisozk-Nikolaus',
            'Stoltenberg, Hirthe and Hettinger',
            'Moen LLC',
            'Padberg-Jones',
            'Beahan, Gutkowski and Hammes',
            'Hauck, Kuhn and Cartwright',
            'Bernier, Strosin and Sawayn',
            'Harris LLC',
            'Abbott, Gibson and Davis',
            'Rogahn Group',
            'Gibson-Yost',
            'Auer, Gutkowski and Torphy',
            'Cummerata, Dare and Langosh',
            'Tillman-Frami',
            'Cummings and Sons',
            'Bayer, Kshlerin and Bailey',
            'Lehner, Funk and Witting',
            'Brakus Ltd',
            'Kub-Schmidt',
            'Murphy-Hill',
            'Mertz Group',
            'Huels, Kreiger and Parker',
            'Von LLC',
            'Goodwin, Gorczany and Rolfson',
            'Herzog-Hane',
            'Gleason-Heathcote',
            'Mosciski-Volkman',
            'Mayert, Rutherford and Purdy',
            'Jacobs, Yost and Macejkovic',
            'Funk LLC',
            'Feest-Lueilwitz',
            'Boyle LLC',
            'Friesen, Goldner and Roob',
            'Corkery, Ondricka and Leannon',
            'Flatley, Corkery and Dickens',
            'Friesen-Pacocha',
            'Runolfsdottir-Dach',
            'Hettinger, Bechtelar and Roob',
            'Thompson, Roberts and Rempel'
        ];

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
        $virt_types = explode(',', SettingsHelper::virt_types());
        $virtualization = $virt_types[array_rand($virt_types)];

        return [
            'user_id' => mt_rand(0,3) > 1 ? mt_rand(1, $user_count - 1) : null,
            'provider_name' => $provider_names[array_rand($provider_names)],
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
            'average_network_speed' => mt_rand(100000, 3000000000),
            'virtualization' => $type == 'vps' ? $virtualization : 'N/A',
            'note' => mt_rand(0,3) == 3 ? fake()->sentence(mt_rand(5,20)) : null
        ];
    }
}
