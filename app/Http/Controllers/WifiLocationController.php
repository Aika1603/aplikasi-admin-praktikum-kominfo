<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Desa;
use App\Kecamatan;
use App\WifiLocation;
use App\WifiLocationAttachment;
use App\Comments;

class WifiLocationController extends Controller
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
                        'title'             => 'Wifi Locations',
                        'subtitle'          => '',
                        'menu'              => 'Wifi Locations',
                        'link_menu'         => '',
                        'icon_menu'         => 'icon-database',
                        'submenu'           => '',
                        'link_submenu'      => '',
                        'icon_submenu'      => '',
                        'subsubmenu'        => '',
                        'icon_subsubmenu'   => '',
                        'route'             => 'wifi_locations',
                        'permission'        => 'wifi locations',
                        'icon_primary'      => 'icon-location4',
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
        $this->data['datatable'] = WifiLocation::select(
                                                'wifi_locations.*',
                                                'kecamatans.name as kecamatan_name',
                                                'desas.name as desa_name',
                                            )
                                            ->join('kecamatans', 'kecamatans.id', '=', 'wifi_locations.kecamatan_id')
                                            ->join('desas', 'desas.id', '=', 'wifi_locations.desa_id')
                                            ->get();
        return view($this->data['route'].'.index', $this->data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_index(Request $request, $id = null)
    {

        $query = WifiLocation::select(
                                    'wifi_locations.*',
                                    'kecamatans.name as kecamatan_name',
                                    'desas.name as desa_name',
                                )
                                ->join('kecamatans', 'kecamatans.id', '=', 'wifi_locations.kecamatan_id')
                                ->join('desas', 'desas.id', '=', 'wifi_locations.desa_id');
        if($id == null){
            $data = $query->get();
            $res = [
                'length' => count($data),
                'data' => $data,
            ];
        }else{
            $res = $query->where('wifi_locations.id', $id)->first();
        }
        return response()->json($res);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_search(Request $request)
    {
        $kecamatan = $request->input('kecamatan');
        $status = $request->input('status');
        
        $query = WifiLocation::select(
                                    'wifi_locations.*',
                                    'kecamatans.name as kecamatan_name',
                                    'desas.name as desa_name',
                                )
                                ->where(function ($q) use($kecamatan) {
                                    if ($kecamatan != "") {
                                        $q->where('kecamatans.name', 'like', "%$kecamatan%");
                                    }
                                })
                                ->where(function ($q) use($status) {
                                    if ($status != "") {
                                        $q->where('is_active', $status);
                                    }
                                })
                                ->join('kecamatans', 'kecamatans.id', '=', 'wifi_locations.kecamatan_id')
                                ->join('desas', 'desas.id', '=', 'wifi_locations.desa_id');
        $data = $query->get();
        $res = [
            'length' => count($data),
            'data' => $data,
        ];
        return response()->json($res);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['subtitle'] = 'Create Data';
        $this->data['kecamatans'] = Kecamatan::get();
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
            'ssid_name' => 'required',
            'desc' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'kecamatan_id' => 'required',
            'desa_id' => 'required',
        ]);

        $query = WifiLocation::create([
            'name' => $request->input('name'), 
            'ssid_name' => $request->input('ssid_name'), 
            'desc' => $request->input('desc'), 
            'latitude' => $request->input('latitude'), 
            'longitude' => $request->input('longitude'), 
            'kecamatan_id' => $request->input('kecamatan_id'), 
            'desa_id' => $request->input('desa_id'), 
            'is_active' => empty($request->input('is_active')) ? '0' : '1',
        ]);

        //convert to db transancation
        if($query){
            //add attachment here

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
        $this->data['kecamatans'] = Kecamatan::get();
        $this->data['data_row'] = WifiLocation::find($id);
        $this->data['attachments'] = WifiLocationAttachment::where('wifi_location_id', $id)->get();
        $this->data['desas'] = Desa::where('kecamatan_id', @$this->data['data_row']->kecamatan_id)->get();
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
            'ssid_name' => 'required',
            'desc' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'kecamatan_id' => 'required',
            'desa_id' => 'required',
        ]);

        $query = WifiLocation::find($id);
        $query->name = $request->input('name');
        $query->ssid_name = $request->input('ssid_name');
        $query->desc = $request->input('desc');
        $query->latitude = $request->input('latitude');
        $query->longitude = $request->input('longitude');
        $query->kecamatan_id = $request->input('kecamatan_id');
        $query->desa_id = $request->input('desa_id');
        $query->is_active = empty($request->input('is_active')) ? '0' : '1';
        $query->save();

        if($query){
            //update attachment
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
        $query = WifiLocation::where('id',$id)->delete();
         if($query){
            //delete attachment and comments
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

    /**
     * Show the page for detail the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id = null)
    {
        $this->data['subtitle'] = 'Detail Data';
        $this->data['data_row'] = WifiLocation::select(
                                                'wifi_locations.*',
                                                'kecamatans.name as kecamatan_name',
                                                'desas.name as desa_name',
                                            )
                                            ->join('kecamatans', 'kecamatans.id', '=', 'wifi_locations.kecamatan_id')
                                            ->join('desas', 'desas.id', '=', 'wifi_locations.desa_id')
                                            ->where('wifi_locations.id', $id)->get();
        $this->data['attachments'] = WifiLocationAttachment::where('wifi_location_id', $id)->get();
        return view('components.edit', $this->data);
    }

}
