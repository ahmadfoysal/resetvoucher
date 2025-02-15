<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Mikrotik;
use Illuminate\Http\Request;
use App\Services\RouterOSAPI as RouterOSAPI;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class VoucherController extends Controller
{
    public function resetVoucherForm()
    {
        if (auth()->user()->hasRole('admin')) {
            $mikrotiks = Mikrotik::all();
        } else {
            $mikrotiks = auth()->user()->mikrotiks;
        }

        return view('reset-vouchers.index', compact('mikrotiks'));
    }

    public function resetVoucher(Request $request, RouterOSAPI $api)
    {
        $data = $request->validate([
            'mikrotik_id' => 'required',
            'voucher_code' => 'required',
        ]);

        $mikrotik = Mikrotik::find($data['mikrotik_id']);

        // dd($mikrotik);

        // $api = new RouterOSAPI();

        $connection = $api->connect($mikrotik->ip . ':' . $mikrotik->port, $mikrotik->username, $mikrotik->password);


        // dd($connection);

        if ($connection) {
            $message = [
                'success' => [],
                'error' => []
            ];

            // Remove Active Users
            $result = $api->comm('/ip/hotspot/active/print', ["?user" => trim($data['voucher_code'])]);

            if (!empty($result) && isset($result[0]['.id'])) {
                $api->comm('/ip/hotspot/active/remove', [".id" => $result[0]['.id']]);
                $message['success'][] = 'Voucher code ' . $data['voucher_code'] . ' removed from active users';
            } else {
                $message['error'][] = 'Voucher code ' . $data['voucher_code'] . ' not found in active users';
            }

            // Set MAC Address to Null
            $secret = $api->comm('/ip/hotspot/user/print', ["?name" => trim($data['voucher_code'])]);

            if (!empty($secret) && isset($secret[0]['.id'])) {
                $api->comm('/ip/hotspot/user/set', [".id" => $secret[0]['.id'], "mac-address" => "00:00:00:00:00:00"]);
                $message['success'][] = 'Voucher code ' . $data['voucher_code'] . ' MAC address reset';
            } else {
                $message['error'][] = 'Voucher code ' . $data['voucher_code'] . ' not found';
            }

            // Remove Hotspot Cookies
            $cookieResult = $api->comm('/ip/hotspot/cookie/print', ["?user" => trim($data['voucher_code'])]);

            if (!empty($cookieResult)) {
                foreach ($cookieResult as $cookie) {
                    if (isset($cookie['.id'])) {
                        $api->comm('/ip/hotspot/cookie/remove', [".id" => $cookie['.id']]);
                    }
                }
                $message['success'][] = 'Voucher code ' . $data['voucher_code'] . ' cookies removed';
            } else {
                $message['error'][] = 'Voucher code ' . $data['voucher_code'] . ' cookies not found';
            }

            $api->disconnect();

            //Add to log

            Log::create([
                'mikrotik_id' => $mikrotik->id,
                'action' => 'Voucher code ' . $data['voucher_code'] . ' reset',
                'user_id' => auth()->id()
            ]);

            return back()->with([
                'success_messages' => $message['success'],
                'error_messages' => $message['error']
            ]);
        } else {
            return back()->with('error', 'Failed to connect to the Mikrotik device');
        }
    }

    public function toggleVoucher(Request $request, RouterOSAPI $api)
    {
        $data = $request->validate([
            'mikrotik_id' => 'required',
            'voucher_code' => 'required',
        ]);

        $mikrotik = Mikrotik::find($data['mikrotik_id']);
        $connection = $api->connect($mikrotik->ip . ':' . $mikrotik->port, $mikrotik->username, $mikrotik->password);

        if ($connection) {
            $secret = $api->comm('/ip/hotspot/user/print', ["?name" => trim($data['voucher_code'])]);

            if (!empty($secret) && isset($secret[0]['.id'])) {
                $currentDisabled = isset($secret[0]['disabled']) && $secret[0]['disabled'] == "true";

                // Toggle the disabled status
                $api->comm('/ip/hotspot/user/set', [
                    ".id" => $secret[0]['.id'],
                    "disabled" => $currentDisabled ? "no" : "yes"
                ]);

                $status = $currentDisabled ? 'enabled' : 'disabled';
                return back()->with('success', 'Voucher ' . $data['voucher_code'] . ' has been ' . $status . ' successfully.');
            } else {
                return back()->with('error', 'Voucher code ' . $data['voucher_code'] . ' not found.');
            }
        } else {
            return back()->with('error', 'Failed to connect to the Mikrotik device');
        }
    }
}
