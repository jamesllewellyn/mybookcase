@extends('layouts.basic')

@section('content')
    <div class="columns is-centered">
        <div class="column is-5">
            <section class="hero register-interest-hero">
                <div class="hero-body">
                    <div class="container has-text-centered">
                        <h1 class="title is-quicksans">
                            My Bookcase
                        </h1>
                        <p v-if="! hasRegisteredInterest" v-cloak>
                                We are currently going though beta testing and are invitation only.
                                Sign up below to register your interest in My Bookcase and we'll give you a heads up as soon
                                as we're ready.
                        </p>
                        <transition name="fade-slow" mode="out-in">
                            <article class="message is-success" v-if="hasRegisteredInterest" v-cloak>
                                <div class="message-header">
                                    <p>You've registered your interest</p>
                                </div>
                                <div class="message-body">
                                    Thank you for registering your interest in My Bookcase. We'll email you over an invite to
                                    <span v-text="email"></span> once we're ready for you
                                </div>
                            </article>
                        </transition>
                    </div>
                </div>
            </section>
            <div class="box" v-if="! hasRegisteredInterest">
                <form>
                    <div class="field">
                        <label class="label">Email</label>
                        <p class="control">
                            <input class="input" type="email" name="email"
                                   placeholder="Please enter your email address"
                                   v-model="email">
                        </p>
                        <p class="help is-danger" v-text="getErrors('email')"></p>
                    </div>
                    <p class="control">
                        <button class="button is-primary" @click.prevent="submit"
                                :class="{'is-loading' : isLoading}">Submit
                        </button>
                    </p>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ mix('js/register-interest.js') }}"></script>
@endsection
