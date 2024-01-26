<header>
    <div class="container-fluid position-relative no-side-padding">

        <a href="#" class="logo"><img src="{{asset('contents/website')}}/images/logo.png" alt="Logo Image"></a>

        <div class="menu-nav-icon" data-nav-menu="#main-menu"><i class="ion-navicon"></i></div>

        <ul class="main-menu visible-on-click" id="main-menu">
            <li><a href="{{ route('web.home') }}">Home</a></li>
            <li class="{{ Request::is('posts') ? ' active':'' }}"><a href="{{ route('post.index') }}">Posts</a></li>
            <li><a href="#">Categories</a></li>
            <li><a href="#">Features</a></li>
            @guest
                <li><a href="{{ route('login') }}">Log In</a></li>
            @else
                @if (Auth::user()->role->role_id == 1)
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                @endif
                @if (Auth::user()->role->role_id == 2)
                    <li><a href="{{ route('author.dashboard') }}">Dashboard</a></li>
                @endif
            @endguest
        </ul><!-- main-menu -->

        <div class="src-area">
            <form action="{{ route('search') }}" method="get">
                <button class="src-btn" type="submit"><i class="ion-ios-search-strong"></i></button>
                <input class="src-input" name="search" value="{{ isset($search) ? $search:'' }}" type="text" placeholder="Type of search">
            </form>
        </div>

    </div><!-- conatiner -->
</header>