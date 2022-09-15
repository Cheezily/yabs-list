<?php

namespace App\Http\Controllers;

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
        // dd($request->selected_items);


        $query = DB::table('servers');
        $use_or = false;
        foreach($request->selected_items['selected_ram'] as $index) {
            $query = QueryHelper::ram_where($query, intval($index), $use_or);
            $use_or = true;
        }
        $selected_ram = $query->select('id')->get()->pluck('id')->toArray();


        $query = DB::table('servers');
        $use_or = false;
        foreach($request->selected_items['selected_cores'] as $index) {
            $query = QueryHelper::cores_where($query, intval($index), $use_or);
            $use_or = true;
        }
        $selected_cores = $query->select('id')->get()->pluck('id')->toArray();

        $query = DB::table('servers');
        $query->whereIn('provider_name', $request->selected_items['selected_providers']);
        $selected_providers = $query->select('id')->get()->pluck('id')->toArray();


        $query = DB::table('servers');
        $use_or = false;
        foreach($request->selected_items['selected_gb5_single'] as $index) {
            $query = QueryHelper::geekbench_5_single_where($query, intval($index), $use_or);
            $use_or = true;
        }
        $selected_gb5_single = $query->select('id')->get()->pluck('id')->toArray();


        $query = DB::table('servers');
        $use_or = false;
        foreach($request->selected_items['selected_gb5_multi'] as $index) {
            $query = QueryHelper::geekbench_5_multi_where($query, intval($index), $use_or);
            $use_or = true;
        }
        $selected_gb5_multi = $query->select('id')->get()->pluck('id')->toArray();


        $merged_ids = array_intersect(
            $selected_ram,
            $selected_cores,
            $selected_providers,
            $selected_gb5_single,
            $selected_gb5_multi
        );

        $test = Server::whereIn('id', $merged_ids)
            ->distinct()
            ->orderBy($request->order_by, $request->sort_direction)
            ->limit($request->limit);



        // $test = Server::where(function ($q) use ($request) {
        //     $q->select('id')
        //         ->from('servers');

        //         $use_or = false;
        //         foreach($request->selected_items['selected_cores'] as $index) {
        //             $q = QueryHelper::cores_where($q, intval($index), $use_or);
        //             $use_or = true;
        //         }
        //     })
        //     ->distinct()
        //     ->orderBy($request->order_by, $request->sort_direction)
        //     ->get();


        // $test = Server::where(function ($q) use ($request) {
        //     $q->select('id')
        //         ->from('servers')
        //         ->where('ram', '<', 512);
        //     })
        //     ->distinct()
        //     ->orderBy($request->order_by, $request->sort_direction)
        //     ->get();


        // $query->orderBy($request->order_by, $request->sort_direction);

        // if(!is_null($request->user_id)) {
        //     $query->where('user_id', $request->user_id);
        // }
        
        // $results = $query->limit($request->limit)
        // ->offset(($request->page - 1) * $request->limit)
        // ->get();

        return response()->json([
            // 'cores_results' => $selected_cores,
            // 'selected_ram' => $selected_ram,
            'merged' => $test->get(),
            'count' => $test->count(),
            'server_count' => Server::count()
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