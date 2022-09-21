<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\QueryHelper;
use Illuminate\Support\Facades\Validator;

class ServerController extends Controller
{
    public function create(Request $request)
    {
        if($request->user() || !DB::table('settings')->anonymous_submissions) {
            $validator = Validator::make($request->all(), [
                'cpu' => 'required|string|max:100',
                'cores' => 'required|integer|max:256',
                'clock_speed' => 'required|integer|max:10000',
                'ram' => 'required|integer',
                'swap' => 'required|integer',
                'gb5_single' => 'required|integer',
                'gb5_multi' => 'required|integer',
                'aes_ni' => 'required|boolean',
                'vm_x' => 'required|boolean',
                'distro' => 'required|string|max:100',
                'kernel' => 'required|string|max:100',
                'read_4k_speed' => 'required|integer',
                'write_4k_speed' => 'required|integer',
                'total_4k_speed' => 'required|integer',
                'read_4k_iops' => 'required|integer',
                'write_4k_iops' => 'required|integer',
                'total_4k_iops' => 'required|integer',
                'read_64k_speed' => 'required|integer',
                'write_64k_speed' => 'required|integer',
                'total_64k_speed' => 'required|integer',
                'read_64k_iops' => 'required|integer',
                'write_64k_iops' => 'required|integer',
                'total_64k_iops' => 'required|integer',
                'read_512k_speed' => 'required|integer',
                'write_512k_speed' => 'required|integer',
                'total_512k_speed' => 'required|integer',
                'read_512k_iops' => 'required|integer',
                'write_512k_iops' => 'required|integer',
                'total_512k_iops' => 'required|integer',
                'read_1m_speed' => 'required|integer',
                'write_1m_speed' => 'required|integer',
                'total_1m_speed' => 'required|integer',
                'read_1m_iops' => 'required|integer',
                'write_1m_iops' => 'required|integer',
                'total_1m_iops' => 'required|integer',
                'network_row_1_provider' => 'sometimes',
                'network_row_1_location' => 'required_with:network_row_1_provider|max:100',
                'network_row_1_send_speed' => 'required_with:network_row_1_provider',
                'network_row_1_rec_speed' => 'required_with:network_row_1_provider',
                'network_row_1_ipv4' => 'required_with:network_row_1_provider|boolean',
                'network_row_2_provider' => 'sometimes',
                'network_row_2_location' => 'required_with:network_row_2_provider|max:100',
                'network_row_2_send_speed' => 'required_with:network_row_2_provider',
                'network_row_2_rec_speed' => 'required_with:network_row_2_provider',
                'network_row_2_ipv4' => 'required_with:network_row_2_provider|boolean',
                'network_row_3_provider' => 'sometimes',
                'network_row_3_location' => 'required_with:network_row_3_provider|max:100',
                'network_row_3_send_speed' => 'required_with:network_row_3_provider',
                'network_row_3_rec_speed' => 'required_with:network_row_3_provider',
                'network_row_3_ipv4' => 'required_with:network_row_3_provider|boolean',
                'network_row_4_provider' => 'sometimes',
                'network_row_4_location' => 'required_with:network_row_4_provider|max:100',
                'network_row_4_send_speed' => 'required_with:network_row_4_provider',
                'network_row_4_rec_speed' => 'required_with:network_row_4_provider',
                'network_row_4_ipv4' => 'required_with:network_row_4_provider|boolean',
                'network_row_5_provider' => 'sometimes',
                'network_row_5_location' => 'required_with:network_row_5_provider|max:100',
                'network_row_5_send_speed' => 'required_with:network_row_5_provider',
                'network_row_5_rec_speed' => 'required_with:network_row_5_provider',
                'network_row_5_ipv4' => 'required_with:network_row_5_provider|boolean',
                'network_row_6_provider' => 'sometimes',
                'network_row_6_location' => 'required_with:network_row_6_provider|max:100',
                'network_row_6_send_speed' => 'required_with:network_row_6_provider',
                'network_row_6_rec_speed' => 'required_with:network_row_6_provider',
                'network_row_6_ipv4' => 'required_with:network_row_6_provider|boolean',
                'network_row_7_provider' => 'sometimes',
                'network_row_7_location' => 'required_with:network_row_7_provider|max:100',
                'network_row_7_send_speed' => 'required_with:network_row_7_provider',
                'network_row_7_rec_speed' => 'required_with:network_row_7_provider',
                'network_row_7_ipv4' => 'required_with:network_row_7_provider|boolean',
                'network_row_8_provider' => 'sometimes',
                'network_row_8_location' => 'required_with:network_row_8_provider|max:100',
                'network_row_8_send_speed' => 'required_with:network_row_8_provider',
                'network_row_8_rec_speed' => 'required_with:network_row_8_provider',
                'network_row_8_ipv4' => 'required_with:network_row_8_provider|boolean',
                'network_row_9_provider' => 'sometimes',
                'network_row_9_location' => 'required_with:network_row_9_provider|max:100',
                'network_row_9_send_speed' => 'required_with:network_row_9_provider',
                'network_row_9_rec_speed' => 'required_with:network_row_9_provider',
                'network_row_9_ipv4' => 'required_with:network_row_9_provider|boolean',
                'network_row_10_provider' => 'sometimes',
                'network_row_10_location' => 'required_with:network_row_10_provider|max:100',
                'network_row_10_send_speed' => 'required_with:network_row_10_provider',
                'network_row_10_rec_speed' => 'required_with:network_row_10_provider',
                'network_row_10_ipv4' => 'required_with:network_row_10_provider|boolean',
                'network_row_11_provider' => 'sometimes',
                'network_row_11_location' => 'required_with:network_row_11_provider|max:100',
                'network_row_11_send_speed' => 'required_with:network_row_11_provider',
                'network_row_11_rec_speed' => 'required_with:network_row_11_provider',
                'network_row_11_ipv4' => 'required_with:network_row_11_provider|boolean',
                'network_row_12_provider' => 'sometimes',
                'network_row_12_location' => 'required_with:network_row_12_provider|max:100',
                'network_row_12_send_speed' => 'required_with:network_row_12_provider',
                'network_row_12_rec_speed' => 'required_with:network_row_12_provider',
                'network_row_12_ipv4' => 'required_with:network_row_12_provider|boolean',
                'network_row_13_provider' => 'sometimes',
                'network_row_13_location' => 'required_with:network_row_13_provider|max:100',
                'network_row_13_send_speed' => 'required_with:network_row_13_provider',
                'network_row_13_rec_speed' => 'required_with:network_row_13_provider',
                'network_row_13_ipv4' => 'required_with:network_row_13_provider|boolean',
                'network_row_14_provider' => 'sometimes',
                'network_row_14_location' => 'required_with:network_row_14_provider|max:100',
                'network_row_14_send_speed' => 'required_with:network_row_14_provider',
                'network_row_14_rec_speed' => 'required_with:network_row_14_provider',
                'network_row_14_ipv4' => 'required_with:network_row_14_provider|boolean',
            ]);

            if($validator->fails()) {
                return response($validator->errors(), 422);
            }



        }

        return response('Please log in to submit your results', 422);
    }
}
