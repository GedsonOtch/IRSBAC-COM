<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Infoirsbac;
use App\Models\SecuritySetting;
use App\Models\SignatureCachet;
class ParametreAdmincontroller extends Controller
{
    //


    public function index()
{
    $admins = Admin::all();
    $security = SecuritySetting::first();
  $elements = SignatureCachet::latest()->get();
  $info = Infoirsbac::first();
    return view('admin.parametreadmin', compact('admins', 'security', 'elements','info'));
}



public function update(Request $request, Admin $admin)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email,' . $admin->id,
        'role' => 'required|string'
    ]);

    $admin->update([
        'name'   => $request->name,
        'email' => $request->email,
        'role'  => $request->role,
    ]);

    return back()->with(
        'success',
        'Administrateur modifié avec succès.'
    );
}


public function destroy(Admin $admin)
{
    $admin->delete();

    return back()->with(
        'success',
        'Administrateur supprimé avec succès.'
    );
}

}
