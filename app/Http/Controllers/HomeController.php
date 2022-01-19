<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Kecamatan;
use App\Desa;
use App\WifiLocation;

class HomeController extends Controller
{
    private $data = [];

    public function __construct()
    {
        $this->data = [
                        'title'             => 'Dashboard',
                        'subtitle'          => '',
                        'menu'              => 'Dashboard',
                        'link_menu'         => '',
                        'icon_menu'         => 'icon-home',
                        'submenu'           => '',
                        'link_submenu'      => '',
                        'icon_submenu'      => '',
                        'subsubmenu'        => '',
                        'icon_subsubmenu'   => '',
                        'route'             => 'dashboard',
                        'permission'        => 'dashboard',
                        'icon_primary'      => 'icon-home',
                        'no'                => 1
                      ];
    }

    public function index(Request $request)
    {
        $this->data['kecamatan'] = Kecamatan::count();
        $this->data['desa'] = Desa::count();
        $this->data['all_wifi'] = WifiLocation::count();
        $this->data['active_wifi'] = WifiLocation::where('is_active', '1')->count();
        
        return view('home', $this->data);
    }
}
