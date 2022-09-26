<?php

namespace App\Http\Controllers;

use App\Helpers\MergedIdsHelper;
use App\Helpers\QueryHelper;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    public function get_results(Request $request)
    {
        $query = Server::with(['user', 'networks'])
            ->orderBy($request->order_by, $request->sort_direction);

        if(!is_null($request->user_id)) {
            $servers = $query->where('user_id', $request->user_id)->get();
        } else {
            $servers = $query->limit($request->limit)
                ->offset(($request->page - 1) * $request->limit)
                ->get();
        }

        return response()->json([
            'servers' => $servers,
            'server_count' => Server::count()
        ]);
    }


    public function update_results(Request $request)
    {
        $merged_ids = [];
        if($request->has('selected_items')) {
            $merged_ids = MergedIdsHelper::getMergedIds($request, $request->user_id);
        }

        $query = Server::distinct();
            if(!empty($merged_ids)) {
                $query->whereIn('id', $merged_ids);
            }
            if(!is_null($request->user_id)) {
                $query->where('user_id', '=', $request->user_id);
            }
            $query->orderBy($request->order_by, $request->sort_direction)
                ->offset($request->limit * ($request->page - 1))
                ->limit($request->limit);

        return response()->json([
            'server_count' => count($merged_ids),
            'servers' => $query->get(),
            'count' => $query->count(),
            'page' => $request->page,
        ]);
    }
}