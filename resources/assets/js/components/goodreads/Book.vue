<template>
    <div class="column is-one-fifth">
        <router-link exact class="book" tag="div" :to="'/book/'+id">
            <img class="image cover" :src="cover_url" alt="" width="180">
            <!--<div class="image cover book-placeholder" width="180" v-if="!cover_url" ></div>-->
            <p class="book-title has-text-weight-bold">{{titleFormatted}}</p>
            <p class="author">by {{ authorFormatted }}</p>
        </router-link>
    </div>
</template>

<script>

    export default {
        props: {
            cover_url: {
                type: String,
                required: false,
                default: null
            },
            title: {
                type: String,
                required: true
            },
            author: {
                required: true
            },
            goodreads_id: {
                type: Number,
                required: false
            },
            isbn: {
                type: String,
                required: false
            }
        },
        computed: {
            id() {
                if (this.goodreads_id) {
                    return this.goodreads_id
                }
                return this.isbn + '?isbn=true'
            },
            titleFormatted() {
                return this.limitLength(this.title, 40)
            },
            authorFormatted() {
                if (!Array.isArray(this.author)) {
                    return this.limitLength(this.author, 40)
                }
                let authorString = this.author.map(function (author) {
                    return author;
                }).join(', ');
                return this.limitLength(authorString, 40)
            }
        },
        methods: {
            limitLength(string, limit) {
                if (string.length < limit) {
                    return string
                }
                return `${string.substring(0, limit)}...`
            }
        },
        mounted() {

        }
    }
</script>
