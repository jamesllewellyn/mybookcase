<template>
    <div class="content">
        <h1 class="is-quicksans has-text-weight-semibold">Search Results</h1>
        <transition name="fade" mode="out-in">
            <div class="search-results" v-if="!isSearching">
                <div class="columns is-multiline" :class="{'is-loading' : isSearching}" v-if="searchResults">
                    <book v-for="(book, index)  in searchResults" :key="index"
                          :title="book.title"
                          :cover_url="book.cover_url"
                          :author="book.author"
                          :goodreads_id="book.goodreads_id">
                    </book>
                </div>
                <div class="notification is-primary"  v-else>
                    <!--<button class="delete"></button>-->
                    <strong>Sorry</strong>, it doesn't look like we can find any results for that search
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import store from '../../store/index';
    import { mapState } from 'vuex'
    export default {
        data() {
            return {}
        },
        computed:
            mapState([
                'searchResults', 'query', 'isSearching'
            ])
        ,
        methods: {},
        watch: {
        },
        created() {
        }
    }
</script>

<style lang="scss" scoped>

</style>
