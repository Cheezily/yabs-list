<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\ServerQueryHelper;

class ServerController extends Controller
{
    public function get_options_counts(Request $request)
    {
        return response()->json([
            'ram' => ServerQueryHelper::ram_count($request),
            'cores' => ServerQueryHelper::cores_count($request),
            'providers' => ServerQueryHelper::provider_names_count($request),
            'virtualization' => ServerQueryHelper::virtualization_count($request),
            'disk_4k_options' => ServerQueryHelper::disk_4k_iops_count($request),
            'disk_4k_speed' => ServerQueryHelper::disk_4k_speed_count($request),
            'average_network_speed' => ServerQueryHelper::average_network_speed_count($request),
            'geekbench_5_single' => ServerQueryHelper::geekbench_5_single_count($request),
            'geekbench_5_multi' => ServerQueryHelper::geekbench_5_multi_count($request),
        ]);
    }
}
