<template>
    <div class="book-status-tags">
        <div class="field is-grouped is-grouped-multiline">
            <div class="control">
                <transition name="fade" mode="out-in">
                    <div class="tags has-addons" v-if="read || reading">
                        <span class="tag"><i
                                :class="[{'fas fa-book': read }, {'fas fa-book-reader' : reading}]"></i></span>
                        <span class="tag is-success" v-if="read">Read</span>
                        <span class="tag is-warning" v-if="reading">Reading</span>
                    </div>
                </transition>
            </div>

            <div class="control">
                <transition name="fade" mode="out-in">
                    <router-link class="tags has-addons is-pointer" tag="div" v-if="isOnShelf" :to="`/shelf/${isOnShelf.id}`" >
                        <span class="tag"><i class="fas fa-bookmark"></i></span>
                        <span class="tag is-success">Currently On Shelf</span>
                    </router-link>
                </transition>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['isbn'],
        computed: {
            read() {
                return this.$store.getters['bookcase/isFlaggedAsRead'](this.isbn);
            },
            reading() {
                return this.$store.getters['bookcase/isFlaggedAsReading'](this.isbn);
            },
            isOnShelf() {
                if (!this.isbn) {
                    return false;
                }
                return this.$store.getters['bookcase/isOnShelf'](this.isbn);
            },
        }
    }
</script>
<style lang="scss" scoped>
    .book-status-tags{
        margin-bottom: 1em;
    }
</style>