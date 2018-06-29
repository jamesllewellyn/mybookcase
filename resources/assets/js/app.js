/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';

Vue.use(VueRouter);
import router from './app-routes';

import store from './store/index';
import {mapState} from 'vuex'
import VueSimpleSpinner from 'vue-simple-spinner'
import Multiselect from 'vue-multiselect'
import StarRating from 'vue-star-rating'

/** event bus */
window.Event = new Vue();
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/** structure components **/
Vue.component('app-nav-bar', require('./components/AppNavBar.vue'));
Vue.component('app-side-bar', require('./components/AppSideBar.vue'));
Vue.component('nav-bar-search', require('./components/NavBarSearch.vue'));
Vue.component('book', require('./components/goodreads/Book.vue'));
Vue.component('google-book', require('./components/googleBooks/Book.vue'));
Vue.component('public-shelf', require('./components/googleBooks/PublicShelf.vue'));
Vue.component('multiselect', Multiselect);
Vue.component('login-form', require('./components/LoginForm.vue'));
/** friends **/
Vue.component('friends-search', require('./components/FriendSearch.vue'));
Vue.component('friend', require('./components/Friend.vue'));
/** bulma components **/
Vue.component('drop-down-button', require('./components/bulma/DropDownButton.vue'));
Vue.component('star-rating', StarRating);
/** Modals **/
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('shelf-add-modal', require('./components/modals/ShelfAddModal.vue'));
Vue.component('shelf-update-modal', require('./components/modals/ShelfUpdateModal.vue'));
Vue.component('are-you-sure-modal', require('./components/modals/AreYouSureModal.vue'));
Vue.component('add-to-shelf-modal', require('./components/modals/AddToShelfModal.vue'));
Vue.component('book-move-shelf-modal', require('./components/modals/BookMoveShelfModal.vue'));
Vue.component('add-friend-modal', require('./components/modals/FriendAddModal.vue'));
Vue.component('accept-friend-modal', require('./components/modals/FriendAcceptModal.vue'));
Vue.component('user-update-modal', require('./components/modals/UserUpdateModal.vue'));
Vue.component('login-modal', require('./components/modals/LoginModal.vue'));


const app = new Vue({
    el: '#app',
    router,
    store,
    components: {VueSimpleSpinner},
    computed: {
        pageLoading() {
            return this.$store.state.pageLoading
        },
        user() {
            return this.$store.state.user
        },
        bookcase() {
            return this.$store.state.bookcase
        },
        isGuestPage() {
            return ! this.$route.meta.requiresAuth
        },
        hasShowSideMenu() {
            return this.$route.meta.hasShowSideMenu
        },
        isAuthenticated(){
            return this.$store.state.isAuthenticated
        }
    },
    methods: {
        /** trigger event method */
        triggerEvent(eventName, payload) {
            Event.$emit(eventName, payload);
        },
        clearTokens(){
            localStorage.removeItem('access_token')
            localStorage.removeItem('token_type')
            localStorage.removeItem('refresh_token')
            this.$store.state.user = null
            this.$store.state.isAuthenticated = false
        },
        changePage($route){
            return router.push($route);
        }
    },
    mounted() {
        let self = this;

        if(!this.user && this.isAuth){
            this.$store.dispatch('userGet')
        }

        Event.$on('clearTokens',  () => {
           self.clearTokens()
        });

        Event.$on('logout', () => {
            self.clearTokens()
            self.changePage('/')
        });

        Event.$on('unauthorized', () => {
            self.clearTokens()
            self.changePage('/login')
        });

        /** listen for force change page events */
        Event.$on('changePage', function ($route) {
           self.changePage($route)
        });

        /** listen for modal show events */
        Event.$on('modalShow', function (name) {
            self.$store.commit('modalShow', {name});
        });

        Event.$on('modalShowWithPayload', function ({name, payload}) {
            self.$store.commit('modalShowWithPayload', {name, payload});
        });
    }
});
