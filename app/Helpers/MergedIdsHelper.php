<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MergedIdsHelper {
    public static function getMergedIds(Request $request)
    {
        if(!is_null($request->selected_items['selected_ram'])) {
            $query = DB::table('servers');
            foreach($request->selected_items['selected_ram'] as $index) {
                $query = QueryHelper::ram_where_not($query, intval($index));
            }
            $selected_ram = $query->select('id')->pluck('id')->toArray();
        }

        if(!is_null($request->selected_items['selected_cores'])) {
            $query = DB::table('servers');
            foreach($request->selected_items['selected_cores'] as $index) {
                $query = QueryHelper::cores_where_not($query, intval($index));
            }
            $selected_cores = $query->select('id')->pluck('id')->toArray();
        }

        if(!is_null($request->selected_items['selected_providers'])) {
            $query = DB::table('servers');
            $query->whereNotIn('provider_name', $request->selected_items['selected_providers']);
            $selected_providers = $query->select('id')->pluck('id')->toArray();
        }

        if(!is_null($request->selected_items['selected_gb5_single'])) {
            $query = DB::table('servers');
            foreach($request->selected_items['selected_gb5_single'] as $index) {
                $query = QueryHelper::geekbench_5_single_where_not($query, intval($index));
            }
            $selected_gb5_single = $query->select('id')->pluck('id')->toArray();
        }

        if(!is_null($request->selected_items['selected_gb5_multi'])) {
            $query = DB::table('servers');
            foreach($request->selected_items['selected_gb5_multi'] as $index) {
                $query = QueryHelper::geekbench_5_multi_where_not($query, intval($index));
            }
            $selected_gb5_multi = $query->select('id')->pluck('id')->toArray();
        }

        if(!is_null($request->selected_items['selected_4k_read_speed'])) {
            $query = DB::table('servers');
            foreach($request->selected_items['selected_4k_read_speed'] as $index) {
                $query = QueryHelper::disk_4k_read_speed_where_not($query, intval($index));
            }
            $selected_4k_read_speed = $query->select('id')->pluck('id')->toArray();
        }

        if(!is_null($request->selected_items['selected_4k_write_speed'])) {
            $query = DB::table('servers');
            foreach($request->selected_items['selected_4k_write_speed'] as $index) {
                $query = QueryHelper::disk_4k_write_speed_where_not($query, intval($index));
            }
            $selected_4k_write_speed = $query->select('id')->pluck('id')->toArray();
        }

        if(!is_null($request->selected_items['selected_4k_write_speed'])) {
            $query = DB::table('servers');
            foreach($request->selected_items['selected_4k_total_iops'] as $index) {
                $query = QueryHelper::disk_4k_total_iops_where_not($query, intval($index));
            }
            $selected_4k_total_iops = $query->select('id')->pluck('id')->toArray();
        }

        if(!is_null($request->selected_items['selected_avg_network'])) {
            $query = DB::table('servers');
            foreach($request->selected_items['selected_avg_network'] as $index) {
                $query = QueryHelper::average_network_speed_where_not($query, intval($index));
            }
            $selected_avg_network = $query->select('id')->pluck('id')->toArray();
        }

        return array_intersect(
            $selected_ram,
            $selected_cores,
            $selected_providers,
            $selected_gb5_single,
            $selected_gb5_multi,
            $selected_4k_read_speed,
            $selected_4k_write_speed,
            $selected_4k_total_iops,
            $selected_avg_network
        ); 
    }
}