<template>
    <div>
        <section class="modal-card-body">
            <div class="notification is-warning">
               You need to be logged in to add a book your shelf
            </div>
            <!--<div class="column is-4">-->
                <login-form :isModal="true"></login-form>
            <!--</div>-->
        </section>
        <footer class="modal-card-foot">
            <!--<a class="button is-success" :class="{'is-loading': modal.isLoading}" @click="updateUser()">Update</a>-->
            <!--<a class="button" @click="hide()">Cancel</a>-->
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
