<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Kecamatan;

class KecamatanController extends Controller
{
    private $data = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->data = [
                        'title'             => 'Kecamatan',
                        'subtitle'          => '',
                        'menu'              => 'Master Data',
                        'link_menu'         => '',
                        'icon_menu'         => 'icon-database',
                        'submenu'           => 'Kecamatan',
                        'link_submenu'      => '',
                        'icon_submenu'      => '',
                        'subsubmenu'        => '',
                        'icon_subsubmenu'   => '',
                        'route'             => 'kecamatans',
                        'permission'        => 'kecamatans',
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
        $this->data['datatable'] = Kecamatan::get();
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
            'name' => 'required',
        ]);

        $query = Kecamatan::create([
            'name' => $request->input('name'), 
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
        $this->data['data_row'] = Kecamatan::find($id);
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
        ]);

        $query = Kecamatan::find($id);
        $query->name = $request->input('name');
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
        $query = Kecamatan::where('id',$id)->delete();
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
