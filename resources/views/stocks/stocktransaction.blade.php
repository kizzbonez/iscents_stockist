
@extends('dashboard.base')

@section('css')

@endsection

@section('content')
    <div class="container">
        <div class="fade-in">
            <div class="row">
                <div class="offset-xl-3 col-xl-6   col-sm-12">
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
                            <form method="POST" >
                                @csrf
                                <div class="form-group" id="product" name="product">
                                    <label>Product</label>
                                    <select class="form-control select2" id="product_id" name="product_id">
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input
                                        type="number"
                                        placeholder="Quantity"
                                        name="qty"
                                        id="qty"
                                        class="form-control"
                                        value="{{\App\Helpers\CommonHelper::getInfoFromArray($stockInfo,'qty')}}"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>Transaction Type</label>
                                    <select class="form-control " id="trans_type" name="trans_type">
                                        <option value="0" selected>IN</option>
                                        <option value="1" >OUT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks">
                                    </textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
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
            $('#product_id').select2();
        })
    </script>

@endsection



