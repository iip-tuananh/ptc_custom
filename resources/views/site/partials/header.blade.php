<header class="header">
    <!-- Header Top Area Start -->
    <div class="header-top-area bg-dark">
        <div class="container-full px-50">
            <div class="row">
                <div
                    class="col py-2 py-lg-0 d-flex flex-column align-items-center flex-md-row justify-content-center justify-content-md-between">
                    <div class="header-top-area-left-side d-flex">
                        <!-- social Share Area -->
                        <div class="social-share d-flex gap-2 header-top-area-left-side-item">
                            <a class="social-share-link facebook" href="https://www.facebook.com/" target="_blank"
                                aria-label="facebook">
                                <i class="icon-rt-4-facebook-f"></i>
                            </a>
                            <a class="social-share-link twitter" href="https://twitter.com/" target="_blank"
                                aria-label="twitter">
                                <i class="icon-rt-logo-twitter"></i>
                            </a>
                            <a class="social-share-link instagram" href="https://instagram.com/" target="_blank"
                                aria-label="instagram">
                                <i class="icon-rt-logo-instagram"></i>
                            </a>
                            <a class="social-share-link youtube" href="https://www.youtube.com/" target="_blank"
                                aria-label="youtube">
                                <i class="icon-rt-2-youtube2"></i>
                            </a>
                            <a class="social-share-link pinterest" href="https://www.pinterest.com/" target="_blank"
                                aria-label="pinterest">
                                <i class="icon-rt-6-pinterest-p"></i>
                            </a>
                        </div>
                        <!-- social Share Area -->
                        <div class="contact-number header-top-area-left-side-item">
                            <a href="tel:{{ str_replace(' ', '', $config->hotline) }}">
                                <i class="icon-rt-call-outline"></i>
                                <span>{{$config->hotline}}</span>
                            </a>
                        </div>
                    </div>
                    <div class="header-top-area-right-side d-flex">
                        <ul class="header-top-area-right-side-item top-bar-item-menu">
                            <li>
                                <a href="#">Languages <i class="icon-rt-arrow-down"></i></a>
                                <ul class="top-bar-item-menu-dropdow">
                                    <li><a href="javascript:;" onclick="translateheader('en')"><img width="30" src="{{url('/site/images/flag_en.png')}}" alt="" loading="lazy"> English</a></li>
                                    <li><a href="javascript:;" onclick="translateheader('vi')"><img width="30" src="{{url('/site/images/flag_vn.png')}}" alt="" loading="lazy"> Vietnamese</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Top Area End -->
    <!-- Header Bottom Area Start -->
    <div class="hader-bottom-area sticky-header">
        <div class="container-full px-50">
            <div class="row align-items-center">
                <div class="col-4 col-lg-2 order-2 order-lg-1">
                    <!-- Logo Start -->
                    <div class="logo text-center">
                        <a href="{{ route('front.home-page') }}">
                            <img src="{{ $config->image->path ?? '' }}" height="" width="120" alt="logo" loading="lazy">
                        </a>
                    </div>
                    <!-- Logo Start -->
                </div>
                <div class="col-4 col-lg-8 order-1 order-lg-2">
                    <!-- Main Menu Area Start -->
                    <nav class="nav-main-menu d-none d-lg-block">
                        <!-- Main Menu Start -->
                        <ul class="main-menu" style="justify-content: flex-end;">
                            <li class="main-menu-item active">
                                <a href="{{ route('front.home-page') }}" class="main-menu-link">Trang chủ</a>
                            </li>
                            <li class="main-menu-item active">
                                <a href="{{ route('front.about-us') }}" class="main-menu-link">Giới thiệu</a>
                            </li>
                            <li class="main-menu-item active">
                                <a href="{{ route('front.product-custom') }}" class="main-menu-link">Tạo thiết kế</a>
                            </li>
                            <li class="main-menu-item has-children">
                                <a href="#" class="main-menu-link">Sản phẩm</a>
                                <!-- mega menu -->
                                {{-- <div class="megamenu megamenu--mega">
                                    <ul class="megamenu--mega-inner">
                                        @foreach ($productCategories as $category)
                                        <li class="megamenu-item">
                                            <h6 class="megamenu-title"><a href="{{route('front.show-product-category', $category->slug)}}">{{ $category->name }}</a></h6>
                                            @if ($category->childs->count() > 0)
                                            <ul>
                                                @foreach ($category->childs as $child)
                                                <li><a href="{{ route('front.show-product-category', $child->slug) }}" class="megamenu-link">{{ $child->name }}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div> --}}
                                <ul class="megamenu megamenu--mega-lavel-2">
                                    @foreach ($productCategories as $category)
                                    <li class="megamenu-item">
                                        <h6 class="megamenu-title"><a href="{{route('front.show-product-category', $category->slug)}}">{{ $category->name }}</a></h6>
                                        <ul>
                                            @foreach ($category->childs as $child)
                                            <li><a href="{{ route('front.show-product-category', $child->slug) }}" class="megamenu-link">{{ $child->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @foreach ($postCategories as $postCategory)
                            <li class="main-menu-item {{ $postCategory->getChilds()->count() > 0 ? 'has-children' : '' }}">
                                <a href="{{route('front.list-blog', $postCategory->slug)}}" class="main-menu-link">{{ $postCategory->name }}</a>
                                @if ($postCategory->getChilds()->count() > 0)
                                <ul class="submenu">
                                    @foreach ($postCategory->getChilds() as $child)
                                    <li><a href="{{route('front.list-blog', $child->slug)}}" class="submenu-link">{{ $child->name }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                            <li class="main-menu-item active">
                                <a href="{{ route('front.contact-us') }}" class="main-menu-link">Liên hệ</a>
                            </li>
                        </ul>
                        <!-- Main Menu End -->
                    </nav>
                    <!-- Main Menu Area End -->
                    <!-- Mobile Menu Toggole Button Start -->
                    <button class="header-action-item d-lg-none mobile-menu-action"
                        aria-label="Mobile Menu Action Button" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvas-mobile-menu">
                        <i class="icon-rt-bars-solid"></i>
                    </button> <!-- Mobile Menu Toggole Button End -->

                </div>
                <div class="col-4 col-lg-2 order-3 order-lg-3">
                    <!-- Heaer Action Area Start -->
                    <div class="header-action d-flex justify-content-end">
                        <button class="header-action-item d-none d-md-block" title="Search" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvas-search">
                            <i class="icon-rt-loupe"></i>
                        </button>
                        <!-- Search Button Start -->
                        <button class="header-action-item d-md-none" title="Search" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvas-search">
                            <i class="icon-rt-loupe"></i>
                        </button> <!-- Search Button End -->
                        {{-- <button class="header-action-item" title="Cart Bag" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvas-cart">
                            <i class="icon-rt-bag-outline"></i>
                            <span class="header-action-item-count" ng-if="cart.count">(<% cart.count %>)</span>
                        </button> --}}
                    </div>
                    <!-- Heaer Action Area End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Header Bottom Area End -->
</header>
