
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
                                <input type="hidden" id="uuid" name="uuid" value="{{\App\Helpers\CommonHelper::getInfoFromArray($productInfo,'uuid')}}">
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input
                                        type="text"
                                        placeholder="Product Name"
                                        name="name"
                                        id="name"
                                        class="form-control"
                                        value="{{\App\Helpers\CommonHelper::getInfoFromArray($productInfo,'name')}}"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>SKU</label>
                                    <input
                                        type="text"
                                        placeholder="SKU"
                                        name="sku"
                                        id="sku"
                                        class="form-control"
                                        value="{{\App\Helpers\CommonHelper::getInfoFromArray($productInfo,'sku')}}"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" id="description" name="description" size="5">
                                        {{\App\Helpers\CommonHelper::getInfoFromArray($productInfo,'description')}}
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Points</label>
                                    <input
                                        type="text"
                                        placeholder="Product Points"
                                        name="points"
                                        id="points"
                                        class="form-control"
                                        value="{{\App\Helpers\CommonHelper::getInfoFromArray($productInfo,'points')}}"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input
                                        type="number"
                                        min="0"
                                        placeholder="Price"
                                        name="price"
                                        id="price"
                                        class="form-control"
                                        value="{{\App\Helpers\CommonHelper::getInfoFromArray($productInfo,'price')}}"
                                    />
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

