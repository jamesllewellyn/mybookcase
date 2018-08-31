<template>
    <div class="columns is-centered">
        <div class="column is-4">
            <div class=" has-text-centered">
                <h1 class="title is-quicksans is-title">
                    Request a password reset
                </h1>
            </div>

            <div class="box is-shadowless">
                <transition name="modal" mode="out-in">
                    <div class="notification" :class="[hasError ? 'is-danger' : 'is-success']" v-if="feedback">
                        <p class="help is-small" v-text="feedback">
                        </p>
                    </div>
                </transition>
                <form>
                    <div class="form-group field">
                        <label for="email" class="label">E-Mail Address</label>
                        <p class="control">
                            <input id="email" type="email" class="input" name="email" required autofocus
                                   v-model="email">
                        </p>
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
                email: null,
                hasError: false,
                feedback: null
            }
        },
        methods: {
            submit() {
                let self = this;
                this.isLoading = true;
                axios.post(`password/email `, {email: this.email})
                    .then(() => {
                        self.hasError = false;
                        self.isLoading = false;
                        return self.feedback = "A password reset has been email to you";
                    }, (error) => {
                        self.hasError = true;
                        self.isLoading = false;
                        return self.feedback = error.response.data.email;
                    });
            }
        }
    }
</script>
