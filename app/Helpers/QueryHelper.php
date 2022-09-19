<?php

namespace App\Helpers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryHelper {

    private static $ram_options = [
        ['> 24GB', 24000],
        ['16GB to 24GB', [16000, 24000]],
        ['8GB to 16GB', [8000, 15999]],
        ['4GB to 8GB', [4001, 7999]],
        ['2GB to 4GB', [2000, 3999]],
        ['1GB to 2GB', [1000, 1999]],
        ['512MB to 1GB', [512, 999]],
        ['< 512MB', 512]
    ];

    private static $cores_options = [
        ['> 16 Cores', 16],
        ['12 to 16 Cores', [12, 13, 14, 15, 16]],
        ['8 to 11 Cores', [8, 9, 10, 11]],
        ['4 to 7 Cores', [4, 5, 6, 7]],
        ['3 Cores', 3],
        ['2 Cores', 2],
        ['1 Core', 1],
    ];

    private static function network_speed_spread($min, $max) 
    {
        return floor(($max - $min) / 4 / 1000) * 1000;
    }

    private static function disk_speed_spread($min, $max) 
    {
        return floor(($max - $min) / 4 / 1000000) * 1000000;
    }

    private static function disk_iops_spread($min, $max) 
    {
        return floor(($max - $min) / 4 / 1000) * 1000;
    }


    private static function start_query()
    {
        $query = DB::table('servers');
        // $query->where();

        return $query;
    }


