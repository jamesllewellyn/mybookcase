<template>
    <modal title="Update Profile" :isVisible="isVisible" @close="hide">
        <template slot="body">
            <section class="modal-card-body">
                <form>
                    <div class="field">
                        <label class="label">Name</label>
                        <p class="control">
                            <input class="input" type="text" name="name" placeholder="Please enter your name"
                                   v-model="name">
                        </p>
                        <p class="help is-danger" v-text="getErrors('name')"></p>
                    </div>
                    <div class="field">
                        <label class="label">Handle</label>
                        <p class="control has-icons-left">
                            <input class="input" type="text" name="handle" placeholder="Please enter a handle"
                                   v-model="handle">
                            <span class="icon is-small is-left">
                          @
                        </span>
                        </p>

                        <p class="is-size-6">
                            <small>Your handle will be displayed along with any messages in My Bookcase. Changing your
                                handle will also change your default application avatar
                            </small>
                        </p>
                        <p class="help is-danger" v-text="getErrors('handle')"></p>
                    </div>
                </form>
            </section>
            <footer class="modal-card-foot">
                <a class="button is-success" :class="{'is-loading': isLoading}" @click="updateProfile()">Update Profile</a>
                <a class="button" @click="hide()">Cancel</a>
            </footer>
        </template>
    </modal>
</template>

<script>
    import Modal from '../Modal.vue';
    import Errors from '../../core/Errors';
    export default {
        data() {
            return {
                isLoading: false,
                formErrors: new Errors(),
                name: '',
                handle: ''
            }
        },
        props: ['isVisible', 'user'],
        components: {Modal},
        methods: {
            updateProfile() {
                let self = this;
                this.isLoading = true;
                this.$store.dispatch('user/update', {name: this.name, handle: this.handle, email : this.user.email})
                    .then((response) => {
                        self.isLoading = false;
                        self.hide();
                        return Event.$emit('changePage', `/user/@${response.data.user.handle}`);
                    }, (error) => {
                        self.formErrors.record(error);
                        return self.isLoading = false;
                    });
            },
            hide() {
                this.$emit('close');
            },
            /** method to get form field errors **/
            getErrors(fieldName) {
                return this.formErrors.get(fieldName);
            }
        },
        mounted() {
            this.name = this.user.name;
            this.handle = this.user.handle;
        }
    }
</script>
