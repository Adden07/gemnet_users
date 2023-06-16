<?php

namespace App\Http\Controllers\Administrator;

use App\Helpers\CommonHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\ActivityLog;
use App\Models\FranchisePackage;
use App\Models\Payment;
use App\Models\User;
use App\Models\LoginFailLog;
use DataTables;
use App\Models\UserRolePermission;

class ProfileController extends Controller
{
    public function index(Request $req){
        
        $data = array(
            'title'                 => 'Profile',
            'user_details'          => User::findOrFail(auth()->id()),
        );
        
        return view('admin.profile.index')->with($data);
    }

    public function updatePassword(Request $req){
        
        $rules = [
            'password'  => ['required', 'min:6', 'confirmed']
        ];

        $validator = Validator::make($req->all(),$rules);

        if($validator->fails()){
            return ['errors'    => $validator->errors()];
        }

        $validated = $validator->validated();

        Admin::where('id',auth()->user()->id)->update([
            'password'  => Hash::make($validated['password'])
        ]);

        return response()->json([
            'success'   => 'Password Updated Successfully',
            'reload'    => TRUE
        ]);
    }

    //disable user like admin,and whole franchise network
    public function disableUser($id){
        if(isset($id) && !empty($id)){
            
            $user_type = auth()->user()->user_type;
            $status    = 'disabled';
            
            if($user_type == 'superadmin'){
                $status = 'disabled';
            }elseif($user_type == 'admin'){
                $status = 'disabled_by_admin';
            }
            $user = Admin::findOrFail(hashids_decode($id));
            $user->is_active = $status;
            $user->save();

            return response()->json([
                'success'   => 'User Disabled Successfully',
                'reload'    => TRUE
            ]);
        }
        abort(404);
    }

    public function EnableUser($id){
        if(isset($id) && !empty($id)){
            $user = Admin::findOrFail(hashids_decode($id));
            $user->is_active = 'active';
            $user->save();

            return response()->json([
                'success'  => 'User Enabled Successfully',
                'reload'    => TRUE
            ]); 
        }
    }

        //update credit limit
    public function updateCreditLimit(Request $req){
        
        // if(\CommonHelpers::rights('enabled-franchise','view-franchise')){
        //     return redirect()->route('admin.home');
        // }
        if(isset($req->user_id) && !empty($req->user_id)){
            $rules = [
                'credit_limit'      => ['required', 'numeric', 'integer', 'digits_between:1,7'],
            ];
        
            $validator = Validator::make($req->all(),$rules);

            if($validator->fails()){
                return ['errors'    => $validator->errors()];
            }
                            
            $admin       = Admin::findOrFail(hashids_decode($req->user_id));
            $activity   = 'updated-credit-limit';
        
            $admin->credit_limit = $req->credit_limit;
            $admin->save();

            CommonHelpers::activity_logs($activity);

            return response()->json([
                'success'   => 'Credit Limit Updated Successfully',
                // 'redirect'    => route('admin.franchises.list'),
                'reload'     => TRUE
            ]);
        }
        abort(404);
    }


    public function setPermissionLimit($id, $limit){//set the frnachise network permissions to limited
        if($limit == 0 || $limit == 1){
            $user = Admin::findOrFail(hashids_decode($id));
            $role = UserRolePermission::when($limit == 0, function($query) use ($user){
                $query->where('role_name', $user->user_type);//if limit is 0 then get the get the permissiona according to the user type
            }, function($query) use ($user){//if limit is 1 then get the limtied permission 
                $query->where('role_name', 'limited');
            })->firstOrFail();
            
            $user->limited = $limit;
            $user->user_permissions = $role->permissions;
            $user->save();

            return response()->json([
                'success'   => 'User limit has been updated successfully',
                'reload'    => true
            ]);
        }
        abort(404);
    }
}
