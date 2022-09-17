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


    public static function provider_names_count($whereIn)
    {
        $query = QueryHelper::start_query();

        if(!empty($whereIn)) {
            $query->whereIn('id', $whereIn);
        }

        return $query->select([
                'provider_name',
                DB::raw('COUNT(servers.provider_name) as count')
                ])
            ->groupBy('servers.provider_name')
            ->orderBy('servers.provider_name')
            ->distinct()
            ->get();
    }


    public static function add_where_in($query, array $whereIn = [])
    {
        if(!empty($whereIn)) {

        }
        return $query;

    }


    public static function cores_count($merged_ids = null)
    {
        if(!empty($merged_ids)) {
            return [
                1 => ['> 16 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 1)->whereIn('id', $merged_ids)->count()],
                2 => ['12 to 16 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 2)->whereIn('id', $merged_ids)->count()],
                3 => ['8 to 11 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 3)->whereIn('id', $merged_ids)->count()],
                4 => ['4 to 7 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 4)->whereIn('id', $merged_ids)->count()],
                5 => ['3 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 5)->whereIn('id', $merged_ids)->count()],
                6 => ['2 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 6)->whereIn('id', $merged_ids)->count()],
                7 => ['1 Core' => QueryHelper::cores_where(QueryHelper::start_query(), 7)->whereIn('id', $merged_ids)->count()],
            ];            
        }
        return [
            1 => ['> 16 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 1)->count()],
            2 => ['12 to 16 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 2)->count()],
            3 => ['8 to 11 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 3)->count()],
            4 => ['4 to 7 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 4)->count()],
            5 => ['3 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 5)->count()],
            6 => ['2 Cores' => QueryHelper::cores_where(QueryHelper::start_query(), 6)->count()],
            7 => ['1 Core' => QueryHelper::cores_where(QueryHelper::start_query(), 7)->count()],
        ];
    }


    public static function cores_where($query, $index)
    {
        if($index == 1) {return $query->where('cores', '>', 16);}
        if($index == 2) {return $query->whereIn('cores', [12, 13, 14, 15, 16]);}
        if($index == 3) {return $query->whereIn('cores', [8, 9, 10, 11]);}
        if($index == 4) {return $query->whereIn('cores', [4, 5, 6, 7]);}
        if($index == 5) {return $query->where('cores', '=', 3);}
        if($index == 6) {return $query->where('cores', '=', 2);}
        if($index == 7) {return $query->where('cores', '=', 1);}
    }


    public static function cores_where_not($query, $index)
    {
        if($index == 1) {return $query->where('cores', '<=', 16);}
        if($index == 2) {return $query->whereNotIn('cores', [12, 13, 14, 15, 16]);}
        if($index == 3) {return $query->whereNotIn('cores', [8, 9, 10, 11]);}
        if($index == 4) {return $query->whereNotIn('cores', [4, 5, 6, 7]);}
        if($index == 5) {return $query->where('cores', '<>', 3);}
        if($index == 6) {return $query->where('cores', '<>', 2);}
        if($index == 7) {return $query->where('cores', '<>', 1);}
    } 


    public static function ram_count($merged_ids = null)
    {
        if(!empty($merged_ids)) {
            return [
                1 => ['> 24GB' => QueryHelper::ram_where(QueryHelper::start_query(), 1)->whereIn('id', $merged_ids)->count()],
                2 => ['16GB to 24GB' => QueryHelper::ram_where(QueryHelper::start_query(), 2)->whereIn('id', $merged_ids)->count()],
                3 => ['8GB to 16GB' => QueryHelper::ram_where(QueryHelper::start_query(), 3)->whereIn('id', $merged_ids)->count()],
                4 => ['4GB to 8GB' => QueryHelper::ram_where(QueryHelper::start_query(), 4)->whereIn('id', $merged_ids)->count()],
                5 => ['2GB to 4GB' => QueryHelper::ram_where(QueryHelper::start_query(), 5)->whereIn('id', $merged_ids)->count()],
                6 => ['1GB to 2GB' => QueryHelper::ram_where(QueryHelper::start_query(), 6)->whereIn('id', $merged_ids)->count()],
                7 => ['512MB to 1GB' => QueryHelper::ram_where(QueryHelper::start_query(), 7)->whereIn('id', $merged_ids)->count()],
                8 => ['< 512MB' => QueryHelper::ram_where(QueryHelper::start_query(), 8)->whereIn('id', $merged_ids)->count()],
            ]; 
        }
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


    public static function ram_where($query, $index)
    {
        if($index == 1) {return $query->where('ram', '>', 24000);}
        if($index == 2) {return $query->whereBetween('ram', [16000, 24000]);}
        if($index == 3) {return $query->whereBetween('ram', [8000, 15999]);}
        if($index == 4) {return $query->whereBetween('ram', [4001, 7999]);}
        if($index == 5) {return $query->whereBetween('ram', [2000, 3999]);}
        if($index == 6) {return $query->whereBetween('ram', [1000, 1999]);}
        if($index == 7) {return $query->whereBetween('ram', [512, 999]);}
        if($index == 8) {return $query->where('ram', '<', 512);}        
    }


    public static function ram_where_not($query, $index)
    {
        if($index == 1) {return $query->where('ram', '<', 24001);}
        if($index == 2) {return $query->whereNotBetween('ram', [16000, 24000]);}
        if($index == 3) {return $query->whereNotBetween('ram', [8000, 15999]);}
        if($index == 4) {return $query->whereNotBetween('ram', [4001, 7999]);}
        if($index == 5) {return $query->whereNotBetween('ram', [2000, 3999]);}
        if($index == 6) {return $query->whereNotBetween('ram', [1000, 1999]);}
        if($index == 7) {return $query->whereNotBetween('ram', [512, 999]);}
        if($index == 8) {return $query->where('ram', '>', 512);}        
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


    public static function average_network_speed_count($merged_ids)
    {
        $max = QueryHelper::start_query()->max('average_network_speed');
        $min = QueryHelper::start_query()->min('average_network_speed');
        $spread = floor(($max - $min) / 4 / 1000) * 1000;

        if(!empty($merged_ids)) {
            return [
                1 => ['> '.floor(($max - $spread)/1000000).' MB/s' => 
                    QueryHelper::average_network_speed_where(QueryHelper::start_query(), 1, $max, $spread)
                        ->whereIn('id', $merged_ids)->count()],
                2 => [floor(($max - $spread * 2)/1000000).' MB/s'.' to '.floor(($max - $spread)/1000000).' MB/s' => 
                    QueryHelper::average_network_speed_where(QueryHelper::start_query(), 2, $max, $spread)
                        ->whereIn('id', $merged_ids)->count()],
                3 => [floor(($max - $spread * 3)/1000000).' MB/s'.' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                    QueryHelper::average_network_speed_where(QueryHelper::start_query(), 3, $max, $spread)
                        ->whereIn('id', $merged_ids)->count()],
                4 => ['< '.floor(($max - $spread *  3)/1000000).' MB/s' => 
                    QueryHelper::average_network_speed_where(QueryHelper::start_query(), 4, $max, $spread)
                        ->whereIn('id', $merged_ids)->count()]
            ];
        }
        return [
            1 => ['> '.($max - $spread) => 
                QueryHelper::average_network_speed_where(QueryHelper::start_query(), 1, $max, $spread)
                    ->count()],
            2 => [($max - $spread * 2).' to '.($max - $spread) => 
                QueryHelper::average_network_speed_where(QueryHelper::start_query(), 2, $max, $spread)
                    ->count()],
            3 => [($max - $spread * 3).' to '.($max - $spread * 2) => 
                QueryHelper::average_network_speed_where(QueryHelper::start_query(), 3, $max, $spread)
                    ->count()],
            4 => ['< '.($max - $spread *  3) => 
                QueryHelper::average_network_speed_where(QueryHelper::start_query(), 4, $max, $spread)
                    ->count()]
        ];
    }


    public static function average_network_speed_where($query, $index)
    {
        $max = QueryHelper::start_query()->max('average_network_speed');
        $min = QueryHelper::start_query()->min('average_network_speed');
        $spread = floor(($max - $min) / 4 / 1000) * 1000;

        if($index == 1) {return $query->where('average_network_speed', '>', ($max - $spread));}
        if($index == 2) {return $query->whereBetween('average_network_speed', [($max - $spread * 2) + 1, ($max - $spread)]);}
        if($index == 3) {return $query->whereBetween('average_network_speed', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('average_network_speed', '<', ($max - $spread * 3));}
    }


    public static function average_network_speed_where_not($query, $index)
    {
        $max = QueryHelper::start_query()->max('average_network_speed');
        $min = QueryHelper::start_query()->min('average_network_speed');
        $spread = floor(($max - $min) / 4 / 1000) * 1000;

        if($index == 1) {return $query->where('average_network_speed', '<=', ($max - $spread));}
        if($index == 2) {return $query->whereNotBetween('average_network_speed', [($max - $spread * 2) + 1, ($max - $spread)]);}
        if($index == 3) {return $query->whereNotBetween('average_network_speed', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('average_network_speed', '>=', ($max - $spread * 3));}
    }


    public static function disk_4k_read_speed_count($merged_ids)
    {
        $max = QueryHelper::start_query()->max('disk_4k_read_speed');
        $min = QueryHelper::start_query()->min('disk_4k_read_speed');
        $spread = floor(($max - $min) / 4 / 1000000) * 1000000;

        if(!empty($merged_ids)) {
            return [
                1 => ['> '.floor(($max - $spread)/1000000).' MB/s' =>
                    QueryHelper::disk_4k_read_speed_where(QueryHelper::start_query(), 1)
                        ->whereIn('id', $merged_ids)->count()],
                2 => [floor(($max - $spread * 2)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                    QueryHelper::disk_4k_read_speed_where(QueryHelper::start_query(), 2)
                        ->whereIn('id', $merged_ids)->count()],
                3 => [floor(($max - $spread * 3)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                    QueryHelper::disk_4k_read_speed_where(QueryHelper::start_query(), 3)
                        ->whereIn('id', $merged_ids)->count()],
                4 => ['< '.floor(($max - $spread *  3)/1000000).' MB/s' => 
                    QueryHelper::disk_4k_read_speed_where(QueryHelper::start_query(), 4)
                        ->whereIn('id', $merged_ids)->count()],
            ];
        }
        return [
            1 => ['> '.floor(($max - $spread)/1000000).' MB/s' =>
                QueryHelper::disk_4k_read_speed_where(QueryHelper::start_query(), 1)
                    ->count()],
            2 => [floor(($max - $spread * 2)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                QueryHelper::disk_4k_read_speed_where(QueryHelper::start_query(), 2)
                    ->count()],
            3 => [floor(($max - $spread * 3)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                QueryHelper::disk_4k_read_speed_where(QueryHelper::start_query(), 3)
                    ->count()],
            4 => ['< '.floor(($max - $spread *  3)/1000000).' MB/s' => 
                QueryHelper::disk_4k_read_speed_where(QueryHelper::start_query(), 4)
                    ->count()],
        ];
    }


    public static function disk_4k_read_speed_where($query, $index)
    {
        $max = QueryHelper::start_query()->max('disk_4k_read_speed');
        $min = QueryHelper::start_query()->min('disk_4k_read_speed');
        $spread = floor(($max - $min) / 4 / 1000000) * 1000000;

        if($index == 1) {return $query->where('disk_4k_read_speed', '>', ($max - $spread));}
        if($index == 2) {return $query->whereBetween('disk_4k_read_speed', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereBetween('disk_4k_read_speed', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('disk_4k_read_speed', '<', ($max - $spread * 3));}
    }


    public static function disk_4k_read_speed_where_not($query, $index)
    {
        $max = QueryHelper::start_query()->max('disk_4k_read_speed');
        $min = QueryHelper::start_query()->min('disk_4k_read_speed');
        $spread = floor(($max - $min) / 4 / 1000000) * 1000000;

        if($index == 1) {return $query->where('disk_4k_read_speed', '<=', ($max - $spread));}
        if($index == 2) {return $query->whereNotBetween('disk_4k_read_speed', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereNotBetween('disk_4k_read_speed', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('disk_4k_read_speed', '>=', ($max - $spread * 3));}
    }


    public static function disk_4k_write_speed_count($merged_ids)
    {
        $max = QueryHelper::start_query()->max('disk_4k_write_speed');
        $min = QueryHelper::start_query()->min('disk_4k_write_speed');
        $spread = floor(($max - $min) / 4 / 1000000) * 1000000;

        if(!empty($merged_ids)) {
            return [
                1 => ['> '.floor(($max - $spread)/1000000).' MB/s' =>
                    QueryHelper::disk_4k_write_speed_where(QueryHelper::start_query(), 1)
                        ->whereIn('id', $merged_ids)->count()],
                2 => [floor(($max - $spread * 2)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                    QueryHelper::disk_4k_write_speed_where(QueryHelper::start_query(), 2)
                        ->whereIn('id', $merged_ids)->count()],
                3 => [floor(($max - $spread * 3)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                    QueryHelper::disk_4k_write_speed_where(QueryHelper::start_query(), 3)
                        ->whereIn('id', $merged_ids)->count()],
                4 => ['< '.floor(($max - $spread *  3)/1000000).' MB/s' => 
                    QueryHelper::disk_4k_write_speed_where(QueryHelper::start_query(), 4)
                        ->whereIn('id', $merged_ids)->count()],
            ];
        }
        return [
            1 => ['> '.floor(($max - $spread)/1000000).' MB/s' =>
                QueryHelper::disk_4k_write_speed_where(QueryHelper::start_query(), 1)
                    ->count()],
            2 => [floor(($max - $spread * 2)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                QueryHelper::disk_4k_write_speed_where(QueryHelper::start_query(), 2)
                    ->count()],
            3 => [floor(($max - $spread * 3)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                QueryHelper::disk_4k_write_speed_where(QueryHelper::start_query(), 3)
                    ->count()],
            4 => ['< '.floor(($max - $spread *  3)/1000000).' MB/s' => 
                QueryHelper::disk_4k_write_speed_where(QueryHelper::start_query(), 4)
                    ->count()],
        ];
    }


    public static function disk_4k_write_speed_where($query, $index)
    {
        $max = QueryHelper::start_query()->max('disk_4k_write_speed');
        $min = QueryHelper::start_query()->min('disk_4k_write_speed');
        $spread = floor(($max - $min) / 4 / 1000000) * 1000000;

        if($index == 1) {return $query->where('disk_4k_write_speed', '>', ($max - $spread));}
        if($index == 2) {return $query->whereBetween('disk_4k_write_speed', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereBetween('disk_4k_write_speed', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('disk_4k_write_speed', '<', ($max - $spread * 3));}
    }


    public static function disk_4k_write_speed_where_not($query, $index)
    {
        $max = QueryHelper::start_query()->max('disk_4k_write_speed');
        $min = QueryHelper::start_query()->min('disk_4k_write_speed');
        $spread = floor(($max - $min) / 4 / 1000000) * 1000000;

        if($index == 1) {return $query->where('disk_4k_write_speed', '<=', ($max - $spread));}
        if($index == 2) {return $query->whereNotBetween('disk_4k_write_speed', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereNotBetween('disk_4k_write_speed', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('disk_4k_write_speed', '>=', ($max - $spread * 3));}
    }


    public static function disk_4k_total_iops_count($merged_ids)
    {
        $max = QueryHelper::start_query()->max('disk_4k_total_iops');
        $min = QueryHelper::start_query()->min('disk_4k_total_iops');
        $spread = floor(($max - $min) / 4 / 1000) * 1000;

        if(!empty($merged_ids)) {
            return [
                1 => ['> '.floor(($max - $spread)/1000).'K' => 
                    QueryHelper::disk_4k_total_iops_where(QueryHelper::start_query(), 1)
                        ->whereIn('id', $merged_ids)->count()],
                2 => [floor(($max - $spread * 2)/1000).'K to '.floor(($max - $spread * 2)/1000).'K' => 
                    QueryHelper::disk_4k_total_iops_where(QueryHelper::start_query(), 2)
                        ->whereIn('id', $merged_ids)->count()],
                3 => [floor(($max - $spread * 3)/1000).'K to '.floor(($max - $spread * 2)/1000).'K' => 
                    QueryHelper::disk_4k_total_iops_where(QueryHelper::start_query(), 3)
                        ->whereIn('id', $merged_ids)->count()],
                4 => ['< '.floor(($max - $spread *  3)/1000).'K' => 
                    QueryHelper::disk_4k_total_iops_where(QueryHelper::start_query(), 4)
                        ->whereIn('id', $merged_ids)->count()],
            ];
        }
        return [
            1 => ['> '.floor(($max - $spread)/1000).'K' => 
                QueryHelper::disk_4k_total_iops_where(QueryHelper::start_query(), 1)
                    ->count()],
            2 => [floor(($max - $spread * 2)/1000).'K to '.floor(($max - $spread * 2)/1000).'K' => 
                QueryHelper::disk_4k_total_iops_where(QueryHelper::start_query(), 2)
                    ->count()],
            3 => [floor(($max - $spread * 3)/1000).'K to '.floor(($max - $spread * 2)/1000).'K' => 
                QueryHelper::disk_4k_total_iops_where(QueryHelper::start_query(), 3)
                    ->count()],
            4 => ['< '.floor(($max - $spread *  3)/1000).'K' => 
                QueryHelper::disk_4k_total_iops_where(QueryHelper::start_query(), 4)
                    ->count()],
        ];
    }


    public static function disk_4k_total_iops_where($query, $index)
    {
        $max = QueryHelper::start_query()->max('disk_4k_total_iops');
        $min = QueryHelper::start_query()->min('disk_4k_total_iops');
        $spread = floor(($max - $min) / 4 / 1000) * 1000;

        if($index == 1) {return $query->where('disk_4k_total_iops', '>', ($max - $spread));}
        if($index == 2) {return $query->whereBetween('disk_4k_total_iops', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereBetween('disk_4k_total_iops', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('disk_4k_total_iops', '<', ($max - $spread * 3));}
    }


    public static function disk_4k_total_iops_where_not($query, $index)
    {
        $max = QueryHelper::start_query()->max('disk_4k_total_iops');
        $min = QueryHelper::start_query()->min('disk_4k_total_iops');
        $spread = floor(($max - $min) / 4 / 1000) * 1000;

        if($index == 1) {return $query->where('disk_4k_total_iops', '<=', ($max - $spread));}
        if($index == 2) {return $query->whereNotBetween('disk_4k_total_iops', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereNotBetween('disk_4k_total_iops', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('disk_4k_total_iops', '>', ($max - $spread * 3));}
    }


    public static function geekbench_5_single_count($merged_ids)
    {
        $max = QueryHelper::start_query()->max('geekbench_5_single');
        $min = QueryHelper::start_query()->min('geekbench_5_single');
        $spread = floor($max - $min) / 4;
        
        If(!empty($merged_ids)) {
            return [
                1 => ['> '.floor($max - $spread) => 
                    QueryHelper::geekbench_5_single_where(QueryHelper::start_query(), 1)
                        ->whereIn('id', $merged_ids)->count()],
                2 => [floor($max - $spread * 2).' to '.floor($max - $spread * 2) => 
                    QueryHelper::geekbench_5_single_where(QueryHelper::start_query(), 2)
                        ->whereIn('id', $merged_ids)->count()],
                3 => [floor($max - $spread * 3).' to '.floor($max - $spread * 2) => 
                    QueryHelper::geekbench_5_single_where(QueryHelper::start_query(), 3)
                        ->whereIn('id', $merged_ids)->count()],
                4 => ['< '.floor($max - $spread *  3) => 
                    QueryHelper::geekbench_5_single_where(QueryHelper::start_query(), 4)
                        ->whereIn('id', $merged_ids)->count()],
            ];   
        }
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


    public static function geekbench_5_single_where($query, $index)
    {
            $max = QueryHelper::start_query()->max('geekbench_5_single');
            $min = QueryHelper::start_query()->min('geekbench_5_single');
            $spread = floor($max - $min) / 4;

            if($index == 1) {return $query->where('geekbench_5_single', '>', ($max - $spread));}
            if($index == 2) {return $query->whereBetween('geekbench_5_single', [($max - $spread * 2), ($max - $spread)]);}
            if($index == 3) {return $query->whereBetween('geekbench_5_single', [($max - $spread * 3), ($max - $spread * 2)]);}
            if($index == 4) {return $query->where('geekbench_5_single', '<', ($max - $spread * 3));}
    }


    public static function geekbench_5_single_where_not($query, $index)
    {
            $max = QueryHelper::start_query()->max('geekbench_5_single');
            $min = QueryHelper::start_query()->min('geekbench_5_single');
            $spread = floor($max - $min) / 4;

            if($index == 1) {return $query->where('geekbench_5_single', '<', ($max - $spread));}
            if($index == 2) {return $query->whereNotBetween('geekbench_5_single', [($max - $spread * 2), ($max - $spread)]);}
            if($index == 3) {return $query->whereNotBetween('geekbench_5_single', [($max - $spread * 3), ($max - $spread * 2)]);}
            if($index == 4) {return $query->where('geekbench_5_single', '>', ($max - $spread * 3));}
    }


    public static function geekbench_5_multi_count($merged_ids)
    {
        $max = QueryHelper::start_query()->max('geekbench_5_multi');
        $min = QueryHelper::start_query()->min('geekbench_5_multi');
        $spread = floor($max - $min) / 4;
        
        if(!empty($merged_ids)) {
            return [
                1 => ['> '.floor($max - $spread) => 
                    QueryHelper::geekbench_5_multi_where(QueryHelper::start_query(), 1)
                        ->whereIn('id', $merged_ids)->count()],
                2 => [floor($max - $spread * 2).' to '.floor($max - $spread * 2) => 
                    QueryHelper::geekbench_5_multi_where(QueryHelper::start_query(), 2)
                        ->whereIn('id', $merged_ids)->count()],
                3 => [floor($max - $spread * 3).' to '.floor($max - $spread * 2) => 
                    QueryHelper::geekbench_5_multi_where(QueryHelper::start_query(), 3)
                        ->whereIn('id', $merged_ids)->count()],
                4 => ['< '.floor($max - $spread *  3) => 
                    QueryHelper::geekbench_5_multi_where(QueryHelper::start_query(), 4)
                        ->whereIn('id', $merged_ids)->count()],
            ];
        }
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


    public static function geekbench_5_multi_where($query, $index)
    {
        $max = QueryHelper::start_query()->max('geekbench_5_multi');
        $min = QueryHelper::start_query()->min('geekbench_5_multi');
        $spread = floor($max - $min) / 4;

        if($index == 1) {return $query->where('geekbench_5_multi', '>', ($max - $spread));}
        if($index == 2) {return $query->whereBetween('geekbench_5_multi', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereBetween('geekbench_5_multi', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('geekbench_5_multi', '<', ($max - $spread * 3));}
    }


    public static function geekbench_5_multi_where_not($query, $index)
    {
        $max = QueryHelper::start_query()->max('geekbench_5_multi');
        $min = QueryHelper::start_query()->min('geekbench_5_multi');
        $spread = floor($max - $min) / 4;

        if($index == 1) {return $query->where('geekbench_5_multi', '<', ($max - $spread));}
        if($index == 2) {return $query->whereNotBetween('geekbench_5_multi', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereNotBetween('geekbench_5_multi', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('geekbench_5_multi', '>', ($max - $spread * 3));}
    }
}