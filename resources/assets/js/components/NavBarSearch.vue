<template>
    <div class="field has-addons navbar-item has-dropdown" :class="{'is-active' : showSearchOptions}"
         v-on-clickaway="hideDropdown" @click="showDropdown()">
        <div class="control" :class="{'is-loading': isSearching}">
            <input class="input search is-boarderless is-shadowless" v-model="query" type="text"
                   placeholder="Search for a book title or an author" @keyup="isTyping" @keyup.enter="search">
        </div>
        <div class="control">
            <a class="button is-primary" @click.prevent="search">
                Search
            </a>
        </div>
        <div class="navbar-dropdown search-dropdown" v-on-clickaway="hideDropdown">
            <div class="search-item" v-for="(book, key) in options" :key="key">
                <div class="has-text-left" @click="selected(book)">
                    <p class=" has-text-weight-bold">{{ book.title }}</p>
                    <p v-for="(author, index) in book.authors" :key="index">{{ author }}<span
                            v-if="index != 0 && index == book.authors.length - 1">, </span></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import store from '../store';
    import {mixin as clickaway} from 'vue-clickaway'

    export default {
        data() {
            return {
                query: null,
                selectedBook: null,
                typingTimer: null,
                doneTypingInterval: 1000,
                isSearching: false,
                options: null,
                showSearchOptions: false
            }
        },
        mixins: [clickaway],
        computed: {
            queryUrlEncoded() {
                return _.replace(this.query, ' ', "+");
            },
        },
        methods: {
            isTyping() {
                clearTimeout(this.typingTimer);
                return this.typingTimer = setTimeout(this.pausedTyping, this.doneTypingInterval);
            },
            pausedTyping() {
                this.isSearching = true
                axios.get(`/api/goodreads?search=${this.query}`)
                    .then((response) => {
                        this.options = response.data.searchResults;
                        this.isSearching = false
                        this.showDropdown()
                    }, (error) => {
                        console.log(response);
                    });
            },
            findIsbn(identifiers) {
                let index = _.findIndex(identifiers, ['type', 'ISBN_10']);
                if (!index < 0) {
                    return false;
                }
                return identifiers[index].identifier;
            },
            urlEncoded() {
                return _.replace(this.query, ' ', "+");
            },
            limitText(count) {
                return `and ${count} other books`
            },
            showDropdown() {
                this.showSearchOptions = true
            },
            hideDropdown() {
                return this.showSearchOptions = false
            },
            selected(book) {
                this.hideDropdown()
                Event.$emit('changePage', '/book/' + book.goodreads_id)
            },
            clearAll() {
                this.selectedBook = null
            },
            search(query) {
                clearTimeout(this.typingTimer)
                this.hideDropdown()
                return this.$store.dispatch('searchGoodreads', this.urlEncoded(query))
            }
        }
    }
</script>
