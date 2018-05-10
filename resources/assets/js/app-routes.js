import VueRouter from 'vue-router';

let routes = [
    {
        path: '',
        redirect: '/home/'
    },
    {
        path: '/',
        redirect: '/home/'
    },
    {
        path: '/home/',
        name: 'home',
        component: require('./pages/Home.vue')
    },
    // {
    //     path: '/inbox/',
    //     name: 'inbox',
    //     component: require('./pages/Inbox.vue')
    // },
    {
        path: '/friends/',
        component: require('./pages/Friends.vue'),
        children: [
            {
                path: '',
                component: require('./pages/FriendsActive.vue'),
                name: 'friends',
            },
            {
                path: 'pending',
                component: require('./pages/FriendRequestsPending.vue'),
                name: 'friends-requests-pending'
            },
            {
                path: 'sent',
                component: require('./pages/FriendRequestsSent.vue'),
                name: 'friends-requests-sent'
            },
            // {
            //     path: 'pending',
            //     component: require('./views/pages/FriendsPending.vue'),
            //     name: 'friends-pending'
            // }
        ]
    },
    {
        path: '/user/:handle/',
        name: 'user-public',
        component: require('./pages/user/User.vue'),
        name: 'user',
        children: [
            {
                path: '',
                component: require('./pages/user/UserPublic.vue'),
                name: 'user-public',
            },
            {
                path: 'shelf/:id',
                component: require('./pages/user/UserShelf.vue'),
                name: 'user-shelf',
            },
        ]
    },
    {
        path: '/shelf/:id',
        component: require('./pages/Shelf.vue')
    },
    {
        path: '/book/:id',
        component: require('./pages/Book.vue')
    },
    {
        path: '/search/',
        component: require('./pages/goodreads/Search.vue'),
        name: 'search'
    },

];

export default new VueRouter({
    routes,
    // mode: 'history'
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});
