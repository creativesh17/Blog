@extends('layouts.website')
@section('title', 'Tag')

@push('css')
    <link href="{{asset('contents/website')}}/category/css/styles.css" rel="stylesheet">
    <link href="{{asset('contents/website')}}/category/css/responsive.css" rel="stylesheet">
@endpush

@section('content')
<div class="slider display-table center-text">
    <h1 class="title display-table-cell"><b>{{ $tag->tag_name }}</b></h1>
</div><!-- slider -->

<section class="blog-area section">
    <div class="container">

        <div class="row">
            @if ($posts->count() > 0)
            
                @foreach ($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                
                                <div class="blog-image"><img src="{{Storage::disk('public')->url('posts/'.$post->post_image)}}" alt="Blog Image"></div>
                                
                                <a class="avatar" href="{{ route('author.profile', $post->author->username) }}"><img src="{{asset('storage/profile/'.$post->author->photo)}}" alt="Profile Image"></a>
                                
                                <div class="blog-info">
                                    
                                    <h4 class="title"><a href="{{ route('post.details', $post->post_slug) }}"><b>{{ $post->post_title }}</b></a></h4>
                                    
                                    <ul class="post-footer">
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
                                    
                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
                @endforeach
            @else
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="single-post post-style-1">
                            <div class="blog-info">
                                <h4 class="title"><strong>No posts found!</strong></h4>
                            </div><!-- blog-info -->
                        </div><!-- single-post -->
                    </div><!-- card -->
                </div><!-- col-lg-4 col-md-6 -->
            @endif
        </div><!-- row -->

        {{-- <b>{{ $tag->posts->links() }}</b> --}}

    </div><!-- container -->
</section><!-- section -->

@endsection

@push('js')

@endpush