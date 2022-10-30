<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\QueryHelper;
use App\Helpers\MergedIdsHelper;

class CountController extends Controller
{
    public function get_options_counts(Request $request)
    {
        // $start_time = microtime(true);

        $merged_ids = MergedIdsHelper::getMergedIds($request, $request->user_id);

        // $end_time = microtime(true);
        // $execution_time = ($end_time - $start_time);
        // return(" Execution time of script = ".$execution_time." sec");

        $counts = [
            'ram' => QueryHelper::ram_count($merged_ids),
            'cores' => QueryHelper::cores_count($merged_ids),
            'providers' => QueryHelper::provider_names_count($merged_ids),
            'virtualization' => QueryHelper::virtualization_count($request),
            'disk_4k_total_iops' => QueryHelper::disk_4k_total_iops_count($merged_ids),
            'disk_4k_read_speed' => QueryHelper::disk_4k_read_speed_count($merged_ids),
            'disk_4k_write_speed' => QueryHelper::disk_4k_write_speed_count($merged_ids),
            'average_network_speed' => QueryHelper::average_network_speed_count($merged_ids),
            'geekbench_5_single' => QueryHelper::geekbench_5_single_count($merged_ids),
            'geekbench_5_multi' => QueryHelper::geekbench_5_multi_count($merged_ids),
        ];

        return response($counts);
    }
}
