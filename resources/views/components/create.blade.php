@extends('layouts.app')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header header-elements-inline">
        <h5 class="card-title"><i class="icon-plus2 mr-1"></i> Tambah Data {{ $title }} </h5>
            <div class="header-elements">
                @can($permission.'-list')
                    <a href="{{ route($route.'.index') }}" class="list-icons-item btn btn-md bg-{{ config('app.theme') }}"> <i class="icon-arrow-left12 mr-1"></i> Kembali ke Data {!! $title !!}</a>
                @endcan
            </div>
        </div>

        <div class="card-body">
            @include($route.'.form')
        </div>
    </div>
</div>
@endsection

