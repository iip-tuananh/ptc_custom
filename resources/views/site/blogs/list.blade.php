@extends('site.layouts.master')
@section('title')
    {{ $cate_title }}
@endsection
@section('description')
    {{ $cate_des ?? '' }}
@endsection

@section('css')
    <style>
        .text-limit-3-line {
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection

@section('content')
    <main>
        <section class="breadcrumb-section section-space-ptb section-space-pb border-bottom-1 border-top-1" style="background-color: #f6f6f6;">
            <div class="breadcrumb-content text-center">
                <h2 class="mb-2">{{ $cate_title }}</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{route('front.home-page')}}">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $cate_title }}</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="shop-page section-space-ptb border-bottom-1">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-xl-3 gy-6">
                    @foreach ($blogs as $blog)
                    <div class="col">
                        <!-- Blog Post Card Start -->
                        <article class="blog-post-card blog-post-card-mask">
                            <a href="{{route('front.detail-blog', $blog->slug)}}" class="blog-post-card-thumbnail">
                                <img src="{{$blog->image ? $blog->image->path : ''}}" alt="{{$blog->name}}" width="450" height="341" loading="lazy">
                            </a>
                            <div class="blog-post-card-content">
                                <div class="blog-post-card-meta">
                                    <a href="{{route('front.list-blog', $blog->category->slug)}}" class="blog-post-card-meta-category">{{$blog->category->name}}</a>
                                </div>
                                <h3 class="blog-post-card-title"><a href="{{route('front.detail-blog', $blog->slug)}}">{{$blog->name}}</a></h3>
                            </div>
                        </article>
                        <!-- Blog Post Card End -->
                    </div>
                    @endforeach
                </div>
                <!-- Shop Pagination Area Start -->
                <div class="pagination-area">
                    <nav aria-label="Page navigation">
                        {{ $blogs->links() }}
                    </nav>
                </div>
                <!-- Shop Pagination Area End -->
            </div>
        </section>
    </main>
@endsection

@push('script')
@endpush
