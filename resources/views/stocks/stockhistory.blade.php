
@extends('dashboard.base')

@section('css')

@endsection

@section('content')


    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="offset-xl-12 col-xl-12   col-sm-12">
                    <div class="card">
                        <div class="card-header"><h4>{{\App\Helpers\CommonHelper::removeDash(last(Request::segments()),Request::segments())}}</h4></div>
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

                            <table id="stock-table" class="table table-bordered">
                                <thead>
                                <th>SKU</th>
                                <th>Product Name</th>
                                <th>Order ID</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Date</th>
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
                const product_id = "{{$product_id}}";
                $('#stock-table').DataTable({
                    pageLength: 10,
                    "processing": true,
                    "ordering": true, "bLengthChange" : true, "pageLength": 10, "searching": true,
                    deferRender:    true,
                    "ajax": '/stocks/history/list/'+product_id ,
                });

            })
        })
    </script>

@endsection
