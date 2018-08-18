<template>
    <a class="button is-block" @click="openModal = true">
                    <span class="icon">
                      <i class="fa fa-plus-circle"></i>
                    </span>
        <span>Add To Shelf</span>
        <portal to="modals" v-if="openModal && isAuthenticated">
            <add-to-shelf-modal
                    :isVisible="openModal"
                    :book="book"
                    @close="openModal = false"
            >
            </add-to-shelf-modal>
        </portal>
        <portal to="modals" v-if="openModal && !isAuthenticated">
            <login-modal
                    :isVisible="openModal"
                    @close="openModal = false"
            >
            </login-modal>
        </portal>
    </a>
</template>

<script>
    import AddToShelfModal from '../modals/AddToShelfModal';
    import LoginModal from '../modals/LoginModal';

    export default {
        data() {
            return {
                openModal: false
            }
        },
        computed:{
            isAuthenticated() {
                return this.$store.getters['user/isAuthenticated'];
            },
        },
        props: ['book'],
        components: {AddToShelfModal, LoginModal}
    }
</script>



