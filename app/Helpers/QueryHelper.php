<?php

namespace App\Helpers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryHelper {


    private static function start_query()
    {
        $query = DB::table('servers');
        // $query->where();

        return $query;
    }


    public static function provider_names_count(Request $request)
    {
        return QueryHelper::start_query()
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
            1 => ['> 16 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 1)->count()],
            2 => ['12 to 16 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 2)->count()],
            3 => ['8 to 12 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 3)->count()],
            4 => ['4 to 8 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 4)->count()],
            5 => ['3 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 5)->count()],
            6 => ['2 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 6)->count()],
            7 => ['1 Core' => QueryHelper::cores_where(QueryHelper::start_query(), 7)->count()],
        ];
    }


    public static function cores_where($query, $index, $use_or = false)
    {
        if($index == 1 && !$use_or) {return $query->where('cores', '>', 16);}
        if($index == 2 && !$use_or) {return $query->whereBetween('cores', [12, 16]);}
        if($index == 3 && !$use_or) {return $query->whereBetween('cores', [8, 12]);}
        if($index == 4 && !$use_or) {return $query->whereBetween('cores', [4, 8]);}
        if($index == 5 && !$use_or) {return $query->where('cores', '=', 3);}
        if($index == 6 && !$use_or) {return $query->where('cores', '=', 2);}
        if($index == 7 && !$use_or) {return $query->where('cores', '=', 1);}
        
        if($index == 1 && $use_or) {return $query->orWhere('cores', '>', 16);}
        if($index == 2 && $use_or) {return $query->orWhereBetween('cores', [12, 16]);}
        if($index == 3 && $use_or) {return $query->orWhereBetween('cores', [8, 12]);}
        if($index == 4 && $use_or) {return $query->orWhereBetween('cores', [4, 8]);}
        if($index == 5 && $use_or) {return $query->orWhere('cores', '=', 3);}
        if($index == 6 && $use_or) {return $query->orWhere('cores', '=', 2);}
        if($index == 7 && $use_or) {return $query->orWhere('cores', '=', 1);}
    }


    public static function ram_count(Request $request)
    {
        return [
            1 => ['> 24GB' => QueryHelper::ram_where(QueryHelper::start_query(), 1)->count()],
            2 => ['16GB to 24GB' => QueryHelper::ram_where(QueryHelper::start_query(), 2)->count()],
            3 => ['8GB to 16GB' => QueryHelper::ram_where(QueryHelper::start_query(), 3)->count()],
            4 => ['4GB to 8GB' => QueryHelper::ram_where(QueryHelper::start_query(), 4)->count()],
            5 => ['2GB to 4GB' => QueryHelper::ram_where(QueryHelper::start_query(), 5)->count()],
            6 => ['1GB to 2GB' => QueryHelper::ram_where(QueryHelper::start_query(), 6)->count()],
            7 => ['512MB to 1GB' => QueryHelper::ram_where(QueryHelper::start_query(), 7)->count()],
            8 => ['< 512MB' => QueryHelper::ram_where(QueryHelper::start_query(), 8)->count()],
        ];
    }


    public static function ram_where($query, $index, $use_or = false)
    {
        if($index == 1 && !$use_or) {return $query->where('ram', '>', 24000);}
        if($index == 2 && !$use_or) {return $query->whereBetween('ram', [16000, 24000]);}
        if($index == 3 && !$use_or) {return $query->whereBetween('ram', [8000, 16000]);}
        if($index == 4 && !$use_or) {return $query->whereBetween('ram', [4000, 8000]);}
        if($index == 5 && !$use_or) {return $query->whereBetween('ram', [2000, 4000]);}
        if($index == 6 && !$use_or) {return $query->whereBetween('ram', [1000, 2000]);}
        if($index == 7 && !$use_or) {return $query->whereBetween('ram', [512, 1000]);}
        if($index == 8 && !$use_or) {return $query->where('ram', '<', 512);}        
        
        if($index == 1 && $use_or) {return $query->orWhere('ram', '>', 24000);}
        if($index == 2 && $use_or) {return $query->orWhereBetween('ram', [16000, 24000]);}
        if($index == 3 && $use_or) {return $query->orWhereBetween('ram', [8000, 16000]);}
        if($index == 4 && $use_or) {return $query->orWhereBetween('ram', [4000, 8000]);}
        if($index == 5 && $use_or) {return $query->orWhereBetween('ram', [2000, 4000]);}
        if($index == 6 && $use_or) {return $query->orWhereBetween('ram', [1000, 2000]);}
        if($index == 7 && $use_or) {return $query->orWhereBetween('ram', [512, 1000]);}
        if($index == 8 && $use_or) {return $query->orWhere('ram', '<', 512);}
    }
    

    public static function virtualization_count()
    {
        return QueryHelper::start_query()
            ->select([
                'virtualization',
                DB::raw('COUNT(servers.virtualization) as count')
            ])
            ->groupBy('servers.virtualization')
            ->orderBy('servers.virtualization')
            ->distinct()
            ->get();
    }


    public static function average_network_speed_count()
    {
        $max = QueryHelper::start_query()->max('average_network_speed');
        $min = QueryHelper::start_query()->min('average_network_speed');
        $spread = floor(($max - $min) / 4 / 1000) * 1000;

        return [
            1 => ['> '.($max - $spread) => 
                QueryHelper::average_network_speed_where(QueryHelper::start_query(), 1, $max, $spread)->count()],
            2 => [($max - $spread * 2).' to '.($max - $spread) => 
                QueryHelper::average_network_speed_where(QueryHelper::start_query(), 2, $max, $spread)->count()],
            3 => [($max - $spread * 3).' to '.($max - $spread * 2) => 
                QueryHelper::average_network_speed_where(QueryHelper::start_query(), 3, $max, $spread)->count()],
            4 => ['< '.($max - $spread *  3) => 
                QueryHelper::average_network_speed_where(QueryHelper::start_query(), 3, $max, $spread)->count()]
        ];
    }


    public static function average_network_speed_where($query, $index, $max, $spread)
    {
        if($index == 1) {return $query->where('average_network_speed', '>', ($max - $spread));}
        if($index == 2) {return $query->whereBetween('average_network_speed', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereBetween('average_network_speed', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('average_network_speed', '<', ($max - $spread * 3));}
    }


    public static function disk_4k_read_speed_count()
    {
        $max = QueryHelper::start_query()->max('disk_4k_read_speed');
        $min = QueryHelper::start_query()->min('disk_4k_read_speed');
        $spread = floor(($max - $min) / 4 / 1000000) * 1000000;

        return [
            1 => ['> '.floor(($max - $spread)/1000000).' MB/s' =>
                QueryHelper::start_query()
                ->where('disk_4k_read_speed', '>', ($max - $spread))
                ->count()],
            2 => [floor(($max - $spread * 2)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                QueryHelper::start_query()
                ->whereBetween('disk_4k_read_speed', [($max - $spread * 2), ($max - $spread)])
                ->count()],
            3 => [floor(($max - $spread * 3)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                QueryHelper::start_query()
                ->whereBetween('disk_4k_read_speed', [($max - $spread * 3), ($max - $spread * 2)])
                ->count()],
            4 => ['< '.floor(($max - $spread *  3)/1000000).' MB/s' => 
                QueryHelper::start_query()
                ->where('disk_4k_read_speed', '<', ($max - $spread * 3))
                ->count()],
        ];
    }


    public static function disk_4k_write_speed_count()
    {
        $max = QueryHelper::start_query()->max('disk_4k_write_speed');
        $min = QueryHelper::start_query()->min('disk_4k_write_speed');
        $spread = floor(($max - $min) / 4 / 1000000) * 1000000;

        return [
            1 => ['> '.floor(($max - $spread)/1000000).' MB/s' =>
                QueryHelper::start_query()
                ->where('disk_4k_write_speed', '>', ($max - $spread))
                ->count()],
            2 => [floor(($max - $spread * 2)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                QueryHelper::start_query()
                ->whereBetween('disk_4k_write_speed', [($max - $spread * 2), ($max - $spread)])
                ->count()],
            3 => [floor(($max - $spread * 3)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                QueryHelper::start_query()
                ->whereBetween('disk_4k_write_speed', [($max - $spread * 3), ($max - $spread * 2)])
                ->count()],
            4 => ['< '.floor(($max - $spread *  3)/1000000).' MB/s' => 
                QueryHelper::start_query()
                ->where('disk_4k_write_speed', '<', ($max - $spread * 3))
                ->count()],
        ];
    }


    public static function disk_4k_total_iops_count()
    {
        $max_4k_iops = QueryHelper::start_query()->max('disk_4k_total_iops');
        $min_4k_iops = QueryHelper::start_query()->min('disk_4k_total_iops');
        $disk_4k_spreads = floor(($max_4k_iops - $min_4k_iops) / 4 / 1000) * 1000;

        return [
            1 => ['> '.floor(($max_4k_iops - $disk_4k_spreads)/1000).'K' => QueryHelper::start_query()
                ->where('disk_4k_total_iops', '>', ($max_4k_iops - $disk_4k_spreads))
                ->count()],
            2 => [floor(($max_4k_iops - $disk_4k_spreads * 2)/1000).'K to '.floor(($max_4k_iops - $disk_4k_spreads * 2)/1000).'K' => 
                QueryHelper::start_query()
                ->whereBetween('disk_4k_total_iops', [($max_4k_iops - $disk_4k_spreads * 2), ($max_4k_iops - $disk_4k_spreads)])
                ->count()],
            3 => [floor(($max_4k_iops - $disk_4k_spreads * 3)/1000).'K to '.floor(($max_4k_iops - $disk_4k_spreads * 2)/1000).'K' => 
                QueryHelper::start_query()
                ->whereBetween('disk_4k_total_iops', [($max_4k_iops - $disk_4k_spreads * 3), ($max_4k_iops - $disk_4k_spreads * 2)])
                ->count()],
            4 => ['< '.floor(($max_4k_iops - $disk_4k_spreads *  3)/1000).'K' => 
                QueryHelper::start_query()
                ->where('disk_4k_total_iops', '<', ($max_4k_iops - $disk_4k_spreads * 3))
                ->count()],
        ];
    }


    public static function geekbench_5_single_count()
    {
        $max = QueryHelper::start_query()->max('geekbench_5_single');
        $min = QueryHelper::start_query()->min('geekbench_5_single');
        $spread = floor($max - $min) / 4;
        
        return [
            1 => ['> '.floor($max - $spread) => 
                QueryHelper::geekbench_5_single_where(QueryHelper::start_query(), 1)->count()],
            2 => [floor($max - $spread * 2).' to '.floor($max - $spread * 2) => 
                QueryHelper::geekbench_5_single_where(QueryHelper::start_query(), 2)->count()],
            3 => [floor($max - $spread * 3).' to '.floor($max - $spread * 2) => 
                QueryHelper::geekbench_5_single_where(QueryHelper::start_query(), 3)->count()],
            4 => ['< '.floor($max - $spread *  3) => 
                QueryHelper::geekbench_5_single_where(QueryHelper::start_query(), 4)->count()],
        ];
    }


    public static function geekbench_5_single_where($query, $index, $use_or = false)
    {
            $max = QueryHelper::start_query()->max('geekbench_5_single');
            $min = QueryHelper::start_query()->min('geekbench_5_single');
            $spread = floor($max - $min) / 4;

            if($index == 1 && !$use_or) {return $query->where('geekbench_5_single', '>', ($max - $spread));}
            if($index == 2 && !$use_or) {return $query->whereBetween('geekbench_5_single', [($max - $spread * 2), ($max - $spread)]);}
            if($index == 3 && !$use_or) {return $query->whereBetween('geekbench_5_single', [($max - $spread * 3), ($max - $spread * 2)]);}
            if($index == 4 && !$use_or) {return $query->where('geekbench_5_single', '<', ($max - $spread * 3));}

            if($index == 1 && $use_or) {return $query->orWhere('geekbench_5_single', '>', ($max - $spread));}
            if($index == 2 && $use_or) {return $query->orWhereBetween('geekbench_5_single', [($max - $spread * 2), ($max - $spread)]);}
            if($index == 3 && $use_or) {return $query->orWhereBetween('geekbench_5_single', [($max - $spread * 3), ($max - $spread * 2)]);}
            if($index == 4 && $use_or) {return $query->orWhere('geekbench_5_single', '<', ($max - $spread * 3));}
    }


    public static function geekbench_5_multi_count()
    {
        $max = QueryHelper::start_query()->max('geekbench_5_multi');
        $min = QueryHelper::start_query()->min('geekbench_5_multi');
        $spread = floor($max - $min) / 4;
        
        return [
            1 => ['> '.floor($max - $spread) => 
                QueryHelper::geekbench_5_multi_where(QueryHelper::start_query(), 1)->count()],
            2 => [floor($max - $spread * 2).' to '.floor($max - $spread * 2) => 
                QueryHelper::geekbench_5_multi_where(QueryHelper::start_query(), 2)->count()],
            3 => [floor($max - $spread * 3).' to '.floor($max - $spread * 2) => 
                QueryHelper::geekbench_5_multi_where(QueryHelper::start_query(), 3)->count()],
            4 => ['< '.floor($max - $spread *  3) => 
                QueryHelper::geekbench_5_multi_where(QueryHelper::start_query(), 4)->count()],
        ];
    }


    public static function geekbench_5_multi_where($query, $index, $use_or = false)
    {
        $max = QueryHelper::start_query()->max('geekbench_5_multi');
        $min = QueryHelper::start_query()->min('geekbench_5_multi');
        $spread = floor($max - $min) / 4;

        if($index == 1 && !$use_or) {return $query->where('geekbench_5_multi', '>', ($max - $spread));}
        if($index == 2 && !$use_or) {return $query->whereBetween('geekbench_5_multi', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3 && !$use_or) {return $query->whereBetween('geekbench_5_multi', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4 && !$use_or) {return $query->where('geekbench_5_multi', '<', ($max - $spread * 3));}

        if($index == 1 && $use_or) {return $query->orWhere('geekbench_5_multi', '>', ($max - $spread));}
        if($index == 2 && $use_or) {return $query->orWhereBetween('geekbench_5_multi', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3 && $use_or) {return $query->orWhereBetween('geekbench_5_multi', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4 && $use_or) {return $query->orWhere('geekbench_5_multi', '<', ($max - $spread * 3));}
    }
}