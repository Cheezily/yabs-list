<?php

namespace App\Http\Controllers;

use Auth;
use App\Rules\NetworkDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\QueryHelper;
use Illuminate\Support\Facades\Validator;

class ServerController extends Controller
{
    public function create(Request $request)
    {
        if($request->user() || DB::table('settings')->first()->anonymous_submissions == 1) {

            $network_messages = [];
            for($i = 1; $i <= 14; $i++) {

                $network_messages += ['network_row_' . $i . '_provider.required' => 'If one field is populated, all must be'];
                $network_messages += ['network_row_' . $i . '_location.required' => 'If one field is populated, all must be'];
                
                $network_messages += ['network_row_' . $i . '_send_speed.integer' => 'Integer Required in bits/s'];
                $network_messages += ['network_row_' . $i . '_send_speed.required' => 'If one field is populated, all must be'];
                
                $network_messages += ['network_row_' . $i . '_rec_speed.integer' => 'Integer Required in bits/s'];
                $network_messages += ['network_row_' . $i . '_rec_speed.required' => 'If one field is populated, all must be'];
            }


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
            ], $network_messages);

            for($i = 1; $i <= 14; $i++) {
                $validator->sometimes('network_row_' . $i . '_provider', 'required|max:100', function ($input) use ($i) {
                    if(!is_null($input->get('network_row_' . $i . '_location'))
                    || !is_null($input->get('network_row_' . $i . '_send_speed'))
                    || !is_null($input->get('network_row_' . $i . '_rec_speed'))) {
                        return true;
                    };
                });
                $validator->sometimes('network_row_' . $i . '_location', 'required|max:100', function ($input) use ($i) {
                    if(!is_null($input->get('network_row_' . $i . '_provider'))
                    || !is_null($input->get('network_row_' . $i . '_send_speed'))
                    || !is_null($input->get('network_row_' . $i . '_rec_speed'))) {
                        return true;
                    };
                });
                $validator->sometimes('network_row_' . $i . '_send_speed', 'required|integer', function ($input) use ($i) {
                    if(!is_null($input->get('network_row_' . $i . '_provider'))
                    || !is_null($input->get('network_row_' . $i . '_location'))
                    || !is_null($input->get('network_row_' . $i . '_rec_speed'))) {
                        return true;
                    };
                });
                $validator->sometimes('network_row_' . $i . '_rec_speed', 'required|integer', function ($input) use ($i) {
                    if(!is_null($input->get('network_row_' . $i . '_provider'))
                    || !is_null($input->get('network_row_' . $i . '_location'))
                    || !is_null($input->get('network_row_' . $i . '_send_speed'))) {
                        return true;
                    };
                });
            }


            

            if($validator->fails()) {
                return response($validator->errors(), 422);
            }
        }

        return response('Please log in to submit your results', 422);
    }
}
