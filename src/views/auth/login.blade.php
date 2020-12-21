@extends('admin::layouts.empty')

@section('content')
    <div id="wrapper">
        <div class="card border-primary border-top-sm border-bottom-sm card-authentication1 mx-auto my-5 animated bounceInDown">
            <div class="card-body">
                <div class="card-content p-2">
                    <div class="text-center">
                        <img src="{{ asset('adminhtml/images/logo-icon.png') }}">
                    </div>
                    <div class="card-title text-uppercase text-center py-3">Login to the Admin Area</div>
                    <form method="POST" action="{{ route('admin.login.post') }}">
                        @csrf
                        <div class="form-group">
                            <div class="position-relative has-icon-right">
                                <label for="exampleInputUsername" class="sr-only">Email</label>
                                <input type="email" name="email" class="form-control form-control-rounded" placeholder="Email" value="{{ old('email') }}">
                                <div class="form-control-position">
                                    <i class="icon-user"></i>
                                </div>
                                @error('email')
                                    <span class="help-block error">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="position-relative has-icon-right">
                                <label for="exampleInputPassword" class="sr-only">Password</label>
                                <input type="password" name="password" class="form-control form-control-rounded" placeholder="Password">
                                <div class="form-control-position">
                                    <i class="icon-lock"></i>
                                </div>
                                @error('password')
                                    <span class="help-block error">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row mr-0 ml-0">
                            <div class="form-group col-6"></div>
                            <div class="form-group col-6 text-right">
                                <a href="{{ route('admin.password.request') }}">Reset Password</a>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary shadow-primary btn-round btn-block waves-effect waves-light">Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
