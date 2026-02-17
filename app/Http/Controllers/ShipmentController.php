<?php
namespace App\Http\Controllers;

use App\Models\Shipment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShipmentController extends Controller
{

    private function isDate($value)
    {
        try {
            Carbon::parse($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    // Shipment List Page
    public function index()
    {
        return view('shipments.index');
    }

    public function data(Request $request)
    {
        $query = Shipment::query();

        return DataTables::of($query)
            ->addIndexColumn() // ✅ Adds index column

        // Custom Search by Tracking Number
        /* ->filter(function ($query) use ($request) {
                if ($request->has('search') && $request->search['value']) {
                    $query->where('tracking_number', 'like', '%' . $request->search['value'] . '%');
                }
            }) */

        // ✅ Filter only date
            ->filter(function ($query) use ($request) {

                if ($request->has('search') && $request->search['value']) {

                    $search = $request->search['value'];

                    // If user types date like 2026-02-17
                    if (preg_match("/^\d{4}-\d{2}-\d{2}$/", $search)) {
                        $query->whereDate('created_at', $search);
                    }
                    // If user types date like 17-02-2026
                    elseif (preg_match("/^\d{2}-\d{2}-\d{4}$/", $search)) {
                        $date = Carbon::createFromFormat('d-m-Y', $search)->format('Y-m-d');
                        $query->whereDate('created_at', $date);
                    }
                }
            })

            ->editColumn('status', function ($shipment) {
                return $shipment->status_badge; // Use the accessor for status badge
            })

            ->editColumn('created_at', function ($shipment) {
                return $shipment->created_at->format('d-m-Y');
            })

        /* ->addColumn('destination_city', function ($shipment) {
                return $shipment->receiver_address;
            }) */

            ->addColumn('action', function ($shipment) {
                return '<a href="' . route('shipments.show', $shipment->id) . '" class="btn btn-sm btn-primary">View</a>';
            })

            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    // Shipment Details Page
    public function show($id)
    {
        $shipment = Shipment::with('statusLogs')->findOrFail($id);
        return view('shipments.show', compact('shipment'));
    }

    // Custom Shipment List Page (without DataTables)
    public function customShipmentList(Request $request)
    {
        $query = Shipment::query();

        // 🔎 Search Filter (Grouped Properly)
        if ($request->filled('search')) {
            $search = $request->search;

            if ($this->isDate($search)) {
                $query->whereDate('created_at', Carbon::parse($search));
            } else {
                $query->where(function ($q) use ($search) {
                    $q->where('tracking_number', 'like', "%{$search}%")
                        ->orWhere('receiver_name', 'like', "%{$search}%")
                        ->orWhere('receiver_address', 'like', "%{$search}%");
                });
            }
        }

        // 📅 Filter by Specific Date
        if ($request->filled('date')) {
        }

        $shipments = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('shipments.custom_shipment', compact('shipments'));
    }

}
