<template>
    <drop-down-button :boarder="false" :direction="'is-right'" :icon="'fa-ellipsis-v'" :class="'is-pulled-right'">
        <template slot="dropdown-items">
            <!--<router-link :to="`/book/${isbn}?isbn=true`" class="dropdown-item" >-->
                <!--View-->
            <!--</router-link>-->
            <!--<a href="#" class="" >View</a >-->
            <router-link exact class="dropdown-item" href="#" active-class="is-active" tag="a"
                         :to="`/user/@${friend.handle}`">
                View
            </router-link>

            <a href="#" class="dropdown-item" @click.prevent="acceptFriendRequestModalOpen = true">
                Accept
                <portal to="modals" v-if="acceptFriendRequestModalOpen">
                    <friend-request-accept-modal
                            :is-visible="acceptFriendRequestModalOpen"
                            :friend="friend"
                            :request_id="request_id"
                            @close="acceptFriendRequestModalOpen = false"
                    ></friend-request-accept-modal>
                </portal>
            </a >
            <a href="#" class="dropdown-item" @click.prevent="declineFriendRequestModalOpen = true">
                Decline
                <portal to="modals" v-if="declineFriendRequestModalOpen">
                    <friend-request-decline-modal
                            :is-visible="declineFriendRequestModalOpen"
                            :friend="friend"
                            :request_id="request_id"
                            @close="declineFriendRequestModalOpen = false"
                    ></friend-request-decline-modal>
                </portal>
            </a >

            <!--<a class="dropdown-item" @click="bookMoveShelfModalOpen = true">-->
                <!--Move-->
                <!--<portal to="modals" v-if="bookMoveShelfModalOpen">-->
                    <!--<book-move-shelf-modal-->
                            <!--:shelf-id="shelfId"-->
                            <!--:user-id="userId"-->
                            <!--:is-visible="bookMoveShelfModalOpen"-->
                            <!--:isbn="isbn"-->
                            <!--@close="bookMoveShelfModalOpen = false"-->
                    <!--&gt;</book-move-shelf-modal>-->
                <!--</portal>-->
            <!--</a>-->
            <!--<a class="dropdown-item" @click="bookRemoveModalOpen = true">-->
                <!--Remove-->
                <!--<portal to="modals" v-if="bookRemoveModalOpen">-->
                    <!--<book-remove-modal-->
                            <!--:user-id="userId"-->
                            <!--:shelf-id="shelfId"-->
                            <!--:isbn="isbn"-->
                            <!--:isVisible="bookRemoveModalOpen"-->
                            <!--@close="bookRemoveModalOpen = false"-->
                    <!--&gt;</book-remove-modal>-->
                <!--</portal>-->
            <!--</a>-->
        </template>
    </drop-down-button>
</template>
<script>

    import DropDownButton from '../bulma/DropDownButton.vue';
    import FriendRequestAcceptModal from '../modals/FriendRequestAcceptModal';
    import FriendRequestDeclineModal from '../modals/FriendRequestDeclineModal';
    export default {
        data() {
            return {
                acceptFriendRequestModalOpen: false,
                declineFriendRequestModalOpen: false,
            }
        },
        components: {DropDownButton, FriendRequestAcceptModal, FriendRequestDeclineModal},
        props: ['friend', 'request_id'],
    }
</script>
