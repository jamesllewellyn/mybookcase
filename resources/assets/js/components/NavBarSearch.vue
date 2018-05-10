<template>
    <div class="field has-addons navbar-item has-dropdown" :class="{'is-active' : showSearchOptions}" v-on-clickaway="hideDropdown">
        <div class="control" :class="{'is-loading': isLoading}">
            <input class="input search is-boarderless is-shadowless" v-model="query" type="text" placeholder="Search for a book title or an author" @keyup="asyncFind" @keyup.enter="search" @click.prevent="inFocus">
        </div>
        <div class="control">
            <a class="button is-primary" @click.prevent="search">
                Search
            </a>
        </div>
        <div class="navbar-dropdown search-dropdown">
            <div class="search-item" v-for="(book, key) in options" :key="key">
                <div class="has-text-left"  @click="selected(book)">
                    <p class=" has-text-weight-bold">{{ book.title }}</p>
                    <p v-for="(author, index) in book.authors" :key="index">{{ author }}<span v-if="index != 0 && index == book.authors.length - 1">, </span></p>
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
                selectedBook: null
            }
        },
        mixins: [ clickaway ],
        components: { Multiselect },
        computed:{
            queryUrlEncoded(){
                return _.replace(this.query, ' ', "+");
            },
            options () { return this.$store.getters.getSearchAsyncResults },
            isLoading(){return this.$store.getters.getIsLoadingOptions},
            lastAsyncTimeStamp(){return this.$store.getters.getLastAsyncSearchTime},
            showSearchOptions(){return this.$store.getters.showSearchOptions}
        },
        methods:{
            findIsbn(identifiers){
                let index = _.findIndex(identifiers, ['type' , 'ISBN_10']);
                if(!index < 0 ){
                    return false;
                }
                return identifiers[index].identifier;
            },
            urlEncoded(){
                return _.replace(this.query, ' ', "+");
            },
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
                if(this.query.length < 5){
                    return false;
                }
                if(_.now() - this.lastAsyncTimeStamp < 2000){
                    return false;
                }
                return this.$store.dispatch('searchAsyncFind', this.urlEncoded())
            },
            selected(book){
                this.$store.commit('hideSearchOptions')
                Event.$emit('changePage', '/book/'+book.goodreads_id)
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
