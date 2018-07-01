import VueRouter from 'vue-router';

let routes = [
    {
        path: '',
        name: 'welcome',
        component: require('./pages/guest/Welcome.vue'),
        meta: { requiresAuth: false, hasShowSideMenu: false }
    },
    {
        path: '/login',
        name: 'login',
        component: require('./pages/guest/Login.vue'),
        meta: { requiresAuth: false, hasShowSideMenu: false }
    },
    {
        path: '/register',
        name: 'register',
        component: require('./pages/guest/Register.vue'),
        meta: { requiresAuth: false, hasShowSideMenu: false }
    },
    {
        path: '/dashboard/',
        name: 'dashboard',
        component: require('./pages/Home.vue'),
        meta: { requiresAuth: true, hasShowSideMenu: true  }
    },
    // {
    //     path: '/inbox/',
    //     name: 'inbox',
    //     component: require('./pages/Inbox.vue')
    // },
    {
        path: '/friends/',
        component: require('./pages/Friends.vue'),
        meta: { requiresAuth: true ,  hasShowSideMenu: true },
        children: [
            {
                path: '',
                component: require('./pages/FriendsActive.vue'),
                name: 'friends',
                meta: { requiresAuth: true,  hasShowSideMenu: true  }
            },
            {
                path: 'pending',
                component: require('./pages/FriendRequestsPending.vue'),
                name: 'friends-requests-pending',
                meta: { requiresAuth: true,  hasShowSideMenu: true  }
            },
            {
                path: 'sent',
                component: require('./pages/FriendRequestsSent.vue'),
                name: 'friends-requests-sent',
                meta: { requiresAuth: true,  hasShowSideMenu: true  }
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
        meta: { requiresAuth: true ,  hasShowSideMenu: true },
        children: [
            {
                path: '',
                component: require('./pages/user/UserPublic.vue'),
                name: 'user-public',
                meta: { requiresAuth: true,  hasShowSideMenu: true  }
            },
            {
                path: 'shelf/:id',
                component: require('./pages/user/UserShelf.vue'),
                name: 'user-shelf',
                meta: { requiresAuth: true,  hasShowSideMenu: true  }
            },
        ]
    },
    {
        path: '/shelf/:id',
        component: require('./pages/Shelf.vue'),
        name: 'shelf',
        meta: { requiresAuth: true,  hasShowSideMenu: true  }
    },
    {
        path: '/book/:id',
        component: require('./pages/Book.vue'),
        name: 'book.view',
        meta: { requiresAuth: false,  hasShowSideMenu: true  }
    },
    {
        path: '/search/',
        component: require('./pages/goodreads/Search.vue'),
        name: 'search',
        meta: { requiresAuth: false,  hasShowSideMenu: true  }
    },

];

const router = new VueRouter({
    routes,
    // mode: 'history'
    scrollBehavior(to, from, savedPosition) {
        return {x: 0, y: 0}
    }
});

router.beforeEach((to, from, next) => {

    if (! to.meta.requiresAuth) {
         next()
        return false
    }

    if (localStorage.getItem('access_token')) {
        next()
        return false
    }

    return next('/login')
});

export default router
