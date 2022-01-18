<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private $data = [];

    public function __construct()
    {
        $this->middleware(['auth']);
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
                        'icon-primary'      => '',
                        'no'                => 1
                      ];
        // $this->middleware("permission:".$this->data['permission']."-list", ['only' => ['index']]);
        // $this->middleware("permission:".$this->data['permission']."-create", ['only' => ['create','store']]);
        // $this->middleware("permission:".$this->data['permission']."-edit", ['only' => ['edit','update']]);
        // $this->middleware("permission:".$this->data['permission']."-delete", ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('home', $this->data);
    }
}
