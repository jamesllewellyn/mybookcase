<!DOCTYPE html>
<html class="has-navbar-fixed-top">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Bookcase</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
          integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="https://blokkfont-losgordos.netdna-ssl.com/v2/blokkfont.css" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="full-height">

    <app-nav-bar :user="user"></app-nav-bar>
    <app-mobile-nav-bar
            :user="user"
            :bookcase="bookcase"
    >
    </app-mobile-nav-bar>

    <div class="columns is-gapless full-height">
        <app-side-bar :user="user" :bookcase="bookcase" v-if="isAuthenticated && hasShowSideMenu"></app-side-bar>
        <div class="column full-height scrollable" :class="[isGuestPage ?  '' :  'is-10-desktop is-9-tablet' ]"
             ref="top">
            <div class="main-content" :class="{ 'page' : $route.name !== 'welcome'}">
                <transition name="fade" mode="out-in">
                    <router-view :key="$route.params.handle"></router-view>
                </transition>
            </div>
            <footer class="footer" v-if="!isAuthenticated || $route.name == 'welcome'">
                <div class="container">
                    <div class="content has-text-centered">
                        <p>
                            <strong>My Bookcase</strong> by <a href="https://github.com/jamesllewellyn/">James
                                Llewellyn</a>.
                        </p>
                        <p>
                            <strong>App Avatars</strong> by <a href="http://avatars.adorable.io/">Adorable Avatars</a>.
                        </p>
                        <p>
                            <strong>Open Source</strong> at
                            <a class="icon" href="https://github.com/jamesllewellyn/mybookcase">
                                <i class="fab fa-github"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <portal-target name="modals" slim></portal-target>

</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>