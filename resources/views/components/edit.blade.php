@extends('layouts.app')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-pencil5 mr-1"></i> Edit Data {{ $title }}</h5>
            <div class="header-elements">
                <div class="list-icons">
                    @can($permission.'-list')
                        <a href="{{ route($route.'.index') }}" class="list-icons-item btn btn-md bg-{{ config('app.theme') }}"> <i class="icon-arrow-left12 "></i> Kembali ke Data {!! $title !!}</a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card-body">
            @include($route.'.form')
        </div>
    </div>
</div>
@endsection

