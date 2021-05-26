
@extends('dashboard.base')

@section('css')

@endsection

@section('content')


    <div class="container">
        <div class="fade-in">
            <div class="row">

                <div class="offset-xl-3 col-xl-6   col-sm-12">
                    <div class="card">
                        <div class="card-header"><h4>{{last(Request::segments())}}</h4></div>
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
                                <input type="hidden" id="id" name="id" value="{{\App\Helpers\CommonHelper::getInfoFromArray($userInfo,'id')}}">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input
                                        type="text"
                                        placeholder="Username"
                                        name="username"
                                        id="username"
                                        class="form-control"
                                        value="{{\App\Helpers\CommonHelper::getInfoFromArray($userInfo,'username')}}"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input
                                        type="text"
                                        placeholder="Fullname"
                                        name="name"
                                        id="name"
                                        class="form-control"
                                        value="{{\App\Helpers\CommonHelper::getInfoFromArray($userInfo,'name')}}"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input
                                        type="email"
                                        placeholder="Email"
                                        name="email"
                                        id="email"
                                        class="form-control"
                                        value="{{\App\Helpers\CommonHelper::getInfoFromArray($userInfo,'email')}}"
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
                                        value="{{\App\Helpers\CommonHelper::getInfoFromArray($userInfo,'contact_number')}}"
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
                                        value="{{\App\Helpers\CommonHelper::getInfoFromArray($userInfo,'address')}}"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>Province</label>
                                    <select name="province"
                                            id="province"
                                            class="form-control select2"
                                    >
                                        @php
                                            $provinces = \App\Helpers\CommonHelper::getProvinces()
                                        @endphp

                                        @foreach($provinces as $province)
                                            <option value="{{$province->id}}" {{(\App\Helpers\CommonHelper::getInfoFromArray($userInfo,'province') != $province->id ?:'selected' )}}>{{$province->province_description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <select name="city"
                                            id="city"
                                            class="form-control select2"
                                    >
                                        @php
                                            $cities = \App\Helpers\CommonHelper::getCities()
                                        @endphp
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" {{(\App\Helpers\CommonHelper::getInfoFromArray($userInfo,'city') != $city->id ?:'selected' )}}>{{$city->city_municipality_description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="stockist_type"
                                            id="stockist_type"
                                            class="form-control"
                                    >
                                        @php
                                            $userTypes = \App\Constants\StockistConstants::USER_TYPES;
                                        @endphp

                                        @foreach($userTypes as $index => $userType)

                                            @if($index !== \App\Constants\StockistConstants::USER_TYPE_ADMIN_STOCKIST)
                                                <option value="{{$index}}" {{(\App\Helpers\CommonHelper::getInfoFromArray($userInfo,'stockist_type') != $index ?:'selected' )}}>{{$userType}}</option>
                                            @endif
                                        @endforeach
                                    </select>
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
        $(document).ready(function(){
            $('.select2').select2();

        })
    </script>

@endsection
