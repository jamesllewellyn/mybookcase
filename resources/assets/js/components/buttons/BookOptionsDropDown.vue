<template>
    <drop-down-button :boarder="true" :transparent="false" direction="is-left" icon="fa-angle-down">
        <slot></slot>
        <template slot="dropdown-items">
            <add-book-to-shelf-menu-item :isbn="isbn"></add-book-to-shelf-menu-item>
            <toggle-read-menu-item :isbn="isbn" @readToggled="$emit('readToggled')"></toggle-read-menu-item>
            <toggle-reading-menu-item :isbn="isbn" @readingToggled="$emit('readingToggled')"></toggle-reading-menu-item>
        </template>
    </drop-down-button>
</template>
<script>
    import DropDownButton from '../bulma/DropDownButton';
    import ToggleReadMenuItem from './ToggleReadMenuItem';
    import ToggleReadingMenuItem from './ToggleReadingMenuItem';
    import AddBookToShelfMenuItem from './AddBookToShelfMenuItem';

    export default {
        data() {
            return {
                bookMoveShelfModalOpen: false,
                bookRemoveModalOpen: false,
            }
        },
        components: {
            DropDownButton,
            ToggleReadMenuItem,
            ToggleReadingMenuItem,
            AddBookToShelfMenuItem,
        },
        props: ['isbn'],
    }
</script>
