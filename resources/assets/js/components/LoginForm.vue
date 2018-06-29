<template>
    <div class="box is-shadowless">
        <form>
            <div class="form-group field">
                <label for="email" class="label">E-Mail Address</label>
                <p class="control">
                    <input id="email" type="email" class="input" name="email" required autofocus
                           v-model="login.username">
                <p class="help is-danger"></p>
                </p>
            </div>
            <div class="form-group field">
                <label for="password" class="label">Password</label>

                <p class="control">
                    <input id="password" type="password" class="input" name="password" required
                           v-model="login.password">
                <p class="help is-danger"></p>
                </p>
            </div>

            <p class="control">
                <button class="button is-primary is-fullwidth" @click.prevent="submit">Submit</button>
            </p>
            <div class="field">
                <p class="control">
                    <label class="checkbox">
                        <!--<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me-->
                    </label>
                </p>
            </div>
            <a class="btn btn-link is-text-small" href="">
                Forgot Your Password?
            </a>
            <router-link :to="{ name: 'register'}" class="btn btn-link is-text-small pull-left">
                Don't have an account? Get started
            </router-link>

        </form>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                formErrors: [],
                isLoading: false,
                login: {
                    username: '',
                    password: '',
                    grant_type: 'password',
                    client_id: process.env.MIX_PASSPORT_CLIENT_ID,
                    client_secret: process.env.MIX_PASSPORT_CLIENT_SERCET,
                },
            }
        },
        props:{
          isModal:{
              type: Boolean,
              default: false
          }
        },
        methods: {
            submit() {
                let self = this
                this.isLoading = true;
                axios.post('/oauth/token', this.login)
                    .then((response) => {
                        console.log(this.user);
                        self.isLoading = false
                        localStorage.setItem('access_token', response.data.access_token)
                        localStorage.setItem('token_type', response.data.token_type)
                        localStorage.setItem('refresh_token', response.data.refresh_token)
                        self.$store.dispatch('userGet')
                        if(self.isModal){
                            return self.$store.commit('modalHide', {name: 'loginModal'})
                        }
                        Event.$emit('changePage', '/dashboard/')
                    }, (error) => {
                        if (error.response.data) {
                            self.isLoading = false;
                            return self.formErrors = error.response.data.errors;
                        }
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
                this.$store.dispatch('userGet')
                Event.$emit('changePage', '/dashboard/')
            }
        }
    }
</script>