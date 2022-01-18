@extends('layouts.app')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="{{ $icon_primary ?? '' }}"></i> {{ $title }} </h5>
            <div class="header-elements">
                <div class="list-icons">
                    @can($permission.'-create')
                        <a href="{{ route($route.'.create') }}" class="list-icons-item btn btn-md bg-{{ config('app.theme') }}"> <i class="icon-plus2 mr-1"></i> Tambah Data</a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table datatable-button-html5-columns no-wrap" >
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Phone Number</th>
                        <th>Status</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datatable as $key => $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->username }}</td>
                            <td>{{ $row->phone_number }}</td>
                            <td><?= $row->is_suspend == '1' ? '<span class="badge bg-danger">Suspend</span>' : '<span class="badge bg-success">Active</span>' ;?></td>
                            <td>{{ $row->email }}</td>
                            <td>
                                @if(!empty($row->getRoleNames()))
                                    @foreach($row->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td class=''>
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can($permission.'-edit')
                                                <a href="{{ route($route.'.edit', $row->id) }}" class="dropdown-item"><i class="icon-pencil5"></i> Edit</a>
                                            @endcan
                                            @can($permission.'-delete')
                                                <a href="#remove" data-toggle="confirm-remove" data-address="{{ route($route.'.delete', $row->id) }}" type="button" class="dropdown-item" ><i class="icon-trash-alt"></i> Delete </a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

