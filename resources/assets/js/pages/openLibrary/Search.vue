<template>
    <div class="content">
        <h1>Search Results</h1>
        <div class="search-results" v-if="!isSearching">
            <div class="columns is-multiline" :class="{'is-loading' : isSearching}">
                <book v-for="(book, index)  in searchResults" :key="index"
                      :title="book.title"
                      :coverId="book.coverId"
                      :authors="book.authors">
                </book>
            </div>
        </div>

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
