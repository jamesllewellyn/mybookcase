<template>
    <drop-down-button :boarder="false" :direction="'is-right'" :icon="'fa-ellipsis-v'" :class="'is-pulled-right'">
        <template slot="dropdown-items">
            <router-link :to="`/book/${isbn}?isbn=true`" class="dropdown-item">
                View
            </router-link>
            <move-shelf-menu-item :isbn="isbn" :shelf-id="shelfId" v-if="shelfId"></move-shelf-menu-item>
            <add-book-to-shelf-menu-item :isbn="isbn" v-if="!shelfId"></add-book-to-shelf-menu-item>
            <toggle-read-menu-item :isbn="isbn" @readToggled="$emit('readToggled')"></toggle-read-menu-item>
            <toggle-reading-menu-item :isbn="isbn" @readingToggled="$emit('readingToggled')"></toggle-reading-menu-item>
            <hr class="dropdown-divider" v-if="shelfId">
            <a class="dropdown-item is-danger" @click="bookRemoveModalOpen = true" v-if="shelfId">
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
    import ToggleReadingMenuItem from './ToggleReadingMenuItem';
    import AddBookToShelfMenuItem from './AddBookToShelfMenuItem';
    import MoveShelfMenuItem from './MoveShelfMenuItem';

    export default {
        data() {
            return {
                bookMoveShelfModalOpen: false,
                bookRemoveModalOpen: false,
            }
        },
        components: {
            DropDownButton,
            BookMoveShelfModal,
            BookRemoveModal,
            ToggleReadMenuItem,
            ToggleReadingMenuItem,
            AddBookToShelfMenuItem,
            MoveShelfMenuItem
        },
        props: ['isbn', 'shelfId'],
    }
</script>
