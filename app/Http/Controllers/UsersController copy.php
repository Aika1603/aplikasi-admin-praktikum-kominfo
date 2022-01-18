<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

use App\User;
use Session;

class UsersController extends Controller
{
    private $data = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->data = [
                        'title'     => 'Data Users',
                        'subtitle'  => '',
                        'menu'      => 'users',
                        'submenu'   => 'Data Users',
                        'route'     => 'users',
                        'permis'    => 'user',
                        'icon'      => '',
                        'no'        => 1
                      ];
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request, $sub = "list")
    {
        if($sub == 'edit' || $sub == 'delete'){
            return redirect('users');
        }
        $this->data['subtitle']     = ucfirst($sub);
        $this->data['datatable']    = User::with('roles')->get();
        $this->data['roles']        = Role::where('name', '!=', 'requestor')->get();
        return view('users.index', $this->data);
    }

    public function add_process(Request $request, $id = null)
    {
        $this->validate($request, [
            'name'         => 'required|max:191',
            'phone_number' => 'required|max:20',
            'username'     => 'required|max:191',
            'email'        => 'required|max:191',
            'roles'        => 'required',
            'avatar'       => 'nullable|sometimes|image|mimes:jpeg,png|max:1024',
        ]);

        $validator = Validator::make($request->all(), [
            'username'          =>   ['required', 'string', 'max:191', 'unique:users'],
            'email'             =>   ['required', 'string', 'email', 'max:191', 'unique:users'],
        ]);
        $validator->validate();

        $data = User::create([
            'name'      => $request->input('name'),
            'username'  => $request->input('username'),
            'email'     => $request->input('email'),
            'password'  => Hash::make(config('app.default_pass', '123123123')),
            'is_suspend'=> empty($request->input('is_suspend')) ? '0' : '1',
            'phone_number' => $request->input('phone_number'),
        ]);

        $data->roles()->attach($request->input('roles'));

        // bypass email verified
        $data->email_verified_at = now();

        // upload avatar
        $data->avatar = 'avatar.png';
        if($request->hasFile('avatar')){
            $data->avatar = $this->_uploadAvatar($request, $data);
        }

        $query = $data->save();

        if($query){
            return response()->json([
                    'status' => true,
                    '_token' => csrf_token(),
                    'message' => 'Add user success!',
                    'return_url' => $request->input('submit') == 'submit' ? url('users/add') : url('users')
                ]);
        }else{
            return response()->json([
                    'status' => false,
                    '_token' => csrf_token(),
                    'message' => 'Add user fail!',
                    'return_url' => '#'
                ]);
        }
    }

    public function edit(Request $request, $id = null)
    {
        $this->data['subtitle'] = 'Edit';
        $this->data['user'] = User::where('id', $id)->with('roles')->first();
        $this->data['roles'] = Role::where('name', '!=', 'requestor')->get();
        return view('users.edit', $this->data);
    }

    public function edit_process(Request $request, $id = null)
    {
        $this->validate($request, [
            'name'         => 'required|max:191',
            'phone_number' => 'required|max:20',
            'username'     => 'required|max:191',
            'email'        => 'required|max:191',
            'roles'        => 'required',
            'avatar'       => 'nullable|sometimes|image|mimes:jpeg,png|max:1024',
        ]);

        if($id == null){
            return response()->json([
                    'status' => false,
                    '_token' => csrf_token(),
                    'message' => 'Update user fail. Data not found!',
                    'return_url' => url('users')
                ]);
        }
        /**
         * Uncomment if mimin can change username and email users
         */
            // if($request->input('username') !=  $request->input('old-username') || $request->input('email') !=  $request->input('old-email')):
            //     $validator = Validator::make($request->all(), [
            //         'username'          =>   ['required', 'string', 'max:191', 'unique:users'],
            //         'email'             =>   ['required', 'string', 'email', 'max:191', 'unique:users'],
            //     ]);
            //     $validator->validate();
            // endif;

        $data            = User::where('id', $id)->first();
        $data->name      = $request->input('name');
        // $data->username  = $request->input('username');
        // $data->email     = $request->input('email');
        $data->phone_number = $request->input('phone_number');
        $data->is_suspend = empty($request->input('is_suspend')) ? '0' : '1';

        // reset password
        if(!empty($request->input('is_reset'))){
            $data->password = Hash::make(config('app.default_pass', '123123123'));
		}

        // upload avatar
        if($request->hasFile('avatar')){
            $data->avatar = $this->_uploadAvatar($request, $data);
        }

        // upadate role
        $data->roles()->sync($request->input('roles'));

        $query = $data->save();

        if($query){
            return response()->json([
                    'status' => true,
                    '_token' => csrf_token(),
                    'message' => 'Update user success!',
                    'return_url' => $request->input('submit') == 'submit' ? '#edit' : url('users')
                ]);
        }else{
            return response()->json([
                    'status' => false,
                    '_token' => csrf_token(),
                    'message' => 'Update user fail!',
                    'return_url' => '#'
                ]);
        }
    }

    public function delete($id = null)
    {
        $query = User::where('id', $id)->delete();

        if($query){
            return response()->json([
                    'status' => true,
                    '_token' => csrf_token(),
                    'message' => 'Delete user success!',
                    'return_url' => url('users')
                ]);
        }else{
            return response()->json([
                    'status' => false,
                    '_token' => csrf_token(),
                    'message' => 'Delete user fail!',
                    'return_url' => '#'
                ]);
        }
    }

    private function _uploadAvatar(Request $request, $data = null)
    {
        if($data == null){
            return 'avatar.png';
        }
        $name = str_replace(' ', '-', $data->username);
        $imageName = $data->id . "_" . $name . Str::random(10);

        $original_filename = $request->file('avatar')->getClientOriginalName();
        $original_filename_arr = explode('.', $original_filename);
        $file_ext = end($original_filename_arr);
        $destination_path = './assets/avatar';
        $imageName = $imageName . '.' . $file_ext;

        $request->file('avatar')->move($destination_path, $imageName);

        //resize image here

        return $imageName;
    }
}
