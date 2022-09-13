<?php

namespace App\Helpers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServerQueryHelper {


    private static function start_query(Request $request)
    {
        $query = DB::table('servers');
        // $query->where();

        return $query;
    }


    public static function provider_names_count(Request $request)
    {
        return ServerQueryHelper::start_query($request)
            ->select([
                'provider_name',
                DB::raw('COUNT(servers.provider_name) as count')
                ])
            ->groupBy('servers.provider_name')
            ->orderBy('servers.provider_name')
            ->distinct()
            ->get();
    }


    public static function cores_count(Request $request)
    {
        return [
            1 => ['> 16 Cores' => ServerQueryHelper::start_query($request)->where('cores', '>', 16)->count()],
            2 => ['12 to 16 Cores' => ServerQueryHelper::start_query($request)->whereBetween('cores', [12, 16])->count()],
            3 => ['8 to 12 Cores' => ServerQueryHelper::start_query($request)->whereBetween('cores', [8, 12])->count()],
            4 => ['4 to 8 Cores' => ServerQueryHelper::start_query($request)->whereBetween('cores', [4, 8])->count()],
            5 => ['3 Cores' => ServerQueryHelper::start_query($request)->where('cores', '=', 3)->count()],
            6 => ['2 Cores' => ServerQueryHelper::start_query($request)->where('cores', '=', 2)->count()],
            7 => ['1 Core' => ServerQueryHelper::start_query($request)->where('cores', '=', 1)->count()],
        ];
    }


    public static function ram_count(Request $request)
    {
        return [
            1 => ['> 32GB' => ServerQueryHelper::start_query($request)->where('ram', '>', 32000)->count()],
            2 => ['16GB to 24GB' =>ServerQueryHelper::start_query($request)->whereBetween('ram', [2400, 32000])->count()],
            3 => ['8GB to 16GB' => ServerQueryHelper::start_query($request)->whereBetween('ram', [8000, 16000])->count()],
            4 => ['4GB to 8GB' => ServerQueryHelper::start_query($request)->whereBetween('ram', [4000, 8000])->count()],
            5 => ['2GB to 4GB' => ServerQueryHelper::start_query($request)->whereBetween('ram', [2000, 4000])->count()],
            6 => ['1GB to 2GB' => ServerQueryHelper::start_query($request)->whereBetween('ram', [1000, 2000])->count()],
            7 => ['512MB to 1GB' => ServerQueryHelper::start_query($request)->whereBetween('ram', [512, 1000])->count()],
            8 => ['< 512MB' => ServerQueryHelper::start_query($request)->where('ram', '<', 512)->count()],
        ];
    }

    
    public static function virtualization_count(Request $request)
    {
        return ServerQueryHelper::start_query($request)
            ->select([
                'virtualization',
                DB::raw('COUNT(servers.virtualization) as count')
            ])
            ->groupBy('servers.virtualization')
            ->orderBy('servers.virtualization')
            ->distinct()
            ->get();
    }


    public static function average_network_speed_count(Request $request)
    {
        $max_average_network_speed = ServerQueryHelper::start_query($request)->max('average_network_speed');
        $min_average_network_speed = ServerQueryHelper::start_query($request)->min('average_network_speed');
        $average_network_speed_spreads = floor(($max_average_network_speed - $min_average_network_speed) / 4 / 1000) * 1000;

        return [
            1 => ['> '.($max_average_network_speed - $average_network_speed_spreads) => ServerQueryHelper::start_query($request)
                ->where('average_network_speed', '>', ($max_average_network_speed - $average_network_speed_spreads))
                ->count()],
            2 => [($max_average_network_speed - $average_network_speed_spreads * 2).' to '.($max_average_network_speed - $average_network_speed_spreads * 2) => ServerQueryHelper::start_query($request)
                ->whereBetween('average_network_speed', [($max_average_network_speed - $average_network_speed_spreads * 2), ($max_average_network_speed - $average_network_speed_spreads)])
                ->count()],
            3 => [($max_average_network_speed - $average_network_speed_spreads * 3).' to '.($max_average_network_speed - $average_network_speed_spreads * 2) => ServerQueryHelper::start_query($request)
                ->whereBetween('average_network_speed', [($max_average_network_speed - $average_network_speed_spreads * 3), ($max_average_network_speed - $average_network_speed_spreads * 2)])
                ->count()],
            4 => ['< '.($max_average_network_speed - $average_network_speed_spreads *  3) => ServerQueryHelper::start_query($request)
                ->where('average_network_speed', '<', ($max_average_network_speed - $average_network_speed_spreads * 3))
                ->count()],
        ];
    }


    public static function disk_4k_speed_count(Request $request)
    {
        $max_4k_speed = ServerQueryHelper::start_query($request)->max('disk_4k_total_speed');
        $min_4k_speed = ServerQueryHelper::start_query($request)->min('disk_4k_total_speed');
        $disk_4k_spreads = floor(($max_4k_speed - $min_4k_speed) / 4 / 1000) * 1000;

        return [
            1 => ['> '.($max_4k_speed - $disk_4k_spreads) =>ServerQueryHelper::start_query($request)
                ->where('disk_4k_total_speed', '>', ($max_4k_speed - $disk_4k_spreads))
                ->count()],
            2 => [($max_4k_speed - $disk_4k_spreads * 2).' to '.($max_4k_speed - $disk_4k_spreads * 2) => ServerQueryHelper::start_query($request)
                ->whereBetween('disk_4k_total_speed', [($max_4k_speed - $disk_4k_spreads * 2), ($max_4k_speed - $disk_4k_spreads)])
                ->count()],
            3 => [($max_4k_speed - $disk_4k_spreads * 3).' to '.($max_4k_speed - $disk_4k_spreads * 2) => ServerQueryHelper::start_query($request)
                ->whereBetween('disk_4k_total_speed', [($max_4k_speed - $disk_4k_spreads * 3), ($max_4k_speed - $disk_4k_spreads * 2)])
                ->count()],
            4 => ['< '.($max_4k_speed - $disk_4k_spreads *  3) => ServerQueryHelper::start_query($request)
                ->where('disk_4k_total_speed', '<', ($max_4k_speed - $disk_4k_spreads * 3))
                ->count()],
        ];
    }


