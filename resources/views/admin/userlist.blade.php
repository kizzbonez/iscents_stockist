
@extends('dashboard.base')

@section('css')

@endsection

@section('content')


    <div class="container">
        <div class="fade-in">
            <div class="row">

                <div class="col-xl-12   col-sm-12">
                    <div class="card">
                        <div class="card-header"><h4>{{$pageData['title']}}</h4></div>
                        <div class="card-body">
                            @if(session()->has('error'))
                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-danger" role="alert">
                                            <ul>
                                                @foreach(session()->get('error') as $value)
                                                    <li>{{$value}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(Session::has('success'))
                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
                                    </div>
                                </div>
                            @endif
                            <table class="table table-bordered datatable" id="datatable-users">
                                <thead>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Type</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('javascript')
<script>
    $(document).ready( function () {
        $('#datatable-users').DataTable({
            pageLength: 10,
            "processing": true,
            "ordering": true, "bLengthChange" : true, "pageLength": 10, "searching": true,
            deferRender:    true,
            "ajax": 'user-list'
        })
    } );
</script>
@endsection
