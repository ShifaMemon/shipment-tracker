<?php
namespace Database\Seeders;

use App\Models\Shipment;
use App\Models\StatusLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {

            // Random Status
            $statuses      = ['Pending', 'In Transit', 'Delivered'];
            $currentStatus = $statuses[array_rand($statuses)];

            $shipment = Shipment::create([
                'tracking_number'  => 'TRK' . strtoupper(Str::random(8)),
                'sender_name'      => 'Sender ' . $i,
                'sender_address'   => 'Address Line 1, City ' . $i,
                'receiver_name'    => 'Receiver ' . $i,
                'receiver_address' => 'Destination City ' . $i,
                'status'           => $currentStatus,
                'created_at'       => now()->subDays(rand(1, 10)),
                'updated_at'       => now()->subDays(rand(1, 10)),
            ]);

            // Always Add Pending
            StatusLog::create([
                'shipment_id' => $shipment->id,
                'status'      => 'Pending',
                'location'    => 'Warehouse',
                'created_at'  => Carbon::parse($shipment->created_at),
                'updated_at'  => Carbon::parse($shipment->created_at),
            ]);

            // If status >= In Transit
            if (in_array($currentStatus, ['In Transit', 'Delivered'])) {
                StatusLog::create([
                    'shipment_id' => $shipment->id,
                    'status'      => 'In Transit',
                    'location'    => 'Distribution Center',
                    'created_at'  => Carbon::parse($shipment->created_at)->addDay(),
                    'updated_at'  => Carbon::parse($shipment->created_at)->addDay(),
                ]);
            }

            // If Delivered
            if ($currentStatus == 'Delivered') {
                StatusLog::create([
                    'shipment_id' => $shipment->id,
                    'status'      => 'Delivered',
                    'location'    => 'Customer Address',
                    'created_at'  => Carbon::parse($shipment->created_at)->addDays(2),
                    'updated_at'  => Carbon::parse($shipment->created_at)->addDays(2),
                ]);
            }
        }
    }
}