    public static function disk_4k_iops_count(Request $request)
    {
        $max_4k_iops = ServerQueryHelper::start_query($request)->max('disk_4k_total_iops');
        $min_4k_iops = ServerQueryHelper::start_query($request)->min('disk_4k_total_iops');
        $disk_4k_spreads = floor(($max_4k_iops - $min_4k_iops) / 4 / 1000) * 1000;

        return [
            1 => ['> '.($max_4k_iops - $disk_4k_spreads) => ServerQueryHelper::start_query($request)
                ->where('disk_4k_total_iops', '>', ($max_4k_iops - $disk_4k_spreads))
                ->count()],
            2 => [($max_4k_iops - $disk_4k_spreads * 2).' to '.($max_4k_iops - $disk_4k_spreads * 2) => ServerQueryHelper::start_query($request)
                ->whereBetween('disk_4k_total_iops', [($max_4k_iops - $disk_4k_spreads * 2), ($max_4k_iops - $disk_4k_spreads)])
                ->count()],
            3 => [($max_4k_iops - $disk_4k_spreads * 3).' to '.($max_4k_iops - $disk_4k_spreads * 2) => ServerQueryHelper::start_query($request)
                ->whereBetween('disk_4k_total_iops', [($max_4k_iops - $disk_4k_spreads * 3), ($max_4k_iops - $disk_4k_spreads * 2)])
                ->count()],
            4 => ['< '.($max_4k_iops - $disk_4k_spreads *  3) => ServerQueryHelper::start_query($request)
                ->where('disk_4k_total_iops', '<', ($max_4k_iops - $disk_4k_spreads * 3))
                ->count()],
        ];
    }


    public static function geekbench_5_single_count(Request $request)
    {
        $max_gb5_single = ServerQueryHelper::start_query($request)->max('geekbench_5_single');
        $min_gb5_single = ServerQueryHelper::start_query($request)->min('geekbench_5_single');
        $gb5_single_spread = floor($max_gb5_single - $min_gb5_single) / 4;
        
        return [
            1 => ['> '.($max_gb5_single - $gb5_single_spread) => ServerQueryHelper::start_query($request)
                ->where('geekbench_5_single', '>', ($max_gb5_single - $gb5_single_spread))
                ->count()],
            2 => [($max_gb5_single - $gb5_single_spread * 2).' to '.($max_gb5_single - $gb5_single_spread * 2) => ServerQueryHelper::start_query($request)
                ->whereBetween('geekbench_5_single', [($max_gb5_single - $gb5_single_spread * 2), ($max_gb5_single - $gb5_single_spread)])
                ->count()],
            3 => [($max_gb5_single - $gb5_single_spread * 3).' to '.($max_gb5_single - $gb5_single_spread * 2) => ServerQueryHelper::start_query($request)
                ->whereBetween('geekbench_5_single', [($max_gb5_single - $gb5_single_spread * 3), ($max_gb5_single - $gb5_single_spread * 2)])
                ->count()],
            4 => ['< '.($max_gb5_single - $gb5_single_spread *  3) => ServerQueryHelper::start_query($request)
                ->where('geekbench_5_single', '<', ($max_gb5_single - $gb5_single_spread * 3))
                ->count()],
        ];
    }


    public static function geekbench_5_multi_count(Request $request)
    {
        $max_gb5_multi = ServerQueryHelper::start_query($request)->max('geekbench_5_multi');
        $min_gb5_multi = ServerQueryHelper::start_query($request)->min('geekbench_5_multi');
        $gb5_multi_spread = floor($max_gb5_multi - $min_gb5_multi) / 4;
        
        return [
            1 => ['> '.($max_gb5_multi - $gb5_multi_spread) => ServerQueryHelper::start_query($request)
                ->where('geekbench_5_multi', '>', ($max_gb5_multi - $gb5_multi_spread))
                ->count()],
            2 => [($max_gb5_multi - $gb5_multi_spread * 2).' to '.($max_gb5_multi - $gb5_multi_spread * 2) => ServerQueryHelper::start_query($request)
                ->whereBetween('geekbench_5_multi', [($max_gb5_multi - $gb5_multi_spread * 2), ($max_gb5_multi - $gb5_multi_spread)])
                ->count()],
            3 => [($max_gb5_multi - $gb5_multi_spread * 3).' to '.($max_gb5_multi - $gb5_multi_spread * 2) => ServerQueryHelper::start_query($request)
                ->whereBetween('geekbench_5_multi', [($max_gb5_multi - $gb5_multi_spread * 3), ($max_gb5_multi - $gb5_multi_spread * 2)])
                ->count()],
            4 => ['< '.($max_gb5_multi - $gb5_multi_spread *  3) => ServerQueryHelper::start_query($request)
                ->where('geekbench_5_multi', '<', ($max_gb5_multi - $gb5_multi_spread * 3))
                ->count()],
        ];
    }
}