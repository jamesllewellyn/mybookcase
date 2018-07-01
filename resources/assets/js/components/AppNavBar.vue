<template>
    <nav class="navbar is-fixed-top is-dark">
        <div class="container is-fluid">
            <div class="navbar-brand">
                <router-link :to="{ name: 'welcome'}" class="navbar-item logo is-quicksans has-text-centered has-text-white">
                    <!--<img src="/images/logo/my-bookcase_logo.png" alt="Logo">-->
                    My Bookcase
                </router-link>

                <div class="navbar-burger burger" data-target="navMenu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
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
                                    <!--<img src="/images/logo/my-bookcase_logo.png" alt="Logo">-->
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
                    <!--<div v-else>-->
                    <div class="navbar-item">
                        <router-link :to="{ name: 'login'}" class="has-text-white" v-if="!user">
                            Login
                        </router-link>
                    </div>

                    <div class="navbar-item ">
                        <router-link :to="{ name: 'register'}" class="button is-primary" v-if="!user">
                            Build your Bookcase
                        </router-link>
                      <!--<a class="" v-if="!user">-->
                        <!--<span></span>-->
                      <!--</a>-->
                    </div>
                </div>
                <!--</div>-->
            </div>
        </div>
    </nav>
</template>

<script>
    import {mixin as clickaway} from 'vue-clickaway'

    export default {
        data() {
            return {
                showUserDropDown: false
            }
        },
        mixins: [clickaway],
        computed: {
            user() {
                return this.$store.getters.getUser
            },
        },
        methods: {
            hideDropDown() {
                return this.showUserDropDown = false
            },
            showDropDown() {
                return this.showUserDropDown = true
            },
            logout(){
                this.hideDropDown()
                Event.$emit('logout')
            }
        },
        mounted() {

        }
    }
</script>
