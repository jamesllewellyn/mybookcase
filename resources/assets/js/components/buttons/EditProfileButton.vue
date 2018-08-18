<template>
    <a class="button" @click="editProfileModalOpen = true">
        Edit Profile
        <portal to="modals" v-if="editProfileModalOpen">
            <profile-update-modal
                    :isVisible="editProfileModalOpen"
                    :user="user"
                    @close="editProfileModalOpen = false"
            >
            </profile-update-modal>
        </portal>
    </a>
</template>

<script>
    import ProfileUpdateModal from '../modals/ProfileUpdateModal'
    export default {
        data(){
            return {
                editProfileModalOpen : false
            }
        },
        props:['user'],
        components:{ProfileUpdateModal}
    }
</script>



