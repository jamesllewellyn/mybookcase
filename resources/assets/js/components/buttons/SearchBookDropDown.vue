<template>
    <drop-down-button :boarder="false" :direction="'is-right'" :icon="'fa-ellipsis-v'" :class="'is-pulled-right'">
        <template slot="dropdown-items">
            <router-link :to="`/book/${isbn}?isbn=true`" class="dropdown-item" >
                View
            </router-link>
            <a class="dropdown-item" @click="addToShelfModelOpen = true">
                Add To Shelf
                <portal to="modals" v-if="addToShelfModelOpen">
                    <add-to-shelf-modal
                            :isVisible="addToShelfModelOpen"
                            :isbn="isbn"
                            @close="addToShelfModelOpen = false"
                    >
                    </add-to-shelf-modal>
                </portal>
            </a>
            <toggle-read-menu-item :isbn="isbn"></toggle-read-menu-item>
            <toggle-reading-menu-item :isbn="isbn"></toggle-reading-menu-item>
        </template>
    </drop-down-button>
</template>
<script>
    import DropDownButton from '../bulma/DropDownButton';
    import AddToShelfModal from '../modals/AddToShelfModal';
    import ToggleReadMenuItem from './ToggleReadMenuItem';
    import ToggleReadingMenuItem from './ToggleReadingMenuItem';

    export default {
        data() {
            return {
                addToShelfModelOpen: false,
            }
        },
        components: {DropDownButton, AddToShelfModal, ToggleReadMenuItem, ToggleReadingMenuItem},
        props: ['isbn', 'book', 'userId']
    }
</script>
