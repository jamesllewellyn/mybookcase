<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Bookcase</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="{{ mix('css/welcome.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar is-transparent">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item has-text-white" href="../">
                    {{--My Bookcase--}}

                    {{--<img src="images/logo/my-bookcase_logo.png" alt="Logo">--}}
                </a>
                <span class="navbar-burger burger" data-target="navbarMenu">
          <span></span>
          <span></span>
          <span></span>
        </span>
            </div>
            <div id="navbarMenu" class="navbar-menu">
                <div class="navbar-end has-text-white">
                    <a class="navbar-item  is-active" href="https://github.com/jamesllewellyn/get-stuff-done">
                            <span class="icon">
                                <i class="fa fa-github"></i>
                            </span>
                    </a>
                    @if (Route::has('login'))
                        @if (Auth::check())
                            <span class="navbar-item ">
                              <a class="button is-primary " href="{{ url('/home') }}">
                                <span>Dashboard</span>
                              </a>
                            </span>
                        @else
                            <a class="navbar-item " href="{{ url('/login') }}">
                                Login
                            </a>
                            <span class="navbar-item ">
                              <a class="button is-primary" href="{{ url('/register') }}">
                                <span>Build your Bookcase</span>
                              </a>
                            </span>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="hero homepage-hero is-medium">
        <div class="hero-body ">
            <div class="container has-text-centered">
                <h1 class="title is-quicksans has-text-centered">
                    My Bookcase
                </h1>
                <h2 class="subtitle">
                    Your new online bookcase for organising, sharing and growing your book collection.
                </h2>
            </div>
        </div>
    </section>

    <section class="hero homepage-hero is-medium is-bold is-background-color">
        <div class="hero-body ">
            <div class="columns features">
                <div class="column is-4">
                    <div class="card is-shadowless">
                        <div class="card-image has-text-centered">
                            <img src="/images/home-page/my-book-shelf-organise.jpg" alt="">
                        </div>
                        <div class="card-content">
                            <div class="content">
                                <h4 class="has-text-weight-semibold">Organise</h4>
                                <p>Create a virtual bookcase to organise your books into as many bookshelves you can
                                    think of. </p>
                                {{--<p><a href="#">Learn more</a></p>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="card is-shadowless">
                        <div class="card-image has-text-centered">
                            <img src="/images/home-page/my-book-shelf-discover.jpg" alt="">
                        </div>
                        <div class="card-content">
                            <div class="content">
                                <h4 class="has-text-weight-semibold">Discover</h4>
                                <p>Search and discover new book from top sellers list and see the books other users
                                    love.</p>
                                {{--<p><a href="#">Learn more</a></p>--}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="column is-4">
                    <div class="card is-shadowless">
                        <div class="card-image has-text-centered">
                            <img src="/images/home-page/my-book-shelf-share.jpg" alt="">
                        </div>
                        <div class="card-content">
                            <div class="content">
                                <h4 class="has-text-weight-semibold">Share</h4>
                                <p>Make and take suggestions from friends, share the books you love </p>
                                {{--<p><a href="#">Learn more</a></p>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="hero is-medium is-bold is-dark">
        <div class="hero-body ">
            <div class="container">
                <div class="columns">
                    <div class="column is-half">
                        <img src="/images/home-page/mybookcase-home.png" alt="">
                    </div>
                    <div class="column is-half">
                        <h1 class="title is-quicksans">
                            New York Times Best Sellers
                        </h1>
                        <h2 class="subtitle">
                            Explore the current list of New York Times best sellers.
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="hero is-medium is-bold ">
        <div class="hero-body ">
            <div class="container">
                <div class="columns">
                    <div class="column is-half">
                        <h1 class="title is-quicksans">
                            Public and Private Shelves
                        </h1>
                        <h2 class="subtitle">
                            Build shelves made up of books that you love and make them public so your friends and see them, or create private collections just for yourself.
                        </h2>
                    </div>
                    <div class="column is-half">
                        <img src="/images/home-page/mybookcase-shelf.png" alt="" class="has-shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="hero is-medium is-bold is-dark">
        <div class="hero-body ">
            <div class="container">
                <div class="columns">
                    <div class="column is-half">
                        <img src="/images/home-page/mybookcase-book.png" alt="">
                    </div>
                    <div class="column is-half">
                        <h1 class="title is-quicksans">
                            Search
                        </h1>
                        <h2 class="subtitle">
                            Find books and see their goodreads rating and description and add them to your shelves
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="container">
            <div class="content has-text-centered">
                <p>
                    <strong>My Bookcase</strong> by <a href="https://github.com/jamesllewellyn/">James Llewellyn</a>.
                </p>
                <p>
                    <strong>App Avatars</strong> by <a href="http://avatars.adorable.io/">Adorable Avatars</a>.
                </p>
                <p>
                    <a class="icon" href="https://github.com/jamesllewellyn/my-book-shelf">
                        <i class="fa fa-github"></i>
                    </a>
                </p>
            </div>
        </div>
    </footer>
</div>

{{--<section class="container homepage-content">--}}

{{--</section>--}}

{{--<section class="container homepage-top-books">--}}
{{--<div class="content">--}}
{{--<h2>Goodreads Top Six Books for March</h2>--}}
{{--</div>--}}
{{--<div class="columns books">--}}
{{--<div class="column is-one-fifth">--}}
{{--<div class="card ">--}}
{{--<div class="card-image has-text-centered">--}}
{{--<img src="/images/home-page/my-book-shelf-share.jpg" alt="">--}}
{{--</div>--}}
{{--<div class="card-content">--}}
{{--<div class="content">--}}
{{--<h4 class="has-text-weight-semibold">Share</h4>--}}
{{--<p>Search and discover new books. Make and take suggestions from friends. Collaborate with friend on collections </p>--}}
{{--<p><a href="#">Learn more</a></p>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}

{{--</div>--}}

{{--</section>--}}

</body>
</html>