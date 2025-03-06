<!-- Footer Area Start -->
<footer class="footer-area">
    <div class="footer-top-area section-space-pt">
        <div class="container-xxl">
            <div class="row">
                <div class="col-sm-12 col-md-5 col-lg-4">
                    <!-- Footer Widget Start -->
                    <div class="footer-widget">
                        <h4 class="footer-widget--title" title="{{ $config->short_name_company}}">{{ $config->short_name_company}}
                        </h4>
                        <div class="widget-newsletter">
                            <p class="fs-16 mb-3">  {{$config->web_des}}
                            </p>
                            <p class="mb-0">Số điện thoại: <a href="tel:{{str_replace(' ', '', $config->hotline)}}">{{$config->hotline}}</a></p>
                            <p class="mb-0">Email: <a href="mailto:{{$config->email}}">{{$config->email}}</a></p>
                            <p class="mb-0">Địa chỉ: {{$config->address_company}}</p>
                            </p>
                        </div>
                    </div>
                    <!-- Footer Widget End -->
                </div>
                <div class="col-sm-12 col-md-7 col-lg-8">
                    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-3">
                        <div class="col-md-6">
                            <!-- Footer Widget Start -->
                            <div class="footer-widget">
                                <h4 class="footer-widget--title text-center" title="Menu">Danh mục menu</h4>
                                <ul class="widget--menu" style="display: flex; flex-wrap: wrap;">
                                    <li class="widget--menu-item" style="width: 50%;"><a href="{{ route('front.home-page') }}"
                                            class="widget--menu-link">Trang chủ</a></li>
                                    <li class="widget--menu-item" style="width: 50%;"><a href="{{ route('front.about-us') }}"
                                            class="widget--menu-link">Giới thiệu</a></li>
                                    <li class="widget--menu-item" style="width: 50%;"><a href="{{ route('front.product-custom') }}"
                                            class="widget--menu-link">Tạo thiết kế</a></li>
                                    @foreach ($product_categories as $category)
                                    <li class="widget--menu-item" style="width: 50%;"><a href="{{ route('front.show-product-category', $category->slug) }}"
                                            class="widget--menu-link">{{ $category->name }}</a></li>
                                    @endforeach
                                    @foreach ($post_categories as $postCategory)
                                    <li class="widget--menu-item" style="width: 50%;"><a href="{{ route('front.list-blog', $postCategory->slug) }}"
                                            class="widget--menu-link">{{ $postCategory->name }}</a></li>
                                    @endforeach
                                    <li class="widget--menu-item" style="width: 50%;"><a href="{{ route('front.contact-us') }}"
                                            class="widget--menu-link">Liên hệ</a></li>
                                </ul>
                            </div>
                            <!-- Footer Widget End -->
                        </div>
                        <div class="col-md-6">
                            <!-- Footer Widget Start -->
                            <div class="footer-widget">
                                <h4 class="footer-widget--title" title="Google Map">Google Map</h4>
                                {!! $config->location !!}
                            </div>
                            <!-- Footer Widget End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom bg-dark py-3">
        <div class="container-xxl">
            <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-center">
                <p class="text-white mb-md-0">Copyright &copy; <a href="{{ route('front.home-page') }}"
                        target="_blank">{{ $config->web_title}}</a>. All Rights Reserved.</p>
                <div class="payment">
                    {{-- <img src="assets/images/others/payment.png" width="286" height="23" alt="payment image"> --}}
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Area End -->
