<template>
    <a class="dropdown-item" @click="openModal = true">
        <span>Add To Shelf</span>

        <portal to="modals" v-if="openModal && isAuthenticated">
            <add-to-shelf-modal
                    :isVisible="openModal"
                    :isbn="isbn"
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
        props: ['isbn'],
        components: {AddToShelfModal, LoginModal}
    }
</script>



