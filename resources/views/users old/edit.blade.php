@extends('layouts.app')

@section('content')
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="" class="breadcrumb-item"><i class="{{ $icon ?? 'icon-home2' }} mr-2"></i> {{ $title ?? '' }}</a>
                @if( @$subtitle != "" )
                    <a href='' class='breadcrumb-item'>{{ $subtitle }}</a>
                @endif
                @if( @$submenu != "" )
                    <span class="breadcrumb-item active">{{ $submenu }}</span>
                @endif
            </div>

        </div>
    </div>
</div>
<!-- /page header -->

<div class="content">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Edit {{ $title }}</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-highlight">
                <li class="nav-item"><a href="{{ route('users') }}" class="nav-link " >List Data</a></li>
                <li class="nav-item"><a href="{{ url('users/add') }}" class="nav-link " >Add New</a></li>
                <li class="nav-item dropdown"><a href="#highlighted-tab1" class="nav-link active" data-toggle="tab">Edit</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="highlighted-tab1">
                    <h6>Edit Data {{ $title }}</h6>
                    @include($menu.'.form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

