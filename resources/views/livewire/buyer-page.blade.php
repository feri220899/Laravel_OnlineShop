<div>
    <div class="wrapper">
        {{-- Navbar --}}
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="../../index3.html" class="navbar-brand">
                    <span class="brand-text font-weight-bold">Shop</span>
                </a>
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="index3.html" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li><a href="#" class="dropdown-item">Some action </a></li>
                                <li><a href="#" class="dropdown-item">Some other action</a></li>

                                <li class="dropdown-divider"></li>
                                <li class="dropdown-submenu dropdown-hover">
                                    <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"
                                        class="dropdown-item dropdown-toggle">Hover
                                        for action</a>
                                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                        <li>
                                            <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a id="dropdownSubMenu3" href="#" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                class="dropdown-item dropdown-toggle">level 2</a>
                                            <ul aria-labelledby="dropdownSubMenu3"
                                                class="dropdown-menu border-0 shadow">
                                                <li><a href="#" class="dropdown-item">3rd level</a></li>
                                                <li><a href="#" class="dropdown-item">3rd level</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#" class="dropdown-item">level 2</a></li>
                                        <li><a href="#" class="dropdown-item">level 2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div class="form-inline ml-0 ml-md-3">
                        <div class="input-group input-group-sm">
                            <input wire:model='search' class="form-control form-control-navbar" type="search"
                                placeholder="Search Products" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="button" wire:click='listProducts()'>
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::check() && Auth::user()->role == 'buyer')
                    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto mr-3">
                        <div class="d-flex">
                            <button data-toggle="modal" wire:click='eventModal' data-target="#DetailCartModal"
                                class="btn btn-outline-dark" type="button">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="badge bg-dark text-white ms-1 rounded-pill">{{ count($get_carts) }}</span>
                            </button>
                        </div>
                    </ul>
                @endif
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto ml-2">
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link">
                            <i class="fas fa-user"></i>
                        </a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            @if (Auth::check() && Auth::user()->role == 'buyer')
                            <li>
                                <a href="{{ route('order') }}" class="dropdown-item">Data Order</a>
                            </li>
                            @endif
                            <li>
                                @if (Auth::check())
                                    <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
                                @else
                                    <a href="{{ route('page.login') }}" class="dropdown-item">Login</a>
                                @endif
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        {{-- Header --}}
        @if ($header == true)
            <header class="bg-dark py-3">
                <div class="container px-4 px-lg-3 my-3">
                    <div class="text-center text-white">
                        <h1 class="display-4 fw-bolder">Shop in style</h1>
                        <p class="lead fw-normal text-white-50 mb-0">Hassle-free and affordable electronics shopping
                        </p>
                    </div>
                </div>
            </header>
        @endif
        {{-- Section Products --}}
        <section>
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @foreach ($list_products as $key => $product)
                        <div class="col mb-5">
                            <div class="card h-100 shadow {{ $product->stock < 1 ? 'text-muted' : '' }}">
                                @if ($product->stock < 1)
                                    <div class="badge bg-danger text-white position-absolute"
                                        style="top: 0.5rem; right: 0.5rem">Sold out</div>
                                @endif
                                <img class="card-img-top" src="{{ asset('storage/' . $product->image) }}"
                                    alt="..." style="object-fit: cover; width: 100%; height: 200px;" />
                                <div class="pt-3">
                                    <div class="text-center">
                                        <h5 class="fw-bolder">{{ $product->product_name }}</h5>
                                        Rp. {{ number_format($product->price, 0, ',', '.') }}
                                        <p>Stok :<span class="float-rigth"> {{ $product->stock }}</span></p>
                                    </div>
                                </div>
                                <div class="pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                        <button wire:click='setKey("{{ $key }}", "add_cart")'
                                            data-toggle="modal" data-target="#OrderModal"
                                            class="btn btn-outline-dark mx-1" {{ $product->stock < 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                        <button wire:click='setKey("{{ $key }}", "single_checkout")'
                                            class="btn btn-outline-dark mt-auto mx-1" data-toggle="modal"
                                            data-target="#OrderModal" {{ $product->stock < 1 ? 'disabled' : '' }}>
                                            Buy Now
                                        </button>
                                        @if (session('error' . $key))
                                             <p class="text-sm text-danger mb-0 mt-1">{{ session('error' . $key) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    {{-- Modal --}}
    <section class="content">
        @if (Auth::check() && Auth::user()->role == 'buyer')
            <div class="modal fade" id="OrderModal" tabindex="-10" role="dialog" aria-hidden="true"
                wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-12 text-center">
                                    @if (isset($list_products[$set_key]))
                                        <div class="card h-100">
                                            <img class="card-img-top"
                                                src="{{ asset('storage/' . $list_products[$set_key]->image) }}"
                                                alt="..."
                                                style="object-fit: cover; width: 100%; height: 200px;" />
                                            <div class="card-body pt-3 mb-0 pb-0">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder">
                                                        {{ $list_products[$set_key]->product_name }}
                                                    </h5>
                                                    Rp.{{ number_format($list_products[$set_key]->price, 0, ',', '.') }}
                                                    <p>Stock : <span class="float-rigth">
                                                            {{ $list_products[$set_key]->stock }}</span>
                                                    </p>
                                                </div>
                                                <div class="text-center">
                                                    <button class="btn btn-outline-dark btn-sm"
                                                        wire:click='quantityCounter(-1)'>
                                                        <span class="font-weight-bold mx-2">-</span>
                                                    </button>
                                                    <span class="mx-2">{{ $quantity_count }}</span>
                                                    @if ($quantity_count >= $list_products[$set_key]->stock)
                                                        <button disabled class="btn btn-outline-dark btn-sm">
                                                            <span class="font-weight-bold mx-2">+</span>
                                                        </button>
                                                    @else
                                                        <button class="btn btn-outline-dark btn-sm"
                                                            wire:click='quantityCounter(1)'>
                                                            <span class="font-weight-bold mx-2">+</span>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="card-footer px-4 pt-0 border-top-0 bg-transparent">
                                                <div class="text-center mb-2 text-muted">
                                                    <b>Total : Rp.
                                                        {{ number_format($quantity_count * $list_products[$set_key]->price, 0, ',', '.') }}</b>
                                                </div>
                                                <div class="text-center ">
                                                    @if ($type_modal == 'add_cart')
                                                        @if ($quantity_count > $list_products[$set_key]->stock)
                                                            <button disabled class="btn btn-outline-dark btn-block"
                                                                href="#">
                                                                <i class="fas fa-shopping-cart"></i> Add to
                                                                cart
                                                            </button>
                                                        @else
                                                            <button wire:click='singleAddCart("{{ $set_key }}")'
                                                                data-toggle="modal" data-target="#OrderModal"
                                                                class="btn btn-outline-dark btn-block" href="#">
                                                                <i class="fas fa-shopping-cart"></i> Add to
                                                                cart
                                                            </button>
                                                        @endif
                                                    @else
                                                        @if ($quantity_count > $list_products[$set_key]->stock)
                                                            <button class="btn btn-outline-dark btn-block"
                                                                href="#">
                                                                Chekout
                                                            </button>
                                                        @else
                                                            <button wire:click='singleCheckOut("{{ $set_key }}")'
                                                                data-toggle="modal" data-target="#OrderModal"
                                                                class="btn btn-outline-dark btn-block" href="#">
                                                                Chekout
                                                            </button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="DetailCartModal" tabindex="-10" role="dialog" aria-hidden="true"
                wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        @livewire('cart-detail')
                    </div>
                </div>
            </div>
        @endif
    </section>
</div>
