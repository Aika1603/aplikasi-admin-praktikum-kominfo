@extends('layouts.app')

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="{{ $icon_menu ?? '' }} mr-2"></i> {{ $title }} </h5>
            <div class="header-elements">
                <div class="list-icons">
                    <button type="button" class="btn btn-mark-read btn-dark btn-sm ">Mark all as read </button>
                    @if(count($datatable) > 0)
                        <a href="#remove" data-toggle="confirm-remove" data-address="{{ url('notification/delete-all/') }}" type="button" class="btn btn-danger btn-sm ">Clear notification </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table datatable no-wrap " >
                <thead style="display:none">
                    <tr>
                        <th style="max-width:5px;">No</th>
                        <th >Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0;?>
                    @foreach ($datatable as $row)
                        <tr style="{!! $row->is_seen != 0 ? 'background-color: #efefef !important;' : '' !!} ">
                            <td style="display:none">{{ $no }}</td>
                            <td>
                                <a class="d-flex flex-nowrap text-default" href="{{ url('notification/view/' . $row->id) }}" target="_blank">
                                    <div class="mr-2 position-relative">
                                        <div class="btn border-2 border-{{ $row->type }} alpha-{{ $row->type }} text-{{ $row->type }}-800 btn-icon rounded-round "><i class="icon-bell3"></i></div>
                                    </div>
                                    <span class="mr-3"><b>{{ $row->title }}</b> <br/>{{ $row->message }}</span>
                                    <div class="ml-auto text-muted"> {{ date("d/m/Y H:i:s", strtotime($row->created_at)) }}</div>
                                </a>
                            </td>
                        </tr>
                        <?php $no++;?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

