<template>
    <div class="content">
        <div class="level user">
            <div class="level-left">
                <p class="image ">
                    <img class="image avatar" :src="user.avatar_url" v-if="user">
                    <img class="image avatar is-96x96" v-if="!user.avatar_url">
                </p>
                <div class="user-details">
                    <h1 class="is-quicksans has-text-weight-bold is-marginless">{{user.name}}
                    </h1>
                    <p class="">@{{user.handle}}</p>
                </div>
            </div>
            <div class="level-right" v-if="isUsersProfile">
                <a class="button" @click.prevent="editProfile">Edit Profile</a>
            </div>
        </div>
        <h2>Public Bookshelves</h2>
        <div class="columns is-multiline">
            <public-shelf v-for="(shelf, index) in shelves" :key="index"
                          :name="shelf.name"
                          :id="shelf.id"
                          :handle="handle"
                          :book="shelf.book"
                          :book_count="shelf.books_count"
            ></public-shelf>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    id: null,
                    avatar_url: '',
                    name: '',
                    handle: null
                },
                shelves: null,
                show_menu: false
            }
        },
        components: {},
        computed: {
            handle() {
                if (!this.$route.params.handle) {
                    return false;
                }
                return this.$route.params.handle;
            },
            isUsersProfile(){
                if(! this.user.id ){
                    return false;
                }
                return this.user.id === this.$store.getters.getUser.id
            }
        },
        methods: {
            getUser() {
                let self = this
                axios.get(`/api/user/${this.handle}/public`)
                    .then((response) => {
                        self.user = response.data.user
                        self.shelves = response.data.shelves
                    }, (error) => {
                        console.log(response)
                    });
            },
            editProfile(){
                Event.$emit('modalShow', 'userUpdateModal')
            }
        },
        watch: {
            /** whenever handle changes, get user data */
            handle() {
                /** dispatch action */
                if (this.handle) {
                    this.getUser();
                }
            }
        },
        created() {
            if (this.handle) {
                this.getUser();
            }
        }
    }
</script>
