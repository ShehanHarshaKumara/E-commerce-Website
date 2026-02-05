<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerOrder;
use App\Models\SellerOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SellerOrderController extends Controller
{
    /**
     * Display all orders
     */
    public function index(Request $request)
    {
        try {
            $seller = Auth::guard('seller')->user();

            $query = SellerOrder::where('seller_id', $seller->id)
                ->with(['items'])
                ->latest();

            // Filter by status
            if ($request->has('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            // Filter by date
            if ($request->has('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->has('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Search
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_email', 'like', "%{$search}%");
                });
            }

            $orders = $query->paginate(20)->withQueryString();

            // Get counts for status badges
            $statusCounts = [
                'all' => SellerOrder::where('seller_id', $seller->id)->count(),
                'pending' => SellerOrder::where('seller_id', $seller->id)->where('status', 'pending')->count(),
                'confirmed' => SellerOrder::where('seller_id', $seller->id)->where('status', 'confirmed')->count(),
                'processing' => SellerOrder::where('seller_id', $seller->id)->where('status', 'processing')->count(),
                'shipped' => SellerOrder::where('seller_id', $seller->id)->where('status', 'shipped')->count(),
                'completed' => SellerOrder::where('seller_id', $seller->id)->where('status', 'completed')->count(),
                'cancelled' => SellerOrder::where('seller_id', $seller->id)->where('status', 'cancelled')->count(),
            ];

            // Calculate total revenue
            $totalRevenue = SellerOrder::where('seller_id', $seller->id)
                ->where('status', 'completed')
                ->sum('total_amount');

            return view('seller.order.index', compact('orders', 'statusCounts', 'totalRevenue'));

        } catch (\Exception $e) {
            \Log::error('Orders index error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading orders: ' . $e->getMessage());
        }
    }

    /**
     * Display order details
     */
    public function show($id)
    {
        try {
            $seller = Auth::guard('seller')->user();

            $order = SellerOrder::where('seller_id', $seller->id)
                ->with(['items.product'])
                ->findOrFail($id);

            return view('seller.order.show', compact('order'));

        } catch (\Exception $e) {
            \Log::error('Show order error: ' . $e->getMessage());
            return redirect()->route('seller.orders.index')->with('error', 'Order not found');
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $seller = Auth::guard('seller')->user();

            $request->validate([
                'status' => 'required|in:pending,confirmed,processing,shipped,delivered,completed,cancelled,refunded',
                'notes' => 'nullable|string|max:500'
            ]);

            $order = SellerOrder::where('seller_id', $seller->id)
                ->findOrFail($id);

            $oldStatus = $order->status;
            $order->status = $request->status;

            if ($request->has('notes') && $request->notes) {
                $order->notes = $request->notes;
            }

            $order->save();

            \Log::info("Order #{$order->order_number} status changed from {$oldStatus} to {$request->status}");

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'status' => $order->status,
                'status_text' => ucfirst($order->status)
            ]);

        } catch (\Exception $e) {
            \Log::error('Update status error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order counts for sidebar/badges
     */
    public function getOrderCounts()
    {
        try {
            $seller = Auth::guard('seller')->user();

            $counts = [
                'all' => SellerOrder::where('seller_id', $seller->id)->count(),
                'pending' => SellerOrder::where('seller_id', $seller->id)->where('status', 'pending')->count(),
                'confirmed' => SellerOrder::where('seller_id', $seller->id)->where('status', 'confirmed')->count(),
                'processing' => SellerOrder::where('seller_id', $seller->id)->where('status', 'processing')->count(),
                'shipped' => SellerOrder::where('seller_id', $seller->id)->where('status', 'shipped')->count(),
                'completed' => SellerOrder::where('seller_id', $seller->id)->where('status', 'completed')->count(),
                'cancelled' => SellerOrder::where('seller_id', $seller->id)->where('status', 'cancelled')->count(),
            ];

            return response()->json([
                'success' => true,
                'counts' => $counts
            ]);

        } catch (\Exception $e) {
            \Log::error('Get order counts error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching order counts'
            ], 500);
        }
    }

    /**
     * Search orders
     */
    public function searchOrders(Request $request)
    {
        try {
            $seller = Auth::guard('seller')->user();
            $query = $request->get('q', '');

            $orders = SellerOrder::where('seller_id', $seller->id)
                ->where(function($q) use ($query) {
                    $q->where('order_number', 'like', "%{$query}%")
                        ->orWhere('customer_name', 'like', "%{$query}%")
                        ->orWhere('customer_email', 'like', "%{$query}%");
                })
                ->limit(10)
                ->get()
                ->map(function($order) {
                    return [
                        'id' => $order->id,
                        'order_number' => $order->order_number,
                        'customer_name' => $order->customer_name,
                        'total_amount' => $order->total_amount,
                        'status' => $order->status,
                        'status_color' => $order->status_color,
                        'status_text' => ucfirst($order->status),
                        'url' => route('seller.orders.show', $order->id)
                    ];
                });

            return response()->json([
                'success' => true,
                'results' => $orders
            ]);

        } catch (\Exception $e) {
            \Log::error('Search orders error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'results' => []
            ]);
        }
    }

    /**
     * Display pending orders
     */
    public function pending()
    {
        try {
            $seller = Auth::guard('seller')->user();

            $orders = SellerOrder::where('seller_id', $seller->id)
                ->where('status', 'pending')
                ->with(['items'])
                ->latest()
                ->paginate(20);

            return view('seller.order.pending', compact('orders'));

        } catch (\Exception $e) {
            \Log::error('Pending orders error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading pending orders');
        }
    }

    /**
     * Display confirmed orders
     */
    public function confirmed()
    {
        try {
            $seller = Auth::guard('seller')->user();

            $orders = SellerOrder::where('seller_id', $seller->id)
                ->where('status', 'confirmed')
                ->with(['items'])
                ->latest()
                ->paginate(20);

            return view('seller.order.confirmed', compact('orders'));

        } catch (\Exception $e) {
            \Log::error('Confirmed orders error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading confirmed orders');
        }
    }

    /**
     * Display processing orders
     */
    public function processing()
    {
        try {
            $seller = Auth::guard('seller')->user();

            $orders = SellerOrder::where('seller_id', $seller->id)
                ->where('status', 'processing')
                ->with(['items'])
                ->latest()
                ->paginate(20);

            return view('seller.order.processing', compact('orders'));

        } catch (\Exception $e) {
            \Log::error('Processing orders error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading processing orders');
        }
    }

    /**
     * Display shipped orders
     */
    public function shipped()
    {
        try {
            $seller = Auth::guard('seller')->user();

            $orders = SellerOrder::where('seller_id', $seller->id)
                ->where('status', 'shipped')
                ->with(['items'])
                ->latest()
                ->paginate(20);

            return view('seller.order.shipped', compact('orders'));

        } catch (\Exception $e) {
            \Log::error('Shipped orders error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading shipped orders');
        }
    }

    /**
     * Display completed orders
     */
    public function completed()
    {
        try {
            $seller = Auth::guard('seller')->user();

            $orders = SellerOrder::where('seller_id', $seller->id)
                ->where('status', 'completed')
                ->with(['items'])
                ->latest()
                ->paginate(20);

            $totalRevenue = SellerOrder::where('seller_id', $seller->id)
                ->where('status', 'completed')
                ->sum('total_amount');

            return view('seller.order.completed', compact('orders', 'totalRevenue'));

        } catch (\Exception $e) {
            \Log::error('Completed orders error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading completed orders');
        }
    }

    /**
     * Display cancelled orders
     */
    public function cancelled()
    {
        try {
            $seller = Auth::guard('seller')->user();

            $orders = SellerOrder::where('seller_id', $seller->id)
                ->where('status', 'cancelled')
                ->with(['items'])
                ->latest()
                ->paginate(20);

            return view('seller.order.cancelled', compact('orders'));

        } catch (\Exception $e) {
            \Log::error('Cancelled orders error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading cancelled orders');
        }
    }

    /**
     * Download invoice
     */
    public function downloadInvoice($id)
    {
        try {
            $seller = Auth::guard('seller')->user();

            $order = SellerOrder::where('seller_id', $seller->id)
                ->with(['items.product'])
                ->findOrFail($id);

            return Pdf::loadView('seller.order.invoice', compact('order'))->download("invoice-{$order->order_number}.pdf");

        } catch (\Exception $e) {
            \Log::error('Download invoice error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error generating invoice');
        }
    }

    /**
     * View invoice
     */
    public function viewInvoice($id)
    {
        try {
            $seller = Auth::guard('seller')->user();

            $order = SellerOrder::where('seller_id', $seller->id)
                ->with(['items.product'])
                ->findOrFail($id);

            return view('seller.order.invoice-view', compact('order'));

        } catch (\Exception $e) {
            \Log::error('View invoice error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading invoice');
        }
    }

    /**
     * Export orders to CSV
     */
    public function export(Request $request)
    {
        try {
            $seller = Auth::guard('seller')->user();

            $orders = SellerOrder::where('seller_id', $seller->id)
                ->with(['items'])
                ->latest()
                ->get();

            $fileName = 'orders-' . date('Y-m-d') . '.csv';
            $headers = [
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];

            $callback = function() use ($orders) {
                $file = fopen('php://output', 'wb');

                fputcsv($file, [
                    'Order Number',
                    'Date',
                    'Customer Name',
                    'Customer Email',
                    'Customer Phone',
                    'Total Amount',
                    'Status',
                    'Payment Method',
                    'Payment Status'
                ]);

                foreach ($orders as $order) {
                    fputcsv($file, [
                        $order->order_number,
                        $order->created_at->format('Y-m-d H:i:s'),
                        $order->customer_name,
                        $order->customer_email,
                        $order->customer_phone,
                        $order->total_amount,
                        ucfirst($order->status),
                        ucwords(str_replace('_', ' ', $order->payment_method)),
                        ucfirst($order->payment_status)
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            \Log::error('Export orders error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error exporting orders');
        }
    }
}
