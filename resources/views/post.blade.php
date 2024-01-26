@extends('layouts.website')
@section('title')
{{$post->post_title}}
@endsection

@push('css')
    <link href="{{asset('contents/website')}}/single-post-1/css/styles.css" rel="stylesheet">
    <link href="{{asset('contents/website')}}/single-post-1/css/responsive.css" rel="stylesheet">

    <style>
        .header-bg{
            height: 400px;
            width: 100%;
            background-image: url("{{ Storage::disk('public')->url('category/slider/'.$post->categories->first()->cate_image) }}");
            background-size: cover;
        }
    </style>
@endpush

@section('content')

    <section class="post-area section">
        <div class="container">

            <div class="row">

                <div class="col-lg-8 col-md-12 no-right-padding">

                    <div class="main-post">

                        <div class="blog-post-inner">

                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="{{ route('author.profile', $post->author->username) }}"><img src="{{ Storage::disk('public')->url('profile/'.$post->author->photo) }}" alt="Profile Image"></a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="#"><b>{{ $post->author->name }}</b></a>
                                    <h6 class="date">{{ $post->created_at->diffForHumans() }}</h6>
                                </div>

                            </div><!-- post-info -->

                            <h3 class="title"><a href="#"><b>{{ $post->post_title }}</b></a></h3>

                            <p class="para">{!! html_entity_decode($post->post_body) !!}</p>

                            <div class="post-image"><img src="{{ Storage::disk('public')->url('posts/'.$post->post_image) }}" alt="Blog Image"></div>

                            <p class="para">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
                            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                            nulla pariatur. Excepteur sint
                            occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>

                            <ul class="tags">
                                @foreach ($post->tags as $tag)
                                    <li><a href="{{ route('tag.posts', $tag->tag_slug) }}"></a>{{ $tag->tag_name }}</li>
                                @endforeach
                            </ul>
                        </div><!-- blog-post-inner -->

                        <div class="post-icons-area">
                            <ul class="post-icons">
                                <li>
                                    @guest
                                    <a href="javascript:void(0);" onclick="toastr.info('To add to favorite list. You need to log in first.','Info', {
                                        closeButton: true,
                                        progressbar: true,
                                    })"><i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}
                                    </a>
                                    @else
                                    <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $post->post_id }}').submit();" class="{{ Auth::user()->favorite_posts->where('pivot.post_id', $post->post_id)->count() != 0 ? 'favorite_posts':'' }}">
                                        <i class="ion-heart"></i>
                                        {{ $post->favorite_to_users->count() }}
                                    </a>
                                    <form id="favorite-form-{{ $post->post_id }}" action="{{ route('post.favorite', $post->post_id) }}" method="post" style="display: none;">
                                        @csrf
                                    </form>
                                    @endguest
                                </li>
                                <li><a href="#"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a></li>
                                <li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
                            </ul>

                            <ul class="icons">
                                <li>SHARE : </li>
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
                            </ul>
                        </div>


                    </div><!-- main-post -->
                </div><!-- col-lg-8 col-md-12 -->

                <div class="col-lg-4 col-md-12 no-left-padding">

                    <div class="single-post info-area">

                        <div class="sidebar-area about-area">
                            <h4 class="title"><b>ABOUT Author</b></h4>
                            <p>{{ $post->author->about }}</p>
                        </div>

                        <div class="tag-area">

                            <h4 class="title"><b>CATEGORIES</b></h4>
                            <ul>
                                @foreach ($post->categories as $category)
                                    <li><a href="{{ route('category.posts', $category->cate_slug) }}"></a>{{ $category->cate_name }}</li>
                                @endforeach
                            </ul>

                        </div><!-- subscribe-area -->

                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- post-area -->


    <section class="recomended-area section">
        <div class="container">
            <div class="row">
                @foreach ($randomPosts as $randomPost)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="single-post post-style-1">
    
                            <div class="blog-image"><img src="{{Storage::disk('public')->url('posts/'.$randomPost->post_image)}}" alt="Blog Image"></div>
    
                            <a class="avatar" href="#"><img src="{{asset('storage/profile/'.$randomPost->author->photo)}}"  alt="Profile Image"></a>
    
                            <div class="blog-info">
    
                                <h4 class="title"><a href="{{ route('post.details', $randomPost->post_slug) }}"><b>{{ $randomPost->post_title }}</b></a></h4>
    
                                <ul class="post-footer">
                                    <li>
                                        @guest
                                        <a href="javascript:void(0);" onclick="toastr.info('To add to favorite list. You need to log in first.','Info', {
                                            closeButton: true,
                                            progressbar: true,
                                        })"><i class="ion-heart"></i>{{ $randomPost->favorite_to_users->count() }}
                                        </a>
                                        @else
                                        <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $randomPost->post_id }}').submit();" class="{{ Auth::user()->favorite_posts->where('pivot.post_id', $randomPost->post_id)->count() != 0 ? 'favorite_posts':'' }}">
                                            <i class="ion-heart"></i>
                                            {{ $post->favorite_to_users->count() }}
                                        </a>
                                        <form id="favorite-form-{{ $randomPost->post_id }}" action="{{ route('post.favorite', $randomPost->post_id) }}" method="post" style="display: none;">
                                            @csrf
                                        </form>
                                        @endguest
                                    </li>
                                    <li><a href="#"><i class="ion-chatbubble"></i>{{ $randomPost->comments->count() }}</a></li>
                                    <li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
                                </ul>
    
                            </div><!-- blog-info -->
                        </div><!-- single-post -->
                    </div><!-- card -->
                </div>
                @endforeach
            </div><!-- row -->
        </div><!-- container -->
    </section>

    <section class="comment-section">
        <div class="container">
            <h4><b>POST COMMENT</b></h4>
            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="comment-form">
                        @guest
                        <p>To post a new comment. You need to log in first. <a href="{{ route('login') }}">Log In</a></p>
                        @else
                        <form method="post" action="{{ route('comment.submit', $post->post_id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <textarea name="comment" rows="2" class="text-area-messge form-control"
                                    placeholder="Enter your comment"></textarea >
                                </div><!-- col-sm-12 -->
                                <div class="col-sm-12">
                                    <button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
                                </div><!-- col-sm-12 -->
                            </div><!-- row -->
                        </form>
                        @endguest
                    </div><!-- comment-form -->

                    <h4><b>COMMENTS({{ $post->comments->count() }})</b></h4>
                    @forelse($post->comments as $comment)
                        <div class="commnets-area ">
                            <div class="comment">
                                <div class="post-info">
                                    <div class="left-area">
                                        <a class="avatar" href="#"><img src="{{ Storage::disk('public')->url('profile/'.$comment->user->photo) }}" alt="Profile Image"></a>
                                    </div>
                                    <div class="middle-area">
                                        <a class="name" href="#"><b>{{ $comment->user->name }}</b></a>
                                        <h6 class="date">&nbsp;&nbsp; {{ $comment->created_at->diffForHumans() }}</h6>
                                    </div>
                                </div><!-- post-info -->
                                <p>{{ $comment->comment }}</p>
                            </div>
                        </div><!-- commnets-area -->
                    @empty
                        <div class="commnets-area">
                            <div class="comment">
                                <p class="alert alert-info">No commnets yet! Be the first one.</p>
                            </div>
                        </div>
                    @endforelse

                </div><!-- col-lg-8 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section>
@endsection


@push('js')

@endpush