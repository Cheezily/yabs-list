<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\QueryHelper;

class CountController extends Controller
{
    public function get_options_counts(Request $request)
    {
        // TRY INCLUDING WHERENOTBETWEEN AND ITERATING
        // dd($request->selected_items);
        $selected_items = $request->selected_items;

        $query = DB::table('servers');
        foreach($request->selected_items['selected_ram'] as $index) {
            $query = QueryHelper::ram_where_not($query, intval($index));
        }
        $selected_ram = $query->select('id')->pluck('id')->toArray();


        $query = DB::table('servers');
        foreach($request->selected_items['selected_cores'] as $index) {
            $query = QueryHelper::cores_where_not($query, intval($index));
        }
        $selected_cores = $query->select('id')->pluck('id')->toArray();

        $query = DB::table('servers');
        $query->whereNotIn('provider_name', $request->selected_items['selected_providers']);
        $selected_providers = $query->select('id')->pluck('id')->toArray();

        $query = DB::table('servers');
        foreach($request->selected_items['selected_gb5_single'] as $index) {
            $query = QueryHelper::geekbench_5_single_where_not($query, intval($index));
        }
        $selected_gb5_single = $query->select('id')->pluck('id')->toArray();


        $query = DB::table('servers');
        foreach($request->selected_items['selected_gb5_multi'] as $index) {
            $query = QueryHelper::geekbench_5_multi_where_not($query, intval($index));
        }
        $selected_gb5_multi = $query->select('id')->pluck('id')->toArray();


        $merged_ids = array_intersect(
            $selected_ram,
            $selected_cores,
            $selected_providers,
            $selected_gb5_single,
            $selected_gb5_multi
        );
        

        return response()->json([
            'ram' => QueryHelper::ram_count($merged_ids),
            'cores' => QueryHelper::cores_count($merged_ids),
            'providers' => QueryHelper::provider_names_count($merged_ids),
            'virtualization' => QueryHelper::virtualization_count($request),
            'disk_4k_total_iops' => QueryHelper::disk_4k_total_iops_count($request),
            'disk_4k_read_speed' => QueryHelper::disk_4k_read_speed_count($request),
            'disk_4k_write_speed' => QueryHelper::disk_4k_write_speed_count($request),
            'average_network_speed' => QueryHelper::average_network_speed_count($request),
            'geekbench_5_single' => QueryHelper::geekbench_5_single_count($merged_ids),
            'geekbench_5_multi' => QueryHelper::geekbench_5_multi_count($merged_ids),
        ]);
    }
}
