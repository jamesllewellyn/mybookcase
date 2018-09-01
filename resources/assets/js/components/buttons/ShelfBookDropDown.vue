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
                            :is-visible="bookMoveShelfModalOpen"
                            :isbn="isbn"
                            @close="bookMoveShelfModalOpen = false"
                    ></book-move-shelf-modal>
                </portal>
            </a>
            <toggle-read-menu-item :isbn="isbn" @readToggled="$emit('readToggled')"></toggle-read-menu-item>
            <hr class="dropdown-divider">
            <a class="dropdown-item is-danger" @click="bookRemoveModalOpen = true">
                Remove
                <portal to="modals" v-if="bookRemoveModalOpen">
                    <book-remove-modal
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
    import DropDownButton from '../bulma/DropDownButton';
    import BookMoveShelfModal from '../modals/BookMoveShelfModal';
    import BookRemoveModal from '../modals/BookRemoveModal';
    import ToggleReadMenuItem from './ToggleReadMenuItem';


    export default {
        data() {
            return {
                bookMoveShelfModalOpen: false,
                bookRemoveModalOpen: false,
            }
        },
        components: {DropDownButton, BookMoveShelfModal, BookRemoveModal, ToggleReadMenuItem},
        props: ['isbn', 'shelfId', 'read'],
    }
</script>
