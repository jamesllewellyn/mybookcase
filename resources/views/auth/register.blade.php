@extends('layouts.basic')

@section('content')
    <div class="columns is-centered">
        <div class="column is-5">
            <section class="hero register-interest-hero">
                <div class="hero-body">
                    <div class="container has-text-centered">
                        <h1 class="title is-quicksans has-text-centered">
                            My Bookcase
                        </h1>
                        <div class="content has-text-centered">
                            <p>Start building and sharing your bookcase today.</p>
                        </div>
                    </div>
                </div>
            </section>
            <div class="box">
                <form role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="name" class="label">Name</label>
                        <p class="control">
                            <input id="name" type="text" class="input" name="name" value="{{ old('name') }}"
                                   required autofocus>
                        @if ($errors->has('name'))
                            <p class="help is-danger">{{ $errors->first('name') }}</p>
                            @endif
                            </p>
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} field">
                        <label for="email" class="label">E-Mail Address</label>
                        <p class="control">
                            <input id="email" type="email" class="input" name="email" value="{{ old('email') }}"
                                   required>
                        @if ($errors->has('email'))
                            <p class="help is-danger">{{ $errors->first('email') }}</p>
                            @endif
                            </p>
                    </div>
                    <div class="form-group{{ $errors->has('handle') ? ' has-error' : '' }} field">
                        <label for="handle" class="label">Handle</label>
                        <p class="control">
                            <input id="handle" type="text" class="input" name="handle" value="{{ old('handle') }}"
                                   required>
                            @if ($errors->has('handle'))
                                <span class="help is-danger">
                                <strong>{{ $errors->first('handle') }}</strong>
                            </span>
                            @endif
                        </p>
                        <p>
                            <small>This will be displayed along with your messages in My Bookcase.</small>
                        </p>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} field">
                        <label for="password" class="label">Password</label>
                        <p class="control">
                            <input id="password" type="password" class="input" name="password" required>
                        @if ($errors->has('password'))
                            <p class="help is-danger">{{ $errors->first('password') }}</p>
                            @endif
                            </p>
                    </div>
                    <div class="field">
                        <label for="password-confirm" class="label">Confirm Password</label>

                        <p class="control">
                            <input id="password-confirm" type="password" class="input" name="password_confirmation"
                                   required>
                        @if ($errors->has('password'))
                            <p class="help is-danger">{{ $errors->first('password') }}</p>
                            @endif
                            </p>
                    </div>
                    <p class="control">
                        <button class="button is-primary">Submit</button>
                    </p>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    {{--<script src="{{ mix('js/register-user.js') }}"></script>--}}
@endsection