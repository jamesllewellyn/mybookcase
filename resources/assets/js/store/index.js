import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

/** Import Modules **/
import friends from './friends';
import user from './user';
import authentication from './authentication';
import bookcase from './bookcase';

const store = new Vuex.Store({
    modules: {
        friends,
        user,
        authentication,
        bookcase
    },
    state: {
        pageLoading: true,
    },

});

export default store;