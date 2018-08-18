<template>
    <div class="field has-addons navbar-item has-dropdown is-fullwidth"
         :class="{'is-active' : showSearchOptions, 'is-marginless' : mobile}"
         v-on-clickaway="hideDropdown">

        <div class="control is-expanded" :class="{'is-loading': isSearching}">
            <input class="input search  is-shadowless is-fullwidth" :class="{'is-boarderless': !mobile, 'is-marginless' : mobile}" placeholder="Search for a book title" type="text"
                   v-model="query"
                    @keyup="isTyping"
                   @keyup.enter="search"
                   @click.prevent="showDropdown()"
            >
        </div>
        <div class="control">
            <a class="button is-primary" @click.prevent="search">
                Search
            </a>
        </div>
        <div class="navbar-dropdown search-dropdown is-hidden-touch" v-on-clickaway="hideDropdown">
            <div class="search-item" v-for="(book, key) in options" :key="key"  @click.prevent="hideDropdown">
                <router-link :to="`/book/${book.isbn}?isbn=true`" class="has-text-left" tag="div">
                    <p class=" has-text-weight-bold">{{ book.title }}</p>
                    <p v-for="(author, index) in book.authors" :key="index">{{ author }}<span v-if="index !== 0 && index === book.authors.length - 1">, </span></p>
                </router-link>

            </div>
        </div>
    </div>
</template>

<script>
    import {mixin as clickaway} from 'vue-clickaway'

    export default {
        data() {
            return {
                query: null,
                selectedBook: null,
                typingTimer: null,
                doneTypingInterval: 1000,
                isSearching: false,
                options: [],
                showSearchOptions: false
            }
        },
        props:{
          mobile:{
              type: Boolean,
              default: false,
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
                let self = this;
                if(!this.query){
                    return false;
                }
                this.isSearching = true;
                axios.get(`/api/isbndb?search=${this.query}`)
                    .then((response) => {
                        self.options = response.data.data;
                        self.isSearching = false;
                        self.showDropdown();
                    }, (error) => {
                        self.isSearching = false;
                        console.log(response);
                    });
            },
            urlEncoded() {
                return _.replace(this.query, ' ', "+");
            },
            limitText(count) {
                return `and ${count} other books`
            },
            showDropdown() {
                console.log('showDropdown');
                console.log(this.options.length);
                if(this.options.length > 0){
                    console.log(this.showSearchOptions);
                    this.showSearchOptions = true;
                    console.log(this.showSearchOptions);
                }
            },
            hideDropdown() {
                 this.showSearchOptions = false;
            },
            search() {
                clearTimeout(this.typingTimer);
                if(!this.query){
                    return false
                }
                this.$emit('searching');
                this.hideDropdown();
                return Event.$emit('changePage', `/search?query=${this.urlEncoded()}`);
            }
        }
    }
</script>
