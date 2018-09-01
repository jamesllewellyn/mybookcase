<template>
    <div class="shelf" ref="top">
        <transition name="fade" mode="out-in">
            <div class="content" v-if="! isLoading">
                <div class="level is-mobile">
                    <div class="level-left">
                        <h1 class="is-quicksans has-text-weight-semibold">Read</h1>
                    </div>
                </div>

                <transition-group class="columns is-multiline" name="fade" mode="out-in">
                    <book-in-list v-for="(book, index) in read" :key="index" :isbn="book.isbn" :title="book.title">
                        <img slot="cover" class="image cover" :src="book.image" :alt="book.title">
                        <!--<template slot="title">{{book.title}}</template>-->
                        <template slot="authors">{{book.authors}}</template>
                        <template slot="drop-down">
                            <shelf-book-drop-down
                                    :isbn="book.isbn"
                                    @readToggled="updateRead(book.id)"
                                    @readingToggled="updateRead(book.id)"
                            >
                            </shelf-book-drop-down>
                        </template>
                    </book-in-list>
                </transition-group>

                <message v-if="read.length === 0">
                    Mark books as read and they will appear here
                </message>

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
    import BookInList from '../components/BookInList';
    import Message from '../components/Message';
    import ShelfBookDropDown from '../components/buttons/ShelfBookDropDown';

    export default {
        data() {
            return {
                nextPageUrl: false,
                prevPageUrl: false,
                currentPage: 1,
                isLoading: true,
                read: []
            }
        },
        components: {VueSimpleSpinner, BookInList, ShelfBookDropDown, Message},
        computed: {
            user() {
                return this.$store.getters['user/get'];
            },
        },
        methods: {
            getRead(page = 1) {
                let self = this;
                this.isLoading = true;
                axios.get(`/api/read?page=${page}`)
                    .then((response) => {
                        self.read = response.data.read.data;
                        self.currentPage = response.data.read.current_page;
                        self.nextPageUrl = response.data.read.next_page_url;
                        self.prevPageUrl = response.data.read.prev_page_url;
                        self.isLoading = false;
                        /** todo: fix scroll to top**/
                        self.$refs.top.scrollTop = 0;
                    }, (error) => {
                    });
            },
            updateRead(bookId) {
                return this.read = this.read.filter(book => book.id !== bookId);
            }
        },
        watch: {
            user() {
                this.getRead();
            }
        },
        created() {
            if (this.user) {
                this.getRead();
            }
        },
        beforeDestroy() {

        }
    }
</script>
