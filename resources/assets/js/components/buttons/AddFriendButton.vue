<template>
    <a class="button" @click="addFriendModalOpen = true">
        Add Friend
        <portal to="modals" v-if="addFriendModalOpen">
            <friend-add-modal
                    :isVisible="addFriendModalOpen"
                    :friend="friend"
                    @close="addFriendModalOpen = false"
            >
            </friend-add-modal>
        </portal>
    </a>
</template>

<script>
    import FriendAddModal from '../modals/FriendAddModal'
    export default {
        data(){
            return {
                addFriendModalOpen : false
            }
        },
        props:['friend'],
        components:{FriendAddModal}
    }
</script>



