<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
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
                        'title'             => 'Roles List',
                        'subtitle'          => '',
                        'menu'              => 'Users Management',
                        'link_menu'         => '',
                        'icon_menu'         => 'icon-users',
                        'submenu'           => 'Roles List',
                        'link_submenu'      => '',
                        'icon_submenu'      => '',
                        'subsubmenu'        => '',
                        'icon_subsubmenu'   => '',
                        'route'             => 'roles',
                        'permission'        => 'role',
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
        $this->data['datatable'] = Role::orderBy('id','DESC')->get();
        foreach ($this->data['datatable'] as $key => $value) {
            @$this->data['datatable'][$key]->rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
                ->where("role_has_permissions.role_id",$value->id)
                ->orderBy('menu_name', 'ASC')
                ->get();
        }
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
        $this->data['list_permission'] = Permission::orderBy('menu_name', 'ASC')->get();
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
            'name' => 'required|unique:roles,name',
            // 'permission' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->input('name'), 
            'desc' => $request->input('desc')
        ]);
        $role->syncPermissions($request->input('permission'));

        if($role){
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
        $this->data['data_row'] = Role::find($id);
        $this->data['list_permission'] = Permission::orderBy('menu_name', 'ASC')->get();
        $this->data['rolePermissions'] = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

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
            // 'permission' => 'required',
        ]);

        $role = Role::find($id);
        
        if($role->name != $request->input('name')){
            $this->validate($request, [
                'name' => 'required|unique:roles,name',
            ]);
        }

        $role->name = $request->input('name');
        $role->desc = $request->input('desc');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        if($role){
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
        $role = DB::table("roles")->where('id',$id)->delete();
         if($role){
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
}
