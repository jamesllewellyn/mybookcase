<template>
    <div class="shelf" ref="top">
        <transition name="fade" mode="out-in">
            <div class="content" v-if="! isLoading">
                <div class="level is-mobile">
                    <div class="level-left">
                        <h1 class="is-quicksans has-text-weight-semibold" >Reading</h1>
                    </div>
                    <!--<div class="level-right">-->
                        <!--<span class="tag" :class="shelf.public ? 'is-success' : 'is-danger'"-->
                              <!--v-text="shelf.public ? 'Public' : 'Private'">-->
                        <!--</span>-->
                    <!--</div>-->
                </div>
                <div class="columns is-multiline">
                    <book-in-list v-for="(book, index) in reading" :key="index" :isbn="book.isbn"  :read="book.read">
                        <img slot="cover"  class="image cover" :src="book.image" :alt="book.title">
                        <template slot="title">{{book.title}}</template>
                        <template slot="authors">{{book.authors}}</template>
                        <template slot="drop-down">
                            <shelf-book-drop-down
                                    :read="book.read"
                                    :isbn="book.isbn"

                                    @readToggled="updateRead(book.id)">
                            </shelf-book-drop-down>
                        </template>
                    </book-in-list>

                    <book-in-list v-if="reading.length === 0"></book-in-list>
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
    import BookInList from '../components/BookInList.vue';
    import ShelfBookDropDown from '../components/buttons/ShelfBookDropDown.vue';

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
        components: {VueSimpleSpinner, BookInList, ShelfBookDropDown},
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
                        console.log(response);
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
