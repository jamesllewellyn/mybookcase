<template>
    <modal title="Add Book To Shelf" :isVisible="isVisible" @close="hide">
        <template slot="body">
            <section class="modal-card-body">
                <multiselect v-model="selectedShelf" placeholder="Select a shelf to add this book to"
                             :options="shelves" track-by="name" label="name">
                </multiselect>
                <p class="help is-danger" v-text="errorMessage"></p>
            </section>
            <footer class="modal-card-foot">
                <a class="button is-success" :class="{'is-loading': isLoading}" @click="addToShelf()">Add To
                    Shelf</a>
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
                errorMessage: null
            }
        },
        components:{Modal},
        props: ['shelfId', 'userId', 'isVisible', 'book'],
        computed: {
            shelves() {
                return store.getters['bookcase/getShelves'];
            }
        },
        methods: {
            addToShelf() {
                let self = this;
                this.isLoading = true;
                this.errorMessage = null;
                this.$store.dispatch('bookcase/addBook', {shelfId: this.selectedShelf.id, isbn: this.book.isbn})
                    .then((response) => {
                        if(! response.data.success){
                            self.errorMessage = response.data.message;
                            self.isLoading = false;
                            return false
                        }
                        self.isLoading = false;
                        return self.$emit('close');
                    }, (error) => {
                        self.isLoading = false;
                        return false;
                    });
            },
            hide() {
                this.$emit('close');
            }
        }
    }
</script>