    public static function provider_names_count($whereIn)
    {
        $query = self::start_query();

        if(!empty($whereIn)) {
            $query->whereIntegerInRaw('id', $whereIn);
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


    public static function cores_count($merged_ids = null)
    {
        if(!empty($merged_ids)) {
            return [
                1 => [self::$cores_options[0][0] => self::cores_where(self::start_query(), 1)->whereIntegerInRaw('id', $merged_ids)->count()],
                2 => [self::$cores_options[1][0] => self::cores_where(self::start_query(), 2)->whereIntegerInRaw('id', $merged_ids)->count()],
                3 => [self::$cores_options[2][0] => self::cores_where(self::start_query(), 3)->whereIntegerInRaw('id', $merged_ids)->count()],
                4 => [self::$cores_options[3][0] => self::cores_where(self::start_query(), 4)->whereIntegerInRaw('id', $merged_ids)->count()],
                5 => [self::$cores_options[4][0] => self::cores_where(self::start_query(), 5)->whereIntegerInRaw('id', $merged_ids)->count()],
                6 => [self::$cores_options[5][0] => self::cores_where(self::start_query(), 6)->whereIntegerInRaw('id', $merged_ids)->count()],
                7 => [self::$cores_options[6][0] => self::cores_where(self::start_query(), 7)->whereIntegerInRaw('id', $merged_ids)->count()],
            ];            
        }
        return [
            1 => [self::$cores_options[0][0] => self::cores_where(self::start_query(), 1)->count()],
            2 => [self::$cores_options[1][0] => self::cores_where(self::start_query(), 2)->count()],
            3 => [self::$cores_options[2][0] => self::cores_where(self::start_query(), 3)->count()],
            4 => [self::$cores_options[3][0] => self::cores_where(self::start_query(), 4)->count()],
            5 => [self::$cores_options[4][0] => self::cores_where(self::start_query(), 5)->count()],
            6 => [self::$cores_options[5][0] => self::cores_where(self::start_query(), 6)->count()],
            7 => [self::$cores_options[6][0] => self::cores_where(self::start_query(), 7)->count()],
        ];
    }


    public static function cores_where($query, $index)
    {
        if($index == 1) {return $query->where('cores', '>', self::$cores_options[0][1]);}
        if($index == 2) {return $query->whereIn('cores', self::$cores_options[1][1]);}
        if($index == 3) {return $query->whereIn('cores', self::$cores_options[2][1]);}
        if($index == 4) {return $query->whereIn('cores', self::$cores_options[3][1]);}
        if($index == 5) {return $query->where('cores', '=', self::$cores_options[4][1]);}
        if($index == 6) {return $query->where('cores', '=', self::$cores_options[5][1]);}
        if($index == 7) {return $query->where('cores', '=', self::$cores_options[6][1]);}
    }


    public static function cores_where_not($query, $index)
    {
        if($index == 1) {return $query->where('cores', '<=', self::$cores_options[0][1]);}
        if($index == 2) {return $query->whereNotIn('cores', self::$cores_options[1][1]);}
        if($index == 3) {return $query->whereNotIn('cores', self::$cores_options[2][1]);}
        if($index == 4) {return $query->whereNotIn('cores', self::$cores_options[3][1]);}
        if($index == 5) {return $query->where('cores', '<>', self::$cores_options[4][1]);}
        if($index == 6) {return $query->where('cores', '<>', self::$cores_options[5][1]);}
        if($index == 7) {return $query->where('cores', '<>', self::$cores_options[6][1]);}
    } 


    public static function ram_count($merged_ids = null)
    {
        if(!empty($merged_ids)) {
            return [
                1 => [self::$ram_options[0][0] => self::ram_where(self::start_query(), 1)->whereIntegerInRaw('id', $merged_ids)->count()],
                2 => [self::$ram_options[1][0] => self::ram_where(self::start_query(), 2)->whereIntegerInRaw('id', $merged_ids)->count()],
                3 => [self::$ram_options[2][0] => self::ram_where(self::start_query(), 3)->whereIntegerInRaw('id', $merged_ids)->count()],
                4 => [self::$ram_options[3][0] => self::ram_where(self::start_query(), 4)->whereIntegerInRaw('id', $merged_ids)->count()],
                5 => [self::$ram_options[4][0] => self::ram_where(self::start_query(), 5)->whereIntegerInRaw('id', $merged_ids)->count()],
                6 => [self::$ram_options[5][0] => self::ram_where(self::start_query(), 6)->whereIntegerInRaw('id', $merged_ids)->count()],
                7 => [self::$ram_options[6][0] => self::ram_where(self::start_query(), 7)->whereIntegerInRaw('id', $merged_ids)->count()],
                8 => [self::$ram_options[7][0] => self::ram_where(self::start_query(), 8)->whereIntegerInRaw('id', $merged_ids)->count()],
            ]; 
        }
        return [
            1 => [self::$ram_options[0][0] => self::ram_where(self::start_query(), 1)->count()],
            2 => [self::$ram_options[1][0] => self::ram_where(self::start_query(), 2)->count()],
            3 => [self::$ram_options[2][0] => self::ram_where(self::start_query(), 3)->count()],
            4 => [self::$ram_options[3][0] => self::ram_where(self::start_query(), 4)->count()],
            5 => [self::$ram_options[4][0] => self::ram_where(self::start_query(), 5)->count()],
            6 => [self::$ram_options[5][0] => self::ram_where(self::start_query(), 6)->count()],
            7 => [self::$ram_options[6][0] => self::ram_where(self::start_query(), 7)->count()],
            8 => [self::$ram_options[7][0] => self::ram_where(self::start_query(), 8)->count()],
        ];
    }


    public static function ram_where($query, $index)
    {
        if($index == 1) {return $query->where('ram', '>', self::$ram_options[0][1]);}
        if($index == 2) {return $query->whereBetween('ram', self::$ram_options[1][1]);}
        if($index == 3) {return $query->whereBetween('ram', self::$ram_options[2][1]);}
        if($index == 4) {return $query->whereBetween('ram', self::$ram_options[3][1]);}
        if($index == 5) {return $query->whereBetween('ram', self::$ram_options[4][1]);}
        if($index == 6) {return $query->whereBetween('ram', self::$ram_options[5][1]);}
        if($index == 7) {return $query->whereBetween('ram', self::$ram_options[6][1]);}
        if($index == 8) {return $query->where('ram', '<', self::$ram_options[7][1]);}        
    }


    public static function ram_where_not($query, $index)
    {
        if($index == 1) {return $query->where('ram', '<=', self::$ram_options[0][1]);}
        if($index == 2) {return $query->whereNotBetween('ram', self::$ram_options[1][1]);}
        if($index == 3) {return $query->whereNotBetween('ram', self::$ram_options[2][1]);}
        if($index == 4) {return $query->whereNotBetween('ram', self::$ram_options[3][1]);}
        if($index == 5) {return $query->whereNotBetween('ram', self::$ram_options[4][1]);}
        if($index == 6) {return $query->whereNotBetween('ram', self::$ram_options[5][1]);}
        if($index == 7) {return $query->whereNotBetween('ram', self::$ram_options[6][1]);}
        if($index == 8) {return $query->where('ram', '>=', self::$ram_options[7][1]);}        
    }
    

    public static function virtualization_count()
    {
        return self::start_query()
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
        $max = self::start_query()->max('average_network_speed');
        $min = self::start_query()->min('average_network_speed');
        $spread = self::network_speed_spread($min, $max);

        if(!empty($merged_ids)) {
            return [
                1 => ['> '.floor(($max - $spread)/1000000).' MB/s' => 
                    self::average_network_speed_where(self::start_query(), 1, $max, $spread)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                2 => [floor(($max - $spread * 2)/1000000).' MB/s'.' to '.floor(($max - $spread)/1000000).' MB/s' => 
                    self::average_network_speed_where(self::start_query(), 2, $max, $spread)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                3 => [floor(($max - $spread * 3)/1000000).' MB/s'.' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                    self::average_network_speed_where(self::start_query(), 3, $max, $spread)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                4 => ['< '.floor(($max - $spread *  3)/1000000).' MB/s' => 
                    self::average_network_speed_where(self::start_query(), 4, $max, $spread)
                        ->whereIntegerInRaw('id', $merged_ids)->count()]
            ];
        }
        return [
            1 => ['> '.($max - $spread) => 
                self::average_network_speed_where(self::start_query(), 1, $max, $spread)
                    ->count()],
            2 => [($max - $spread * 2).' to '.($max - $spread) => 
                self::average_network_speed_where(self::start_query(), 2, $max, $spread)
                    ->count()],
            3 => [($max - $spread * 3).' to '.($max - $spread * 2) => 
                self::average_network_speed_where(self::start_query(), 3, $max, $spread)
                    ->count()],
            4 => ['< '.($max - $spread *  3) => 
                self::average_network_speed_where(self::start_query(), 4, $max, $spread)
                    ->count()]
        ];
    }


    public static function average_network_speed_where($query, $index)
    {
        $max = self::start_query()->max('average_network_speed');
        $min = self::start_query()->min('average_network_speed');
        $spread = self::network_speed_spread($min, $max);

        if($index == 1) {return $query->where('average_network_speed', '>', ($max - $spread));}
        if($index == 2) {return $query->whereBetween('average_network_speed', [($max - $spread * 2) + 1, ($max - $spread)]);}
        if($index == 3) {return $query->whereBetween('average_network_speed', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('average_network_speed', '<', ($max - $spread * 3));}
    }


    public static function average_network_speed_where_not($query, $index)
    {
        $max = self::start_query()->max('average_network_speed');
        $min = self::start_query()->min('average_network_speed');
        $spread = self::network_speed_spread($min, $max);

        if($index == 1) {return $query->where('average_network_speed', '<=', ($max - $spread));}
        if($index == 2) {return $query->whereNotBetween('average_network_speed', [($max - $spread * 2) + 1, ($max - $spread)]);}
        if($index == 3) {return $query->whereNotBetween('average_network_speed', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('average_network_speed', '>=', ($max - $spread * 3));}
    }


    public static function disk_4k_read_speed_count($merged_ids)
    {
        $max = self::start_query()->max('disk_4k_read_speed');
        $min = self::start_query()->min('disk_4k_read_speed');
        $spread = self::disk_speed_spread($min, $max);

        if(!empty($merged_ids)) {
            return [
                1 => ['> '.floor(($max - $spread)/1000000).' MB/s' =>
                    self::disk_4k_read_speed_where(self::start_query(), 1)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                2 => [floor(($max - $spread * 2)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                    self::disk_4k_read_speed_where(self::start_query(), 2)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                3 => [floor(($max - $spread * 3)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                    self::disk_4k_read_speed_where(self::start_query(), 3)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                4 => ['< '.floor(($max - $spread *  3)/1000000).' MB/s' => 
                    self::disk_4k_read_speed_where(self::start_query(), 4)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
            ];
        }
        return [
            1 => ['> '.floor(($max - $spread)/1000000).' MB/s' =>
                self::disk_4k_read_speed_where(self::start_query(), 1)
                    ->count()],
            2 => [floor(($max - $spread * 2)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                self::disk_4k_read_speed_where(self::start_query(), 2)
                    ->count()],
            3 => [floor(($max - $spread * 3)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                self::disk_4k_read_speed_where(self::start_query(), 3)
                    ->count()],
            4 => ['< '.floor(($max - $spread *  3)/1000000).' MB/s' => 
                self::disk_4k_read_speed_where(self::start_query(), 4)
                    ->count()],
        ];
    }


    public static function disk_4k_read_speed_where($query, $index)
    {
        $max = self::start_query()->max('disk_4k_read_speed');
        $min = self::start_query()->min('disk_4k_read_speed');
        $spread = self::disk_speed_spread($min, $max);

        if($index == 1) {return $query->where('disk_4k_read_speed', '>', ($max - $spread));}
        if($index == 2) {return $query->whereBetween('disk_4k_read_speed', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereBetween('disk_4k_read_speed', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('disk_4k_read_speed', '<', ($max - $spread * 3));}
    }


    public static function disk_4k_read_speed_where_not($query, $index)
    {
        $max = self::start_query()->max('disk_4k_read_speed');
        $min = self::start_query()->min('disk_4k_read_speed');
        $spread = self::disk_speed_spread($min, $max);

        if($index == 1) {return $query->where('disk_4k_read_speed', '<=', ($max - $spread));}
        if($index == 2) {return $query->whereNotBetween('disk_4k_read_speed', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereNotBetween('disk_4k_read_speed', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('disk_4k_read_speed', '>=', ($max - $spread * 3));}
    }


    public static function disk_4k_write_speed_count($merged_ids)
    {
        $max = self::start_query()->max('disk_4k_write_speed');
        $min = self::start_query()->min('disk_4k_write_speed');
        $spread = self::disk_speed_spread($min, $max);

        if(!empty($merged_ids)) {
            return [
                1 => ['> '.floor(($max - $spread)/1000000).' MB/s' =>
                    self::disk_4k_write_speed_where(self::start_query(), 1)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                2 => [floor(($max - $spread * 2)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                    self::disk_4k_write_speed_where(self::start_query(), 2)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                3 => [floor(($max - $spread * 3)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                    self::disk_4k_write_speed_where(self::start_query(), 3)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                4 => ['< '.floor(($max - $spread *  3)/1000000).' MB/s' => 
                    self::disk_4k_write_speed_where(self::start_query(), 4)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
            ];
        }
        return [
            1 => ['> '.floor(($max - $spread)/1000000).' MB/s' =>
                self::disk_4k_write_speed_where(self::start_query(), 1)
                    ->count()],
            2 => [floor(($max - $spread * 2)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                self::disk_4k_write_speed_where(self::start_query(), 2)
                    ->count()],
            3 => [floor(($max - $spread * 3)/1000000).' to '.floor(($max - $spread * 2)/1000000).' MB/s' => 
                self::disk_4k_write_speed_where(self::start_query(), 3)
                    ->count()],
            4 => ['< '.floor(($max - $spread *  3)/1000000).' MB/s' => 
                self::disk_4k_write_speed_where(self::start_query(), 4)
                    ->count()],
        ];
    }


    public static function disk_4k_write_speed_where($query, $index)
    {
        $max = self::start_query()->max('disk_4k_write_speed');
        $min = self::start_query()->min('disk_4k_write_speed');
        $spread = self::disk_speed_spread($min, $max);

        if($index == 1) {return $query->where('disk_4k_write_speed', '>', ($max - $spread));}
        if($index == 2) {return $query->whereBetween('disk_4k_write_speed', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereBetween('disk_4k_write_speed', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('disk_4k_write_speed', '<', ($max - $spread * 3));}
    }


    public static function disk_4k_write_speed_where_not($query, $index)
    {
        $max = self::start_query()->max('disk_4k_write_speed');
        $min = self::start_query()->min('disk_4k_write_speed');
        $spread = self::disk_speed_spread($min, $max);

        if($index == 1) {return $query->where('disk_4k_write_speed', '<=', ($max - $spread));}
        if($index == 2) {return $query->whereNotBetween('disk_4k_write_speed', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereNotBetween('disk_4k_write_speed', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('disk_4k_write_speed', '>=', ($max - $spread * 3));}
    }


    public static function disk_4k_total_iops_count($merged_ids)
    {
        $max = self::start_query()->max('disk_4k_total_iops');
        $min = self::start_query()->min('disk_4k_total_iops');
        $spread = self::disk_iops_spread($min, $max);

        if(!empty($merged_ids)) {
            return [
                1 => ['> '.floor(($max - $spread)/1000).'K' => 
                    self::disk_4k_total_iops_where(self::start_query(), 1)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                2 => [floor(($max - $spread * 2)/1000).'K to '.floor(($max - $spread * 2)/1000).'K' => 
                    self::disk_4k_total_iops_where(self::start_query(), 2)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                3 => [floor(($max - $spread * 3)/1000).'K to '.floor(($max - $spread * 2)/1000).'K' => 
                    self::disk_4k_total_iops_where(self::start_query(), 3)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                4 => ['< '.floor(($max - $spread *  3)/1000).'K' => 
                    self::disk_4k_total_iops_where(self::start_query(), 4)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
            ];
        }
        return [
            1 => ['> '.floor(($max - $spread)/1000).'K' => 
                self::disk_4k_total_iops_where(self::start_query(), 1)
                    ->count()],
            2 => [floor(($max - $spread * 2)/1000).'K to '.floor(($max - $spread * 2)/1000).'K' => 
                self::disk_4k_total_iops_where(self::start_query(), 2)
                    ->count()],
            3 => [floor(($max - $spread * 3)/1000).'K to '.floor(($max - $spread * 2)/1000).'K' => 
                self::disk_4k_total_iops_where(self::start_query(), 3)
                    ->count()],
            4 => ['< '.floor(($max - $spread *  3)/1000).'K' => 
                self::disk_4k_total_iops_where(self::start_query(), 4)
                    ->count()],
        ];
    }


    public static function disk_4k_total_iops_where($query, $index)
    {
        $max = self::start_query()->max('disk_4k_total_iops');
        $min = self::start_query()->min('disk_4k_total_iops');
        $spread = self::disk_iops_spread($min, $max);

        if($index == 1) {return $query->where('disk_4k_total_iops', '>', ($max - $spread));}
        if($index == 2) {return $query->whereBetween('disk_4k_total_iops', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereBetween('disk_4k_total_iops', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('disk_4k_total_iops', '<', ($max - $spread * 3));}
    }


    public static function disk_4k_total_iops_where_not($query, $index)
    {
        $max = self::start_query()->max('disk_4k_total_iops');
        $min = self::start_query()->min('disk_4k_total_iops');
        $spread = self::disk_iops_spread($min, $max);

        if($index == 1) {return $query->where('disk_4k_total_iops', '<=', ($max - $spread));}
        if($index == 2) {return $query->whereNotBetween('disk_4k_total_iops', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereNotBetween('disk_4k_total_iops', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('disk_4k_total_iops', '>', ($max - $spread * 3));}
    }


    public static function geekbench_5_single_count($merged_ids)
    {
        $max = self::start_query()->max('geekbench_5_single');
        $min = self::start_query()->min('geekbench_5_single');
        $spread = floor($max - $min) / 4;
        
        If(!empty($merged_ids)) {
            return [
                1 => ['> '.floor($max - $spread) => 
                    self::geekbench_5_single_where(self::start_query(), 1)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                2 => [floor($max - $spread * 2).' to '.floor($max - $spread * 2) => 
                    self::geekbench_5_single_where(self::start_query(), 2)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                3 => [floor($max - $spread * 3).' to '.floor($max - $spread * 2) => 
                    self::geekbench_5_single_where(self::start_query(), 3)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                4 => ['< '.floor($max - $spread *  3) => 
                    self::geekbench_5_single_where(self::start_query(), 4)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
            ];   
        }
        return [
            1 => ['> '.floor($max - $spread) => 
                self::geekbench_5_single_where(self::start_query(), 1)->count()],
            2 => [floor($max - $spread * 2).' to '.floor($max - $spread * 2) => 
                self::geekbench_5_single_where(self::start_query(), 2)->count()],
            3 => [floor($max - $spread * 3).' to '.floor($max - $spread * 2) => 
                self::geekbench_5_single_where(self::start_query(), 3)->count()],
            4 => ['< '.floor($max - $spread *  3) => 
                self::geekbench_5_single_where(self::start_query(), 4)->count()],
        ];
    }


    public static function geekbench_5_single_where($query, $index)
    {
            $max = self::start_query()->max('geekbench_5_single');
            $min = self::start_query()->min('geekbench_5_single');
            $spread = floor($max - $min) / 4;

            if($index == 1) {return $query->where('geekbench_5_single', '>', ($max - $spread));}
            if($index == 2) {return $query->whereBetween('geekbench_5_single', [($max - $spread * 2), ($max - $spread)]);}
            if($index == 3) {return $query->whereBetween('geekbench_5_single', [($max - $spread * 3), ($max - $spread * 2)]);}
            if($index == 4) {return $query->where('geekbench_5_single', '<', ($max - $spread * 3));}
    }


    public static function geekbench_5_single_where_not($query, $index)
    {
            $max = self::start_query()->max('geekbench_5_single');
            $min = self::start_query()->min('geekbench_5_single');
            $spread = floor($max - $min) / 4;

            if($index == 1) {return $query->where('geekbench_5_single', '<', ($max - $spread));}
            if($index == 2) {return $query->whereNotBetween('geekbench_5_single', [($max - $spread * 2), ($max - $spread)]);}
            if($index == 3) {return $query->whereNotBetween('geekbench_5_single', [($max - $spread * 3), ($max - $spread * 2)]);}
            if($index == 4) {return $query->where('geekbench_5_single', '>', ($max - $spread * 3));}
    }


    public static function geekbench_5_multi_count($merged_ids)
    {
        $max = self::start_query()->max('geekbench_5_multi');
        $min = self::start_query()->min('geekbench_5_multi');
        $spread = floor($max - $min) / 4;
        
        if(!empty($merged_ids)) {
            return [
                1 => ['> '.floor($max - $spread) => 
                    self::geekbench_5_multi_where(self::start_query(), 1)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                2 => [floor($max - $spread * 2).' to '.floor($max - $spread * 2) => 
                    self::geekbench_5_multi_where(self::start_query(), 2)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                3 => [floor($max - $spread * 3).' to '.floor($max - $spread * 2) => 
                    self::geekbench_5_multi_where(self::start_query(), 3)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
                4 => ['< '.floor($max - $spread *  3) => 
                    self::geekbench_5_multi_where(self::start_query(), 4)
                        ->whereIntegerInRaw('id', $merged_ids)->count()],
            ];
        }
        return [
            1 => ['> '.floor($max - $spread) => 
                self::geekbench_5_multi_where(self::start_query(), 1)->count()],
            2 => [floor($max - $spread * 2).' to '.floor($max - $spread * 2) => 
                self::geekbench_5_multi_where(self::start_query(), 2)->count()],
            3 => [floor($max - $spread * 3).' to '.floor($max - $spread * 2) => 
                self::geekbench_5_multi_where(self::start_query(), 3)->count()],
            4 => ['< '.floor($max - $spread *  3) => 
                self::geekbench_5_multi_where(self::start_query(), 4)->count()],
        ];
    }


    public static function geekbench_5_multi_where($query, $index)
    {
        $max = self::start_query()->max('geekbench_5_multi');
        $min = self::start_query()->min('geekbench_5_multi');
        $spread = floor($max - $min) / 4;

        if($index == 1) {return $query->where('geekbench_5_multi', '>', ($max - $spread));}
        if($index == 2) {return $query->whereBetween('geekbench_5_multi', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereBetween('geekbench_5_multi', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('geekbench_5_multi', '<', ($max - $spread * 3));}
    }


    public static function geekbench_5_multi_where_not($query, $index)
    {
        $max = self::start_query()->max('geekbench_5_multi');
        $min = self::start_query()->min('geekbench_5_multi');
        $spread = floor($max - $min) / 4;

        if($index == 1) {return $query->where('geekbench_5_multi', '<', ($max - $spread));}
        if($index == 2) {return $query->whereNotBetween('geekbench_5_multi', [($max - $spread * 2), ($max - $spread)]);}
        if($index == 3) {return $query->whereNotBetween('geekbench_5_multi', [($max - $spread * 3), ($max - $spread * 2)]);}
        if($index == 4) {return $query->where('geekbench_5_multi', '>', ($max - $spread * 3));}
    }
}