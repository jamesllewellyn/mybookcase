<template>
    <div class="shelf" ref="top">
        <transition name="fade" mode="out-in">
            <div class="content" v-if="! isLoading">
                <nav class="breadcrumb has-arrow-separator" aria-label="breadcrumbs" v-if="user">
                    <ul>
                        <li>
                            <router-link exact href="#" active-class="is-active" tag="a" :to="`/user/@${user.handle}`"
                                         v-if="user">
                                <img class="avatar" :src="user.avatar_url" alt="" >
                                {{user.name}}
                            </router-link>
                        </li>
                        <li><h2 class="is-quicksans has-text-weight-semibold">{{shelf.name}}</h2></li>
                    </ul>
                </nav>
                <div class="columns is-multiline">

                    <shelf-book v-for="(book, index) in books" :key="index"
                                 :title="book.title"
                                 :cover_url="book.image"
                                 :authors="book.authors"
                                 :isbn="book.isbn"
                                 :identifiers="book.identifiers"
                                 :show_menu="false"
                    >
                    </shelf-book>
                    <shelf-book :placeholder="true" v-if="books.length == 0">
                    </shelf-book>
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
        <div class="vue-simple-spinner-wrap is-fullheight" v-if="isLoading">
            <vue-simple-spinner size="75" :line-size=6 line-fg-color="#2d2b4a"></vue-simple-spinner>
        </div>
    </div>
</template>

<script>
    import VueSimpleSpinner from 'vue-simple-spinner'
    import ShelfBook from  '../../components/ShelfBook.vue';
    export default {
        data() {
            return {
                user: null,
                shelf: null,
                books: [],
                nextPageUrl: false,
                prevPageUrl: false,
                currentPage: 1,
                isLoading: true
            }
        },
        components: {VueSimpleSpinner, ShelfBook},
        computed: {
            handle: function () {
                if (!this.$route.params.handle) {
                    return false;
                }
                return this.$route.params.handle;
            },
            id: function () {
                if (!this.$route.params.id) {
                    return false;
                }
                return this.$route.params.id;
            },
        },
        methods: {
            getShelf() {
                let self = this
                axios.get(`/api/user/${this.handle}/public/shelf/${this.id}`)
                    .then((response) => {
                        self.user = response.data.user;
                        self.shelf = response.data.shelf;
                    }, (error) => {
//                        console.log(response)
                    });
            },
            getBooks(page = 1) {
                let self = this;
                this.isLoading = true;
                axios.get(`/api/user/${this.handle}/public/shelf/${this.id}/book?page=${page}`)
                    .then((response) => {
                        self.books = response.data.books.data;
                        self.currentPage = response.data.books.current_page;
                        self.nextPageUrl = response.data.books.next_page_url;
                        self.prevPageUrl = response.data.books.prev_page_url;
                        self.isLoading = false;
                        /** todo: fix scroll to top**/
                        self.$refs.top.scrollTop = 0;
                    }, (error) => {
//                        console.log(response)
                    });
            }
        },
        watch: {
            /** whenever handle changes, get user data */
            id() {
                /** dispatch action */
                if (this.id) {
                    this.getShelf();
                    this.getBooks();
                }
            },
            handle() {
                /** dispatch action */
                if (this.handle) {
                    this.getShelf();
                    this.getBooks();
                }
            },
        },
        created() {
            if (this.handle) {
                this.getShelf();
                this.getBooks();
            }
        }
    }
</script>
