<template>
    <div class="content">
        <div class="level user is-hidden-touch">
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
            <div class="level-right">
                <edit-profile-button
                        v-if="isUsersProfile"
                        :user="user"
                ></edit-profile-button>
                <add-friend-button
                        v-else
                        :friend="user"
                ></add-friend-button>
            </div>
        </div>
        <div class="is-hidden-desktop">
            <div class="card friend ">
                <div class="card-content">
                    <div class="columns is-mobile">
                        <div class="column is-one-third">
                            <img class="image avatar" :src="user.avatar_url" v-if="user">
                            <img class="image avatar is-96x96" v-if="!user.avatar_url">
                        </div>
                        <div class="column is-two-thirds">
                            <div class="content">
                                <h1 class="is-quicksans has-text-weight-bold is-marginless">{{user.name}}
                                </h1>
                                <p class="">@{{user.handle}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <edit-profile-button
                    v-if="isUsersProfile"
                    :user="user"
                    class="is-block"
            ></edit-profile-button>
            <add-friend-button
                    v-else
                    :friend="user"
                    class="is-block"
            ></add-friend-button>
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
    import EditProfileButton from '../../components/buttons/EditProfileButton';
    import AddFriendButton from '../../components/buttons/AddFriendButton';

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
        components: {EditProfileButton, AddFriendButton},
        computed: {
            handle() {
                if (!this.$route.params.handle) {
                    return false;
                }
                return this.$route.params.handle;
            },
            isUsersProfile() {
                if (!this.user.id) {
                    return false;
                }
                return this.user.id === this.$store.getters['user/getUserId'];
            }
        },
        methods: {
            getUser() {
                let self = this;
                axios.get(`/api/user/${this.handle}/public`)
                    .then((response) => {
                        self.user = response.data.user;
                        self.shelves = response.data.shelves;
                    }, (error) => {
                        console.log(response);
                    });
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
