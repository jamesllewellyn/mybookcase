<template>
    <div class="column is-one-fifth is-half-tablet">
        <router-link exact class="book is-hidden-touch" tag="div" :to="`/book/${isbn}`">
            <img class="image cover" :src="cover_url" alt="" width="180">
            <!--<div class="image cover book-placeholder" width="180" v-if="!cover_url" ></div>-->
            <p class="book-title has-text-weight-bold">{{titleFormatted}}</p>
            <p class="author">by {{ authorFormatted }}</p>
        </router-link>
        <router-link exact class="card book-shelf is-hidden-desktop" tag="div" :to="`/book/${isbn}`">
            <div class="card-content">
                <div class="columns is-mobile">
                    <div class="column is-one-third is-paddingless">
                        <img class="image cover" :src="cover_url" alt="" width="180">
                    </div>
                    <div class="column is-two-thirds">
                        <div class="content">
                            <p class="book-title has-text-weight-bold">{{titleFormatted}}</p>
                            <p class="author">by {{ authorFormatted }}</p>
                        </div>
                    </div>
                </div>
            </div>
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
            isbn: {
                type: String,
                required: true
            }
        },
        computed: {
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
