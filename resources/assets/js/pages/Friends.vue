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
        <div class="tabs is-small">
            <ul>
                <router-link exact active-class="is-active" tag="li" :to="{name : 'friends'}" >
                    <a>Active<span class="tag is-light is-pulled-right" v-text="friendsCount.active" v-if="friendsCount">0</span></a>
                </router-link>
                <router-link exact  active-class="is-active" tag="li" :to="{name : 'friends-requests-pending'}" >
                    <a>Pending Requests<span class="tag is-small is-pulled-right" :class="{'is-danger' : friendsCount.pending > 0}" v-text="friendsCount.pending" v-if="friendsCount">0</span></a>
                </router-link>
                <router-link exact  active-class="is-active" tag="li" :to="{name : 'friends-requests-sent'}" >
                    <a>Request Sent<span class="tag is-light is-pulled-right" v-text="friendsCount.sent" v-if="friendsCount">0</span></a>
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
        computed: {
            friendsCount(){
                return this.$store.getters['friends/getCount'];
            },
        },
        methods: {
            getFriends(){
                return this.$store.dispatch('friends/get');
            }
        },
        created() {
            this.getFriends();
        }
    }
</script>
