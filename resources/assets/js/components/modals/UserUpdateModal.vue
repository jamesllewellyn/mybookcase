<template>
    <div>
        <section class="modal-card-body">
            <form>
                <div class="field">
                    <label class="label">Name</label>
                    <p class="control">
                        <input class="input" type="text" name="name" placeholder="Please enter your name"
                               v-model="user.name">
                    </p>
                    <p class="help is-danger" v-text="getErrors('name')"></p>
                </div>
                <div class="field">
                    <label class="label">Handle</label>
                    <p class="control has-icons-left">
                        <input class="input" type="text" name="handle" placeholder="Please enter a handle"
                               v-model="user.handle">
                        <span class="icon is-small is-left">
                          @
                        </span>
                    </p>

                    <p class="is-size-6">
                        <small>Your handle will be displayed along with any messages in My Bookcase. Changing your
                            handle will also change your application avatar
                        </small>
                    </p>
                    <p class="help is-danger" v-text="getErrors('handle')"></p>
                </div>
            </form>
        </section>
        <footer class="modal-card-foot">
            <a class="button is-success" :class="{'is-loading': modal.isLoading}" @click="updateUser()">Update</a>
            <a class="button" @click="hide()">Cancel</a>
        </footer>
    </div>
</template>

<script>
    import store from '../../store';

    export default {
        data() {
            return {
                modalName: 'userUpdateModal',
                user : this.$store.getters.getUser
            }
        },
        computed: {
            modal() {
                return store.getters.getModalByName(this.modalName);
            }
        },
        methods: {
            updateUser() {
                /** set modal save button to loading status **/
                this.modal.loading();
                /** dispatch add new project action **/
                store.dispatch('userUpdate', {name : this.user.name, email : this.user.email, handle : this.user.handle});
            },
            hide() {
                this.modal.hide();
            },
            /** method to get form field errors **/
            getErrors(fieldName) {
                return store.getters.getFormErrors(fieldName);
            }
        }
    }
</script>
