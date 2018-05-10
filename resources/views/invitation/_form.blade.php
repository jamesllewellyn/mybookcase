<div class="content has-text-centered">
    <p>Thank you for registering your interest. Let's get you set up with an account</p>
</div>
<div class="box">
 <user-register-form></user-register-form>
    {{--<form class="form" role="form" method="POST" action="{{ route('register') }}">--}}
        {{--@csrf--}}
        {{--<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">--}}
            {{--<label for="name" class="label">First Name</label>--}}
            {{--<p class="control">--}}
                {{--<input id="name" type="text" class="input" name="name" value="{{ old('name') }}" required autofocus>--}}
            {{--@if ($errors->has('name'))--}}
                {{--<p class="help is-danger">{{ $errors->first('name') }}</p>--}}
                {{--@endif--}}
                {{--</p>--}}
        {{--</div>--}}
        {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} field">--}}
            {{--<label for="email" class="label">E-Mail Address</label>--}}
            {{--<p class="control">--}}
                {{--<input id="email" type="email" class="input" name="email" value="{{ old('email') }}" required>--}}
            {{--@if ($errors->has('email'))--}}
                {{--<p class="help is-danger">{{ $errors->first('email') }}</p>--}}
                {{--@endif--}}
                {{--</p>--}}
        {{--</div>--}}
        {{--<div class="form-group{{ $errors->has('handle') ? ' has-error' : '' }} field">--}}
        {{--<label for="handle" class="label">Handle</label>--}}
        {{--<p class="control">--}}
        {{--<input id="handle" type="text" class="input" name="handle" value="{{ old('handle') }}" required>--}}
        {{--@if ($errors->has('handle'))--}}
        {{--<span class="help is-danger">--}}
        {{--<strong>{{ $errors->first('handle') }}</strong>--}}
        {{--</span>--}}
        {{--@endif--}}
        {{--</p>--}}
        {{--<p><small>Your hand will be displayed along with your messages in Get Stuff Done.</small></p>--}}
        {{--</div>--}}
        {{--<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} field">--}}
            {{--<label for="password" class="label">Password</label>--}}
            {{--<p class="control">--}}
                {{--<input id="password" type="password" class="input" name="password" required>--}}
            {{--@if ($errors->has('password'))--}}
                {{--<p class="help is-danger">{{ $errors->first('password') }}</p>--}}
                {{--@endif--}}
                {{--</p>--}}
        {{--</div>--}}
        {{--<div class="field">--}}
            {{--<label for="password-confirm" class="label">Confirm Password</label>--}}

            {{--<p class="control">--}}
                {{--<input id="password-confirm" type="password" class="input" name="password_confirmation" required>--}}
            {{--@if ($errors->has('password'))--}}
                {{--<p class="help is-danger">{{ $errors->first('password') }}</p>--}}
                {{--@endif--}}
                {{--</p>--}}
        {{--</div>--}}
        {{--<p class="control">--}}
            {{--<button class="button is-primary is-fullwidth">Submit</button>--}}
        {{--</p>--}}
    {{--</form>--}}
</div>