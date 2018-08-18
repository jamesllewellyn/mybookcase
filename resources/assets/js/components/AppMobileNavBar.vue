<template>
    <nav class="navbar is-fixed-top is-dark is-hidden-desktop">
        <div class="container is-fluid">
            <div class="navbar-brand">
                <router-link :to="{ name: 'welcome'}"
                             class="navbar-item logo is-quicksans has-text-centered has-text-white">
                    My Bookcase
                </router-link>

                <div class="navbar-burger burger" :class="{'is-active' : showMobileNav}" data-target="navMenu"
                     @click="toggleMobileMenu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <transition name="fade" mode="out-in">
                <div class="navbar-menu" :class="{'is-active' : showMobileNav}" v-if="showMobileNav">
                    <div class="navbar-item is-marginless">
                        <nav-bar-search
                                :mobile="true"
                                @searching="toggleMobileMenu"
                        ></nav-bar-search>
                    </div>
                    <div class="guest-nav-items" v-if="!user">
                        <div class="navbar-item" @click="toggleMobileMenu">
                            <router-link :to="{ name: 'register'}">
                                Start building your Bookcase
                            </router-link>
                        </div>
                        <div class="navbar-item" @click="toggleMobileMenu" v-if="!user">
                            <router-link :to="{ name: 'login'}">
                                Login
                            </router-link>
                        </div>
                    </div>
                    <div class="logged-in-nav-items" v-if="user">
                        <div class="navbar-item" @click="toggleMobileMenu">
                            <router-link exact active-class="is-active"
                                         :to="{ name: 'dashboard'}" @click="toggleMobileMenu">
                            <span class="icon">
                                <i class="fa fa-home"></i>
                            </span>
                                <span class="name">Home</span>
                            </router-link>
                        </div>
                        <div class="navbar-item" @click="toggleMobileMenu">
                            <router-link exact active-class="is-active" :to="`/user/@${user.handle}`" @click="toggleMobileMenu">
                            <span class="icon">
                                <i class="fa fa-user-circle"></i>
                            </span>
                                <span class="name">Profile</span>
                            </router-link>
                        </div>
                        <div class="navbar-item" @click="toggleMobileMenu">
                            <router-link active-class="is-active"  to="/friends/" @click="toggleMobileMenu">
                            <span class="icon">
                                <i class="fa fa-users"></i>
                            </span>
                                <span class="name">Friends</span>
                            </router-link>
                        </div>
                        <div class="navbar-item">
                            <p class="menu-label">
                                Bookcase
                                <shelf-add-button></shelf-add-button>
                            </p>
                        </div>
                        <div v-for="(shelf, index) in bookcase.shelves" :key="index" class="navbar-item"
                             @click="toggleMobileMenu">
                            <router-link exact class="item" active-class="is-active" tag="a" :to="`/shelf/${shelf.id}`">
                                <span v-text="shelf.name"></span>
                                <span class="tag is-light is-pulled-right"
                                      v-text="shelf.books_count"></span>
                            </router-link>
                        </div>

                        <div class="navbar-item has-text-centered" @click="toggleMobileMenu">
                            <a href="" @click.prevent="logout">
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </nav>
</template>

<script>
    import {mixin as clickaway} from 'vue-clickaway';
    import ShelfAddButton from '../components/buttons/ShelfAddButton.vue';

    export default {
        data() {
            return {
                showMobileNav: false,
                showUserDropDown: false
            }
        },
        mixins: [clickaway],
        components: {ShelfAddButton},
        props: {
            user: {
                required: true
            },
            bookcase: {
                required: true
            }
        },
        methods: {
            toggleMobileMenu() {
                return this.showMobileNav = !this.showMobileNav;
            },
            hideDropDown() {
                return this.showUserDropDown = false
            },
            showDropDown() {
                return this.showUserDropDown = true
            },
            logout() {
                this.hideDropDown();
                Event.$emit('logout');
            }
        },
        mounted() {
            console.log('app mobile nav bar');
        }
    }
</script>
<style lang="scss" scoped>
    .navbar-menu {
        .navbar-item {
            margin-top: 20px;
            margin-bottom: 20px;
            a{
                color: #4a4a4a;
            }
        }
    }
</style>