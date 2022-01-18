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
                        'title'             => 'Users List',
                        'subtitle'          => '',
                        'menu'              => 'Users Management',
                        'link_menu'         => '',
                        'icon_menu'         => 'icon-users',
                        'submenu'           => 'Users List',
                        'link_submenu'      => '',
                        'icon_submenu'      => '',
                        'subsubmenu'        => '',
                        'icon_subsubmenu'   => '',
                        'route'             => 'users',
                        'permission'        => 'user',
                        'icon-primary'      => '',
                        'no'                => 1
                      ];
        $this->middleware("permission:".$this->data['permission']."-list", ['only' => ['index']]);
        $this->middleware("permission:".$this->data['permission']."-create", ['only' => ['create','store']]);
        $this->middleware("permission:".$this->data['permission']."-edit", ['only' => ['edit','update']]);
        $this->middleware("permission:".$this->data['permission']."-delete", ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data['datatable']  = User::get();
        return view($this->data['route'].'.index', $this->data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['subtitle'] = 'Create Data';
        $this->data['roles']    = Role::pluck('name','name')->all();
        return view('components.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required',
            'email'        => 'required|email|unique:users,email',
            'roles'        => 'required',
            'username'     => 'required|username|unique:users,username',
            'avatar'       => 'nullable|sometimes|image|mimes:jpeg,png|max:1024',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make(config('app.default_pass', '123123123'));
        $input['is_suspend'] = empty($request->input('is_suspend')) ? '0' : '1';
        $input['email_verified_at'] = now();
        
        // upload avatar
        $input['avatar'] = 'avatar.png';
        if($request->hasFile('avatar')){
            $input['avatar'] = $this->_uploadAvatar($request, $data);
        }

        $query = User::create($input);
        $query->assignRole($request->input('roles'));

        if($query){
            return response()->json([
                    'status' => true,
                    '_token' => csrf_token(),
                    'message' => 'Add data success!',
                    'return_url' => $request->input('submit') == 'submit' ? url($this->data['route'].'/create') : url($this->data['route'])
                ]);
        }else{
            return response()->json([
                    'status' => false,
                    '_token' => csrf_token(),
                    'message' => 'Add data fail!',
                    'return_url' => '#'
                ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        $this->data['subtitle'] = 'Edit Data';
        $this->data['data_row']  = User::find($id);
        $this->data['roles']     = Role::pluck('name','name')->all();
        $this->data['userRole']  = $this->data['data_row']->roles->pluck('name','name')->all();

        return view('components.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = null)
    {
        $this->validate($request, [
            'name' => 'required',
            'menu_id' => 'required'
        ]);

        $menu = Menus::find($request->input('menu_id'));

        $query = Permission::find($id);
        if($query->name != $request->input('name')){
            $this->validate($request, [
                'name' => 'required|unique:permissions,name',
            ]);
        }
        $query->name = $request->input('name');
        $query->menu_id = $request->input('menu_id');
        $query->menu_name  = $menu->name;
        $query->save();

        if($query){
            return response()->json([
                    'status' => true,
                    '_token' => csrf_token(),
                    'message' => 'Update data success!',
                    'return_url' => $request->input('submit') == 'submit' ? "#edit-done" : url($this->data['route'])
                ]);
        }else{
            return response()->json([
                    'status' => false,
                    '_token' => csrf_token(),
                    'message' => 'Update data fail!',
                    'return_url' => '#'
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = null)
    {
        $query = DB::table("permissions")->where('id',$id)->delete();
         if($query){
            return response()->json([
                    'status' => true,
                    '_token' => csrf_token(),
                    'message' => 'Delete data success!',
                    'return_url' => url($this->data['route'])
                ]);
        }else{
            return response()->json([
                    'status' => false,
                    '_token' => csrf_token(),
                    'message' => 'Delete data fail!',
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

        return $imageName;
    }
}
