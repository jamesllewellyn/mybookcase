<template>
    <a class="is-pulled-right align-vertical tooltip is-tooltip-right is-primary"
       data-tooltip="Add New Bookshelf" @click.prevent="shelfAddModalOpen = true"
    >
        <i class="fa fa-plus-circle is-pulled-right align-vertical is-primary icon is-small" aria-hidden="true"></i>
        <portal to="modals" v-if="shelfAddModalOpen">
            <shelf-add-modal
                :isVisible="shelfAddModalOpen"
                @close="shelfAddModalOpen = false"
            >
            </shelf-add-modal>
        </portal>

    </a>
</template>

<script>
    import ShelfAddModal from '../modals/ShelfAddModal.vue'
    export default {
        data(){
          return {
              shelfAddModalOpen : false
          }
        },
        components:{ShelfAddModal}
    }
</script>



