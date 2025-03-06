@extends('site.layouts.master')
@section('title')
{{$config->web_title}}
@endsection
@section('description')
{{$config->web_des}}
@endsection
@section('image')
{{url(''.$banners[0]->image->path)}}
@endsection
@section('css')
@endsection
@section('content')
<main>
    <!-- Hero Slider Section Start -->
    <section class="hero-area">
        <!-- Swiper Slider Main Start -->
        <div class="swiper hero-slider-active">
            <!-- Swiper Wrapper Start -->
            <div class="swiper-wrapper">
                <!-- Swiper Slide Item Start -->
                @foreach ($banners as $banner)
                <div class="swiper-slide">
                    <div class="hero-slider-item">
                        <div class="hero-slider-image">
                            <img src="{{ $banner->image->path }}" alt="banner" width="1600"
                                height="717" loading="lazy">
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- Swiper Slide Item End -->
            </div>
            <!-- Swiper Wrapper End -->
            <!-- swiper Navigation -->
            <div class="hero-swiper-button-next swiper-navigation-next"><i class="icon-rt-arrow-right"></i></div>
            <div class="hero-swiper-button-prev swiper-navigation-prev"><i class="icon-rt-arrow-left"></i></div>
            <!-- swiper pagination -->
            <div class="hero-swiper-pagination swiper-pagination-button text-center position-absolute mb-3"></div>
        </div>
        <!-- Swiper Slider Main End -->
    </section>
    <!-- Hero Slider Section End -->
    {{-- <section class="deal-offer-section position-relative">
        <div class="deal-offer-bg-image">
            <img src="assets/images/deal-offer/bkg_banner2_bag2.jpg" alt="Deal Offer Image" width="1920" height="680">
        </div>
        <div class="deal-offer-content position-absolute top-50 translate-middle-y w-full">
            <div class="container">
                <h2 class="deal-offer-title">Nike Brasilla <br> Medium Backpacks</h2>
                <h5>Best quality Backpacks Dealer in Singapore</h5>
                <div class="outline-countdown countdown my-4" data-countdown="2023/12/18 23:59:59">
                    <div class="product-countdown-item">
                        <div class="product-countdown-item--value days">00</div>
                        <div class="product-countdown-item--label">
                            Days
                        </div>
                    </div>
                    <div class="product-countdown-item">
                        <div class="product-countdown-item--value hours">00</div>
                        <div class="product-countdown-item--label">
                            Hours
                        </div>
                    </div>
                    <div class="product-countdown-item">
                        <div class="product-countdown-item--value minutes">00</div>
                        <div class="product-countdown-item--label">
                            Mins
                        </div>
                    </div>
                    <div class="product-countdown-item">
                        <div class="product-countdown-item--value seconds">00</div>
                        <div class="product-countdown-item--label">
                            Secs
                        </div>
                    </div>
                </div>
                <a href="shop.html" class="btn-primary btn-lg mt-20">Shop Now</a>
            </div>
        </div>
    </section> --}}
    @foreach ($categorySpecial as $category)
    @if ($category->image)
    <section class="banner-section mt-50">
        <div class="container-full px-50">
            <div class="row gy-6">
                <div class="col">
                    <figure class="banner-card banner-card-animation-one">
                        <a href="{{route('front.show-product-category', $category->slug)}}" class="banner-card-image small-device-image-large">
                            <img src="{{$category->image ? $category->image->path : ''}}" alt="{{$category->name}}" width="450" height="570" loading="lazy">
                        </a>
                    </figure>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- Product Section Start -->
    <section class="product-section section-space-ptb">
        <div class="container">
            <!-- Section Title Area Start -->
            <div class="section-title-area text-center">
                <h2 class="section-title">{{$category->name}}</h2>
            </div>
            <!-- Section Title Area End -->
            <!-- Swiper Slider Main Start -->
            <div class="swiper product-row-2-slider-active position-relative">
                <!-- Swiper Wrapper Start -->
                <div class="swiper-wrapper">
                    <!-- Swiper Slide Item Start -->
                    @foreach ($category->products as $product)
                    <div class="swiper-slide">
                        <!-- Product Card Start -->
                        @include('site.products.product_item', ['product' => $product])
                        <!-- Product Card End -->
                    </div>
                    @endforeach
                    <!-- Swiper Slide Item End -->
                </div>
                <!-- swiper Navigation -->
                <div class="product-row-2-swiper-button-next swiper-navigation-next z-1"><i
                        class="icon-rt-arrow-right"></i></div>
                <div class="product-row-2-swiper-button-prev swiper-navigation-prev z-1"><i
                        class="icon-rt-arrow-left"></i></div>
            </div>
            <!-- Swiper Slider Main End -->
        </div>
    </section>
    <!-- Product Section End -->
    @endforeach
    <!-- Banner Section Start -->
    <section class="banner-section section-space-pb">
        <div class="container">
            <!-- Section Title Area Start -->
            {{-- <div class="section-title-area text-center">
                <h2 class="section-title">Danh mục sản phẩm</h2>
            </div> --}}
            <!-- Section Title Area End -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 gy-6">
                @foreach ($productCategories as $category)
                <div class="col">
                    <figure class="banner-card banner-card-animation-two">
                        <a href="{{ route('front.show-product-category', $category->slug) }}" class="banner-card-image">
                            <img src="{{ $category->image ? $category->image->path : '' }}" alt="{{ $category->name }}" width="450"
                                height="570" loading="lazy">
                        </a>
                        <figcaption class="banner-card-content mt-3">
                            <a class="banner-card-button" href="{{ route('front.show-product-category', $category->slug) }}">{{ $category->name }}</a>
                        </figcaption>
                    </figure>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Banner Section End -->
    <!-- Product Section Start -->
    <section class="product-section section-space-ptb bg-dark">
        <div class="container">
            <!-- Section Title Area Start -->
            <div class="section-title-area text-center">
                <h2 class="section-title text-white">Đánh giá của khách hàng</h2>
            </div>
            <!-- Section Title Area End -->
            <!-- Swiper Slider Main Start -->
            <div class="swiper product-slider-active position-relative">
                <!-- Swiper Wrapper Start -->
                <div class="swiper-wrapper">
                    <!-- Swiper Slide Item Start -->
                    @foreach ($reviews as $review)
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p class="testimonial-content text-white">
                                {{$review->message}}
                            </p>
                            <div class="testimonial-author-box justify-content-center">
                                <div class="testimonial-author-thum">
                                    <img src="{{$review->image ? $review->image->path : ''}}" width="100"
                                        height="100" alt="Testimonial 01" loading="lazy">
                                </div>
                                <div class="testimonial-author">
                                    <p class="testimonial-author-name text-white">{{$review->name}}</p>
                                    <p class="testimonial-author-designation text-white">{{$review->position}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- Swiper Slide Item End -->
                </div>
                <div class="product-navigation-bottom-wrap">
                    <!-- swiper Navigation -->
                    <div class="product-swiper-button-prev swiper-navigation-bottom-prev z-1"><i
                            class="icon-rt-arrow-left"></i></div>
                    <div class="product-swiper-button-next swiper-navigation-bottom-next z-1"><i
                            class="icon-rt-arrow-right"></i></div>
                </div>
            </div>
            <!-- Swiper Slider Main End -->
        </div>
    </section>
    <!-- Product Section End -->
    <!-- Testimonials Section Start -->
    <section class="testimonials-section section-space-ptb">
        <div class="container">
            <!-- Section Title Area Start -->
            <div class="section-title-area text-center">
                <h2 class="section-title">Tin tức mới nhất</h2>
            </div>
            <!-- Section Title Area End -->
            <!-- Swiper Slider Main Start -->
            <div class="swiper testimonials-slider-active">
                <!-- Swiper Wrapper Start -->
                <div class="swiper-wrapper">
                    <!-- Swiper Slide Item Start -->
                    @foreach ($newBlogs as $blog)
                    <div class="swiper-slide">
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
                    </div>
                    @endforeach
                    <!-- Swiper Slide Item End -->
                </div>
                <!-- Swiper Wrapper End -->
                <!-- swiper Navigation -->
                <div class="testimonial-swiper-button-next swiper-navigation-next"><i
                        class="icon-rt-arrow-right"></i></div>
                <div class="testimonial-swiper-button-prev swiper-navigation-prev"><i
                        class="icon-rt-arrow-left"></i></div>
            </div>
            <!-- Swiper Slider Main End -->
        </div>
    </section>
    <!-- Testimonials Section End -->
    <!-- Patner Brand Section Start -->
    <section class="patner-brand-section section-space-ptb border-top-1 border-bottom-1">
        <div class="container">
            <h2 class="visually-hidden">Đối tác</h2>
            <!-- Swiper Slider Main Start -->
            <div class="swiper patner-brand-slider-active">
                <!-- Swiper Wrapper Start -->
                <div class="swiper-wrapper">
                    <!-- Swiper Slide Item Start -->
                    @foreach ($partners as $partner)
                    <div class="swiper-slide">
                        <a href="{{$partner->link}}" class="single-patner-brand" target="_blank">
                            <img src="{{$partner->image ? $partner->image->path : ''}}" width="207" height="46" alt="{{$partner->name}}"
                                loading="lazy">
                        </a>
                    </div>
                    @endforeach
                    <!-- Swiper Slide Item End -->
                </div>
                <!-- Swiper Wrapper End -->
            </div>
            <!-- Swiper Slider Main End -->
        </div>
    </section>
    <!-- Patner Brand Section End -->
</main>
@endsection
@push('script')
@endpush
