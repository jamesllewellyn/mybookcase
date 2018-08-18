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
import PortalVue from 'portal-vue';
Vue.use(PortalVue);
import Raven from 'raven-js';
import RavenVue from 'raven-js/plugins/vue';
import store from './store/index';
import VueSimpleSpinner from 'vue-simple-spinner'
import Multiselect from 'vue-multiselect'

/** Sentry vuejs**/
Raven
    .config('https://f5c8e970f89d47e39af712727ef99164@sentry.io/1206231')
    .addPlugin(RavenVue, Vue)
    .install();

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
Vue.component('app-mobile-nav-bar', require('./components/AppMobileNavBar.vue'));
Vue.component('nav-bar-search', require('./components/NavBarSearch.vue'));
// Vue.component('book', require('./components/goodreads/Book.vue'));
Vue.component('public-shelf', require('./components/googleBooks/PublicShelf.vue'));
Vue.component('multiselect', Multiselect);
Vue.component('login-form', require('./components/LoginForm.vue'));
/** friends **/
Vue.component('friends-search', require('./components/FriendSearch.vue'));
/** bulma components **/
Vue.component('drop-down-button', require('./components/bulma/DropDownButton.vue'));


const app = new Vue({
    el: '#app',
    router,
    store,
    data(){
        return {
             // : false,
            // pageLoading: true
        }
    },
    components: {VueSimpleSpinner},
    computed: {
        // pageLoading() {
        //     return store.state.pageLoading;
        // },
        user() {
            return store.getters['user/get'];
        },
        bookcase() {
            return store.getters['bookcase/get'];
        },
        isAuthenticated() {
            return this.$store.getters['user/isAuthenticated'];
        },
        isGuestPage() {
            return ! this.$route.meta.requiresAuth;
        },
        hasShowSideMenu() {
            return this.$route.meta.hasShowSideMenu;
        }
    },
    methods: {
        /** trigger event method */
        triggerEvent(eventName, payload) {
            Event.$emit(eventName, payload);
        },
        unauthorized(){
            return this.$store.commit('authentication/unauthorized');
        },
        changePage($route){
            return router.push($route);
        },
        logout(){
            this.$store.commit('authentication/logout');
            this.$store.commit('user/clear');
            this.changePage('/');
        }
    },
    mounted() {
        let self = this;

        if(!this.user && localStorage.getItem('access_token')){
            self.$store.dispatch('user/get');
            self.$store.dispatch('bookcase/get');
        }

        Event.$on('logout', () => {
            self.logout();
        });

        Event.$on('unauthorized', () => {
            self.unauthorized();
        });

        /** listen for force change page events */
        Event.$on('changePage', ($route) => {
           self.changePage($route);
        });

    },
    beforeDestroy(){
        Event.$off('logout');
        Event.$off('unauthorized');
        Event.$off('changePage');
    }
});
