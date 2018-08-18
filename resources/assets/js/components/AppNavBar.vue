<template>
    <nav class="navbar is-fixed-top is-dark is-hidden-touch">
        <div class="container is-fluid">
            <div class="navbar-brand">
                <router-link :to="{ name: 'welcome'}"
                             class="navbar-item logo is-quicksans has-text-centered has-text-white">
                    My Bookcase
                </router-link>
            </div>

            <div class="navbar-menu">
                <div class="navbar-start">
                    <div class="navbar-item">
                        <div class="control has-text-centered">
                            <nav-bar-search></nav-bar-search>
                        </div>
                    </div>
                </div>

                <div class="navbar-end">

                    <div class="navbar-item has-dropdown" :class="{'is-active' : showUserDropDown}"
                         @click="showDropDown" v-on-clickaway="hideDropDown" v-if="user">
                        <a class="navbar-link has-text-white">
                            <img class="avatar" :src="user.avatar_url" alt="">
                            {{user.name}}
                        </a>
                        <div class="navbar-dropdown" @click="hideDropDown">
                            <div class="navbar-item has-text-white">
                                <router-link :to="{ name: 'dashboard'}">
                                    Dashboard
                                </router-link>
                            </div>
                            <div class="navbar-item has-text-white">
                                <a href="" @click.prevent="logout">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="navbar-item">
                        <router-link :to="{ name: 'login'}" class="has-text-white" v-if="!user">
                            Login
                        </router-link>
                    </div>

                    <div class="navbar-item ">
                        <router-link :to="{ name: 'register'}" class="button is-primary" v-if="!user">
                            Build your Bookcase
                        </router-link>
                    </div>
                </div>
            </div>

        </div>
    </nav>
</template>

<script>
    import {mixin as clickaway} from 'vue-clickaway'

    export default {
        data() {
            return {
                showMobileNav: false,
                showUserDropDown: false
            }
        },
        mixins: [clickaway],
        computed: {
            user() {
                return this.$store.getters['user/get'];
            },
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

        }
    }
</script>
