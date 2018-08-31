<template>
    <div class="shelf" ref="top">
        <transition name="fade" mode="out-in">
            <div class="content" v-if="! isLoading">
                <div class="level is-mobile">
                    <div class="level-left">
                        <shelf-options-drop-down :shelf="shelf" :user-id="user.id"></shelf-options-drop-down>
                        <h1 class="is-quicksans has-text-weight-semibold" v-if="shelf">{{shelf.name}}</h1>
                    </div>
                    <div class="level-right">
                        <span class="tag" :class="shelf.public ? 'is-success' : 'is-danger'"
                              v-text="shelf.public ? 'Public' : 'Private'">
                        </span>
                    </div>
                </div>
                <div class="columns is-multiline">
                    <book-in-list v-for="(book, index) in books" :key="index" :isbn="book.isbn" :shelf-id="shelf.id" :read="book.read">
                        <img slot="cover"  class="image cover" :src="book.image" :alt="book.title">
                        <template slot="title">{{book.title}}</template>
                        <template slot="authors">{{book.authors}}</template>
                        <template slot="drop-down">
                            <shelf-book-drop-down
                                    :read="book.read"
                                    :isbn="book.isbn"
                                    :shelf-id="shelf.id"
                                    @readToggled="updateRead(book.id)">
                            </shelf-book-drop-down>
                        </template>
                    </book-in-list>

                    <shelf-book v-if="books.length === 0"></shelf-book>
                </div>

                <nav class="pagination" role="navigation" aria-label="pagination" v-if="nextPageUrl || prevPageUrl">
                    <ul class="pagination-list"></ul>
                    <a class="pagination-previous button is-right" :disabled="currentPage == 1"
                       @click.prevent="getBooks(currentPage - 1)">Previous</a>
                    <a class="pagination-next button is-right" :disabled="!nextPageUrl"
                       @click.prevent="getBooks(currentPage + 1)">Next page</a>
                </nav>

            </div>
        </transition>
    </div>
</template>

<script>
    import VueSimpleSpinner from 'vue-simple-spinner';
    import ShelfOptionsDropDown from '../components/buttons/ShelfOptionsDropDown.vue';
    import BookInList from '../components/BookInList.vue';
    import ShelfBookDropDown from '../components/buttons/ShelfBookDropDown.vue';

    export default {
        data() {
            return {
                nextPageUrl: false,
                prevPageUrl: false,
                currentPage: 1,
                isLoading: true,
                books: []
            }
        },
        components: {VueSimpleSpinner, ShelfOptionsDropDown, BookInList, ShelfBookDropDown},
        computed: {
            id: function () {
                if (!this.$route.params.id) {
                    return false;
                }
                return this.$route.params.id;
            },
            user() {
                return this.$store.getters['user/get'];
            },
            shelf() {
                return this.$store.getters['bookcase/getShelfById'](this.id);
            }
        },
        methods: {
            getShelf() {
                return this.$store.dispatch('bookcase/getShelf', this.id);
            },
            getBooks(page = 1) {
                let self = this;
                this.isLoading = true;
                axios.get(`/api/shelf/${this.id}/book?page=${page}`)
                    .then((response) => {
                        self.books = response.data.books.data;
                        self.currentPage = response.data.books.current_page;
                        self.nextPageUrl = response.data.books.next_page_url;
                        self.prevPageUrl = response.data.books.prev_page_url;
                        self.isLoading = false;
                        /** todo: fix scroll to top**/
                        self.$refs.top.scrollTop = 0;
                    }, (error) => {
                    });
            },
            updateRead(bookId){
                let book = this.books.find(book => book.id === bookId);
                return book.read = !book.read;
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
            Event.$on(`shelf.delete`, function () {
                self.shelf.destroy();
            });

            Event.$on(`shelf.book.remove`, function (isbn) {
                self.books = _.reject(self.books, ['isbn', isbn]);
            });
        },
        beforeDestroy() {
            Event.$off(`shelf.delete`);
            Event.$off(`shelf.delete`);
            Event.$off(`shelf.book.remove`);
        }
    }
</script>
