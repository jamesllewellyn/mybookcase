<template>
    <modal title="Remove Book From Shelf" :isVisible="isVisible" @close="hide">
        <template slot="body">
            <section class="modal-card-body">
                <p>Are you sure you want to remove this book?</p>
            </section>
            <footer class="modal-card-foot">
                <a class="button is-success" :class="{'is-loading': isLoading}" @click="removeBook()">Remove Book</a>
                <a class="button" @click="hide()">Cancel</a>
            </footer>
        </template>
    </modal>
</template>

<script>
    import store from '../../store';
    import Modal from '../../components/Modal.vue';

    export default {
        data() {
            return {
                isLoading: false,
                name: null,
                selectedShelf: null,
            }
        },
        components: {Modal},
        props: ['shelfId', 'userId', 'isVisible', 'isbn'],
        methods: {
            removeBook() {
                let self = this;
                /** set modal save button to loading status **/
                this.isLoading = true;
                this.$store.dispatch('bookcase/removeBook', {shelfId: this.shelfId, isbn: this.isbn})
                    .then((response) => {
                        self.isLoading = false;
                        Event.$emit('shelf.book.remove', response.data.book.isbn);
                        self.hide('close');
                    }, (error) => {
                        return self.isLoading = false;
                    });
            },
            hide() {
                this.$emit('close');
            }
        }
    }
</script>
