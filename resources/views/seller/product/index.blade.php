@extends('seller.layout.app')

@push('title')
    My Products - Dashboard
@endpush

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            --border-radius: 12px;
            --border-radius-sm: 6px;
            --border-radius-lg: 16px;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --transition: all 0.2s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 14px;
            color: var(--gray-700);
            line-height: 1.5;
        }

        /* ==================== HEADER ==================== */
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: var(--border-radius);
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-md);
            color: white;
        }

        .header-main {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-info h1 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-info h1 i {
            font-size: 1.1rem;
            background: rgba(255, 255, 255, 0.15);
            padding: 0.5rem;
            border-radius: 8px;
        }

        .header-info p {
            font-size: 0.8rem;
            opacity: 0.9;
            max-width: 500px;
        }

        .header-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-primary, .btn-secondary {
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            font-size: 0.8rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
            border: none;
        }

        .btn-primary {
            background: white;
            color: var(--primary);
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* ==================== STATS GRID ==================== */
        .stats-section {
            margin-bottom: 1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.75rem;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--border-radius);
            padding: 1rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .stat-card:hover {
            box-shadow: var(--shadow);
            transform: translateY(-1px);
        }

        .stat-card-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .stat-icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            background: var(--primary-50);
            color: var(--primary);
        }

        .stat-details {
            flex: 1;
            min-width: 0;
        }

        .stat-label {
            color: var(--gray-600);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.125rem;
        }

        .stat-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .stat-trend {
            font-size: 0.7rem;
            padding: 0.125rem 0.5rem;
            border-radius: 10px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* ==================== FILTERS ==================== */
        .filters-wrapper {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-sm);
        }

        .filters-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .filters-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filters-title i {
            color: var(--primary);
        }

        .filters-controls {
            display: flex;
            gap: 0.5rem;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .filter-group {
            position: relative;
        }

        .filter-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-600);
            margin-bottom: 0.375rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .filter-input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius-sm);
            font-size: 0.8rem;
            background: white;
            transition: var(--transition);
            height: 34px;
        }

        .filter-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .quick-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.375rem;
            padding-top: 0.75rem;
            border-top: 1px solid var(--gray-200);
        }

        .quick-filter-btn {
            padding: 0.375rem 0.75rem;
            border: 1px solid var(--gray-300);
            background: white;
            border-radius: 16px;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .quick-filter-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .quick-filter-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* ==================== TABLE ==================== */
        .table-wrapper {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1rem;
        }

        .table-header {
            padding: 1rem;
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
        }

        .table-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .table-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .table-title i {
            color: var(--primary);
        }

        .table-controls {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .sort-select, .order-select {
            padding: 0.375rem 0.5rem;
            border: 1px solid var(--gray-300);
            background: white;
            border-radius: var(--border-radius-sm);
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--gray-700);
            cursor: pointer;
            min-width: 110px;
            height: 34px;
        }

        .table-actions {
            display: flex;
            gap: 0.375rem;
        }

        .table-btn {
            padding: 0.375rem 0.75rem;
            border: 1px solid var(--gray-300);
            background: white;
            border-radius: var(--border-radius-sm);
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            height: 34px;
            white-space: nowrap;
        }

        .table-btn:hover {
            background: var(--gray-50);
        }

        .table-btn.primary {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* ==================== BULK ACTIONS ==================== */
        .bulk-actions {
            background: var(--primary-50);
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--gray-200);
            display: none;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .bulk-actions.active {
            display: flex;
        }

        .bulk-info {
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--gray-700);
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .bulk-actions-btns {
            display: flex;
            gap: 0.375rem;
        }

        .bulk-btn {
            padding: 0.375rem 0.75rem;
            border: none;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            font-size: 0.75rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .bulk-btn:hover {
            transform: translateY(-1px);
        }

        /* ==================== TABLE CONTENT ==================== */
        .table-responsive {
            overflow-x: auto;
        }

        #product-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
        }

        #product-table thead th {
            background: var(--gray-50);
            font-weight: 600;
            color: var(--gray-700);
            padding: 0.75rem;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--gray-200);
            white-space: nowrap;
            text-align: left;
        }

        #product-table tbody td {
            padding: 0.75rem;
            border-bottom: 1px solid var(--gray-100);
            font-size: 0.8rem;
            line-height: 1.4;
            vertical-align: middle;
        }

        #product-table tbody tr:hover {
            background: var(--gray-50);
        }

        /* ==================== CHECKBOX ==================== */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
        }

        .checkbox-custom {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        /* ==================== PRODUCT CELL ==================== */
        .product-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-width: 200px;
        }

        .product-image-box {
            width: 40px;
            height: 40px;
            border-radius: var(--border-radius-sm);
            overflow: hidden;
            background: var(--gray-100);
            flex-shrink: 0;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-details {
            flex: 1;
            min-width: 0;
        }

        .product-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.125rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.7rem;
            color: var(--gray-600);
        }

        /* ==================== BADGES ==================== */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 600;
            gap: 0.25rem;
        }

        .badge-code {
            background: var(--gray-100);
            color: var(--gray-700);
            font-family: monospace;
        }

        /* ==================== PRICE ==================== */
        .price-display {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
        }

        .price-current {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .price-original {
            font-size: 0.75rem;
            color: var(--gray-500);
            text-decoration: line-through;
        }

        /* ==================== STOCK ==================== */
        .stock-display {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 600;
            width: fit-content;
        }

        .stock-badge.in-stock {
            background: var(--success-50);
            color: var(--success);
        }

        .stock-badge.low-stock {
            background: var(--warning-50);
            color: var(--warning);
        }

        .stock-badge.out-stock {
            background: var(--danger-50);
            color: var(--danger);
        }

        .stock-count {
            font-size: 0.7rem;
            color: var(--gray-600);
        }

        /* ==================== STATUS ==================== */
        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .status-indicator.active {
            background: var(--success-50);
            color: var(--success);
        }

        .status-indicator.inactive {
            background: var(--danger-50);
            color: var(--danger);
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        /* ==================== ACTIONS ==================== */
        .action-buttons {
            display: flex;
            gap: 0.25rem;
        }

        .action-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: none;
            color: white;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }

        .action-btn:hover {
            transform: translateY(-1px);
        }

        .action-btn.view { background: var(--info); }
        .action-btn.edit { background: var(--warning); }
        .action-btn.delete { background: var(--danger); }

        /* ==================== PAGINATION ==================== */
        .pagination-wrapper {
            padding: 1rem;
            background: white;
            border-top: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }

        .pagination {
            display: flex;
            gap: 0.25rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .page-item {
            margin: 0;
        }

        .page-link {
            padding: 0.375rem 0.75rem;
            border: 1px solid var(--gray-300);
            background: white;
            color: var(--gray-700);
            text-decoration: none;
            border-radius: var(--border-radius-sm);
            font-size: 0.8rem;
            min-width: 34px;
            text-align: center;
            transition: var(--transition);
        }

        .page-link:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
        }

        .page-item.active .page-link {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .page-item.disabled .page-link {
            color: var(--gray-400);
            cursor: not-allowed;
            background: var(--gray-100);
        }

        .page-item.ellipsis {
            display: flex;
            align-items: center;
            padding: 0 0.25rem;
        }

        .pagination-info {
            font-size: 0.75rem;
            color: var(--gray-600);
            text-align: center;
        }

        .pagination-controls {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .page-input-group {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .page-input {
            width: 60px;
            padding: 0.25rem 0.5rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius-sm);
            font-size: 0.8rem;
            text-align: center;
        }

        .go-btn {
            padding: 0.25rem 0.5rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius-sm);
            font-size: 0.8rem;
            cursor: pointer;
        }

        /* ==================== LOADING ==================== */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-overlay.active {
            display: flex;
        }

        .loader-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ==================== EMPTY STATE ==================== */
        .empty-state {
            text-align: center;
            padding: 2rem;
        }

        .empty-icon {
            font-size: 2.5rem;
            color: var(--gray-300);
            margin-bottom: 1rem;
        }

        .empty-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: var(--gray-600);
            font-size: 0.85rem;
            margin-bottom: 1rem;
            max-width: 300px;
            margin: 0 auto 1rem;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .header-main {
                flex-direction: column;
                align-items: stretch;
            }

            .header-actions {
                justify-content: center;
            }

            .filters-header {
                flex-direction: column;
                align-items: stretch;
                gap: 0.75rem;
            }

            .filters-controls {
                justify-content: center;
            }

            .table-header-content {
                flex-direction: column;
                align-items: stretch;
                gap: 0.75rem;
            }

            .table-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .sort-select, .order-select {
                width: 100%;
            }

            .table-actions {
                justify-content: center;
            }

            #product-table thead th:nth-child(3),
            #product-table td:nth-child(3),
            #product-table thead th:nth-child(4),
            #product-table td:nth-child(4),
            #product-table thead th:nth-child(5),
            #product-table td:nth-child(5) {
                display: none;
            }

            .product-cell {
                flex-direction: column;
                text-align: center;
            }

            .product-meta {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filters-grid {
                grid-template-columns: 1fr;
            }

            .quick-filters {
                justify-content: center;
            }

            .bulk-actions {
                flex-direction: column;
                align-items: stretch;
                gap: 0.5rem;
            }

            .bulk-actions-btns {
                justify-content: center;
            }

            .pagination {
                flex-wrap: wrap;
            }

            .page-link {
                padding: 0.25rem 0.5rem;
                min-width: 30px;
            }
        }

        @media (max-width: 400px) {
            .btn-primary, .btn-secondary {
                width: 100%;
                justify-content: center;
            }

            .table-btn {
                flex: 1;
                justify-content: center;
            }

            .action-buttons {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        /* ==================== SCROLLBAR ==================== */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gray-400);
            border-radius: 3px;
        }
    </style>
@endpush

@section('content')
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loader-spinner"></div>
    </div>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="header-main">
            <div class="header-info">
                <h1>
                    <i class="fas fa-boxes"></i>
                    Product Management
                </h1>
                <p>
                    Manage your inventory, track stock levels, and update product information
                </p>
            </div>
            <div class="header-actions">
                <a href="{{ route('seller.product.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Product
                </a>
                <button class="btn-secondary" onclick="toggleBulkSelect()">
                    <i class="fas fa-tasks"></i>
                    Bulk Actions
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="stat-details">
                        <div class="stat-label">Total Products</div>
                        <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                        <span class="stat-trend" style="background: var(--primary-50); color: var(--primary);">
                            <i class="fas fa-chart-line"></i>
                            All Inventory
                        </span>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-details">
                        <div class="stat-label">Active</div>
                        <div class="stat-value">{{ $stats['active'] ?? 0 }}</div>
                        @php
                            $activePercent = isset($stats['total']) && $stats['total'] > 0 ?
                                round(($stats['active'] / $stats['total']) * 100) : 0;
                        @endphp
                        <span class="stat-trend" style="background: var(--success-50); color: var(--success);">
                            <i class="fas fa-arrow-up"></i>
                            {{ $activePercent }}%
                        </span>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-details">
                        <div class="stat-label">Low Stock</div>
                        <div class="stat-value">{{ $stats['low_stock'] ?? 0 }}</div>
                        <span class="stat-trend" style="background: var(--warning-50); color: var(--warning);">
                            <i class="fas {{ $stats['low_stock'] > 0 ? 'fa-bell' : 'fa-check' }}"></i>
                            {{ $stats['low_stock'] > 0 ? 'Need Restock' : 'Optimal' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-icon-wrapper">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-details">
                        <div class="stat-label">Out of Stock</div>
                        <div class="stat-value">{{ $stats['out_of_stock'] ?? 0 }}</div>
                        <span class="stat-trend" style="background: var(--danger-50); color: var(--danger);">
                            <i class="fas fa-exclamation"></i>
                            Action Required
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-wrapper">
        <div class="filters-header">
            <h3 class="filters-title">
                <i class="fas fa-filter"></i>
                Filter Products
            </h3>
            <div class="filters-controls">
                <button class="table-btn" onclick="toggleFilters()">
                    <i class="fas fa-sliders-h"></i> Filters
                </button>
                <button class="table-btn" onclick="resetAllFilters()">
                    <i class="fas fa-redo"></i> Reset
                </button>
            </div>
        </div>

        <div class="filters-grid" id="filtersGrid" style="display: none;">
            <div class="filter-group">
                <label class="filter-label">
                    <i class="fas fa-search"></i> Search
                </label>
                <input type="text" id="searchInput" class="filter-input"
                       placeholder="Search by name or SKU..."
                       value="{{ request('search', '') }}">
            </div>

            <div class="filter-group">
                <label class="filter-label">
                    <i class="fas fa-tag"></i> Category
                </label>
                <select id="filterCategory" class="filter-input">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">
                    <i class="fas fa-copyright"></i> Brand
                </label>
                <select id="filterBrand" class="filter-input">
                    <option value="">All Brands</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">
                    <i class="fas fa-toggle-on"></i> Status
                </label>
                <select id="filterStatus" class="filter-input">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">
                    <i class="fas fa-box"></i> Stock
                </label>
                <select id="filterStock" class="filter-input">
                    <option value="">All Stock</option>
                    <option value="in" {{ request('stock') == 'in' ? 'selected' : '' }}>In Stock</option>
                    <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
        </div>

        <div class="quick-filters">
            <button class="quick-filter-btn {{ !request()->hasAny(['status', 'stock', 'discount']) ? 'active' : '' }}"
                    onclick="window.location.href='{{ route('seller.product.index') }}'">
                <i class="fas fa-globe"></i> All
            </button>
            <button class="quick-filter-btn {{ request('status') == 'active' ? 'active' : '' }}"
                    onclick="window.location.href='{{ route('seller.product.index', array_merge(request()->all(), ['status' => 'active', 'page' => 1])) }}'">
                <i class="fas fa-check"></i> Active
            </button>
            <button class="quick-filter-btn {{ request('stock') == 'low' ? 'active' : '' }}"
                    onclick="window.location.href='{{ route('seller.product.index', array_merge(request()->all(), ['stock' => 'low', 'page' => 1])) }}'">
                <i class="fas fa-exclamation"></i> Low Stock
            </button>
            <button class="quick-filter-btn {{ request('stock') == 'out' ? 'active' : '' }}"
                    onclick="window.location.href='{{ route('seller.product.index', array_merge(request()->all(), ['stock' => 'out', 'page' => 1])) }}'">
                <i class="fas fa-ban"></i> Out of Stock
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <div class="table-header">
            <div class="table-header-content">
                <div>
                    <h2 class="table-title">
                        <i class="fas fa-list"></i>
                        Products List
                        <span class="text-muted" style="font-size: 0.8rem; font-weight: normal;">
                            ({{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() ?? 0 }})
                        </span>
                    </h2>
                </div>
                <div class="table-controls">
                    <select class="sort-select" onchange="updateSort(this.value)">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest First</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="display_price" {{ request('sort') == 'display_price' ? 'selected' : '' }}>Price Low-High</option>
                        <option value="display_price_desc" {{ request('sort') == 'display_price_desc' ? 'selected' : '' }}>Price High-Low</option>
                    </select>

                    <select class="order-select" onchange="updateOrder(this.value)">
                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>

                    <div class="table-actions">
                        <button class="table-btn" onclick="exportToExcel()" title="Export to Excel">
                            <i class="fas fa-file-excel"></i>
                        </button>
                        <button class="table-btn" onclick="printTable()" title="Print">
                            <i class="fas fa-print"></i>
                        </button>
                        <button class="table-btn primary" onclick="refreshPage()" title="Refresh">
                            <i class="fas fa-sync"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="bulk-actions" id="bulkActions">
            <span class="bulk-info">
                <i class="fas fa-check-square"></i>
                <span id="selectedCount">0</span> selected
            </span>
            <div class="bulk-actions-btns">
                <button class="bulk-btn" onclick="bulkActivate()" style="background: var(--success);">
                    <i class="fas fa-check"></i> Activate
                </button>
                <button class="bulk-btn" onclick="bulkDeactivate()" style="background: var(--warning);">
                    <i class="fas fa-ban"></i> Deactivate
                </button>
                <button class="bulk-btn" onclick="bulkDelete()" style="background: var(--danger);">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="product-table">
                <thead>
                <tr>
                    <th class="checkbox-wrapper">
                        <input type="checkbox" class="checkbox-custom" id="selectAll">
                    </th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    @php
                        $stockStatus = $product->qty == 0 ? 'out-stock' :
                                     ($product->qty <= $product->min_qty ? 'low-stock' : 'in-stock');
                        $stockText = $product->qty == 0 ? 'Out of Stock' :
                                   ($product->qty <= $product->min_qty ? 'Low Stock' : 'In Stock');
                    @endphp
                    <tr>
                        <td class="checkbox-wrapper">
                            <input type="checkbox" class="checkbox-custom row-checkbox"
                                   value="{{ $product->id }}"
                                   data-name="{{ $product->name }}">
                        </td>
                        <td>
                            <div class="product-cell">
                                <div class="product-image-box">
                                    <img src="{{ $product->image_url }}"
                                         alt="{{ $product->name }}"
                                         class="product-img"
                                         onerror="this.src='{{ asset('images/default-product.png') }}'">
                                </div>
                                <div class="product-details">
                                    <div class="product-name" title="{{ $product->name }}">
                                        {{ Str::limit($product->name, 50) }}
                                    </div>
                                    <div class="product-meta">
                                        <span><i class="fas fa-calendar"></i> {{ $product->created_at->format('M d, Y') }}</span>
                                        @if($product->discount > 0)
                                            <span><i class="fas fa-tag"></i> {{ $product->discount }}% OFF</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-code">{{ $product->code }}</span>
                        </td>
                        <td>
                                <span class="badge" style="background: #e0e7ff; color: #4f46e5;">
                                    <i class="fas fa-tag"></i>
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                        </td>
                        <td>
                                <span class="badge" style="background: #f3e8ff; color: #7c3aed;">
                                    <i class="fas fa-copyright"></i>
                                    {{ $product->brand->name ?? 'N/A' }}
                                </span>
                        </td>
                        <td>
                            <div class="price-display">
                                <div class="price-current">
                                    Rs. {{ number_format($product->final_price, 2) }}
                                </div>
                                @if($product->discount > 0)
                                    <div class="price-original">
                                        Rs. {{ number_format($product->display_price, 2) }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="stock-display">
                                    <span class="stock-badge {{ $stockStatus }}">
                                        <i class="fas fa-{{ $stockStatus == 'in-stock' ? 'check' : ($stockStatus == 'low-stock' ? 'exclamation' : 'times') }}"></i>
                                        {{ $stockText }}
                                    </span>
                                <div class="stock-count">
                                    {{ $product->qty }} units
                                </div>
                            </div>
                        </td>
                        <td>
                                <span class="status-indicator {{ $product->status }}">
                                    <span class="status-dot"></span>
                                    {{ ucfirst($product->status) }}
                                </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('seller.product.show', $product->id) }}"
                                   class="action-btn view" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('seller.product.edit', $product->id) }}"
                                   class="action-btn edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="action-btn delete"
                                        onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <h3 class="empty-title">No Products Found</h3>
                                <p class="empty-text">
                                    {{ request()->hasAny(['search', 'category_id', 'brand_id', 'status', 'stock'])
                                       ? 'Try changing your filters'
                                       : 'Add your first product to get started' }}
                                </p>
                                @if(!request()->hasAny(['search', 'category_id', 'brand_id', 'status', 'stock']))
                                    <a href="{{ route('seller.product.create') }}" class="btn-primary">
                                        <i class="fas fa-plus"></i>
                                        Add Product
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="pagination-wrapper">
                <nav>
                    <ul class="pagination">
                        <!-- Previous Page Link -->
                        @if($products->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        <!-- First Page -->
                        @if($products->currentPage() > 3)
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->url(1) }}">1</a>
                            </li>
                            @if($products->currentPage() > 4)
                                <li class="page-item ellipsis"><span class="page-link">...</span></li>
                            @endif
                        @endif

                        <!-- Middle Pages -->
                        @for($i = max(1, $products->currentPage() - 2); $i <= min($products->lastPage(), $products->currentPage() + 2); $i++)
                            <li class="page-item {{ $i == $products->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <!-- Last Page -->
                        @if($products->currentPage() < $products->lastPage() - 2)
                            @if($products->currentPage() < $products->lastPage() - 3)
                                <li class="page-item ellipsis"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->url($products->lastPage()) }}">{{ $products->lastPage() }}</a>
                            </li>
                        @endif

                        <!-- Next Page Link -->
                        @if($products->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->nextPageUrl() }}">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </nav>

                <div class="pagination-controls">
                    <div class="pagination-info">
                        Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                        ({{ $products->total() }} total products)
                    </div>

                    @if($products->lastPage() > 5)
                        <div class="page-input-group">
                            <input type="number" class="page-input" id="pageInput"
                                   min="1" max="{{ $products->lastPage() }}"
                                   placeholder="Page">
                            <button class="go-btn" onclick="goToPage()">Go</button>
                        </div>
                    @endif

                    <select class="filter-input" onchange="updatePerPage(this.value)" style="width: auto;">
                        <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20 per page</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                    </select>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        let selectedProducts = new Set();
        let currentPage = {{ $products->currentPage() }};
        let totalPages = {{ $products->lastPage() }};

        $(document).ready(function() {
            // Initialize tooltips
            $('[title]').tooltip();

            // Initialize bulk actions
            initializeBulkActions();

            // Initialize filters
            initializeFilters();

            // Initialize DataTable for export only
            @if($products->count() > 0)
            $('#product-table').DataTable({
                paging: false,
                searching: false,
                info: false,
                ordering: false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'table-btn',
                        exportOptions: {
                            columns: ':not(:first-child):not(:last-child)'
                        }
                    }
                ]
            });
            @endif
        });

        function initializeFilters() {
            // Search input with debounce
            let searchTimer;
            $('#searchInput').on('keyup', function() {
                clearTimeout(searchTimer);
                const value = $(this).val();

                searchTimer = setTimeout(() => {
                    if (value.length >= 2 || value.length === 0) {
                        updateFilter('search', value);
                    }
                }, 500);
            });

            // Filter dropdowns
            $('#filterCategory, #filterBrand, #filterStatus, #filterStock').on('change', function() {
                const name = $(this).attr('id').replace('filter', '').toLowerCase();
                const value = $(this).val();
                updateFilter(name, value);
            });

            // Toggle filters visibility
            window.toggleFilters = function() {
                $('#filtersGrid').slideToggle();
            };
        }

        function updateFilter(name, value) {
            const url = new URL(window.location.href);

            if (value) {
                url.searchParams.set(name, value);
            } else {
                url.searchParams.delete(name);
            }

            // Reset to page 1 when filters change
            url.searchParams.set('page', 1);

            window.location.href = url.toString();
        }

        function updateSort(value) {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', value);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        function updateOrder(value) {
            const url = new URL(window.location.href);
            url.searchParams.set('order', value);
            window.location.href = url.toString();
        }

        function updatePerPage(value) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', value);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        function goToPage() {
            const pageInput = $('#pageInput').val();
            if (pageInput && pageInput >= 1 && pageInput <= totalPages) {
                const url = new URL(window.location.href);
                url.searchParams.set('page', pageInput);
                window.location.href = url.toString();
            }
        }

        function resetAllFilters() {
            window.location.href = '{{ route("seller.product.index") }}';
        }

        function refreshPage() {
            window.location.reload();
        }

        function initializeBulkActions() {
            // Select all checkbox
            $('#selectAll').on('change', function() {
                const isChecked = $(this).prop('checked');
                $('.row-checkbox').prop('checked', isChecked).trigger('change');
            });

            // Individual row checkboxes
            $(document).on('change', '.row-checkbox', function() {
                const productId = $(this).val();

                if ($(this).prop('checked')) {
                    selectedProducts.add(productId);
                } else {
                    selectedProducts.delete(productId);
                    $('#selectAll').prop('checked', false);
                }

                updateBulkActions();
            });
        }

        function updateBulkActions() {
            const count = selectedProducts.size;
            $('#selectedCount').text(count);

            if (count > 0) {
                $('#bulkActions').addClass('active');
            } else {
                $('#bulkActions').removeClass('active');
            }

            // Update select all checkbox
            const totalRows = $('.row-checkbox').length;
            $('#selectAll').prop('checked', count === totalRows && totalRows > 0);
        }

        function toggleBulkSelect() {
            const isVisible = $('#selectAll').is(':visible');
            $('.checkbox-wrapper').toggle(!isVisible);

            if (!isVisible) {
                selectedProducts.clear();
                updateBulkActions();
            }
        }

        function bulkActivate() {
            if (selectedProducts.size === 0) {
                toastr.warning('Please select at least one product');
                return;
            }

            confirmBulkAction('activate', 'Activate selected products?');
        }

        function bulkDeactivate() {
            if (selectedProducts.size === 0) {
                toastr.warning('Please select at least one product');
                return;
            }

            confirmBulkAction('deactivate', 'Deactivate selected products?');
        }

        function bulkDelete() {
            if (selectedProducts.size === 0) {
                toastr.warning('Please select at least one product');
                return;
            }

            confirmBulkAction('delete', 'Delete selected products? This action cannot be undone!');
        }

        function confirmBulkAction(action, message) {
            Swal.fire({
                title: 'Confirm Action',
                text: message,
                icon: action === 'delete' ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: action === 'delete' ? '#dc3545' : '#3085d6',
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return performBulkAction(action);
                }
            });
        }

        async function performBulkAction(action) {
            showLoading();

            {{--try {--}}
            {{--    const response = await fetch('{{ route("seller.product.bulk-action") }}', {--}}
            {{--        method: 'POST',--}}
            {{--        headers: {--}}
            {{--            'Content-Type': 'application/json',--}}
            {{--            'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
            {{--        },--}}
            {{--        body: JSON.stringify({--}}
            {{--            action: action,--}}
            {{--            product_ids: Array.from(selectedProducts)--}}
            {{--        })--}}
            {{--    });--}}

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Action failed');
                }

                hideLoading();

                toastr.success(data.message || 'Action completed successfully');

                // Clear selection and refresh page
                selectedProducts.clear();
                setTimeout(() => {
                    window.location.reload();
                }, 1500);

                return true;
            } catch (error) {
                hideLoading();
                toastr.error(error.message || 'Action failed');
                return false;
            }
        }

        function confirmDelete(productId, productName) {
            Swal.fire({
                title: 'Delete Product',
                html: `Are you sure you want to delete <strong>"${productName}"</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteProduct(productId);
                }
            });
        }

        async function deleteProduct(productId) {
            showLoading();

            try {
                const response = await fetch(`/seller/product/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Delete failed');
                }

                hideLoading();

                toastr.success(data.message || 'Product deleted successfully');

                setTimeout(() => {
                    window.location.reload();
                }, 1500);

            } catch (error) {
                hideLoading();
                toastr.error(error.message || 'Delete failed');
            }
        }

        function exportToExcel() {
            // Trigger DataTable export button
            $('.buttons-excel').click();
        }

        function printTable() {
            window.print();
        }

        function showLoading() {
            $('#loadingOverlay').addClass('active');
        }

        function hideLoading() {
            $('#loadingOverlay').removeClass('active');
        }
    </script>
@endpush
