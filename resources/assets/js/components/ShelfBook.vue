<template>
    <div class="column is-half">
        <div class="card book-shelf">
            <div class="card-content">
                <div class="columns is-mobile">
                    <div class="column is-one-third is-paddingless">
                        <router-link tag="div" class="image is-pointer" :to="bookUrl"
                                     v-if="cover_url">
                            <img class="image cover" :src="cover_url" alt="">
                        </router-link>
                        <div class="book-placeholder" v-if="!cover_url"></div>
                    </div>
                    <div class="column is-two-thirds">
                        <div class="div is-pulled-right">
                            <shelf-book-drop-down
                                    v-if="show_menu"
                                    :isbn="isbn"
                                    :shelf-id="shelfId"
                                    :user-id="userId">
                            </shelf-book-drop-down>
                        </div>
                        <div class="content">
                            <p class="book-title has-text-weight-bold" v-if="title">{{titleToLength}}</p>
                            <progress class="progress is-width-90" value="0" max="100" v-if="!title"></progress>
                            <progress class="progress is-width-40" value="0" max="100" v-if="!title"></progress>
                            <progress class="progress is-width-30" value="0" max="100" v-if="!title"></progress>
                            <p class="author" v-if="authors">by
                                <span v-for="(author, index) in authors" :key="index" v-if="authors">
                                    {{ author }}<span v-if="index !== 0 && index === authors.length - 1">, </span>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import ShelfBookDropDown from '../components/buttons/ShelfBookDropDown.vue';
    export default {
        props: {
            cover_url: {
                required: false,
                default: null
            },
            title: {
                required: false,
                default: false
            },
            authors: {
                required: false,
                default: false
            },
            isbn: {
                required: false,
                default: false
            },
            show_menu: {
                default: false
            },
            placeholder: {
                type: Boolean,
                default: false
            },
            shelfId:{
                type: Number,
                required: false
            },
            userId:{
                type: Number,
                required: false
            },
            searchQuery:{
                type: String,
                required: false
            }
        },
        components:{ShelfBookDropDown},
        computed: {
            titleToLength() {
                if (!this.title) {
                    return false
                }
                if (this.title.length < 32) {
                    return this.title
                }
                return `${this.title.substring(0, 32)}...`
            },
            bookUrl(){
                if(this.searchQuery){
                    return `/book/${this.isbn}?search=${this.searchQuery}`;
                }
                return `/book/${this.isbn}`;
            }
        },
    }
</script>
