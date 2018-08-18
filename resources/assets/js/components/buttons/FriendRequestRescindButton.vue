<template>
    <button class="delete is-pulled-right" @click="rescindFriendRequestModalOpen = true">
        <portal to="modals" v-if="rescindFriendRequestModalOpen">
            <rescind-friend-request-modal
                    :isVisible="rescindFriendRequestModalOpen"
                    :friend="friend"
                    :request_id="request_id"
                    @close="rescindFriendRequestModalOpen = false"
            >
            </rescind-friend-request-modal>
        </portal>
    </button>
</template>

<script>
    import RescindFriendRequestModal from '../modals/RescindFriendRequestModal'
    export default {
        data(){
            return {
                rescindFriendRequestModalOpen : false
            }
        },
        props:['friend', 'request_id'],
        components:{RescindFriendRequestModal}
    }
</script>



