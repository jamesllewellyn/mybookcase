@extends('layouts.basic')

@section('content')
    <div class="columns is-centered">
        <div class="column is-4">
            <div class="box is-shadowless">
                <form class="" role="form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} field">
                        <label for="email" class="label">E-Mail Address</label>
                        <p class="control">
                            <input id="email" type="email" class="input" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <p class="help is-danger">{{$errors->first('email')}}</p>
                            @endif
                            </p>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} field">
                        <label for="password" class="label">Password</label>

                        <p class="control">
                            <input id="password" type="password" class="input" name="password" required>

                        @if ($errors->has('password'))
                            <p class="help is-danger">
                                {{ $errors->first('password') }}
                            </p>
                            @endif
                            </p>
                    </div>

                    <p class="control">
                        <button class="button is-primary is-fullwidth">Submit</button>
                    </p>
                    <div class="field">
                        <p class="control">
                            <label class="checkbox">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </p>
                    </div>
                    <a class="btn btn-link is-text-small" href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
