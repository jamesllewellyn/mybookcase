<template>
    <div class="field has-addons navbar-item has-dropdown" :class="{'is-active' : showSearchOptions}" v-on-clickaway="hideDropdown">
        <div class="control" :class="{'is-loading': isLoading}">
            <input class="input search is-boarderless is-shadowless" v-model="query" type="text" placeholder="Search for a friend" @keyup="asyncFind" @keyup.enter="search" @click.prevent="inFocus">
        </div>
        <div class="control">
            <a class="button is-primary" @click.prevent="search">
                Search
            </a>
        </div>
        <div class="navbar-dropdown search-dropdown">
            <div class="search-item level" v-for="(user, key) in friends" :key="key" @click.prevent="selected(user)">
                <div class="level-left">
                    <img class="avatar" :src="user.avatar_url" alt="">
                </div>
                <div class="level-right" >
                    <p class="has-text-weight-bold">{{ user.name }}</p>
                    <!--<p v-for="(author, index) in book.authors" :key="index">{{ author }}<span v-if="index != 0 && index == book.authors.length - 1">, </span></p>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import store from '../store';
    import Multiselect from 'vue-multiselect'
    import { mixin as clickaway } from 'vue-clickaway'

    export default {
        data() {
            return{
                query: null,
                selectedUser: null
            }
        },
        mixins: [ clickaway ],
        components: { Multiselect },
        computed:{
            friends () { return this.$store.getters.getFriendsSearchAsyncResults },
            isLoading(){return this.$store.getters.getIsLoadingOptions},
            lastAsyncTimeStamp(){return this.$store.getters.getLastAsyncSearchTime},
            showSearchOptions(){return this.$store.getters.showFriendsSearchOptions;}
        },
        methods:{
            limitText (count) {
                return `and ${count} other books`
            },
            inFocus() {
                if(!this.options){
                    return false
                }
                return this.$store.commit('showSearchOptions')
            },
            hideDropdown(){
                return this.$store.commit('hideSearchOptions')
            },
            asyncFind () {
//                if(this.query.length < 5){
//                    return false;
//                }
                return this.$store.dispatch('searchAsyncFindFriends', this.query)
            },
            selected(user){
                this.$store.commit('hideSearchOptions')
                Event.$emit('modalShowWithPayload', {name : 'friendAddModal' , payload : user})
            },
            clearAll () {
                this.selectedBook = null
            },
            search(query){
                this.$store.commit('hideSearchOptions')
                return this.$store.dispatch('searchGoodreads', this.urlEncoded(query))
            }
        },
        mounted() {
        }
    }
</script>
