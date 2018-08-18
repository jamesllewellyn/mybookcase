<template>
    <modal title="Move Book To Another Shelf" :isVisible="isVisible" @close="hide">
        <template slot="body">
            <section class="modal-card-body">
                <multiselect v-model="selectedShelf" placeholder="Select a shelf to move this book to"
                             :options="shelves" track-by="name" label="name">
                </multiselect>
            </section>
            <footer class="modal-card-foot">
                <a class="button is-success" :class="{'is-loading': isLoading}" @click="moveToShelf()">Move To
                    Shelf</a>
                <a class="button" @click="hide()">Cancel</a>
            </footer>
        </template>
    </modal>
</template>

<script>
    import Modal from '../../components/Modal.vue';

    export default {
        data() {
            return {
                isLoading: false,
                name: null,
                selectedShelf: null,
            }
        },
        components:{Modal},
        props: ['shelfId', 'userId', 'isVisible', 'isbn'],
        computed: {
            shelves() {
                return this.$store.getters['bookcase/getShelves'];
            }
        },
        methods: {
            moveToShelf() {
                let self = this;
                this.isLoading = true;
                this.$store.dispatch('bookcase/moveBook', {currentShelfId : this.shelfId, isbn : this.isbn , newShelfId : this.selectedShelf.id})
                    .then((response) => {
                        self.isLoading = false;
                        Event.$emit('shelf.book.remove', response.data.book.isbn);
                        return self.hide();
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
