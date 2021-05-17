
@extends('dashboard.base')

@section('css')

@endsection

@section('content')


    <div class="container">
        <div class="fade-in">
            <div class="row">

                <div class="offset-xl-3 col-xl-6   col-sm-12">
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
                            <form method="POST" >
                                @csrf
                                <div class="form-group">
                                    <label class="font-weight-bold">Username: </label>
                                    {{$userInfo['username']}}
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold" >Name: </label>
                                    {{$userInfo['name']}}
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Email Address: </label>
                                    {{$userInfo['email']}}
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Contact : </label>
                                    {{$userInfo['contact_number']}}
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Address: </label>
                                    {{$userInfo['address']}}
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Province: </label>
                                    {{\App\Helpers\CommonHelper::getProvincesById($userInfo['province'])}}
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">City: </label>
                                        {{\App\Helpers\CommonHelper::getCitiesById($userInfo['city'])}}
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Type</label>
                                    {{\App\Constants\StockistConstants::USER_TYPES[$userInfo['stockist_type_id']]}}

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('javascript')

@endsection
