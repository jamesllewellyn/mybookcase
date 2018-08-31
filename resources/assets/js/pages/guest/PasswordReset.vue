<template>
    <div class="columns is-centered">
        <div class="column is-4">
            <div class=" has-text-centered">
                <h1 class="title is-quicksans is-title">
                    Reset your password
                </h1>
            </div>

            <div class="box is-shadowless">
                <transition name="modal" mode="out-in">
                    <div class="notification is-warning" v-if="tokenError">
                        <p class="help ">
                            Your password reset appears to be invalid. Please request another one.
                        </p>
                        <router-link class="btn btn-link is-text-small is-block has-text-centered" :to="{ name: 'password-reset-request'}">
                            Request Password Reset
                        </router-link>
                    </div>
                </transition>
                <form>
                    <div class="form-group field">
                        <label for="email" class="label">E-Mail Address</label>
                        <p class="control">
                            <input id="email" type="email" class="input" name="email" required autofocus
                                   v-model="user.email">
                        </p>
                        <p class="help is-danger" v-text="getErrors('email')"></p>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <p class="control">
                            <input class="input" type="password" name="password"
                                   placeholder="************"
                                   v-model="user.password">
                        </p>
                        <p class="help is-danger" v-text="getErrors('password')"></p>
                    </div>
                    <div class="field">
                        <label class="label">Confirm Password</label>
                        <p class="control">
                            <input class="input" type="password" name="password_confirmation"
                                   placeholder="************"
                                   v-model="user.password_confirmation">
                        </p>
                        <p class="help is-danger" v-text="getErrors('password_confirmation')"></p>
                    </div>

                    <p class="control">
                        <button class="button is-primary is-fullwidth" :class="{'is-loading' : isLoading}"
                                @click.prevent="submit">Submit
                        </button>
                    </p>

                </form>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isLoading: false,
                user: {email: null, password: null, password_confirmation: null, token : this.$route.query.token},
                formErrors: [],
                tokenError: false,
            }
        },
        computed: {
            // token(){
            //     if (!this.$route.query.token) {
            //         return false;
            //     }
            //     return ;
            // },
            login() {
                return {
                    username: this.user.email,
                    password: this.user.password,
                    grant_type: 'password',
                    client_id: process.env.MIX_PASSPORT_CLIENT_ID,
                    client_secret: process.env.MIX_PASSPORT_CLIENT_SERCET
                }
            },
        },
        methods: {
            submit() {
                let self = this;
                this.isLoading = true;
                axios.post(`password/reset`, this.user)
                    .then(() => {
                        self.isLoading = false;
                        self.grantPassportToken();
                    }, (error) => {
                        console.log(error.response);
                        if (error.response.data) {
                            self.isLoading = false;
                            self.formErrors = error.response.data.errors;
                        }
                        if (typeof error.response.data.errors.token !== 'undefined') {
                            self.tokenError = true;
                        }
                    });
            },
            grantPassportToken() {
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
            },
            getErrors(fieldName) {
                if (this.formErrors[fieldName]) {
                    return this.formErrors[fieldName][0];
                }
            }
        }
    }
</script>
