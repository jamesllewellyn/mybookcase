<template>
    <div class="content friends-page">

        <div class="level">
            <div class="level-left">
                <h1 class="is-quicksans has-text-weight-semibold">
                    Friends
                </h1>
            </div>
            <div class="level-right">
                <friends-search></friends-search>
            </div>
        </div>
        <!--<a class="is-pulled-right align-vertical tooltip is-tooltip-right is-primary" data-tooltip="Invite Friend" @click.prevent="triggerEvent('modalShow', 'shelfAdd')"><i class="fa fa-plus-circle is-pulled-right align-vertical is-primary" aria-hidden="true"></i></a>-->
        <div class="tabs is-small">
            <ul>
                <router-link exact active-class="is-active" tag="li" :to="{name : 'friends'}" >
                    <a>Active<span class="tag is-light is-pulled-right" v-text="friends.active.length" v-if="friends.active">0</span></a>
                </router-link>
                <router-link exact  active-class="is-active" tag="li" :to="{name : 'friends-requests-pending'}" >
                    <a>Pending Requests<span class="tag is-small is-pulled-right" :class="{'is-danger' : friends.pending.length > 0}" v-text="friends.pending.length" v-if="friends.pending">0</span></a>
                </router-link>
                <router-link exact  active-class="is-active" tag="li" :to="{name : 'friends-requests-sent'}" >
                    <a>Request Sent<span class="tag is-light is-pulled-right" v-text="friends.sent.length" v-if="friends.sent">0</span></a>
                </router-link>
            </ul>
        </div>

        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    export default {
        data() {
            return{

            }
        },
        components:{},
        computed: {
            friends(){
                return this.$store.state.friends;
            },
        },
        methods: {
            getFriends(){
                return this.$store.dispatch('friendsGet');
            }
        },
        watch: {
        },
        created() {
            this.getFriends();
        }
    }
</script>
