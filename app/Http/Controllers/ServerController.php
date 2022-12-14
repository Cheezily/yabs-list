<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Helpers\SettingsHelper;
use App\Models\Network;
use App\Rules\NetworkDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServerController extends Controller
{
    public function create(Request $request)
    {
        if($request->user() || SettingsHelper::allow_anonymous_submissions() == 1) {

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
                'provider_name' => 'required|string',
                'when' => 'required|date',
                'city' => 'nullable',
                'type' => 'nullable',
                'virtualization' => 'nullable|in:'.SettingsHelper::virt_types(),
                'note' => 'nullable|string|max:255',
                'cpu' => 'required|string|max:100',
                'cores' => 'required|integer|max:256',
                'clock_speed' => 'required|integer|max:10000',
                'ram' => 'required|integer|min:1',
                'swap' => 'required|integer',
                'geekbench_5_single' => 'required|integer|min:10',
                'geekbench_5_multi' => 'required|integer|min:10',
                'aes_ni' => 'required|boolean',
                'vm_x' => 'required|boolean',
                'distro' => 'nullable|string|max:100',
                'kernel' => 'nullable|string|max:100',
                'disk_4k_read_speed' => 'required|integer',
                'disk_4k_write_speed' => 'required|integer',
                'disk_4k_total_speed' => 'required|integer',
                'disk_4k_read_iops' => 'required|integer',
                'disk_4k_write_iops' => 'required|integer',
                'disk_4k_total_iops' => 'required|integer',
                'disk_64k_read_speed' => 'required|integer',
                'disk_64k_write_speed' => 'required|integer',
                'disk_64k_total_speed' => 'required|integer',
                'disk_64k_read_iops' => 'required|integer',
                'disk_64k_write_iops' => 'required|integer',
                'disk_64k_total_iops' => 'required|integer',
                'disk_512k_read_speed' => 'required|integer',
                'disk_512k_write_speed' => 'required|integer',
                'disk_512k_total_speed' => 'required|integer',
                'disk_512k_read_iops' => 'required|integer',
                'disk_512k_write_iops' => 'required|integer',
                'disk_512k_total_iops' => 'required|integer',
                'disk_1m_read_speed' => 'required|integer',
                'disk_1m_write_speed' => 'required|integer',
                'disk_1m_total_speed' => 'required|integer',
                'disk_1m_read_iops' => 'required|integer',
                'disk_1m_write_iops' => 'required|integer',
                'disk_1m_total_iops' => 'required|integer',
            ], $network_messages);

            for($i = 1; $i <= 14; $i++) {
                $validator->sometimes('network_row_' . $i . '_provider', 'required|max:100', function ($input) use ($i) {
                    if(!is_null($input->get('network_row_' . $i . '_provider'))
                    && (is_null($input->get('network_row_' . $i . '_location'))
                    || is_null($input->get('network_row_' . $i . '_send_speed'))
                    || is_null($input->get('network_row_' . $i . '_rec_speed')))) {
                        return true;
                    };
                });
                $validator->sometimes('network_row_' . $i . '_location', 'required|max:100', function ($input) use ($i) {
                    if(!is_null($input->get('network_row_' . $i . '_location'))
                    && (is_null($input->get('network_row_' . $i . '_provider'))
                    || is_null($input->get('network_row_' . $i . '_send_speed'))
                    || is_null($input->get('network_row_' . $i . '_rec_speed')))) {
                        return true;
                    };
                });
                $validator->sometimes('network_row_' . $i . '_send_speed', 'required|integer', function ($input) use ($i) {
                    if(!is_null($input->get('network_row_' . $i . '_send_speed'))
                    && (is_null($input->get('network_row_' . $i . '_provider'))
                    || is_null($input->get('network_row_' . $i . '_location'))
                    || is_null($input->get('network_row_' . $i . '_rec_speed')))) {
                        return true;
                    };
                });
                $validator->sometimes('network_row_' . $i . '_rec_speed', 'required|integer', function ($input) use ($i) {
                    if(!is_null($input->get('network_row_' . $i . '_rec_speed'))
                    && (is_null($input->get('network_row_' . $i . '_provider'))
                    || is_null($input->get('network_row_' . $i . '_location'))
                    || is_null($input->get('network_row_' . $i . '_send_speed')))) {
                        return true;
                    };
                });
            }

            if($validator->fails()) {
                return response($validator->errors(), 422);
            }

            if(Server::check_for_duplicates($validator->valid())) {
                $validator->errors()->add('flash', 'This server is already on file');
                return response($validator->errors(), 422);
            }

            $network_speeds = [];
            for($i = 1; $i <= 14; $i++) {
                if(!empty($validator->valid()['network_row_' . $i . '_send_speed'])
                && $validator->valid()['network_row_' . $i . '_send_speed'] > 0) {
                    array_push($network_speeds, $validator->valid()['network_row_' . $i . '_send_speed']);
                }
                if(!empty($validator->valid()['network_row_' . $i . '_rec_speed'])
                && $validator->valid()['network_row_' . $i . '_rec_speed'] > 0) {
                    array_push($network_speeds, $validator->valid()['network_row_' . $i . '_rec_speed']);
                }
            }
            $average_network_speed = floor(array_sum($network_speeds) / count($network_speeds));

            $server = new Server();
            $server->user_id = Auth::check() ? Auth::user()->id : null;
            $server->provider_name = trim($validator->valid()['provider_name']);
            $server->when = date_format(date_create($validator->valid()['when']),"Y-m-d H:i:s");
            $server->city = ucfirst(trim($validator->valid()['city']));
            $server->type = $validator->valid()['type'];
            $server->virtualization = $validator->valid()['virtualization'];
            $server->note = $validator->valid()['note'];
            $server->cpu = $validator->valid()['cpu'];
            $server->cores = $validator->valid()['cores'];
            $server->clock_speed = $validator->valid()['clock_speed'];
            $server->ram = $validator->valid()['ram'];
            $server->swap = $validator->valid()['swap'];
            $server->geekbench_5_single = $validator->valid()['geekbench_5_single'];
            $server->geekbench_5_multi = $validator->valid()['geekbench_5_multi'];
            $server->aes_ni = $validator->valid()['aes_ni'];
            $server->vm_x = $validator->valid()['vm_x'];
            $server->distro = trim($validator->valid()['distro']);
            $server->kernel = trim($validator->valid()['kernel']);
            $server->disk_4k_read_speed = $validator->valid()['disk_4k_read_speed'];
            $server->disk_4k_write_speed = $validator->valid()['disk_4k_write_speed'];
            $server->disk_4k_total_speed = $validator->valid()['disk_4k_total_speed'];
            $server->disk_4k_read_iops = $validator->valid()['disk_4k_read_iops'];
            $server->disk_4k_write_iops = $validator->valid()['disk_4k_write_iops'];
            $server->disk_4k_total_iops = $validator->valid()['disk_4k_total_iops'];
            $server->disk_64k_read_speed = $validator->valid()['disk_64k_read_speed'];
            $server->disk_64k_write_speed = $validator->valid()['disk_64k_write_speed'];
            $server->disk_64k_total_speed = $validator->valid()['disk_64k_total_speed'];
            $server->disk_64k_read_iops = $validator->valid()['disk_64k_read_iops'];
            $server->disk_64k_write_iops = $validator->valid()['disk_64k_write_iops'];
            $server->disk_64k_total_iops = $validator->valid()['disk_64k_total_iops'];
            $server->disk_512k_read_speed = $validator->valid()['disk_512k_read_speed'];
            $server->disk_512k_write_speed = $validator->valid()['disk_512k_write_speed'];
            $server->disk_512k_total_speed = $validator->valid()['disk_512k_total_speed'];
            $server->disk_512k_read_iops = $validator->valid()['disk_512k_read_iops'];
            $server->disk_512k_write_iops = $validator->valid()['disk_512k_write_iops'];
            $server->disk_512k_total_iops = $validator->valid()['disk_512k_total_iops'];
            $server->disk_1m_read_speed = $validator->valid()['disk_1m_read_speed'];
            $server->disk_1m_write_speed = $validator->valid()['disk_1m_write_speed'];
            $server->disk_1m_total_speed = $validator->valid()['disk_1m_total_speed'];
            $server->disk_1m_read_iops = $validator->valid()['disk_1m_read_iops'];
            $server->disk_1m_write_iops = $validator->valid()['disk_1m_write_iops'];
            $server->disk_1m_total_iops = $validator->valid()['disk_1m_total_iops'];
            $server->average_network_speed = $average_network_speed;

            $server->save();
            

            for($i = 1; $i <= 14; $i++) {
                if(!empty($validator->valid()['network_row_' . $i . '_provider'])) {
                    Network::create([
                        'server_id' => $server->id,
                        'provider' => trim($validator->valid()['network_row_' . $i . '_provider']),
                        'ipv4' => $validator->valid()['network_row_' . $i . '_ipv4'],
                        'location' => trim($validator->valid()['network_row_' . $i . '_location']),
                        'send_speed' => $validator->valid()['network_row_' . $i . '_send_speed'],
                        'receive_speed' => $validator->valid()['network_row_' . $i . '_rec_speed']
                    ]);
                }
            }

            return response('Benchmark submitted successfully. Thanks!', 200);
        }

        return response('Please log in to submit your results', 422);
    }


    public function delete(Request $request)
    {
        $server = Server::where('user_id', Auth::user()->id)->where('id', $request->id)->first();

        if(!is_null($server)) {
            $server->delete();
            return response('Benchmark Deleted', 200);
        }

        return response('Error deleting benchmark. Please refresh the page and try again' ,422);
    }
}
