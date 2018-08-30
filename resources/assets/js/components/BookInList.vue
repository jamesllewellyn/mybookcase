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
                    <div class="column is-two-thirds">
                        <div class="div is-pulled-right">
                            <slot name="drop-down">
                            </slot>
                        </div>
                        <div class="content">
                            <p class="book-title has-text-weight-bold">
                               <slot name="title">
                                   <progress class="progress is-width-90" value="0" max="100"></progress>
                                   <progress class="progress is-width-40" value="0" max="100"></progress>
                                   <progress class="progress is-width-30" value="0" max="100"></progress>
                               </slot>
                            </p>
                            <slot name="authors">
                                <p class="author" v-if="authors">by
                                    <span v-for="(author, index) in authors" :key="index" v-if="authors">
                                    {{ author }}<span v-if="index !== 0 && index === authors.length - 1">, </span>
                                </span>
                                </p>
                            </slot>
                            <div class="tags has-addons has-been-read" v-if="read">
                                <span class="tag"><i class="fas fa-book-reader"></i></span>
                                <span class="tag is-success">Read</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: {
            isbn: {
                required: false,
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
            read:{
                type: Boolean,
                default: false
            },
            searchQuery:{
                type: String,
                required: false
            }
        },
        computed: {

            bookUrl(){
                if(!this.isbn){
                    return null;
                }
                if(this.searchQuery){
                    return `/book/${this.isbn}?search=${this.searchQuery}`;
                }
                return `/book/${this.isbn}`;
            }
        },
        methods:{
            titleToLength(title) {
                if (!title) {
                    return false
                }
                if (title.length < 32) {
                    return title
                }
                return `${title.substring(0, 32)}...`
            },
        }
    }
</script>

<style lang="scss" scoped>
    .column{
        position: relative;
        .has-been-read{
            position: absolute;
            bottom: 0;
            left: 0;
        }
    }


</style>
