<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\QueryHelper;

class ServerController extends Controller
{
    public function get_options_counts(Request $request)
    {

        // dd($request->where_in);
        return response()->json([
            'ram' => QueryHelper::ram_count($request),
            'cores' => QueryHelper::cores_count($request),
            'providers' => QueryHelper::provider_names_count($request),
            'virtualization' => QueryHelper::virtualization_count($request),
            'disk_4k_total_iops' => QueryHelper::disk_4k_total_iops_count($request),
            'disk_4k_read_speed' => QueryHelper::disk_4k_read_speed_count($request),
            'disk_4k_write_speed' => QueryHelper::disk_4k_write_speed_count($request),
            'average_network_speed' => QueryHelper::average_network_speed_count($request),
            'geekbench_5_single' => QueryHelper::geekbench_5_single_count($request),
            'geekbench_5_multi' => QueryHelper::geekbench_5_multi_count($request),
        ]);
    }
}
