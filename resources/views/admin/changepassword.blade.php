
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
                                <input type="hidden" id="id" name="id" value="{{\App\Helpers\CommonHelper::getInfoFromArray($userInfo,'id')}}">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input
                                            type="password"
                                            placeholder="Password"
                                            name="password"
                                            id="password"
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input
                                            type="password"
                                            placeholder="Confirm Password"
                                            name="password_confirmation"
                                            id="password_confirmation"
                                            class="form-control"
                                        />
                                    </div>
                                <button type="submit" class="btn btn-primary">Change Password</button>
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
