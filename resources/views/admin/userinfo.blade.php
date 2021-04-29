
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
                            @if(Session::has('message'))
                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                                    </div>
                                </div>
                            @endif
                                <form method="POST" action="{{ route('admin.user.add') }}">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input
                                            type="text"
                                            placeholder="Fullname"
                                            name="name"
                                            id="name"
                                            class="form-control"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input
                                            type="email"
                                            placeholder="Email"
                                            name="email"
                                            id="email"
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <input
                                            type="text"
                                            placeholder="Contact Number"
                                            name="contact_number"
                                            id="contact_number"
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input
                                            type="text"
                                            placeholder="Address"
                                            name="address"
                                            id="address"
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label>Province</label>
                                        <select name="province" id="province" class="form-control">
                                            {{$provinces = \App\Helpers\CommonHelper::getProvinces()}}
                                            @foreach($provinces as $province)
                                                <option id="{{$province->id}}">{{$province->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <select name="city" id="city" class="form-control">
                                            {{$cities = \App\Helpers\CommonHelper::getCities()}}
                                            @foreach($cities as $city)
                                                <option id="{{$city->id}}">{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="stockist_type" id="stockist_type" class="form-control">
                                        </select>
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
