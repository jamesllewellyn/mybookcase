<template>
    <div class="user-register-form">
        <h1 class="title is-quicksans has-text-centered">
            My Bookcase
        </h1>
        <div class="content has-text-centered" v-if="!invitationError">
            <p>Thank you for registering your interest. Let's get you set up with an account</p>
        </div>
        <div class="box" v-if="!invitationError">
            <form>
                <div class="field">
                    <label class="label">Name</label>
                    <p class="control">
                        <input class="input" type="text" name="name"
                               placeholder="Kitty Lou"
                               v-model="user.name">
                    </p>
                    <p class="help is-danger" v-text="getErrors('name')"></p>
                </div>
                <div class="field">
                    <label class="label">Email</label>
                    <p class="control">
                        <input class="input" type="email" name="email"
                               placeholder="kitty.lou@just-asitting-in-the-window.cat"
                               v-model="user.email" disabled>
                    </p>
                    <p class="help is-danger" v-text="getErrors('email')"></p>
                </div>
                <div class="field">
                    <label class="label">Handle</label>
                    <p class="control has-icons-left">
                        <input class="input" type="text" name="handle" placeholder="lou"
                               v-model="user.handle">
                        <span class="icon is-small is-left">
                          @
                </span>
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
        <article class="message is-warning" v-else>
            <div class="message-header">
                {{invitationError['title']}}
            </div>
            <div class="message-body">
                {{invitationError['message']}}
            </div>
        </article>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                invitationError: null,
                invitation:null,
                email: '',
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
            invitationCode() {
                return location.search.match(new RegExp('invitation_code' + "=(.*?)($|\&)", "i"))[1]
            }
        },
        methods: {
            getInvitation() {
                if (!this.invitationCode) {
                    return false
                }
                let self = this
                this.isLoading = true;
                axios.get(`/api/interested-user?invitation_code=${this.invitationCode}`, this.user)
                    .then((response) => {
                        if (!response.data.success) {
                            console.log(response.data.inviteError)
                            self.isLoading = false;
                            return self.invitationError = response.data.inviteError;
                        }
                        self.isLoading = false;
                        self.invitation = {id: response.data.invitation.id, token: response.data.invitation.token}
                        self.user.email = response.data.invitation.email
//                        self.hasRegisteredInterest = true;
                    }, (error) => {
                        if (error.response.data) {
                            console.log(error.response.data.inviteError)
                            self.isLoading = false;
                            return self.invitationError = error.response.data.inviteError;
                        }
                    });
            },
            submit() {
                let self = this
                this.isLoading = true;
                axios.post('/interested-user/register', this.user)
                    .then((response) => {
                        self.isLoading = false
                        console.log(response)
                        window.location = "/home/"
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
            this.getInvitation();
        }
    }
</script>
