<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\DHLShippingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $dhlService;

    public function __construct(DHLShippingService $dhlService)
    {
        $this->dhlService = $dhlService;
    }
    public function index(Request $request)
    {
        $query = Order::query();

        // Filter by status
        $status = $request->get('shipping_status', 'all');
        if ($status !== 'all') {
            $query->where('shipping_status', $status);
        }

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%$search%");
                //   ->orWhere('customer', 'like', "%$search%")
                //   ->orWhere('customer_email', 'like', "%$search%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'order_date');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        // Analytics
        $totalOrders = Order::count();
        $totalProcessOrder = Order::whereIn('shipping_status', ['pending', 'processing', 'shipped', 'completed'])->count();
        $totalCompleteOrder = Order::where('shipping_status', 'completed')->count();
        $averagePrice = Order::avg('total_amount');

        // Paginate
        $orders = $query->paginate(5);

        return view('admin.order', compact(
            'orders',
            'totalOrders',
            'totalProcessOrder',
            'totalCompleteOrder',
            'averagePrice'
        ));
    }

    public function show(Order $order)
    {
        $order->load(['items.diamond', 'payments']);
        $trackingInfo = $order->tracking_number ? $this->dhlService->getShipmentStatus($order->tracking_number) : null;

        return view('admin.order-details', compact('order', 'trackingInfo'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $status = $request->input('status');
        $order->shipping_status = $status;

        if ($status === 'Processing') {
            try {
                $shipmentResult = $this->dhlService->createShipment($order);
                $order->save();
                return redirect()->back()->with('success', 'Order status updated and DHL shipment scheduled.');
            } catch (\Exception $e) {
                Log::error('Failed to create DHL shipment: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to create DHL shipment. Please try again.');
            }
        dd($shipmentResult);

        }
        dd('not ok');
        $order->save();
        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function printInvoice(Order $order)
    {
        $order->load([
            'items.diamond',
            'payments'
        ]);

        // Generate the PDF
        $pdf = Pdf::loadView('admin.invoice-pdf', compact('order'));
        return $pdf->download('invoice-order-' . $order->order_number . '.pdf');
    }
}
