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
                            :book="book"
                            @close="addToShelfModelOpen = false"
                    >
                    </add-to-shelf-modal>
                </portal>
            </a>
        </template>
    </drop-down-button>
</template>
<script>
    import DropDownButton from '../bulma/DropDownButton.vue';
    import AddToShelfModal from '../modals/AddToShelfModal.vue';

    export default {
        data() {
            return {
                addToShelfModelOpen: false,
            }
        },
        components: {DropDownButton, AddToShelfModal},
        props: ['isbn', 'book', 'userId']
    }
</script>
