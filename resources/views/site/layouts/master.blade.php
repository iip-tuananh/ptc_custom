<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    @include('site.partials.head')
    <!-- CSS (Font, Vendor, Icon, Plugins & Style CSS files) -->
    <!-- Font CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS (Bootstrap & Icon Font) -->
    <link rel="stylesheet" href="{{ env('AWS_R2_URL') }}/site/css/bootstrap.min.css">
    <!-- Plugins CSS (All Plugins Files) -->
    <link rel="stylesheet" href="{{ env('AWS_R2_URL') }}/site/css/roadthemes-icon.css">
    <link rel="stylesheet" href="{{ env('AWS_R2_URL') }}/site/css/swiper-bundle.min.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ env('AWS_R2_URL') }}/site/css/style.css">
    <link rel="stylesheet" href="/site/css/callbutton.css">

    @yield('css')
    <script src="{{ env('AWS_R2_URL') }}/site/js/jquery-3.6.0.min.js"></script>

    <!-- Angular Js -->
    <script src="{{ asset('libs/angularjs/angular.js?v=222222') }}"></script>
    <script src="{{ asset('libs/angularjs/angular-resource.js') }}"></script>
    <script src="{{ asset('libs/angularjs/sortable.js') }}"></script>
    <script src="{{ asset('libs/dnd/dnd.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.9/angular-sanitize.js"></script>
    <script src="{{ asset('libs/angularjs/select.js') }}"></script>
    <script src="{{ asset('js/angular.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    @stack('script')
    <script>
        app.factory('cartItemSync', function ($interval) {
            var cart = {items: null, total: null};

            cart.items = @json($cartItems);
            cart.count = {{$cartItems->sum('quantity')}};
            cart.total = {{$totalPriceCart}};

            return cart;
        });

        app.controller('AppController', function($rootScope, $scope, cartItemSync, $interval, $compile){
            $scope.cart = cartItemSync;

            $scope.changeQty = function (qty, product_id) {
                updateCart(qty, product_id)
            }

            $scope.incrementQuantity = function (product) {
                product.quantity = Math.min(product.quantity + 1, 9999);
            };

            $scope.decrementQuantity = function (product) {
                product.quantity = Math.max(product.quantity - 1, 0);
            };

            // var container = angular.element(document.getElementsByClassName('item_product_main'));
            // $compile(container.contents())($scope);

            $scope.addToCart = function (productId, quantity = 1) {
                url = "{{route('cart.add.item', ['productId' => 'productId'])}}";
                url = url.replace('productId', productId);
                let item_qty = quantity;

                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    },
                    data: {
                        'qty': parseInt(item_qty)
                    },
                    success: function (response) {
                        if (response.success) {
                            if (response.count > 0) {
                                $scope.hasItemInCart = true;
                            }

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function () {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);
                            toastr.success('Thao tác thành công !')
                        }
                    },
                    error: function () {
                        toastr.error('Thao tác thất bại !')
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }

            function updateCart(qty, product_id) {
                jQuery.ajax({
                    type: 'POST',
                    url: "{{route('cart.update.item')}}",
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    },
                    data: {
                        product_id: product_id,
                        qty: qty
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.total_qty = response.count;
                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function(){
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.$applyAsync();
                        }
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }

            // xóa item trong giỏ
            $scope.removeItem = function (product_id) {
                jQuery.ajax({
                    type: 'GET',
                    url: "{{route('cart.remove.item')}}",
                    data: {
                        product_id: product_id
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.cart.items = response.items;
                            $scope.cart.count = Object.keys($scope.cart.items).length;
                            $scope.cart.totalCost = response.total;

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function(){
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            if ($scope.cart.count == 0) {
                                $scope.hasItemInCart = false;
                            }
                            $scope.$applyAsync();
                        }
                    },
                    error: function (e) {
                        jQuery.toast.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }

            // Xem nhanh
            $scope.showQuickView = function (slug) {
                $scope.quickViewProduct = {};
                $.ajax({
                    url: "{{route('front.get-product-quick-view')}}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    },
                    data: {
                        slug: slug
                    },
                    success: function (response) {
                        $scope.quickViewProduct = response.data;
                        $scope.$applyAsync(function () {
                            setTimeout(function () {
                                var swiperProductThumbItem = new Swiper(".product-quickview-sm-thum-active", {
                                    // slidesPerView: 'auto',
                                    spaceBetween: 10,
                                    // centeredSlides: false,
                                    loop: true,
                                    // slideToClickedSlide: true,
                                    slidesPerView: 4,
                                    // center: true,
                                });

                                var swiperProductLargeItem = new Swiper(".product-quickview-lg-active", {
                                    slidesPerView: 1,
                                    // centeredSlides: true,
                                    loop: true,
                                    loopedSlides: 1,
                                    navigation: {
                                        nextEl: ".product-details-button-next",
                                        prevEl: ".product-details-button-prev",
                                    },
                                    thumbs: {
                                        swiper: swiperProductThumbItem,
                                    },
                                });
                            }, 100);
                        });
                        $scope.$applyAsync();
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        // $scope.$applyAsync();
                    }
                });
            }
        })
    </script>
    <style>
        .product-attributes {
            margin-bottom: 0 !important;
        }
        .product-attributes label {
            font-weight: 600;
            margin-bottom: 0 !important;
        }
        .product-attribute-values {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .product-attribute-values .badge,
        .product-attribute-values .badge+ .badge {
            width: auto;
            border: 1px solid #0974ba;
            /* padding: 2px 10px;
            border-radius: 5px; */
            font-size: 14px;
            color: #0974ba;
            height: 30px;
            cursor: pointer;
            pointer-events: auto;
        }
        .product-attribute-values .badge:hover {
            background-color: #0974ba;
            color: #fff;
        }
        .product-attribute-values .badge.active {
            background-color: #0974ba;
            color: #fff;
        }
    </style>
</head>

<body ng-app="App" ng-cloak ng-controller="AppController">
    @include('site.partials.header')
    @yield('content')
    @include('site.partials.footer')
    <!-- OffCanvas Cart Start -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-cart">
        <div class="offcanvas-cart-wrap">
            <div class="offcanvas-cart-header">
                <div class="offcanvas-cart-title">
                    Giỏ hàng của bạn
                </div>
                <button type="button" class="btn-close text-end" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body" ng-if="cart.count > 0">
                <div class="cart-product" >
                    <!-- Cart Product Item Start -->
                    <div class="cart-product-item" ng-repeat="item in cart.items">
                        <a href="/san-pham/<% item.attributes.slug %>.html" class="cart-product-thum">
                            <img ng-src="<% item.attributes.image %>" alt="<% item.name %>">
                        </a>
                        <div class="cart-product-content">
                            <h6 class="cart-product-content-title">
                                <a href="/san-pham/<% item.attributes.slug %>.html"><% item.name %></a>
                            </h6>
                            <div class="cart_attribute">
                                <div ng-repeat="attribute in item.attributes.attributes" style="line-height: 1;">
                                    <span class="cart_attribute_name" style="margin-left: 8px; font-weight: 600; font-size: 14px;"><% attribute.name %> :</span>
                                    <span class="cart_attribute_value" style="font-size: 14px;"><% attribute.value %></span>
                                </div>
                            </div>
                            <div class="cart-product-content-bottom">
                                <span class="cart-product-content-quantity"><% item.quantity %> × </span>
                                <span class="cart-product-content-amount">
                                    <bdi>
                                        <span class="visually-hidden">Price:</span>
                                        <span class="price-currency-symbol"></span><% item.price | number: 0 %>₫
                                    </bdi>
                                </span>
                            </div>
                        </div>
                        <button class="cart-product-close" ng-click='removeItem(item.id)'>×</button>
                    </div>
                    <!-- Cart Product Item End -->
                </div>
                <div class="offcanvas-cart-footer">
                    <div class="mini-cart-total">
                        <strong class="mini-cart-subtotal">Tổng tiền</strong>
                        <span class="mini-cart-amount">
                            <bdi>
                                <span class="currency-symbol"></span><% cart.total | number: 0 %>₫
                            </bdi>
                        </span>
                    </div>
                    <div class="cart-button-action-wrap gap-2 d-flex flex-column">
                        {{-- <a href="{{route('cart.index')}}" class="btn-outline btn btn-full btn-lg">Xem giỏ hàng</a> --}}
                        <a href="{{route('cart.checkout')}}" class="btn-outline btn btn-full btn-lg">Thanh toán</a>
                    </div>
                </div>
            </div>
            <div class="offcanvas-body text-center" ng-if="cart.count == 0">
                <img width="32" height="32" src="/site/images/no-cart.png?1677998172667">
                <p>Không có sản phẩm nào trong giỏ hàng của bạn</p>
            </div>
        </div>
    </div>
    <!-- OffCanvas Cart End -->
    @include('site.partials.mobile_menu')
    <!-- Product Modal Start -->
    <div class="modal fade" id="product-modal-active" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered product-quick-view-modal">
            <div class="modal-content">
                <button type="button" class="btn-close position-absolute end-0 p-2" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="product-item-details px-3 py-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="swiper product-quickview-lg-active">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide" ng-repeat="gallery in quickViewProduct.galleries track by $index">
                                        <img ng-src="<% gallery.image.path %>" alt="product quick view 1"
                                            loading="lazy">
                                    </div>
                                </div>
                                <div class="product-details-button-next product-details-navigation-next"><i
                                        class="icon-rt-arrow-right"></i></div>
                                <div class="product-details-button-prev product-details-navigation-prev"><i
                                        class="icon-rt-arrow-left"></i></div>
                            </div>
                            <div class="swiper product-quickview-sm-thum-active mt-2">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide" ng-repeat="gallery in quickViewProduct.galleries track by $index">
                                        <img ng-src="<% gallery.image.path %>" alt="<% quickViewProduct.name %>"
                                            loading="lazy">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product-item-details-box">
                                <h4 class="product-item-details-title"><% quickViewProduct.name %></h4>
                                <div class="product-item-details-rating d-flex align-items-center gap-2 text-black">
                                    <div class="product-item-details-rating-list d-flex">
                                        <i class="icon-rt-star-solid"></i>
                                        <i class="icon-rt-star-solid"></i>
                                        <i class="icon-rt-star-solid"></i>
                                        <i class="icon-rt-star-solid"></i>
                                        <i class="icon-rt-star-solid"></i>
                                    </div>
                                    <a href="#" class="fs-16">(Đánh giá sản phẩm 5 sao)</a>
                                </div>
                                <div class="product-card-price mt-2">
                                    <span class="product-card-old-price" ng-if="quickViewProduct.base_price"><del><% quickViewProduct.base_price | number: 0 %>₫</del></span>
                                    <span class="product-card-regular-price"><% quickViewProduct.price | number: 0 %>₫</span>
                                </div>
                                <p class="product-item-details-description mt-2 fs-16" ng-bind-html="quickViewProduct.intro"></p>
                                <div class="mt-2 product-attributes" ng-if="quickViewProduct.attributes" ng-repeat="attribute in quickViewProduct.attributes">
                                    <label><% attribute.name %></label>
                                    <div class="product-attribute-values">
                                        <div ng-repeat="value in attribute.values" class="badge badge-primary" data-value="<% value %>" data-name="<% attribute.name %>" data-index="<% index %>"><% value %></div>
                                    </div>
                                </div>
                                <div class="product-item-action-box d-flex gap-2 align-items-center">
                                    {{-- <form action="#" class="product-item-quantity">
                                        <button class="product-item-quantity-decrement product-item-quantity-button"
                                            type="button">-</button>
                                        <input type="text" class="product-item-quantity-input" value="1">
                                        <button class="product-item-quantity-increment product-item-quantity-button"
                                            type="button">+</button>
                                    </form>
                                    <button class="btn btn-primary btn-lg" ng-click="addToCart(quickViewProduct.id)">Thêm vào giỏ hàng</button> --}}
                                    <a class="btn btn-primary btn-lg" href="{{route('front.product-custom')}}?product_id=<% quickViewProduct.id %>">Tạo thiết kế</a>
                                </div>
                                <div class="social-share-wrap d-flex gap-1 mt-3">
                                    <p class="fs-16">SHARE: </p>
                                    <div class="social-share social-share-in-color d-flex gap-2">
                                        <a class="social-share-link facebook" href="https://www.facebook.com/"
                                            target="_blank" aria-label="facebook">
                                            <i class="icon-rt-4-facebook-f"></i>
                                        </a>
                                        <a class="social-share-link twitter" href="https://twitter.com/" target="_blank"
                                            aria-label="twitter">
                                            <i class="icon-rt-logo-twitter"></i>
                                        </a>
                                        <a class="social-share-link instagram" href="https://instagram.com/"
                                            target="_blank" aria-label="instagram">
                                            <i class="icon-rt-logo-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Modal End -->

    <!-- JS Vendor, Plugins & Activation Script Files -->
    <!-- Vendors JS -->
    <script src="{{ env('AWS_R2_URL') }}/site/js/modernizr-3.11.7.min.js"></script>
    <script src="{{ env('AWS_R2_URL') }}/site/js/bootstrap.bundle.min.js"></script>
    <!-- Plugins JS -->
    <script src="{{ env('AWS_R2_URL') }}/site/js/swiper-bundle.min.js"></script>
    <script src="{{ env('AWS_R2_URL') }}/site/js/jquery.validate.min.js"></script>
    <script src="{{ env('AWS_R2_URL') }}/site/js/ajax.js"></script>
    <!-- Activation JS -->
    <script src="{{ env('AWS_R2_URL') }}/site/js/main.js"></script>

    {{-- Call to action button --}}
    <div id="call-to-action-pc" class="hidden-xs">
        <div onclick="window.location.href= 'tel:{{ $config->hotline }}'" class="hotline-phone-ring-wrap">
            <div class="hotline-phone-ring">
                <div class="hotline-phone-ring-circle"></div>
                <div class="hotline-phone-ring-circle-fill"></div>
                <div class="hotline-phone-ring-img-circle">
                    <a href="tel:{{ $config->hotline }}" class="pps-btn-img">
                        <img src="/site/images/phone.png" alt="Gọi điện thoại" width="50" loading="lazy">
                    </a>
                </div>
            </div>
            <a href="tel:{{ $config->hotline }}">
            </a>
            <div class="hotline-bar"><a href="tel:{{ $config->hotline }}">
                </a><a href="tel:{{ $config->hotline }}" style="padding-left: 23px;">
                    <span class="text-hotline">{{ $config->hotline }}</span>
                </a>
            </div>

        </div>
        <div class="inner-fabs">
            <a target="blank" href="{{ $config->facebook }}" class="fabs roundCool" id="challenges-fab"
                data-tooltip="Send Messenger">
                <img class="inner-fab-icon" src="/site/images/messenger-icon.png" alt="challenges-icon"
                    border="0" loading="lazy">
            </a>
            <a target="blank" href="https://zalo.me/{{ $config->zalo }}" class="fabs roundCool" id="chat-fab"
                data-tooltip="Send message Zalo">
                <img class="inner-fab-icon" src="/site/images/zalo.png" alt="chat-active-icon"
                    border="0" loading="lazy">
            </a>
            <a target="blank" href="https://maps.app.goo.gl/YXMwmkUUM6o2Abov5" class="fabs roundCool" id="chat-fab"
                data-tooltip="View map">
                <img class="inner-fab-icon" src="/site/images/map.png" alt="chat-active-icon"
                    border="0" loading="lazy">
            </a>

        </div>
        <div class="fabs roundCool call-animation" id="main-fab">
            <img class="img-circle" src="/site/images/lienhe.png" alt="" width="135" loading="lazy">
        </div>
    </div>
    <div id="azt-contact-footer-outer" class="hidden-lg">
        <div id="azt-contact-footer">
            <a href="#" class="mr_menu_toggle_mobile" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvas-mobile-menu">
                <span>
                    <img src="/site/images/menu.png" alt="menu">
                    <span class="azt-contact-footer-btn-label">Menu</span>
                </span>
            </a>
            <a href="https://maps.app.goo.gl/YXMwmkUUM6o2Abov5">
                <span>
                    <img src="/site/images/map.png" alt="Map">
                    <span class="azt-contact-footer-btn-label">Map</span>
                </span>
            </a>
            <a id="azt-contact-footer-btn-center" href="tel:{{ $config->hotline }}">
                <span class="azt-contact-footer-btn-center-icon">
                    <span class="phone-vr-circle-fill"></span>
                    <img src="/site/images/phone.png" alt="Call Now">
                </span>
                <span>
                    <span class="azt-contact-footer-btn-label">
                        <span>Call Now</span>
                    </span>
                </span>
            </a>
            <a href="{{ $config->facebook }}" target="_blank">
                <span>
                    <img src="/site/images/messenger-icon.png" alt="Messenger">
                    <span class="azt-contact-footer-btn-label">Messenger</span>
                </span>
            </a>
            <a href="https://zalo.me/{{ $config->zalo }}" target="_blank">
                <span>
                    <img class="zalo-icon" src="/site/images/zalo.png" alt="Zalo">
                    <span class="azt-contact-footer-btn-label">Zalo</span>
                </span>
            </a>
        </div>
    </div>
    <script src="/site/js/callbutton.js"></script>

    <!-- Google Translate -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'vi',includedLanguages:'en,vi', }, 'translate_select');
        }
    </script>
    <div id="translate_select" style="display: none;"></div>
    <style>
        #goog-gt-tt {
            display: none !important;
        }
        /* iframe.skiptranslate {
            display: none !important;
        }
        .skiptranslate {
            display: none !important;
        } */
    </style>
    <script type="text/javascript"
    src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
    <script>
        function translateheader(lang){
            var languageSelect = document.querySelector("select.goog-te-combo");
            languageSelect.value = lang;
            languageSelect.dispatchEvent(new Event("change"));
        }
        function scrollHiddenTranslate() {
            var frame = document.querySelector("iframe.skiptranslate");
            if (frame) {
                if (window.scrollY > 100) {
                    frame.style.display = "none";
                } else {
                    frame.style.display = "block";
                }
            }
        }

        window.addEventListener("scroll", scrollHiddenTranslate);
        scrollHiddenTranslate();
    </script>

</body>

</html>
