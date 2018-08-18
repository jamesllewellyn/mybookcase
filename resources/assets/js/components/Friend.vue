<template>
    <div class="column is-half">

        <div class="card friend " active-class="is-active" v-if="handle">
            <div class="card-content">
                <div class="columns">
                    <router-link exact class="column is-one-third is-pointer" tag="div" :to="`/user/@${handle}`">
                        <img class="image avatar" :src="avatar_url" alt="" v-if="avatar_url">
                    </router-link>
                    <div class="column is-two-thirds">
                        <friend-request-rescind-button
                                v-if="type === 'sent'"
                                :friend="friend"
                                :request_id="request_id"
                        ></friend-request-rescind-button>
                        <friend-request-drop-down
                                v-if="type === 'pending'"
                                :friend="friend"
                                :request_id="request_id"
                                >
                        </friend-request-drop-down>
                        <div class="content">
                            <p class="book-title has-text-weight-bold" v-if="name">{{name}}</p><br>
                            <p class="author" v-if="handle">@{{handle}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card friend" v-if="placeholder">
            <div class="card-content">
                <div class="columns">
                    <div class="column is-one-third">
                        <img class="image avatar is-placeholder-avatar">
                    </div>
                    <div class="column is-two-thirds">
                        <div class="content">
                            <progress class="progress is-width-90" value="0" max="100"></progress>
                            <progress class="progress is-width-30" value="0" max="100"></progress>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FriendRequestRescindButton from '../components/buttons/FriendRequestRescindButton';
    import FriendRequestDropDown from '../components/buttons/FriendRequestDropDown';

    export default {
        props: {
            id: {
                required: false,
            },
            request_id: {
                required: false,
            },
            name: {
                required: false,
            },
            handle: {
                required: false
            },
            avatar_url: {
                required: false
            },
            type: {
                required: false
            },
            placeholder:{
                required: false
            }
        },
        components:{FriendRequestRescindButton, FriendRequestDropDown},
        methods:{

        },
        computed:{
          friend(){
              return {id : this.id, name : this.name, handle: this.handle, avatar_url : this.avatar_url};
          }
        },
        mounted() {
            let self = this;
            /** listen for friend request delete event **/
            Event.$on('friend-request.' + this.request_id + '.delete', function () {
                self.deleteRequest();
            });
        }
    }
</script>
