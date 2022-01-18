<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use DB;
use App\Menus;
use App\Action;

class PermissionController extends Controller
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
                        'title'             => 'Permissions',
                        'subtitle'          => '',
                        'menu'              => 'Users Management',
                        'link_menu'         => '',
                        'icon_menu'         => 'icon-users',
                        'submenu'           => 'Permissions',
                        'link_submenu'      => '',
                        'icon_submenu'      => '',
                        'subsubmenu'        => '',
                        'icon_subsubmenu'   => '',
                        'route'             => 'permissions',
                        'permission'        => 'permissions',
                        'icon_primary'      => '',
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
        $this->data['datatable'] = Permission::select('permissions.*', 'menus.name as menu_name')->join('menus', 'menus.id', '=', 'permissions.menu_id')->orderBy('menu_id','ASC')->get();
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
        $this->data['menus'] = Menus::orderBy('name', 'ASC')->get();
        $this->data['actions'] = Action::get();
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
            'name' => 'required|unique:permissions,name',
            'menu_id' => 'required',
            'action_id' => 'required',
        ]);

        $query = Permission::create([
            'name' => $request->input('name'), 
            'menu_id' => $request->input('menu_id'),
            'action_id' => $request->input('action_id'),
        ]);

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
        $this->data['data_row'] = Permission::find($id);
        $this->data['menus'] = Menus::orderBy('name', 'ASC')->get();
        $this->data['actions'] = Action::get();
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
            'menu_id' => 'required',
            'action_id' => 'required',
        ]);

        $query = Permission::find($id);
        if($query->name != $request->input('name')){
            $this->validate($request, [
                'name' => 'required|unique:permissions,name',
            ]);
        }
        $query->name = $request->input('name');
        $query->menu_id = $request->input('menu_id');
        $query->action_id = $request->input('action_id');
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
}
