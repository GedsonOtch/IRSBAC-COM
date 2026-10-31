<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SecuritySetting;
use Illuminate\Support\Facades\Artisan;
class SecuritySettingController extends Controller
{
    //


 public function update(Request $request)
{
    $setting = SecuritySetting::updateOrCreate(
        ['id' => 1],
        [
            'session_timeout' => $request->session_timeout,

            'maintenance_mode' =>
                $request->has('maintenance_mode'),

            'audit_log' =>
                $request->has('audit_log'),
        ]
    );



    return back()->with(
        'success',
        'Paramètres enregistrés avec succès.'
    );
}
}
