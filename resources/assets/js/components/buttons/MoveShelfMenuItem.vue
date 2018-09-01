<template>
    <a class="dropdown-item" @click="bookMoveShelfModalOpen = true">
        Move To Another Shelf
        <portal to="modals" v-if="bookMoveShelfModalOpen">
            <book-move-shelf-modal
                    :shelf-id="shelfId"
                    :is-visible="bookMoveShelfModalOpen"
                    :isbn="isbn"
                    @close="bookMoveShelfModalOpen = false"
            ></book-move-shelf-modal>
        </portal>
    </a>
</template>

<script>
    import BookMoveShelfModal from '../modals/BookMoveShelfModal';

    export default {
        data() {
            return {
                bookMoveShelfModalOpen: false
            }
        },
        props: ['isbn', 'shelfId'],
        components: {BookMoveShelfModal}
    }
</script>



