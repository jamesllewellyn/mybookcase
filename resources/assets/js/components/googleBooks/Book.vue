<template>
    <div class="column is-half">
        <div class="card book-shelf">
            <div class="card-content">
                <div class="columns">
                    <div class="column is-one-third is-paddingless">
                        <router-link tag="div" class="image is-pointer" :to="`/book/${isbn}?isbn=true`"
                                     v-if="cover_url">
                            <img class="image cover" :src="cover_url" alt="">
                        </router-link>
                        <div class="book-placeholder" v-if="!cover_url"></div>
                    </div>
                    <div class="column is-two-thirds">
                        <div class="div is-pulled-right">
                            <drop-down-button :boarder="false"
                                              :dropdowns="[{text : 'View', event: { name : 'changePage', payload : `/book/${isbn}?isbn=true` }, action: 'update project', areYouSure : false},{text : 'Move', event: { name : 'modalShowWithPayload', payload : {name : 'bookMoveShelf', payload : isbn} }, action: 'update project', areYouSure : false},{text : 'Remove', event: { name : `shelf.${shelfId}.book.remove`, payload : isbn}, action: 'remove this book from your shelf', areYouSure : true}]"
                                              :class="'is-pulled-right'"
                                              :direction="'is-right'"
                                              :icon="'fa-ellipsis-v'"
                                              v-if="show_menu">
                            </drop-down-button>
                        </div>
                        <div class="content">
                            <p class="book-title has-text-weight-bold" v-if="title">{{titleToLength}}</p>
                            <progress class="progress is-width-90" value="0" max="100" v-if="!title"></progress>
                            <progress class="progress is-width-40" value="0" max="100" v-if="!title"></progress>
                            <progress class="progress is-width-30" value="0" max="100" v-if="!title"></progress>
                            <p class="author" v-if="authors">by
                                <span v-for="(author, index) in authors" :key="index" v-if="authors">
                                    {{ author }}<span v-if="index != 0 && index == authors.length - 1">, </span>
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
                default: false
            }
        },
        computed: {
//            isbn() {
//                if (!this.identifiers) {
//                    return false
//                }
//                let index = _.findIndex(this.identifiers, ['type', 'ISBN_10']);
//                return this.identifiers[index].identifier;
//            },
//            shelfId() {
//                return this.$store.getters.getShelf.id
//            },
            titleToLength() {
                if (!this.title) {
                    return false
                }
                if (this.title.length < 32) {
                    return this.title
                }
                return `${this.title.substring(0, 32)}...`
            },
//            authorToLength() {
//                let string = ''
//                this.authors.each(function(author, index){
//                    string += author
//                    if(index != 0 && index == this.authors.length - 1){
//                        string += ', '
//                    }
//                })
//                return  string
//            }
        },
        methods: {
//            moveShelf() {
//                Event.$emit('modalShowWithPayload', {name: 'bookMoveShelf', payload: })
//            },
//            removeBook() {
//                Event.$emit('showAreYouSure', '', )
//            }

        },
        mounted() {
            let self = this
        }
    }
</script>
