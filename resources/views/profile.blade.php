@extends('layouts.website')
@section('title', 'Profile')

@push('css')
    <link href="{{asset('contents/website')}}/category-sidebar/css/styles.css" rel="stylesheet">
    <link href="{{asset('contents/website')}}/category-sidebar/css/responsive.css" rel="stylesheet">

    <style>
        
    </style>
@endpush

@section('content')
<div class="slider display-table center-text">
    <h1 class="title display-table-cell"><b>{{ $author->name }}</b></h1>
</div>
<!-- slider -->

<section class="blog-area section">
    <div class="container">

        <div class="row">

            <div class="col-lg-8 col-md-12">
                <div class="row">
                    @if($posts->count() > 0 )
                    @foreach ($posts as $post)
                    <div class="col-sm-12 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{Storage::disk('public')->url('posts/'.$post->post_image)}}" alt="Blog Image"></div>

                                <a class="avatar" href="{{ route('author.profile', $post->author->username) }}"><img src="{{asset('storage/profile/'.$post->author->photo)}}"  alt="Profile Image"></a>

                                <div class="blog-info">

                                    <h4 class="title"><a href="{{ route('post.details', $post->post_slug) }}"><b>{{ $post->post_title }}</b></a></h4>

                                    <ul class="post-footer">
                                        <li>
                                            @guest
                                            <a href="javascript:void(0);" onclick="toastr.info('To add to favorite list. You need to log in first.','Info', {
                                                closeButton: true,
                                                progressbar: true,
                                            })"><i class="ion-heart"></i>
                                            {{ $post->favorite_to_users->count() }}
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

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->    
                    @endforeach
                    @else
                    <div class="col-sm-12 col-md-12">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                <div class="blog-info">
                                    <div class="title">
                                        <strong>No Posts Found!</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
                <!-- row -->

                {{-- <a class="load-more-btn" href="#"><b>LOAD MORE</b></a> --}}

            </div>
            <!-- col-lg-8 col-md-12 -->

            <div class="col-lg-4 col-md-12 ">

                <div class="single-post info-area ">

                    <div class="about-area">
                        <h4 class="title"><b>ABOUT AUTHOR</b></h4>
                        <p>{{ $author->name }}</p><br/>
                        <p>{{ $author->about }}</p><br/>
                        <strong>Author Since: {{ $author->created_at->toDateString() }}</strong><br/>
                        <strong>Total Posts: {{ $author->posts->count() }}</strong>
                    </div>

                </div>
                <!-- info-area -->

            </div>
            <!-- col-lg-4 col-md-12 -->

        </div>
        <!-- row -->

    </div>
    <!-- container -->
</section>
<!-- section -->
@endsection


@push('js')

@endpush