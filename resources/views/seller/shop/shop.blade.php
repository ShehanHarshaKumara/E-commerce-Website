@extends('seller.layout.app')
@push('title')
    {{ $shop->shop_name ?? 'My Shop' }} | Seller Marketplace
@endpush

@push('css')
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --bg-light: #f8fafc;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 2px 4px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 6px 12px rgba(99, 102, 241, 0.15);
        }

        * {
            transition: all 0.2s ease;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
            font-size: 13px;
        }

        .container-fluid {
            padding-left: 0;
            padding-right: 0;
        }

        .full-width-content {
            max-width: 100%;
            padding: 0 0.75rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hero Section - Ultra Compact */
        .shop-hero {
            background: var(--primary-gradient);
            padding: 1.25rem 0;
            margin-bottom: 0;
            position: relative;
            overflow: hidden;
        }

        .shop-info-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 12px;
            padding: 1rem;
            box-shadow: var(--shadow-lg);
            animation: fadeInUp 0.3s ease-out;
            max-width: 1200px;
            margin: 0 auto;
        }

        .shop-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .shop-description {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .shop-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
        }

        .badge {
            padding: 0.2rem 0.5rem;
            font-size: 0.7rem;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 0.2rem;
        }

        .badge .material-icons {
            font-size: 0.8rem !important;
        }

        /* Top Filter Bar - Compact */
        .top-filter-bar {
            background: white;
            padding: 0.75rem;
            box-shadow: var(--shadow-sm);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: slideDown 0.2s ease-out;
        }

        .filter-toggle-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .filter-toggle-btn .material-icons {
            font-size: 0.9rem;
        }

        .filters-expanded {
            background: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease;
        }

        .filters-expanded.active {
            max-height: 300px;
            padding: 0.75rem 0;
        }

        .filter-section {
            margin-bottom: 0.75rem;
        }

        .filter-section-title {
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--text-primary);
            margin-bottom: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .filter-section-title .material-icons {
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .filter-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.3rem;
        }

        .filter-pill {
            padding: 0.25rem 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            background: white;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.2rem;
        }

        .filter-pill.active {
            background: var(--primary-gradient);
            border-color: var(--primary-color);
            color: white;
        }

        .price-range-group {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .price-input {
            flex: 1;
            min-width: 80px;
            padding: 0.35rem 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 0.8rem;
        }

        .btn-apply-filters {
            background: var(--primary-gradient);
            color: white;
            padding: 0.35rem 0.75rem;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .btn-clear-filters {
            background: white;
            color: var(--text-secondary);
            padding: 0.35rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* Products Toolbar - Compact */
        .products-toolbar {
            background: white;
            padding: 0.5rem 0.75rem;
            margin: 0.75rem 0;
            box-shadow: var(--shadow-sm);
            border-radius: 6px;
            animation: fadeInUp 0.2s ease-out 0.1s backwards;
        }

        .products-count {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .products-count span {
            color: var(--primary-color);
        }

        .sort-dropdown {
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 0.35rem;
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--text-primary);
            background: white;
            cursor: pointer;
            min-width: 140px;
        }

        /* Product Grid - Ultra Compact */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 0.75rem;
            padding: 0 0.25rem;
        }

        /* Product Cards - Very Small */
        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-md);
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border-color);
            animation: fadeInUp 0.3s ease-out backwards;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            border-color: var(--primary-color);
        }

        .card-img-container {
            position: relative;
            width: 100%;
            height: 140px;
            overflow: hidden;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
        }

        .card-img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }

        .product-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            background: var(--danger-color);
            color: white;
            padding: 0.15rem 0.4rem;
            border-radius: 10px;
            font-size: 0.6rem;
            font-weight: 700;
            z-index: 2;
        }

        .product-rating {
            position: absolute;
            bottom: 5px;
            left: 5px;
            background: rgba(255, 255, 255, 0.95);
            padding: 0.15rem 0.4rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 0.15rem;
            font-size: 0.65rem;
            font-weight: 600;
            z-index: 2;
        }

        .product-rating .material-icons {
            font-size: 0.7rem;
        }

        .card-content {
            padding: 0.75rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.4rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 1.8rem;
        }

        .product-meta {
            display: flex;
            gap: 0.3rem;
            margin-bottom: 0.5rem;
            flex-wrap: wrap;
        }

        .meta-badge {
            background: var(--bg-light);
            color: var(--text-secondary);
            padding: 0.15rem 0.4rem;
            border-radius: 10px;
            font-size: 0.65rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.15rem;
            border: 1px solid var(--border-color);
        }

        .meta-badge .material-icons {
            font-size: 0.7rem;
        }

        .product-pricing {
            margin: 0.4rem 0;
            padding: 0.5rem;
            background: #f8f9ff;
            border-radius: 6px;
        }

        .price-display {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.15rem;
        }

        .wholesale-price {
            color: var(--success-color);
            font-size: 0.7rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.15rem;
        }

        .wholesale-price .material-icons {
            font-size: 0.8rem;
        }

        .stock-info {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.7rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            padding: 0.4rem;
            background: var(--bg-light);
            border-radius: 4px;
        }

        .stock-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--success-color);
        }

        .stock-dot.low { background: var(--warning-color); }
        .stock-dot.out { background: var(--danger-color); }

        /* Quantity Controls - Compact */
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            margin-bottom: 0.5rem;
        }

        .quantity-btn {
            width: 26px;
            height: 26px;
            border: 1px solid var(--border-color);
            background: white;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
        }

        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .quantity-btn .material-icons {
            font-size: 0.9rem;
        }

        .quantity-input {
            flex: 1;
            height: 26px;
            text-align: center;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.8rem;
            min-width: 0;
        }

        .order-now-btn {
            width: 100%;
            padding: 0.4rem;
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
        }

        .order-now-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .order-now-btn .material-icons {
            font-size: 0.9rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: var(--shadow-sm);
            border: 1px dashed var(--border-color);
            animation: fadeInUp 0.3s ease-out;
            grid-column: 1 / -1;
        }

        .empty-state-icon {
            font-size: 2.5rem;
            color: var(--text-muted);
            opacity: 0.5;
        }

        .empty-state h4 {
            margin-top: 0.75rem;
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1rem;
        }

        .empty-state p {
            color: var(--text-muted);
            margin-top: 0.25rem;
            font-size: 0.8rem;
        }

        /* Material Icons */
        .material-icons {
            font-family: 'Material Icons';
            font-weight: normal;
            font-style: normal;
            font-size: 0.9rem;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            vertical-align: middle;
        }

        /* Scroll to Top Button */
        .scroll-to-top {
            position: fixed;
            bottom: 15px;
            right: 15px;
            width: 32px;
            height: 32px;
            background: var(--primary-gradient);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 16px;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 999;
            box-shadow: var(--shadow-md);
        }

        .scroll-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        /* Pagination */
        .pagination-wrapper {
            margin-top: 1.5rem;
            padding: 0 0.25rem;
        }

        /* Stagger animation for product cards */
        .product-card:nth-child(1) { animation-delay: 0.05s; }
        .product-card:nth-child(2) { animation-delay: 0.1s; }
        .product-card:nth-child(3) { animation-delay: 0.15s; }
        .product-card:nth-child(4) { animation-delay: 0.2s; }
        .product-card:nth-child(5) { animation-delay: 0.25s; }
        .product-card:nth-child(6) { animation-delay: 0.3s; }
        .product-card:nth-child(7) { animation-delay: 0.35s; }
        .product-card:nth-child(8) { animation-delay: 0.4s; }

        /* ============================================
           RESPONSIVE DESIGN
           ============================================ */

        /* Large Desktop (1400px+) */
        @media (min-width: 1400px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 1rem;
            }

            .card-img-container {
                height: 150px;
            }
        }

        /* Desktop (1200px - 1400px) */
        @media (min-width: 1200px) and (max-width: 1399px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
            }
        }

        /* Tablets (992px - 1199px) */
        @media (max-width: 1199px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
            }

            .card-img-container {
                height: 130px;
            }
        }

        /* Tablets Portrait (768px - 991px) */
        @media (max-width: 991px) {
            .shop-hero {
                padding: 1rem 0;
            }

            .shop-info-card {
                padding: 0.75rem;
            }

            .shop-title {
                font-size: 1rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 0.6rem;
            }

            .card-img-container {
                height: 110px;
                padding: 0.4rem;
            }

            .card-content {
                padding: 0.6rem;
            }

            .card-title {
                font-size: 0.75rem;
                min-height: 1.6rem;
            }

            .price-display {
                font-size: 0.9rem;
            }
        }

        /* Mobile Devices (640px - 767px) */
        @media (max-width: 767px) {
            .full-width-content {
                padding: 0 0.5rem;
            }

            .shop-hero {
                padding: 0.75rem 0;
            }

            .shop-info-card {
                padding: 0.6rem;
            }

            .shop-title {
                font-size: 0.9rem;
            }

            .shop-description {
                font-size: 0.75rem;
            }

            .badge {
                padding: 0.15rem 0.4rem;
                font-size: 0.65rem;
            }

            .top-filter-bar {
                padding: 0.6rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 0.5rem;
            }

            .card-img-container {
                height: 100px;
            }

            .card-content {
                padding: 0.5rem;
            }

            .card-title {
                font-size: 0.7rem;
                min-height: 1.4rem;
            }

            .price-display {
                font-size: 0.85rem;
            }

            .quantity-btn {
                width: 24px;
                height: 24px;
            }

            .quantity-btn .material-icons {
                font-size: 0.8rem;
            }

            .quantity-input {
                height: 24px;
                font-size: 0.75rem;
            }
        }

        /* Small Mobile (480px - 639px) */
        @media (max-width: 639px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            }

            .card-img-container {
                height: 90px;
            }

            .card-title {
                font-size: 0.68rem;
            }

            .product-meta {
                display: none;
            }

            .order-now-btn {
                font-size: 0.75rem;
                padding: 0.35rem;
            }

            .empty-state-icon {
                font-size: 2rem;
            }

            .empty-state h4 {
                font-size: 0.9rem;
            }
        }

        /* Extra Small (400px - 479px) */
        @media (max-width: 479px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }

            .card-img-container {
                height: 80px;
            }

            .card-content {
                padding: 0.4rem;
            }

            .product-pricing {
                padding: 0.4rem;
            }

            .price-display {
                font-size: 0.8rem;
            }

            .wholesale-price {
                font-size: 0.65rem;
            }

            .stock-info {
                font-size: 0.65rem;
                padding: 0.3rem;
            }
        }

        /* Very Small (360px - 399px) */
        @media (max-width: 399px) {
            .full-width-content {
                padding: 0 0.4rem;
            }

            .shop-title {
                font-size: 0.85rem;
            }

            .shop-description {
                font-size: 0.7rem;
            }

            .badge {
                font-size: 0.6rem;
                padding: 0.1rem 0.3rem;
            }

            .products-grid {
                gap: 0.4rem;
            }

            .card-img-container {
                height: 70px;
            }

            .price-display {
                font-size: 0.75rem;
            }

            .quantity-btn {
                width: 22px;
                height: 22px;
            }

            .quantity-input {
                height: 22px;
                font-size: 0.7rem;
            }

            .order-now-btn {
                font-size: 0.7rem;
            }
        }

        /* Tiny (320px - 359px) */
        @media (max-width: 359px) {
            .products-grid {
                grid-template-columns: 1fr;
                max-width: 200px;
                margin: 0 auto;
            }

            .card-img-container {
                height: 90px;
            }

            .empty-state {
                padding: 1.5rem 0.75rem;
            }
        }

        /* Touch Devices */
        @media (hover: none) and (pointer: coarse) {
            .product-card:hover {
                transform: none;
            }

            .product-card:active {
                transform: scale(0.98);
            }
        }
    </style>
