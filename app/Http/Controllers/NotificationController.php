<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Notification;
use Session;

class NotificationController extends Controller
{
    private $data = [];

    public function __construct()
    {
        $this->data = [
                        'title'             => 'Notifications',
                        'subtitle'          => '',
                        'menu'              => 'Notifications',
                        'link_menu'         => '',
                        'icon_menu'         => 'icon-bell2',
                        'submenu'           => '',
                        'link_submenu'      => '',
                        'icon_submenu'      => '',
                        'subsubmenu'        => '',
                        'icon_subsubmenu'   => '',
                        'route'             => 'notification',
                        'permission'        => 'notification',
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
        $this->data['datatable'] = Notification::where(['user_id' => Auth::user()->id])->orWhere(['is_topic' => '1'])->orderBy('id', 'DESC')->get();
        return view($this->data['route'].'.index', $this->data);
    }

    public function get(Request $request, $last_id = 0)
    {
        $last_id = (integer) $last_id;
        $content = Notification::select('*', DB::raw("DATE_FORMAT(created_at, '%W, %d-%m-%Y %H:%i') as date"))->where(['user_id' => Auth::user()->id])->orWhere(['is_topic' => '1'])->limit(5)->orderBy('id', 'DESC')->get();
        $data_notifikasi = [
            "status" => true,
            "content" =>  $content,
            "all" =>  Notification::where(['user_id' => Auth::user()->id])->orWhere(['is_topic' => '1'])->count(),
            "new" => $last_id > 0 ? Notification::Where(function($query){
                                $query->where(['user_id' => Auth::user()->id]);
                                $query->orWhere(['is_topic' => '1']);
                            })->where('id', '>', $last_id)->count() : 0, //handle by fcm
            // "new" =>  0,
            "unseen" => Notification::Where(function($query){
                                $query->where(['user_id' => Auth::user()->id]);
                                $query->orWhere(['is_topic' => '1']);
                            })->where(['is_seen' => '0'])->count(),
        ];

        //get last notif id
        foreach ($content as $row) {
            $last_id = $last_id < $row->id ? $row->id : $last_id;
        }
        $data_notifikasi['last_id'] = $last_id;
        return response()->json($data_notifikasi);
    }

    public function read_all(Request $request)
    {
        Notification::Where(function($query){
                                $query->where(['user_id' => Auth::user()->id]);
                                $query->orWhere(['is_topic' => '1']);
                            })->update(['is_seen' => '1']);
        return response()->json(['status' => true, 'message' => 'All notifications have been marked as read ']);
    }

    public function delete_all(Request $request)
    {
        Notification::Where(function($query){
                                $query->where(['user_id' => Auth::user()->id]);
                                $query->orWhere(['is_topic' => '1']);
                            })->delete();
        return response()->json([
            'status' => true,
            'message' => 'All notifications has been removed',
            'return_url' => url($this->data['route'])
        ]);
    }

    public function view(Request $request, $id)
    {
        $notif = Notification::where(['id' => $id])->first();
        if (isset($notif->id)) {
            Notification::where(['id' => $id])->update(['is_seen' => '1']);
            if (@$notif->link != "") {
                return redirect(url($notif->link));
            } else {
                return url('/dashboard');
            }
        } else {
            return redirect('/notfound');
        }
    }
}
