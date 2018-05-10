<template>
    <div class="column is-half">
        <router-link exact class="card friend is-pointer" active-class="is-active" tag="div" :to="`/user/@${handle}`" v-if="handle">
            <div class="card-content">
                <div class="columns">
                    <div class="column is-one-third">
                        <!--<p class="image is-100x100 has-text-centered">-->
                        <img class="image avatar" :src="avatar_url" alt="" v-if="avatar_url">
                        <!--</p>-->
                    </div>
                    <div class="column is-two-thirds">
                        <button class="delete is-pulled-right" @click.prevent="deleteRequestAreYoSure" v-if="type == 'sent'"></button>
                        <div class="content">
                            <p class="book-title has-text-weight-bold" v-if="name">{{name}}</p><br>
                            <p class="author" v-if="handle">@{{handle}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="card-footer" v-if="type == 'pending'">
                <a href="#" class="card-footer-item" @click.prevent="accept">Accept</a >
                <router-link exact class="card-footer-item" href="#" active-class="is-active" tag="a" :to="`/user/@${handle}`">View</router-link>
                <a href="#" class="card-footer-item">Decline</a>
            </footer>
        </router-link>
        <div class="card friend" v-if="placeholder">
            <div class="card-content">
                <div class="columns">
                    <div class="column is-one-third">
                        <img class="image avatar is-placeholder-avatar">
                            <!--<img src="https://bulma.io/images/placeholders/128x128.png">-->
                        </img>
                        <!--<p class="image is-100x100 has-text-centered">-->
                        <!--<img class="image  is-100x100" alt="">-->
                        <!--</p>-->
                    </div>
                    <div class="column is-two-thirds">
                        <!--<button class="delete is-pulled-right" @click.prevent="deleteRequestAreYoSure" v-if="type == 'sent'"></button>-->
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
    import store from '../store';
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
        computed: {
        },
        methods:{
            accept(){
                if(this.type !== 'pending' ){
                    return false
                }
                let shelf = this
                Event.$emit('modalShowWithPayload', {name : 'friendAcceptModal' , payload : {
                    'id' : shelf.id,
                    'name' : shelf.name,
                    'avatar_url' : shelf.avatar_url,
                    'handle' : shelf.handle,
                }})
            },
            deleteRequestAreYoSure(){
                if(this.type !== 'sent' ){
                    return false
                }
                Event.$emit('showAreYouSure', 'rescind this friend request', `friend-request.${this.request_id}.delete`);
            },
            deleteRequest(){
                if(this.type !== 'sent' ){
                    return false
                }
                return store.dispatch('friendRequestDelete', this.request_id);
//                Event.$emit('showAreYouSure', 'rescind this friend request', `friend-request.${id}.delete`);
            }
        },
        mounted() {
            let self = this
            /** listen for friend request delete event **/
            Event.$on('friend-request.' + this.request_id + '.delete', function () {
                self.deleteRequest();
            });
        }
    }
</script>
