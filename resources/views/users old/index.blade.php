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

<!-- Content area -->
<div class="content">
    <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title"><i class="{{ $icon ?? 'icon-home2' }} mr-2"></i> {{ $title }} </h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="nav-item"><a href="#highlighted-tab1" class="nav-link {{ $subtitle == 'List' ? ' active' : '' }}" data-toggle="tab">List Data</a></li>
                    <li class="nav-item"><a href="#highlighted-tab2" class="nav-link {{ $subtitle == 'Add' ? ' active' : '' }}" data-toggle="tab">Add New</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade {{ $subtitle == 'List' ? 'show active' : '' }}" id="highlighted-tab1" style="margin-top:-20px;">
                        <table class="table datatable-button-html5-columns no-wrap" >
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Phone Number</th>
                                    <th>Is Suspend</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $isRole3 = false;?>
                                @foreach ($datatable as $row)
                                    <?php $isRole3 = false;?>
                                        @foreach($row->roles as $currentRole)
                                            @if($currentRole->id != '3')
                                                <?php $isRole3 = true;?>
                                            @endif
                                        @endforeach
                                    <tr>
                                        <td>
                                            @if($isRole3)
                                                <img src="{{ !empty(@$row->avatar) ? asset('/assets/avatar/'.$row->avatar) : '' }}" width="36" height="36" class="rounded-circle mr-2">  {{ $row->name }}
                                            @else
                                                <div style="display:inline">
                                                    <img style="display:inline" src="{{ !empty(@$row->avatar) ? $row->avatar : '' }}" width="36" height="36" class="rounded-circle mr-2">
                                                    {{ $row->name }} <span class="badge bg-success">Requestor</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $row->username}}</td>
                                        <td>{{ $row->phone_number }}</td>
                                        <td><?= $row->is_suspend == '1' ? '<span class="badge bg-danger">Yes</span>' : '<span class="badge bg-success">No</span>' ;?></td>
                                        <td>{{ $row->email }}</td>
                                        <td class='text-center'>
                                            <div class="list-icons">
                                                <div class="dropdown">
                                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                        <i class="icon-menu9"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($isRole3)
                                                            <a href="{{ url('users/edit/'.$row->id) }}" class="dropdown-item"><i class="icon-pencil5"></i> Edit</a>
                                                        @endif
                                                        <a href="#remove" data-toggle="confirm-remove" data-address="{{ url('users/delete/'.$row->id) }}" type="button" class="dropdown-item" ><i class="icon-trash-alt"></i> Delete </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade {{ $subtitle == 'Add' ? 'show active' : '' }}" id="highlighted-tab2">
                        <br/>
                        @include($menu.'.form')
                    </div>

                </div>


            </div>

        </div>
</div>

@endsection

