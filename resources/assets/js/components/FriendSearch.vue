<template>
    <div class="field has-addons navbar-item has-dropdown" :class="{'is-active' : showSearchOptions}" v-on-clickaway="hideDropdown">
        <div class="control" :class="{'is-loading': isSearching}">
            <input class="input search is-boarderless is-shadowless"  type="text" placeholder="Search for a friend"
                   v-model="query"
                   @keyup="isTyping()"
                   @keyup.enter="search()"
                   @click.prevent="inFocus()">
        </div>
        <div class="control">
            <a class="button is-primary" @click.prevent="search()">
                Search
            </a>
        </div>
        <div class="navbar-dropdown search-dropdown">
            <router-link tag="div"  class="search-item level" v-for="(user, key) in searchResults" :key="key" :to="`/user/@${user.handle}`">
                <div class="level-left">
                    <img class="avatar" :src="user.avatar_url" alt="">
                </div>
                <div class="level-right" >
                    <p class="has-text-weight-bold">{{ user.name }}</p>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
    import { mixin as clickaway } from 'vue-clickaway'

    export default {
        data() {
            return{
                query: null,
                selectedUser: null,
                searchResults: null,
                isSearching : false,
                showSearchOptions : false,
                typingTimer: null,
                doneTypingInterval: 1000,
            }
        },
        mixins: [ clickaway ],
        methods:{
            inFocus() {
                if(!this.searchResults){
                    return false
                }
                return this.showSearchOptions = true;
            },
            hideDropdown(){
                return this.showSearchOptions = false;
            },
            isTyping() {
                clearTimeout(this.typingTimer);
                return this.typingTimer = setTimeout(this.pausedTyping, this.doneTypingInterval);
            },
            pausedTyping() {
                let self = this;

                if(!this.query){
                    return false;
                }

                this.isSearching = true;

                axios.get(`/api/friends-find?search=${this.query}`)
                    .then((response) => {
                        self.searchResults = response.data.users;
                        self.showSearchOptions = true;
                        self.isSearching = false;
                    }, (error) => {
                        console.log(error);
                    });
            },
            // selected(user){
            //     this.hideDropdown();
            //     // Event.$emit('modalShowWithPayload', {name : 'friendAddModal' , payload : user})
            // },
            search(query){
                this.hideDropdown();
                clearTimeout(this.typingTimer);
                if(!this.query){
                    return false
                }
                this.hideDropdown();
                return Event.$emit('changePage', `/friends/search?query=${this.urlEncoded()}`);
            },
            urlEncoded() {
                return _.replace(this.query, ' ', "+");
            },
        },
    }
</script>
