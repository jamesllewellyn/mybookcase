<template>
    <div class="content">
        <transition name="fade" mode="out-in">
            <div class="columns is-multiline" v-if="! pageLoading">
                <h1 class="is-quicksans has-text-weight-semibold">New York Times Best Sellers</h1>
                <div class="nyt-lists" v-for="(list, index) in bestSellers" :key="index">
                    <h3 class="">{{list.name}}</h3>
                    <transition name="fade" mode="out-in">
                        <div class="search-results">
                            <div class="columns is-multiline">
                                <book v-for="(book, index)  in list.books" :key="index"
                                      :title="book.title"
                                      :cover_url="book.cover_url"
                                      :author="book.author"
                                      :isbn="book.isbn_13">
                                </book>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </transition>
        <div class="vue-simple-spinner-wrap is-fullheight" v-if="pageLoading">
            <vue-simple-spinner size="75" :line-size=6 line-fg-color="#2d2b4a"></vue-simple-spinner>
        </div>
    </div>
</template>

<script>
    import VueSimpleSpinner from 'vue-simple-spinner'
    export default {
        data() {
            return{

            }
        },
        components:{VueSimpleSpinner},
        computed: {
            bestSellers(){
                return this.$store.getters.getBestSellerLists;
            },
            pageLoading(){
                return this.$store.getters.getPageLoading;
            }
        },
        methods: {
            getBestSellers(){
                return this.$store.dispatch('newYorkTimeGetBestSellers');
            }
        },
        watch: {
        },
        created() {
            this.getBestSellers();
        }
    }
</script>
