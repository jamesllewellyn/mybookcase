<template>
    <div class="content">
        <h1 class="is-quicksans has-text-weight-semibold">Search Results</h1>
        <transition name="fade" mode="out-in">
            <div class="search-results" v-if="!isSearching">
                <div class="columns is-multiline" :class="{'is-loading' : isSearching}" v-if="searchResults">

                    <book-in-list v-for="(book, index) in searchResults.data" :key="index"  :isbn="book.isbn" :title="book.title">
                        <img slot="cover"  class="image cover" :src="book.image" v-if="book.image">
                        <!--<template slot="title">{{book.title}}</template>-->
                        <template slot="authors">{{book.authors}}</template>
                        <template slot="drop-down">
                            <search-book-drop-down :isbn="book.isbn" :book="book">
                            </search-book-drop-down>
                        </template>
                    </book-in-list>
                    <nav class="pagination column is-full" role="navigation" aria-label="pagination" v-if="searchResults.totalResults > 9">
                        <a class="pagination-next button is-pulled-right"
                           @click.prevent="search(searchResults.currentPage + 1)">Next page</a>
                        <a class="pagination-previous button is-pulled-right" :disabled="searchResults.currentPage === 1"
                           @click.prevent="search(searchResults.currentPage - 1)">Previous</a>
                    </nav>
                </div>
                <div class="notification is-primary"  v-else>
                    <strong>Sorry</strong>, it doesn't look like we can find any results for that search
                </div>
            </div>
            <div class="vue-simple-spinner-wrap is-fullheight" v-if="isSearching">
                <vue-simple-spinner size="75" :line-size=6 line-fg-color="#2d2b4a"></vue-simple-spinner>
            </div>
        </transition>
    </div>
</template>

<script>
    import VueSimpleSpinner from 'vue-simple-spinner';
    import BookInList from  '../../components/BookInList';
    import SearchBookDropDown from  '../../components/buttons/SearchBookDropDown';
    export default {
        data() {
            return {
                query : null,
                searchResults : [],
                isSearching : false
            }
        },
        components:{BookInList, VueSimpleSpinner, SearchBookDropDown},
        computed:{
            queryString() {
                if (!this.$route.query.query) {
                    return false;
                }
                return  this.$route.query.query;
            },
        },
        methods: {
            search(page) {
                let self = this;
                this.isSearching = true;
                axios.get(`/api/isbndb?search=${this.query}&page=${page}`)
                    .then((response) => {
                        self.isSearching = false;
                        self.searchResults = response.data;
                        self.$route.query.query = self.query;
                    }, (error) => {
                        console.log(error);
                    });
            },
        },
        watch:{
            queryString(){
                if(this.queryString){
                    this.query = this.queryString;
                    this.search(1);
                }
            }
        },
        created() {
            if (this.$route.query.query) {
                this.query = this.$route.query.query;
                this.search(1);
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
