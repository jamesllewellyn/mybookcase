<template>
    <div class="shelf" ref="top">
        <transition name="fade" mode="out-in">
            <div class="content" v-if="! isLoading">
                <div class="level">
                    <div class="level-left">
                        <drop-down-button :boarder="false"
                                          :dropdowns="[{text : 'Edit', event: { name : 'modalShow', payload : 'shelfUpdate'}, action: 'update project', areYouSure : false},{text : 'Delete', event: { name : 'shelf.'+id+'.delete', payload : null}, action: 'delete this shelf', areYouSure : true}]"></drop-down-button>
                        <h1 class="is-quicksans has-text-weight-semibold" v-if="shelf">{{shelf.name}}</h1>
                    </div>
                    <div class="level-right">
                        <span class="tag" :class="shelf.public ? 'is-success' : 'is-danger'"
                              v-text="shelf.public ? 'Public' : 'Private'">
                        </span>
                    </div>
                </div>
                <div class="columns is-multiline">
                    <google-book v-for="(book, index) in books" :key="index"
                                 :title="book.title"
                                 :cover_url="book.small_cover_url"
                                 :authors="book.authors"
                                 :identifiers="book.identifiers">
                    </google-book>
                    <google-book :placeholder="true" v-if="books.length == 0">
                    </google-book>

                </div>

                <nav class="pagination" role="navigation" aria-label="pagination" v-if="totalPages > 1">
                    <ul class="pagination-list"></ul>
                    <a class="pagination-previous button is-right" :disabled="currentPage == 1"
                       @click.prevent="getBooks(currentPage - 1)">Previous</a>
                    <a class="pagination-next button is-right" :disabled="currentPage >= totalPages"
                       @click.prevent="getBooks(currentPage + 1)">Next page</a>
                </nav>

            </div>
        </transition>
        <div class="vue-simple-spinner-wrap is-fullheight" v-if="isLoading">
            <vue-simple-spinner size="75" :line-size=6 line-fg-color="#2d2b4a"></vue-simple-spinner>
        </div>
    </div>
</template>

<script>
    import VueSimpleSpinner from 'vue-simple-spinner'

    export default {
        data() {
            return {
                books: [],
                totalPages: 1,
                currentPage: 1,
                totalBooks: 0,
                isLoading: true
            }
        },
        components: {VueSimpleSpinner},
        computed: {
            id: function () {
                if (!this.$route.params.id) {
                    return false;
                }
                return this.$route.params.id;
            },
            shelf() {
                return this.$store.getters.getShelf
            },
            booksOnShelf() {
                return this.shelf.books
            },
            pageLoading() {
                return this.$store.getters.getPageLoading;
            },
            user() {
                return this.$store.getters.getUser;
            },
        },
        methods: {
            getShelf() {
                return this.$store.dispatch('shelfGet', this.id);
            },
            getBooks(page = 1) {
                let self = this
                this.isLoading = true
                axios.get(`/api/user/${this.user.id}/shelf/${this.id}/book?page=${page}`)
                    .then((response) => {
                        self.books = response.data.books
                        self.currentPage = response.data.currentPage
                        self.totalPages = response.data.totalPages
                        self.totalBooks = response.data.totalBooks
                        self.isLoading = false
                        /** todo: fix scroll to top**/
                        self.$refs.top.scrollTop = 0;
                    }, (error) => {
                        console.log(response)
                    });
            }
        },
        watch: {
            /** whenever id changes, get shelf data */
            id() {
                /** dispatch action */
                if (this.id) {
                    this.getShelf();
                    this.getBooks();
                }
            },
            user() {
                this.getShelf();
                this.getBooks();
            }
        },
        created() {
            let self = this;
            if (this.user) {
                this.getShelf();
                this.getBooks();
            }

            /** listen for project delete event **/
            Event.$on('shelf.' + this.id + '.delete', function () {
                self.shelf.delete();
            });
        }
    }
</script>
