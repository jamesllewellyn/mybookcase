<template>
    <router-link exact class="column is-half" active-class="is-active" tag="div" :to="`/user/${handle}/shelf/${id}`">
        <div class="card book-shelf is-pointer">
            <div class="card-content">
                <div class="columns">
                    <div class="column is-one-third is-paddingless">
                        <img class="image cover" :src="book.cover_url" alt="" v-if="book">
                        <div class="book-placeholder" v-if="!book"></div>
                    </div>
                    <div class="column is-two-thirds">
                        <div class="content">
                            <p class="book-title has-text-weight-bold">{{name}}</p>
                            <div class="tags has-addons">
                                <span class="tag"><i class="fas fa-book"></i></span>
                                <span class="tag is-primary">{{book_count}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </router-link>
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
                required: true
            },
            handle: {
                type: String,
                required: true
            },
            id: {
                type: Number,
                required: true
            },
            book: {
                required: false
            },
            book_count: {
                type: Number,
                required: true
            }
        },
        methods: {
            titleToLength() {
                if (this.title.length < 32) {
                    return this.title
                }
                return `${this.title.substring(0, 32)}...`
            },
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
