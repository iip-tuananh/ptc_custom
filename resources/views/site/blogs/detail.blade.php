@extends('site.layouts.master')
@section('title')
    {{ $blog_title }}
@endsection

@section('description')
    {{ $blog_des }}
@endsection

@section('css')
@endsection

@section('content')
    <main>
        <section class="breadcrumb-section section-space-ptb section-space-pb border-bottom-1 border-top-1" style="background-color: #f6f6f6;">
            <div class="breadcrumb-content text-center">
                <h2 class="mb-2">{{ $blog_title }}</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{route('front.home-page')}}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{route('front.list-blog', $category->slug)}}">{{ $category->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $blog_title }}</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="shop-page section-space-ptb border-bottom-1">
            <div class="container">
                <div class="row gy-5 justify-content-center">
                    <div class="order-1 order-md-1 col-md-8 col-lg-8">
                        <div class="row row-cols-1">
                            <div class="col">
                                <!-- Blog Post Start -->
                                <article class="blog-post-card">
                                    <div class="blog-post-header">
                                        <div class="blog-post-meta">
                                            <div class="blog-post-meta-data fs-16">
                                                Ngày đăng <a href="#" class="blog-post-meta-data-link text-black">
                                                    {{ $blog->created_at->format('d/m/Y') }}</a>
                                            </div>
                                        </div>
                                        <h2 class="blog-post-title mb-7">{{ $blog_title }}</h2>
                                        <div class="blog-post-meta-data fs-16">
                                            {!! $blog->intro !!}
                                        </div>
                                    </div>
                                    <div class="blog-post-card-thumbnail mb-10">
                                        <img src="{{$blog->image ? $blog->image->path : ''}}" alt="{{$blog->name}}" loading="lazy">
                                    </div>
                                    <div class="row">
                                        <div class="col-10 mx-auto ">
                                            <div class="blog-post-contents fs-16">
                                                {!! $blog->body !!}
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <!-- Posts comments End -->
                            </div>
                        </div>
                    </div>
                    <div class="order-2 order-md-2 col-md-4 col-lg-4">
                        <aside class="blog-sidebar">
                            <!-- Blog Widget Recent Post Start -->
                            <div class="blog-widget blog-widget-recent-posts">
                                <h5 class="blog-widget-title">Bài viết liên quan</h5>
                                <div class="row">
                                    @foreach ($other_blogs as $other_blog)
                                    <div class="col-12">
                                        <!-- Blog Post Card Start -->
                                        <article class="blog-post-card blog-post-card-mask">
                                            <a href="{{route('front.detail-blog', $other_blog->slug)}}" class="blog-post-card-thumbnail">
                                                <img src="{{$other_blog->image ? $other_blog->image->path : ''}}" alt="{{$other_blog->name}}" width="450" height="341" loading="lazy">
                                            </a>
                                            <div class="blog-post-card-content">
                                                <div class="blog-post-card-meta">
                                                    <a href="{{route('front.list-blog', $blog->category->slug)}}" class="blog-post-card-meta-category">{{$blog->category->name}}</a>
                                                </div>
                                                <h3 class="blog-post-card-title"><a href="{{route('front.detail-blog', $other_blog->slug)}}">{{$other_blog->name}}</a></h3>
                                            </div>
                                        </article>
                                        <!-- Blog Post Card End -->
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Blog Widget Meta End -->
                        </aside>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('script')
@endpush
