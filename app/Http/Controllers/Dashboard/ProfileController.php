<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{

    public function editProfile()
    {
        $id = auth('admin')->user()->id;
        $admin = Admin::find($id);

        return view('dashboard.profile.edit', compact('admin'));
    }

    public function updateProfile(AdminProfileRequest $request)
    {
        $id = auth('admin')->user()->id;
        $admin = Admin::find($id);

        if ($request->filled('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        }
        $returnValue=$admin->update($request->only(['name', 'email', 'password']));
        if($returnValue){
//            unset($admin['password']);
//            return response()->json(['success'=>__('updated successfully'),'data'=>$admin],200);
            return redirect()->back()->with(['success' => __('updated successfully')]);
        }
        return redirect()->back()->with(['error'=>__('there is something error,please try again later')]);
    }
}
