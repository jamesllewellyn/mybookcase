<template>
    <div class="box is-shadowless">
        <transition name="modal" mode="out-in">
            <div class="notification is-danger" v-if="loginError">
                <p class="help is-small">
                    These credentials don't seem quite right.
                </p>
            </div>
        </transition>
        <form>
            <div class="form-group field">
                <label for="email" class="label">E-Mail Address</label>
                <p class="control">
                    <input id="email" type="email" class="input" name="email" required autofocus
                           v-model="login.username">
                </p>
            </div>
            <div class="form-group field">
                <label for="password" class="label">Password</label>

                <p class="control">
                    <input id="password" type="password" class="input" name="password" required v-model="login.password">
                </p>
            </div>

            <p class="control">
                <button class="button is-primary is-fullwidth" :class="{'is-loading' : isLoading}" @click.prevent="submit">Submit
                </button>
            </p>

            <div class="field">
                <p class="control">
                    <label class="checkbox">
                        <!--<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me-->
                    </label>
                </p>
            </div>

            <a class="btn btn-link is-text-small is-block has-text-centered" href="">
                Forgot Your Password?
            </a>
            <router-link :to="{ name: 'register'}" class="btn btn-link is-text-small is-block has-text-centered">
                Don't have an account? Get started
            </router-link>

        </form>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                isLoading: false,
                loginError: false,
                login: {
                    username: '',
                    password: '',
                    grant_type: 'password',
                    client_id: process.env.MIX_PASSPORT_CLIENT_ID,
                    client_secret: process.env.MIX_PASSPORT_CLIENT_SERCET,
                },
            }
        },
        props: {
            isModal: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            submit() {
                let self = this;
                this.isLoading = true;
                this.$store.dispatch('authentication/login', {login: this.login})
                    .then((response) => {
                        self.isLoading = false;
                        Event.$emit('changePage', '/dashboard/');
                        return self.$store.dispatch('user/get');
                    })
                    .then((response) => {
                        return self.$store.dispatch('bookcase/get');
                    })
                    .catch((error) => {
                        self.isLoading = false;
                        return self.loginError = true;
                    });
            }
        },
        mounted() {
            if (localStorage.getItem('access_token')) {
                this.$store.dispatch('user/get');
            }
        }
    }
</script>