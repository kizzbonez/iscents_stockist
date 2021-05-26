
@extends('dashboard.base')

@section('css')

@endsection

@section('content')


    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="offset-xl-12 col-xl-12   col-sm-12">
                    <div class="card">
                        <div class="card-header"><h4>{{\App\Helpers\CommonHelper::removeDash(last(Request::segments()))}}</h4></div>
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

                            <table id="product-table" class="table table-bordered">
                                <thead>
                                <th>SKU</th>
                                <th>Products</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Points</th>
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
        $(document).ready(function() {
            $(document).ready(function () {
                $('#product-table').DataTable();

            })
        })
    </script>

@endsection
