<template>
    <modal title="Login" :isVisible="isVisible" @close="hide">
        <template slot="body">
            <section class="modal-card-body">
                <div class="notification is-warning">
                    You need to be logged in to add a book your shelf
                </div>
                <!--<div class="column is-4">-->
                <login-form :isModal="true"></login-form>
                <!--</div>-->
            </section>
            <!--<footer class="modal-card-foot">-->
                <!--&lt;!&ndash;<a class="button is-success" :class="{'is-loading': modal.isLoading}" @click="updateUser()">Update</a>&ndash;&gt;-->
                <!--&lt;!&ndash;<a class="button" @click="hide()">Cancel</a>&ndash;&gt;-->
            <!--</footer>-->
        </template>
    </modal>
</template>

<script>
    import store from '../../store';
    import Modal from '../../components/Modal.vue';
    import LoginForm from '../../components/LoginForm';

    export default {
        data() {
            return {
                isLoading: false,
            }
        },
        props: ['isVisible'],
        components: {Modal, LoginForm},
        computed: {},
        methods: {
            hide() {
                this.$emit('close');
            },
        }
    }
</script>
