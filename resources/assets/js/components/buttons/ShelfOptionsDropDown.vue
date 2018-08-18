<template>
    <drop-down-button :boarder="false">
        <template slot="dropdown-items">
            <a class="dropdown-item" @click="shelfUpdateModalOpen = true">
                Edit
                <portal to="modals" v-if="shelfUpdateModalOpen">
                    <shelf-update-modal
                            :user-id="userId"
                            :shelf="shelf"
                            :isVisible="shelfUpdateModalOpen"
                            @close="shelfUpdateModalOpen = false"
                    ></shelf-update-modal>
                </portal>
            </a>
            <a class="dropdown-item" @click="shelfDeleteModalOpen = true">
                Delete
                <portal to="modals" v-if="shelfDeleteModalOpen">
                    <shelf-delete-modal
                            :user-id="userId"
                            :shelf="shelf"
                            :isVisible="shelfDeleteModalOpen"
                            @close="shelfDeleteModalOpen = false"
                    ></shelf-delete-modal>
                </portal>
            </a>
        </template>
    </drop-down-button>
</template>
<script>
    import DropDownButton from '../bulma/DropDownButton.vue';
    import ShelfUpdateModal from '../modals/ShelfUpdateModal.vue';
    import ShelfDeleteModal from '../modals/ShelfDeleteModal.vue';

    export default {
        data() {
            return {
                shelfUpdateModalOpen: false,
                shelfDeleteModalOpen: false,
            }
        },
        components: {DropDownButton, ShelfUpdateModal, ShelfDeleteModal},
        props: ['shelf', 'userId']
    }
</script>
