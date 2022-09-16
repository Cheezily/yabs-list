<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MergedIdsHelper {
    public static function getMergedIds(Request $request)
    {
        $query = DB::table('servers');
        foreach($request->selected_items['selected_ram'] as $index) {
            $query = QueryHelper::ram_where_not($query, intval($index));
        }
        $selected_ram = $query->select('id')->get()->pluck('id')->toArray();


        $query = DB::table('servers');
        foreach($request->selected_items['selected_cores'] as $index) {
            $query = QueryHelper::cores_where_not($query, intval($index));
        }
        $selected_cores = $query->select('id')->get()->pluck('id')->toArray();

        $query = DB::table('servers');
        $query->whereNotIn('provider_name', $request->selected_items['selected_providers']);
        $selected_providers = $query->select('id')->get()->pluck('id')->toArray();

        $query = DB::table('servers');
        foreach($request->selected_items['selected_gb5_single'] as $index) {
            $query = QueryHelper::geekbench_5_single_where_not($query, intval($index));
        }
        $selected_gb5_single = $query->select('id')->get()->pluck('id')->toArray();


        $query = DB::table('servers');
        foreach($request->selected_items['selected_gb5_multi'] as $index) {
            $query = QueryHelper::geekbench_5_multi_where_not($query, intval($index));
        }
        $selected_gb5_multi = $query->select('id')->get()->pluck('id')->toArray();


        return array_intersect(
            $selected_ram,
            $selected_cores,
            $selected_providers,
            $selected_gb5_single,
            $selected_gb5_multi
        );
    }
}