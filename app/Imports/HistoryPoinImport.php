<?php

namespace App\Imports;

use App\HistoryPoin;
use App\Programs;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class HistoryPoinImport implements ToModel,  WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $emp = json_decode(Http::withHeaders([
                    'Authorization' => 'f252f169933b9a719a0bbe13de9d249f395428ab',
                ])
                ->get(config('app.url_api_emp').'api/master/emp_lite/'.$row['no_badge'])
                ->throw(function () {
                    return false;
                }));

        $get_program = Programs::where(['id' => request()->input('program_id')])->first();

        $query = new HistoryPoin([
            'no_badge' => $row['no_badge'],
            'name' => @$emp->NAMA,
            'org_code' => @$emp->KD_PUSAT_BIAYA,
            'org_name' => @$emp->UNIT_KERJA,
            'validation' => 'manual',
            'program_id' => request()->input('program_id'),
            'category_id' => @$get_program->category_id,
            'status' => 'approved',
            'poin' => request()->input('poin'),
            'note' => request()->input('note'),
        ]);
        if($query){
            /**
             * send push notif to emp
             */
            _push_notif_demplon([
                'no_badge' => $row['no_badge'],
                'title' => 'Kejar Reward AKHLAK',
                'body' => "Selamat! Kamu mendapatkan ".request()->input('poin')." Poin tambahan dari Aktivitas Program $get_program->name",
            ]);

        }
        return $query;
    }
}
