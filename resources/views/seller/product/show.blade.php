@extends('seller.layout.app')

@push('title')
    Product Details - {{ $product->name }}
@endpush

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --primary-50: #eef2ff;
            --secondary: #8b5cf6;
            --success: #10b981;
            --success-50: #ecfdf5;
            --warning: #f59e0b;
            --warning-50: #fffbeb;
            --danger: #ef4444;
            --danger-50: #fef2f2;
            --info: #3b82f6;
            --dark: #0f172a;
            --light: #f8fafc;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --border-radius: 16px;
            --border-radius-sm: 8px;
            --border-radius-lg: 20px;
            --shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #f8faff 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 14px;
            color: var(--gray-700);
        }

        /* Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            color: white;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 50%);
        }

        .header-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .header-info h1 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-info h1 i {
            font-size: 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.75rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .header-info p {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.875rem 1.5rem;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            font-size: 0.875rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            text-decoration: none;
            border: none;
        }

        .btn-white {
            background: white;
            color: var(--primary);
            box-shadow: var(--shadow-md);
        }

        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Main Content */
        .content-wrapper {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem;
            background: linear-gradient(to right, rgba(99, 102, 241, 0.03), rgba(139, 92, 246, 0.03));
            border-bottom: 1px solid var(--gray-200);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
        }

        .card-title i {
            color: var(--primary);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Product Image */
        .product-image-wrapper {
            position: relative;
            width: 100%;
            height: 400px;
            background: var(--gray-100);
            border-radius: var(--border-radius-sm);
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: var(--transition);
        }

        .product-image:hover {
            transform: scale(1.05);
        }

        .product-badges {
            position: absolute;
            top: 1rem;
            left: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 0.875rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            gap: 0.375rem;
            backdrop-filter: blur(10px);
        }

        .badge-status {
            background: var(--success);
            color: white;
            box-shadow: var(--shadow);
        }

        .badge-status.inactive {
            background: var(--danger);
        }

        .badge-discount {
            background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
            color: white;
            font-weight: 700;
            box-shadow: var(--shadow);
        }

        .badge-type {
            background: var(--info);
            color: white;
            box-shadow: var(--shadow);
        }

        /* Product Info */
        .product-name {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .product-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .meta-item i {
            color: var(--primary);
        }

        /* Pricing */
        .pricing-section {
            background: linear-gradient(135deg, var(--primary-50) 0%, #f5f3ff 100%);
            padding: 1.5rem;
            border-radius: var(--border-radius-sm);
            margin-bottom: 1.5rem;
        }

        .price-display {
            display: flex;
            align-items: baseline;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .current-price {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--gray-900);
        }

        .current-price::before {
            content: 'Rs. ';
            font-size: 1.25rem;
            color: var(--gray-500);
            font-weight: 600;
        }

        .original-price {
            font-size: 1.5rem;
            color: var(--gray-500);
            text-decoration: line-through;
        }

        .price-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }

        .price-item {
            background: white;
            padding: 1rem;
            border-radius: var(--border-radius-sm);
        }

        .price-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .price-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            gap: 1.5rem;
        }

        .info-group {
            display: grid;
            grid-template-columns: 140px 1fr;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .info-group:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-label i {
            color: var(--primary);
        }

        .info-value {
            font-size: 0.95rem;
            color: var(--gray-900);
            font-weight: 500;
        }

        .badge-info {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            gap: 0.375rem;
        }

        .badge-category {
            background: color-mix(in srgb, var(--primary) 10%, transparent 90%);
            color: var(--primary);
        }

        .badge-brand {
            background: color-mix(in srgb, var(--secondary) 10%, transparent 90%);
            color: var(--secondary);
        }

        .badge-code {
            background: var(--gray-100);
            color: var(--gray-700);
            font-family: 'Monaco', 'Courier New', monospace;
        }

        /* Stock Info */
        .stock-section {
            background: linear-gradient(135deg, var(--success-50) 0%, #f0fdf4 100%);
            padding: 1.5rem;
            border-radius: var(--border-radius-sm);
            margin-bottom: 1.5rem;
        }

        .stock-section.low-stock {
            background: linear-gradient(135deg, var(--warning-50) 0%, #fefce8 100%);
        }

        .stock-section.out-stock {
            background: linear-gradient(135deg, var(--danger-50) 0%, #fef2f2 100%);
        }

        .stock-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .stock-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stock-badge {
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .stock-badge.in-stock {
            background: var(--success);
            color: white;
        }

        .stock-badge.low-stock {
            background: var(--warning);
            color: white;
        }

        .stock-badge.out-stock {
            background: var(--danger);
            color: white;
        }

        .stock-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stock-item {
            background: white;
            padding: 1rem;
            border-radius: var(--border-radius-sm);
            text-align: center;
        }

        .stock-item-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .stock-item-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--gray-900);
        }

        /* Description */
        .description-section {
            line-height: 1.8;
            color: var(--gray-700);
        }

        .description-section p {
            margin-bottom: 1rem;
        }

        .description-section ul {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .description-section li {
            margin-bottom: 0.5rem;
        }

        /* Features */
        .features-list {
            display: grid;
            gap: 0.75rem;
        }

        .feature-item {
            display: flex;
            align-items: start;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: var(--border-radius-sm);
        }

        .feature-icon {
            width: 24px;
            height: 24px;
            background: var(--primary);
            color: white;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.75rem;
        }

        .feature-text {
            flex: 1;
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        /* Activity Timeline */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--gray-200);
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -1.625rem;
            top: 0.25rem;
            width: 12px;
            height: 12px;
            background: var(--primary);
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 0 2px var(--primary-light);
        }

        .timeline-content {
            background: var(--gray-50);
            padding: 1rem;
            border-radius: var(--border-radius-sm);
        }

        .timeline-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .timeline-date {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        /* Loading */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-overlay.active {
            display: flex;
        }

        .loader-spinner {
            width: 60px;
            height: 60px;
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content-wrapper {
                grid-template-columns: 1fr;
            }

            .price-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
            }

            .header-content {
                flex-direction: column;
                align-items: stretch;
            }

            .header-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .product-name {
                font-size: 1.5rem;
            }

            .current-price {
                font-size: 2rem;
            }

            .info-group {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .stock-details {
                grid-template-columns: 1fr;
            }

            .price-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loader-spinner"></div>
    </div>

    <!-- Page Header -->
    <div class="page-header" data-aos="fade-down">
        <div class="header-content">
            <div class="header-info">
                <h1>
                    <i class="fas fa-box-open"></i>
                    Product Details
                </h1>
                <p>View complete information about this product</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('seller.product.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i>
                    Back to Products
                </a>
                <a href="{{ route('seller.product.edit', $product->id) }}" class="btn btn-white">
                    <i class="fas fa-edit"></i>
                    Edit Product
                </a>
                <button class="btn btn-danger" onclick="deleteProduct({{ $product->id }}, '{{ addslashes($product->name) }}')">
                    <i class="fas fa-trash"></i>
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper">
        <!-- Left Column -->
        <div>
            <!-- Product Image & Basic Info -->
            <div class="card" data-aos="fade-up">
                <div class="card-body">
                    <div class="product-image-wrapper">
                        <img src="{{ $product->image_url }}"
                             alt="{{ $product->name }}"
                             class="product-image"
                             onerror="this.src='{{ asset('images/default-product.png') }}'">
                        <div class="product-badges">
                            <span class="badge badge-status {{ $product->status }}">
                                <i class="fas fa-circle"></i>
                                {{ ucfirst($product->status) }}
                            </span>
                            @if($product->hasDiscount())
                                <span class="badge badge-discount">
                                    <i class="fas fa-percent"></i>
                                    {{ $product->discount }}% OFF
                                </span>
                            @endif
                            <span class="badge badge-type">
                                <i class="fas fa-{{ $product->type == 'physical' ? 'box' : 'cloud' }}"></i>
                                {{ ucfirst($product->type) }}
                            </span>
                        </div>
                    </div>

                    <h2 class="product-name">{{ $product->name }}</h2>

                    <div class="product-meta">
                        <div class="meta-item">
                            <i class="fas fa-calendar-plus"></i>
                            Created: {{ $product->created_at->format('M d, Y') }}
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            Updated: {{ $product->updated_at->format('M d, Y') }}
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-user"></i>
                            Added by: {{ ucfirst($product->add_by) }}
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="pricing-section">
                        <div class="price-display">
                            <span class="current-price">{{ number_format($product->final_price, 2) }}</span>
                            @if($product->hasDiscount())
                                <span class="original-price">Rs. {{ number_format($product->display_price, 2) }}</span>
                            @endif
                        </div>
                        <div class="price-grid">
                            <div class="price-item">
                                <div class="price-label">Stock Price</div>
                                <div class="price-value">Rs. {{ number_format($product->stock_price, 2) }}</div>
                            </div>
                            <div class="price-item">
                                <div class="price-label">Display Price</div>
                                <div class="price-value">Rs. {{ number_format($product->display_price, 2) }}</div>
                            </div>
                            @if($product->packaging_cost > 0)
                                <div class="price-item">
                                    <div class="price-label">Packaging Cost</div>
                                    <div class="price-value">Rs. {{ number_format($product->packaging_cost, 2) }}</div>
                                </div>
                            @endif
                            @if($product->hasDiscount())
                                <div class="price-item">
                                    <div class="price-label">Discount</div>
                                    <div class="price-value">{{ $product->discount }}%</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Stock Information -->
                    @php
                        $stockStatus = $product->qty == 0 ? 'out-stock' : ($product->qty <= $product->min_qty ? 'low-stock' : 'in-stock');
                        $stockText = $product->qty == 0 ? 'Out of Stock' : ($product->qty <= $product->min_qty ? 'Low Stock' : 'In Stock');
                        $stockIcon = $product->qty == 0 ? 'fa-xmark' : ($product->qty <= $product->min_qty ? 'fa-triangle-exclamation' : 'fa-check');
                    @endphp
                    <div class="stock-section {{ $stockStatus }}">
                        <div class="stock-header">
                            <h3 class="stock-title">
                                <i class="fas fa-warehouse"></i>
                                Inventory Status
                            </h3>
                            <span class="stock-badge {{ $stockStatus }}">
                                <i class="fas {{ $stockIcon }}"></i>
                                {{ $stockText }}
                            </span>
                        </div>
                        <div class="stock-details">
                            <div class="stock-item">
                                <div class="stock-item-label">Current Stock</div>
                                <div class="stock-item-value">{{ $product->qty }}</div>
                            </div>
                            <div class="stock-item">
                                <div class="stock-item-label">Minimum Stock</div>
                                <div class="stock-item-value">{{ $product->min_qty }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($product->description)
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-align-left"></i>
                                Description
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="description-section">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Features -->
                    @if($product->features)
                        <div class="card-header" style="margin-top: 1.5rem;">
                            <h3 class="card-title">
                                <i class="fas fa-star"></i>
                                Features
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="features-list">
                                @foreach(explode("\n", $product->features) as $feature)
                                    @if(trim($feature))
                                        <div class="feature-item">
                                            <div class="feature-icon">
                                                <i class="fas fa-check"></i>
                                            </div>
                                            <div class="feature-text">{{ trim($feature) }}</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <!-- Product Information -->
            <div class="card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Product Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-group">
                            <div class="info-label">
                                <i class="fas fa-barcode"></i>
                                Product Code
                            </div>
                            <div class="info-value">
                                <span class="badge badge-code">{{ $product->code }}</span>
                            </div>
                        </div>

                        @if($product->barcode)
                            <div class="info-group">
                                <div class="info-label">
                                    <i class="fas fa-qrcode"></i>
                                    Barcode
                                </div>
                                <div class="info-value">
                                    <span class="badge badge-code">{{ $product->barcode }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="info-group">
                            <div class="info-label">
                                <i class="fas fa-tag"></i>
                                Category
                            </div>
                            <div class="info-value">
                                <span class="badge badge-category">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                            </div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">
                                <i class="fas fa-copyright"></i>
                                Brand
                            </div>
                            <div class="info-value">
                                <span class="badge badge-brand">
                                    {{ $product->brand->name ?? 'N/A' }}
                                </span>
                            </div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">
                                <i class="fas fa-link"></i>
                                Slug
                            </div>
                            <div class="info-value">
                                <code>{{ $product->slug }}</code>
                            </div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">
                                <i class="fas fa-id-badge"></i>
                                Seller Code
                            </div>
                            <div class="info-value">
                                <span class="badge badge-code">{{ $product->seller_code }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="card" data-aos="fade-up" data-aos-delay="200" style="margin-top: 1.5rem;">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history"></i>
                        Activity Timeline
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">Product Created</div>
                                <div class="timeline-date">
                                    <i class="fas fa-calendar"></i>
                                    {{ $product->created_at->format('F d, Y') }} at {{ $product->created_at->format('h:i A') }}
                                </div>
                            </div>
                        </div>

                        @if($product->updated_at != $product->created_at)
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Last Updated</div>
                                    <div class="timeline-date">
                                        <i class="fas fa-clock"></i>
                                        {{ $product->updated_at->format('F d, Y') }} at {{ $product->updated_at->format('h:i A') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">Current Status</div>
                                <div class="timeline-date">
                                    <i class="fas fa-circle"></i>
                                    {{ ucfirst($product->status) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card" data-aos="fade-up" data-aos-delay="300" style="margin-top: 1.5rem;">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <div style="display: grid; gap: 0.75rem;">
                        <a href="{{ route('seller.product.edit', $product->id) }}" class="btn btn-white" style="width: 100%;">
                            <i class="fas fa-edit"></i>
                            Edit Product
                        </a>
                        <button class="btn btn-outline" onclick="duplicateProduct()" style="width: 100%; background: var(--primary-50); color: var(--primary); border-color: var(--primary-light);">
                            <i class="fas fa-copy"></i>
                            Duplicate Product
                        </button>
                        <button class="btn btn-outline" onclick="printProduct()" style="width: 100%; background: var(--info); color: white; border-color: var(--info);">
                            <i class="fas fa-print"></i>
                            Print Details
                        </button>
                        <button class="btn btn-danger" onclick="deleteProduct({{ $product->id }}, '{{ addslashes($product->name) }}')" style="width: 100%;">
                            <i class="fas fa-trash"></i>
                            Delete Product
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        AOS.init({ duration: 500, once: true, offset: 50 });

        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            showMethod: 'slideDown',
            hideMethod: 'slideUp'
        };

        function deleteProduct(productId, productName) {
            Swal.fire({
                title: 'Delete Product',
                html: `
                    <div style="text-align: left;">
                        <p>Delete product <strong>"${productName}"</strong>?</p>
                        <p class="text-danger" style="font-size: 0.9rem; margin-top: 10px;">
                            <i class="fas fa-exclamation-triangle"></i>
                            This action cannot be undone!
                        </p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    showLoading();

                    try {
                        const response = await fetch(`/seller/product/${productId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Failed to delete product');
                        }

                        hideLoading();
                        return data;
                    } catch (error) {
                        hideLoading();
                        Swal.showValidationMessage(error.message);
                        return false;
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    toastr.success('Product deleted successfully');
                    setTimeout(() => {
                        window.location.href = '{{ route("seller.product.index") }}';
                    }, 1000);
                }
            });
        }

        function duplicateProduct() {
            Swal.fire({
                title: 'Duplicate Product',
                text: 'Create a copy of this product?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6366f1',
                confirmButtonText: 'Yes, Duplicate',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    toastr.info('Duplication feature coming soon!');
                }
            });
        }

        function printProduct() {
            window.print();
        }

        function showLoading() {
            $('#loadingOverlay').addClass('active');
        }

        function hideLoading() {
            $('#loadingOverlay').removeClass('active');
        }

        // Print Styles
        window.addEventListener('beforeprint', function() {
            document.body.classList.add('printing');
        });

        window.addEventListener('afterprint', function() {
            document.body.classList.remove('printing');
        });
    </script>

    <style media="print">
        .page-header,
        .header-actions,
        .btn,
        [data-aos] {
            display: none !important;
        }

        .content-wrapper {
            grid-template-columns: 1fr !important;
        }

        .card {
            box-shadow: none !important;
            page-break-inside: avoid;
        }
    </style>
@endpush
