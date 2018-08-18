<template>
    <modal title="Delete Shelf" :isVisible="isVisible" @close="hide">
        <template slot="body">
            <section class="modal-card-body">
                <p>Do you really want to delete shelf <span class="has-text-weight-bold">{{shelf.name}}</span>?</p>
            </section>
            <footer class="modal-card-foot">
                <a class="button is-success" :class="{'is-loading': isLoading}" @click="deleteShelf()">Yes Delete Shelf</a>
                <a class="button" @click="hide()">Cancel</a>
            </footer>
        </template>
    </modal>
</template>

<script>
    import Modal from '../Modal.vue';
    import Errors from '../../core/Errors';
    import store from '../../store';

    export default {
        data() {
            return {
                isLoading: false,
            }
        },
        props: ['isVisible', 'shelf', 'userId'],
        components: {Modal},
        methods: {
            deleteShelf() {
                let self = this;
                this.isLoading = true;
                this.$store.dispatch('bookcase/removeShelf', this.shelf.id)
                    .then((response) => {
                        self.isLoading = false;
                        self.hide();
                        return Event.$emit('changePage', '/dashboard/');
                    }, (error) => {
                        return self.isLoading = false;
                    });
            },
            hide() {
                this.isLoading = false;
                this.$emit('close');
            }
        },
    }
</script>
