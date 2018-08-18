<template>
    <div class="columns is-centered">
        <div class="column is-4">
            <div class=" has-text-centered">
                <h1 class="title is-quicksans is-title">
                    My Bookcase
                </h1>
            </div>
            <div class="box is-shadowless">
                <form>
                    <div class="field">
                        <label class="label">Name</label>
                        <p class="control">
                            <input class="input" type="text" name="name"
                                   placeholder="Please enter your name"
                                   v-model="user.name">
                        </p>
                        <p class="help is-danger" v-text="getErrors('name')"></p>
                    </div>
                    <div class="field">
                        <label class="label">Email</label>
                        <p class="control">
                            <input class="input" type="email" name="email"
                                   placeholder="Please enter your email address"
                                   v-model="user.email">
                        </p>
                        <p class="help is-danger" v-text="getErrors('email')"></p>
                    </div>
                    <div class="field">
                        <label class="label">Handle</label>
                        <p class="control has-icons-left">
                            <input class="input" type="text" name="handle" placeholder="Create a handle"
                                   v-model="user.handle">
                            <span class="icon is-small is-left">@</span>
                        </p>
                        <p class="is-size-6">
                            <small>Your handle will be displayed along with any messages in My Bookcase.</small>
                        </p>
                        <p class="help is-danger" v-text="getErrors('handle')"></p>
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
                        <button class="button is-primary is-fullwidth" @click.prevent="submit"
                                :class="{'is-loading' : isLoading}">Submit
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
                formErrors: [],
                isLoading: false,
                user: {
                    email: '',
                    name: '',
                    handle: '',
                    password: '',
                    password_confirm: ''
                },
            }
        },
        computed: {
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
                axios.post('/api/user', this.user)
                    .then((response) => {
                        self.isLoading = false;
                        self.grantPassportToken();
                    }, (error) => {
                        console.log(error)
                        if (error.response.data) {
                            self.isLoading = false;
                            return self.formErrors = error.response.data.errors;
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
        },
        mounted() {
            if (localStorage.getItem('access_token')) {
                this.$store.dispatch('user/get');
                this.$store.dispatch('bookcase/get');
                Event.$emit('changePage', '/dashboard/');
            }
        }
    }
</script>