<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\User;
use Session;

class AccountController extends Controller
{
    private $data = [];

    public function __construct()
    {
        $this->data = [
                        'title'             => 'Your Account',
                        'subtitle'          => '',
                        'menu'              => 'Your Account',
                        'link_menu'         => '',
                        'icon_menu'         => 'icon-user',
                        'submenu'           => '',
                        'link_submenu'      => '',
                        'icon_submenu'      => '',
                        'subsubmenu'        => '',
                        'icon_subsubmenu'   => '',
                        'route'             => 'account',
                        'permission'        => 'account',
                        'icon_primary'      => '',
                        'no'                => 1
                      ];
    }

    public function show(Request $request)
    {
        $this->data['user'] = User::find(Auth::user()->id);
        return view('account.show', $this->data);
    }

    public function update_process(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required|max:191',
            'phone_number' => 'required|max:20',
            'username'     => 'required|max:191',
            'email'        => 'required|max:191',
        ]);

        if($request->input('username') !=  $request->input('old-username') || $request->input('email') !=  $request->input('old-email')):
            $validator = Validator::make($request->all(), [
                'username'          =>   ['required', 'string', 'max:191', 'unique:users'],
                'email'             =>   ['required', 'string', 'email', 'max:191', 'unique:users'],
            ]);
            $validator->validate();
        endif;

        $data           = User::where('id', Auth::user()->id )->first();
        $data->name      = $request->input('name');
        $data->username  = $request->input('username');
        $data->email     = $request->input('email');
        $data->phone_number = $request->input('phone_number');
        $query          = $data->save();

        if($query){
            return response()->json([
                    'status' => true,
                    '_token' => csrf_token(),
                    'message' => 'Update profile success!',
                    'return_url' => url('account')
                ]);
        }else{
            return response()->json([
                    'status' => false,
                    '_token' => csrf_token(),
                    'message' => 'Update profile fail!',
                    'return_url' => '#'
                ]);
        }
    }

    public function update_fcm(Request $request)
    {
        $data           = User::where('id', Auth::user()->id )->first();
        $data->fcm      = $request->input('fcm');
        $query          = $data->save();

        if($query){
            $response = Http::withHeaders([
                'Authorization' => 'key=',
            ])->post('https://iid.googleapis.com/iid/v1/'.$request->input('fcm').'/rel/topics/admin');

            return response()->json([
                    'status' => true,
                    '_token' => csrf_token(),
                    'message' => 'push fcm success!',
                    'return_url' => '#'
                ]);
        }else{
            return response()->json([
                    'status' => false,
                    '_token' => csrf_token(),
                    'message' => 'fail!',
                    'return_url' => '#'
                ]);
        }
    }

    public function change_password_process(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:8',
        ]);

        $user  = User::where('id', Auth::user()->id )->first();

        if (Hash::check($request->old_password, $user->password)) {
            $user->fill(['password' => Hash::make($request->password)])->save();
            return response()->json([
                    'status' => true,
                    '_token' => csrf_token(),
                    'message' => 'Password changed!',
                    'return_url' => url('account')
                ]);
        } else {
            return response()->json([
                    'status' => false,
                    '_token' => csrf_token(),
                    'message' => 'Old password is wrong',
                    'return_url' => '#'
                ]);
        }
    }

    public function change_avatar_process(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'nullable|sometimes|image|mimes:jpeg,png|max:1024',
        ]);

        $user  = User::where('id', Auth::user()->id)->first();

        if($request->hasFile('avatar')){
            $name = str_replace(' ', '-', $user->username);
            $imageName = $user->id . "_" . $name . Str::random(10);

            $original_filename = $request->file('avatar')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './assets/avatar';
            $imageName = $imageName . '.' . $file_ext;

            $request->file('avatar')->move($destination_path, $imageName);
            $user->avatar = $imageName;

            //resize image here
        }

        $query = $user->save();
        if($query){
            return response()->json([
                    'status' => true,
                    '_token' => csrf_token(),
                    'message' => 'Update avatar success!',
                    'return_url' => url('account')
                ]);
        }else{
            return response()->json([
                    'status' => false,
                    '_token' => csrf_token(),
                    'message' => 'Update avatar fail!',
                    'return_url' => '#'
                ]);
        }
    }
}
