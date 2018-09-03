<template>
    <div class="column is-half">
        <div class="card book-shelf">
            <div class="card-content">
                <div class="columns is-mobile">
                    <div class="column is-one-third is-paddingless">
                        <router-link tag="div" class="image is-pointer" :to="bookUrl">
                            <slot name="cover">
                                <div class="book-placeholder"></div>
                            </slot>
                        </router-link>
                    </div>
                    <div class="column is-two-thirds right-hand-side">
                        <div class="div is-pulled-right">
                            <slot name="drop-down">
                            </slot>
                        </div>
                        <div class="content">
                            <p class="book-title has-text-weight-bold">
                                <slot name="title">
                                    {{titleToLength}}
                                    <!--<progress class="progress is-width-90" value="0" max="100"></progress>-->
                                    <!--<progress class="progress is-width-40" value="0" max="100"></progress>-->
                                    <!--<progress class="progress is-width-30" value="0" max="100"></progress>-->
                                </slot>
                            </p>
                            <p class="author">
                                <slot name="authors">
                                </slot>
                            </p>
                            <book-status :isbn="isbn"></book-status>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import BookStatus from '../components/BookStatus';

    export default {
        props: {
            isbn: {
                required: false,
                default: false
            },
            title: {
                required: false,
                default: false
            },
            shelfId: {
                type: Number,
                required: false
            },
            userId: {
                type: Number,
                required: false
            },
            searchQuery: {
                type: String,
                required: false
            }
        },
        components:{BookStatus},
        computed: {
            bookUrl() {
                if (!this.isbn) {
                    return null;
                }
                if (this.searchQuery) {
                    return `/book/${this.isbn}?search=${this.searchQuery}`;
                }
                return `/book/${this.isbn}`;
            },
            titleToLength() {
                if (!this.title) {
                    return false
                }
                if (this.title.length < 25) {
                    return this.title
                }
                return `${this.title.substring(0, 25)}...`
            },
        }
    }
</script>

<style lang="scss" scoped>
    .right-hand-side {
        position: relative;
        .has-been-read {
            position: absolute;
            bottom: 0;
            left: 0;
        }
    }


</style>