@endpush

@section('content')
    <!-- Shop Hero Section -->
    <div class="shop-hero">
        <div class="container-fluid">
            <div class="full-width-content">
                <div class="shop-info-card">
                    <h1 class="shop-title">Seller Marketplace</h1>
                    <p class="shop-description">Quality products at competitive prices</p>
                    <div class="shop-badges">
                        <span class="badge bg-primary">
                            <i class="material-icons">inventory_2</i>
                            {{ $products->total() }}
                        </span>
                        <span class="badge bg-success">
                            <i class="material-icons">verified</i>
                            Verified
                        </span>
                        <span class="badge bg-info">
                            <i class="material-icons">local_shipping</i>
                            Fast
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Filter Bar -->
    <div class="top-filter-bar">
        <div class="container-fluid">
            <div class="full-width-content">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <button type="button" class="filter-toggle-btn" onclick="toggleFilters()" id="filterToggleBtn">
                        <i class="material-icons">tune</i>
                        Filters
                        <i class="material-icons" id="filterArrow">keyboard_arrow_down</i>
                    </button>

                    <div class="d-flex gap-2">
                        <a href="{{ route('seller.shop.index') }}" class="btn-clear-filters">
                            <i class="material-icons">clear_all</i>
                            Clear
                        </a>
                    </div>
                </div>

                <div class="filters-expanded" id="filtersExpanded">
                    <form action="{{ route('seller.shop.index') }}" method="GET" id="filterForm">
                        <!-- Categories Filter -->
                        @if(isset($categories) && $categories->count() > 0)
                            <div class="filter-section">
                                <div class="filter-section-title">
                                    <i class="material-icons">category</i>
                                    Categories
                                </div>
                                <div class="filter-pills">
                                    @foreach($categories as $category)
                                        <label class="filter-pill {{ in_array($category->id, request('category', [])) ? 'active' : '' }}">
                                            <input type="checkbox"
                                                   name="category[]"
                                                   value="{{ $category->id }}"
                                                {{ in_array($category->id, request('category', [])) ? 'checked' : '' }}>
                                            {{ Str::limit($category->name, 12) }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Price Range -->
                        <div class="filter-section">
                            <div class="filter-section-title">
                                <i class="material-icons">payments</i>
                                Price
                            </div>
                            <div class="price-range-group">
                                <input type="number"
                                       name="min_price"
                                       class="price-input"
                                       placeholder="Min"
                                       value="{{ request('min_price') }}">
                                <span class="text-muted">-</span>
                                <input type="number"
                                       name="max_price"
                                       class="price-input"
                                       placeholder="Max"
                                       value="{{ request('max_price') }}">
                                <button type="submit" class="btn-apply-filters">
                                    <i class="material-icons">filter_alt</i>
                                    Apply
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="container-fluid">
        <div class="full-width-content">
            <!-- Products Toolbar -->
            <div class="products-toolbar d-flex justify-content-between align-items-center">
                <div class="products-count">
                    <span>{{ $products->total() }}</span> Products
                </div>
                <div>
                    <select class="sort-dropdown" onchange="window.location.href=this.value">
                        <option value="{{ route('seller.shop.index', array_merge(request()->all(), ['sort' => 'newest'])) }}"
                            {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>
                            Newest
                        </option>
                        <option value="{{ route('seller.shop.index', array_merge(request()->all(), ['sort' => 'price_low'])) }}"
                            {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                            Price ↑
                        </option>
                        <option value="{{ route('seller.shop.index', array_merge(request()->all(), ['sort' => 'price_high'])) }}"
                            {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                            Price ↓
                        </option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid">
                @forelse($products as $product)
                    <div class="product-card" data-product-id="{{ $product->id }}">
                        <div class="card-img-container">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="card-img"
                                     loading="lazy">
                            @else
                                <i class="material-icons" style="font-size: 2rem; color: var(--text-muted); opacity: 0.3;">
                                    image
                                </i>
                            @endif

                            @if($product->qty < 10)
                                <span class="product-badge">Low</span>
                            @endif

                            @if(isset($product->average_rating) && $product->average_rating > 0)
                                <div class="product-rating">
                                    <i class="material-icons" style="color: var(--warning-color);">star</i>
                                    {{ number_format($product->average_rating, 1) }}
                                </div>
                            @endif
                        </div>

                        <div class="card-content">
                            <h5 class="card-title" title="{{ $product->name }}">{{ Str::limit($product->name, 40) }}</h5>

                            <div class="product-meta">
                                @if($product->category)
                                    <span class="meta-badge">
                                        <i class="material-icons">category</i>
                                        {{ Str::limit($product->category->name, 10) }}
                                    </span>
                                @endif
                            </div>

                            <div class="product-pricing">
                                <div class="price-display">
                                    Rs. {{ number_format($product->display_price, 0) }}
                                </div>
                                @if($product->stock_price < $product->display_price)
                                    <div class="wholesale-price">
                                        <i class="material-icons">store</i>
                                        Rs. {{ number_format($product->stock_price, 0) }}
                                    </div>
                                @endif
                            </div>

                            <div class="stock-info">
                                <div class="stock-dot {{ $product->qty > 50 ? '' : ($product->qty > 10 ? 'low' : 'out') }}"></div>
                                <span>
                                    Stock: {{ $product->qty }}
                                </span>
                            </div>

                            <div class="quantity-controls">
                                <button class="quantity-btn decrement-btn"
                                        onclick="decrementQuantity({{ $product->id }})"
                                        disabled>
                                    <i class="material-icons">remove</i>
                                </button>
                                <input type="number"
                                       class="quantity-input"
                                       id="quantity-{{ $product->id }}"
                                       value="0"
                                       min="0"
                                       max="{{ $product->qty }}"
                                       data-price="{{ $product->display_price }}"
                                       data-name="{{ $product->name }}"
                                       data-min-qty="{{ $product->min_qty ?? 1 }}"
                                       oninput="updateQuantity({{ $product->id }}, this.value)">
                                <button class="quantity-btn increment-btn"
                                        onclick="incrementQuantity({{ $product->id }})">
                                    <i class="material-icons">add</i>
                                </button>
                            </div>

                            <button class="order-now-btn"
                                    onclick="placeOrder({{ $product->id }})"
                                    id="order-btn-{{ $product->id }}"
                                    disabled>
                                <i class="material-icons">shopping_bag</i>
                                Order
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="material-icons">inventory_2</i>
                        </div>
                        <h4>No Products</h4>
                        <p>Try adjusting filters</p>
                        <a href="{{ route('seller.shop.index') }}" class="btn btn-primary btn-sm mt-2">
                            Clear Filters
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="pagination-wrapper">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" onclick="scrollToTop()">
        <i class="material-icons">arrow_upward</i>
    </button>
@endsection

@push('script')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Toggle Filters
        function toggleFilters() {
            const filtersExpanded = document.getElementById('filtersExpanded');
            const filterArrow = document.getElementById('filterArrow');

            filtersExpanded.classList.toggle('active');
            filterArrow.textContent = filtersExpanded.classList.contains('active')
                ? 'keyboard_arrow_up'
                : 'keyboard_arrow_down';
        }

        // Filter Pills Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const filterPills = document.querySelectorAll('.filter-pill');
            filterPills.forEach(pill => {
                pill.addEventListener('click', function() {
                    const checkbox = this.querySelector('input[type="checkbox"]');
                    if (checkbox) {
                        checkbox.checked = !checkbox.checked;
                        this.classList.toggle('active');

                        // Auto-submit form
                        setTimeout(() => {
                            document.getElementById('filterForm').submit();
                        }, 200);
                    }
                });
            });
        });

        // Scroll to Top
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        window.addEventListener('scroll', function() {
            const scrollBtn = document.getElementById('scrollToTop');
            scrollBtn.classList.toggle('visible', window.pageYOffset > 150);
        });

        // Quantity Management
        function updateQuantity(productId, value) {
            const quantityInput = document.getElementById(`quantity-${productId}`);
            const orderBtn = document.getElementById(`order-btn-${productId}`);
            const decrementBtn = document.querySelector(`.decrement-btn[onclick="decrementQuantity(${productId})"]`);
            const incrementBtn = document.querySelector(`.increment-btn[onclick="incrementQuantity(${productId})"]`);

            let quantity = parseInt(value) || 0;
            const maxQuantity = parseInt(quantityInput.max) || 0;
            const minQty = parseInt(quantityInput.getAttribute('data-min-qty')) || 1;

            if (isNaN(quantity) || quantity < 0) quantity = 0;
            if (quantity > maxQuantity) quantity = maxQuantity;

            quantityInput.value = quantity;
            orderBtn.disabled = quantity === 0;
            decrementBtn.disabled = quantity <= 0;
            incrementBtn.disabled = quantity >= maxQuantity;
        }

        function incrementQuantity(productId) {
            const quantityInput = document.getElementById(`quantity-${productId}`);
            let currentValue = parseInt(quantityInput.value) || 0;
            updateQuantity(productId, currentValue + 1);
        }

        function decrementQuantity(productId) {
            const quantityInput = document.getElementById(`quantity-${productId}`);
            let currentValue = parseInt(quantityInput.value) || 0;
            if (currentValue > 0) {
                updateQuantity(productId, currentValue - 1);
            }
        }

        // Place Order
        async function placeOrder(productId) {
            const quantityInput = document.getElementById(`quantity-${productId}`);
            const quantity = parseInt(quantityInput.value) || 0;
            const productName = quantityInput.getAttribute('data-name');
            const productPrice = parseFloat(quantityInput.getAttribute('data-price'));

            if (quantity === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Select quantity',
                    text: 'Please select quantity first',
                    timer: 1500,
                    showConfirmButton: false
                });
                return;
            }

            const totalPrice = (quantity * productPrice).toFixed(2);

            const result = await Swal.fire({
                title: 'Confirm Order',
                html: `
                    <div style="text-align: left; font-size: 0.9rem;">
                        <p><strong>Product:</strong> ${productName}</p>
                        <p><strong>Quantity:</strong> ${quantity}</p>
                        <p><strong>Total:</strong> Rs. ${totalPrice}</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#6366f1',
                cancelButtonColor: '#64748b'
            });

            if (result.isConfirmed) {
                const orderBtn = document.getElementById(`order-btn-${productId}`);
                orderBtn.innerHTML = '<i class="material-icons">check</i> Ordered';
                orderBtn.disabled = true;

                setTimeout(() => {
                    updateQuantity(productId, 0);
                    orderBtn.innerHTML = '<i class="material-icons">shopping_bag</i> Order';
                    orderBtn.disabled = false;
                }, 1500);
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.quantity-input').forEach(input => {
                const productId = input.id.replace('quantity-', '');
                updateQuantity(productId, 0);
            });
        });
    </script>
@endpush
