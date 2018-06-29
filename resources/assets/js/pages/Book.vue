<template>
    <div class="content">
        <div class="columns">
            <div class="column is-one-fifth">
                <div class="book">
                    <img :src="book.cover_url" alt="" v-if="book.cover_url">
                    <div class="book-placeholder" v-if="!book.cover_url"></div>
                </div>
                <p class="field">
                    <a class="button is-block" @click="addToShelfModal">
                    <span class="icon">
                      <i class="fa fa-plus-circle"></i>
                    </span>
                        <span>Add To Shelf</span>
                    </a>
                </p>
            </div>
            <div class="column">
                <p class="title wrapper">
                    <span v-if="book.title">{{book.title}}</span>
                    <progress class="progress is-width-60" value="0" max="100" v-if="!book.title"></progress>
                    <progress class="progress is-width-30" value="0" max="100" v-if="!book.title"></progress>
                </p>
                <p class="author" v-if="getAuthors" v-text="getAuthors"></p>
                <p class="level" v-if="!book.authors">
                    <progress class="progress is-width-10" value="0" max="100"></progress>
                </p>
                <div class="level">
                    <div class="level-left">
                        <star-rating :rating="getRating" :read-only="true" :increment="0.01"></star-rating>
                    </div>
                </div>
                <div class="description wrapper">
                    <p v-html="book.description" v-if="book.description"></p>
                    <div v-if="!book.description">
                        <progress class="progress is-widthfull" value="0" max="100"></progress>
                        <progress class="progress is-widthfull" value="0" max="100"></progress>
                        <progress class="progress is-widthfull" value="0" max="100"></progress>
                        <progress class="progress is-width-30" value="0" max="100"></progress>
                    </div>
                </div>
                <hr>
                <p class="has-text-weight-bold">Find Book.</p>

                <p class="field">
                    <a class="button" :href="`https://www.amazon.com/gp/product/${book.isbn}/ref=as_li_tl?ie=UTF8&tag=mybookcase03-20`" target="_blank">
                        <span class="icon is-small">
                            <i class="fab fa-amazon"></i>
                        </span>
                        <span>Amazon</span>
                    </a>
                    <a class="button" :href="'http://www.worldcat.org/isbn/'+book.isbn" target="_blank">
                        <span class="icon">
                            <i class="fas fa-heart"></i>
                        </span>
                        <span>Library</span>
                    </a>
                    <a class="button" :href="'https://www.goodreads.com/book/isbn/'+book.isbn" target="_blank">
                        <span class="icon">
                          <i class="fab fa-goodreads-g"></i>
                        </span>
                        <span>Goodreads</span>
                    </a>
                </p>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        computed: {
            id: function () {
                if (!this.$route.params.id) {
                    return false;
                }
                return this.$route.params.id;
            },
            isbn() {
                if (!this.$route.query.isbn) {
                    return false
                }
                return this.$route.query.isbn
            },
            book() {
                return this.$store.getters.getBook
            },
            getRating() {
                if (!this.book) {
                    return 0
                }
                if (!this.book.average_rating) {
                    return 0
                }
                return parseFloat(this.book.average_rating)
            },
            getAuthors() {
                if (!this.book) {
                    return null
                }
                if (this.book.authors.name) {
                    return this.book.authors.name
                }
                return _.map(this.book.authors, function (author, key) {
                    let name = ` ${author.name}`
                    if (author.role.length !== 0) {
                        name += ` (${author.role})`
                    }
                    return name
                }).toString()
            }
        },
        methods: {
            getBook() {
                return this.$store.dispatch('getGoodreadsBook', {id: this.id, isbn: this.isbn});
            },
            addToShelfModal() {
                if(! this.$store.state.isAuthenticated){
                    return Event.$emit('modalShow', 'loginModal');
                }
                Event.$emit('modalShow', 'addToShelf');
            }
        },
        watch: {
            /** whenever isbn changes, get book data */
            id() {
                /** dispatch action */
                if (this.id) {
                    this.getBook();
                }
            },
        },
        created() {
            this.$store.commit('clearBook');
            this.getBook();
        }
    }
</script>
