<?php

namespace App\Http\Controllers;

use App\Helpers\MergedIdsHelper;
use App\Helpers\QueryHelper;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    public function results(Request $request)
    {
        $query = Server::with(['user', 'networks']);

        $query->orderBy($request->order_by, $request->sort_direction);

        if(!is_null($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }
        
        $results = $query->limit($request->limit)
        ->offset(($request->page - 1) * $request->limit)
        ->get();

        return response()->json([
            'results' => $results,
            'server_count' => Server::count()
        ]);
        
    }


    public function update_results(Request $request)
    {
        $merged_ids = [];
        if($request->has('selected_items')) {
            $merged_ids = MergedIdsHelper::getMergedIds($request);
        }

        $test = Server::distinct();
            if(!empty($merged_ids)) {
                $test->whereIn('id', $merged_ids);
            }
            $test->orderBy($request->order_by, $request->sort_direction)
                ->offset($request->limit * ($request->page - 1))
                ->limit($request->limit);

        return response()->json([
            'server_count' => count($merged_ids),
            'merged' => $test->get(),
            'count' => $test->count(),
            'page' => $request->page,
        ]);
    }
}

        // $query = DB::table('servers')
        // ->join('networks', 'networks.server_id', '=', 'servers.id')
        // ->join('users', 'servers.user_id', '=', 'users.id')
        // ->select([
        //     'servers.id',
        //     'servers.provider_name',
        //     'servers.type',
        //     'servers.when',
        //     'servers.city',
        //     'servers.cpu',
        //     'servers.cores',
        //     'servers.clock_speed',
        //     'servers.ram',
        //     'servers.swap',
        //     'servers.distro',
        //     'servers.kernel',
        //     'servers.aes_ni',
        //     'servers.vm_x',
        //     'servers.disk_4k_read_speed',
        //     'servers.disk_4k_read_iops',
        //     'servers.disk_4k_write_speed',
        //     'servers.disk_4k_write_iops',
        //     'servers.disk_4k_total_speed',
        //     'servers.disk_4k_total_iops',
        //     'servers.disk_64k_read_speed',
        //     'servers.disk_64k_read_iops',
        //     'servers.disk_64k_write_speed',
        //     'servers.disk_64k_write_iops',
        //     'servers.disk_64k_total_speed',
        //     'servers.disk_64k_total_iops',
        //     'servers.disk_512k_read_speed',
        //     'servers.disk_512k_read_iops',
        //     'servers.disk_512k_write_speed',
        //     'servers.disk_512k_write_iops',
        //     'servers.disk_512k_total_speed',
        //     'servers.disk_512k_total_iops',
        //     'servers.disk_1m_read_speed',
        //     'servers.disk_1m_read_iops',
        //     'servers.disk_1m_write_speed',
        //     'servers.disk_1m_write_iops',
        //     'servers.disk_1m_total_speed',
        //     'servers.disk_1m_total_iops',
        //     'servers.geekbench_5_single',
        //     'servers.geekbench_5_multi',
        //     'servers.virtualization',
        //     'servers.note',
        //     'servers.created_at',
        //     'servers.average_network_speed',
        // ]);