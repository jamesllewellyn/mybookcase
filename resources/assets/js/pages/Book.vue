<template>
    <div class="content">
        <div class="columns">
            <div class="column is-one-fifth">
                <back-button class="is-hidden-desktop"></back-button>
                <div class="book has-text-centered">
                    <img :src="book.cover_url" alt="" v-if="book.cover_url">
                    <div class="book-placeholder" v-if="!book.cover_url"></div>
                </div>
                <p class="field">
                    <router-link class="button is-success is-block"
                                 v-if="isOnShelf"
                                 :to="`/shelf/${isOnShelf.id}`">
                        <span class="icon">
                            <i class="fas fa-bookmark"></i>
                        </span>
                        <span>On Shelf</span>
                    </router-link>

                    <add-book-to-shelf-button :book="book"></add-book-to-shelf-button>
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
                    <a class="button" :href="`http://www.worldcat.org/isbn/${book.isbn}`" target="_blank">
                        <span class="icon">
                            <i class="fas fa-heart"></i>
                        </span>
                        <span>Library</span>
                    </a>
                    <a class="button" :href="`https://www.goodreads.com/book/isbn/${book.isbn}`" target="_blank">
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
    import StarRating from 'vue-star-rating';
    import AddBookToShelfButton from '../components/buttons/AddBookToShelfButton';
    import BackButton from '../components/buttons/BackButton';

    export default {
        data() {
            return {
                book: ''
            }
        },
        components: {StarRating, AddBookToShelfButton, BackButton},
        computed: {
            isbn() {
                if (!this.$route.params.isbn) {
                    return false;
                }
                return this.$route.params.isbn;
            },
            isOnShelf() {
                if (!this.isbn) {
                    return false;
                }
                console.log(`isOnShelf ${this.isbn}`);
                return this.$store.getters['bookcase/isOnShelf'](this.isbn);
            },
            searchQuery() {
                if (!this.$route.query.search) {
                    return false;
                }
                return this.$route.query.search
            },
            getRating() {
                if (!this.book) {
                    return 0;
                }
                if (!this.book.average_rating) {
                    return 0;
                }
                return parseFloat(this.book.average_rating);
            },
            getAuthors() {
                if (!this.book) {
                    return null;
                }
                if (this.book.authors.name) {
                    return this.book.authors.name;
                }
                return _.map(this.book.authors, function (author, key) {
                    let name = ` ${author.name}`;
                    if (author.role.length !== 0) {
                        name += ` (${author.role})`;
                    }
                    return name;
                }).toString()
            }
        },
        methods: {
            getBook() {
                let self = this;
                this.book = null;
                axios.get(`/api/goodreads/${this.isbn}`)
                    .then((response) => {
                        self.book = response.data.book;
                    }, (error) => {
                        // console.log(response);
                    });
            },
            addToShelfModal() {
                if (!this.$store.state.isAuthenticated) {
                    return Event.$emit('modalShow', 'loginModal');
                }
                Event.$emit('modalShow', 'addToShelf');
            }
        },
        watch: {
            /** whenever isbn changes, get book data */
            isbn() {
                /** dispatch action */
                if (this.isbn) {
                    this.getBook();
                }
            },
        },
        created() {
            this.getBook();
        },
    }
</script>
