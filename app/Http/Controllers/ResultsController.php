<?php

namespace App\Http\Controllers;

use App\Helpers\MergedIdsHelper;
use App\Models\Server;
use Illuminate\Http\Request;


class ResultsController extends Controller
{
    public function get_results(Request $request)
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