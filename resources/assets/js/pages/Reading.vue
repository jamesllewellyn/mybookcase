<template>
    <div class="shelf" ref="top">
        <transition name="fade" mode="out-in">
            <div class="content" v-if="! isLoading">
                <div class="level is-mobile">
                    <div class="level-left">
                        <h1 class="is-quicksans has-text-weight-semibold">Reading</h1>
                    </div>
                </div>

                <transition-group class="columns is-multiline" name="fade" mode="out-in">
                    <book-in-list v-for="(book, index) in reading" :key="index" :isbn="book.isbn" :title="book.title">
                        <img slot="cover" class="image cover" :src="book.image" :alt="book.title">
                        <!--<template slot="title">{{book.title}}</template>-->
                        <template slot="authors">{{book.authors}}</template>
                        <template slot="drop-down">
                            <shelf-book-drop-down
                                    :isbn="book.isbn"
                                    @readingToggled="updateReading(book.id)"
                                    @readToggled="updateReading(book.id)">
                            </shelf-book-drop-down>
                        </template>
                    </book-in-list>
                </transition-group>
                <message v-if="reading.length === 0">
                    Mark books as reading and they will appear here
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
    import ShelfBookDropDown from '../components/buttons/ShelfBookDropDown';
    import Message from '../components/Message';

    export default {
        data() {
            return {
                nextPageUrl: false,
                prevPageUrl: false,
                currentPage: 1,
                isLoading: true,
                reading: []
            }
        },
        components: {VueSimpleSpinner, BookInList, ShelfBookDropDown, Message},
        computed: {
            user() {
                return this.$store.getters['user/get'];
            },
        },
        methods: {
            getReading(page = 1) {
                let self = this;
                this.isLoading = true;
                axios.get(`/api/reading?page=${page}`)
                    .then((response) => {
                        self.reading = response.data.reading.data;
                        self.currentPage = response.data.reading.current_page;
                        self.nextPageUrl = response.data.reading.next_page_url;
                        self.prevPageUrl = response.data.reading.prev_page_url;
                        self.isLoading = false;
                        /** todo: fix scroll to top**/
                        self.$refs.top.scrollTop = 0;
                    }, (error) => {
                    });
            },
            updateReading(bookId) {
                return this.reading = this.reading.filter(book => book.id !== bookId);
            }
        },
        watch: {
            user() {
                this.getReading();
            }
        },
        created() {
            if (this.user) {
                this.getReading();
            }
        }
    }
</script>
