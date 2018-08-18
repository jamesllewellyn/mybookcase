<template>
    <drop-down-button :boarder="false" :direction="'is-right'" :icon="'fa-ellipsis-v'" :class="'is-pulled-right'">
        <template slot="dropdown-items">
            <router-link :to="`/book/${isbn}?isbn=true`" class="dropdown-item" >
                View
            </router-link>
            <a class="dropdown-item" @click="bookMoveShelfModalOpen = true">
                Move
                <portal to="modals" v-if="bookMoveShelfModalOpen">
                    <book-move-shelf-modal
                            :shelf-id="shelfId"
                            :user-id="userId"
                            :is-visible="bookMoveShelfModalOpen"
                            :isbn="isbn"
                            @close="bookMoveShelfModalOpen = false"
                    ></book-move-shelf-modal>
                    <!--<modal modal-name="bookMoveShelf" title="Move To Another Shelf">-->
                        <!--<template slot="body">-->
                            <!--<book-move-shelf-modal></book-move-shelf-modal>-->
                        <!--</template>-->
                    <!--</modal>-->
                    <!--<shelf-update-modal-->
                            <!--:user-id="userId"-->
                            <!--:shelf="shelf"-->
                            <!--:isVisible="shelfUpdateModalOpen"-->
                            <!--@close="shelfUpdateModalOpen = false"-->
                    <!--&gt;</shelf-update-modal>-->
                </portal>
            </a>
            <a class="dropdown-item" @click="bookRemoveModalOpen = true">
                Remove
                <portal to="modals" v-if="bookRemoveModalOpen">
                    <book-remove-modal
                            :user-id="userId"
                            :shelf-id="shelfId"
                            :isbn="isbn"
                            :isVisible="bookRemoveModalOpen"
                            @close="bookRemoveModalOpen = false"
                    ></book-remove-modal>
                </portal>
            </a>
        </template>
    </drop-down-button>
</template>
<script>
    import DropDownButton from '../bulma/DropDownButton.vue';
    import BookMoveShelfModal from '../modals/BookMoveShelfModal.vue';
    import BookRemoveModal from '../modals/BookRemoveModal.vue';


    export default {
        data() {
            return {
                bookMoveShelfModalOpen: false,
                bookRemoveModalOpen: false,
            }
        },
        components: {DropDownButton, BookMoveShelfModal, BookRemoveModal},
        props: ['isbn', 'shelfId', 'userId']
    }
</script>
