@extends('layouts.app')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-12">
            <h5>Dashboard <br/><small class="text-muted">Overview data </small></h5>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-danger-400 has-bg-image">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0">{{ $all_wifi }}</h3>
                        <span class="font-size-lg" style="font-size:20px;">Wifi</span>
                    </div>

                    <div class="ml-3 align-self-center">
                        <i class="icon-location4 icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-blue-400 has-bg-image">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0">{{ $kecamatan }}</h3>
                        <span class="font-size-lg" style="font-size:18px;">Kecamatan</span>
                    </div>

                    <div class="ml-3 align-self-center">
                        <i class="icon-database icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-orange-400 has-bg-image">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0">{{ $desa }}</h3>
                        <span class="font-size-lg" style="font-size:20px;">Desa</span>
                    </div>

                    <div class="ml-3 align-self-center">
                        <i class="icon-database icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
