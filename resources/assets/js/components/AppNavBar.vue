<template>
    <nav class="navbar is-fixed-top">
        <div class="container is-fluid">
            <div class="navbar-brand">
                <a class="navbar-item logo is-quicksans has-text-centered has-text-white " href="../">
                    <!--<img src="/images/logo/my-bookcase_logo.png" alt="Logo">-->
                    My Bookcase
                </a>

                <div class="navbar-burger burger" data-target="navMenu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div class="navbar-menu">
                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="control has-text-centered">
                            <nav-bar-search></nav-bar-search>
                        </div>
                    </div>
                    <div class="navbar-item has-dropdown" :class="{'is-active' : showUserDropDown}" @click="showDropDown" v-on-clickaway="hideDropDown">
                        <a class="navbar-link has-text-white">
                            <img class="avatar" :src="user.avatar_url" alt="">
                            {{user.name}}
                        </a>
                        <div class="navbar-dropdown">
                            <div class="navbar-item has-text-white">
                                <a href="/logout">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
    import { mixin as clickaway } from 'vue-clickaway'
    export default {
        data() {
            return {
                showUserDropDown: false
            }
        },
        mixins: [ clickaway ],
        computed:{
            user () { return this.$store.getters.getUser },
        },
        methods:{
            hideDropDown(){
                return this.showUserDropDown = false
            },
            showDropDown(){
                return this.showUserDropDown = true
            }
        },
        mounted() {

        }
    }
</script>
