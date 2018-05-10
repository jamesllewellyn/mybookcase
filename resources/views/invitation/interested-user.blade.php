@extends('layouts.basic')

@section('content')
    {{--<div id="app">--}}
    <div class="columns is-centered">
        <div class="column is-5">
            <section class="hero register-interest-hero">
                <div class="hero-body">
                    <div class="container">

                        <user-register-form></user-register-form>

                    </div>
                </div>
            </section>
        </div>
    </div>
    {{--</div>--}}
@endsection
@section('scripts')
    <script src="{{ mix('js/register-interest.js') }}"></script>
@endsection