<?php

namespace App\Http\Controllers\Api;

use App\Models\Asset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ManageController extends Controller
{
    function assign(Request $request) {
        // 1. Validation
        $request->validate([
            "asset" => "required|exists:assets,id",
            "employee" => "required|exists:employees,id"
        ]);

        // 2. Start the Transaction
        DB::beginTransaction();

        try {
            // --- Step A: Update status in asset table ---
            $asset = Asset::findOrFail($request->asset);
            
            // Check if already assigned if necessary
            if ($asset->status === 'assigned') {
                throw new Exception("This asset is already assigned.");
            }

            $asset->status = 'assigned'; // Update your specific status enum/string here
            $asset->save();

            // --- Step B: Pivot table insert ---
            // Option 1: The Eloquent way (Recommended if relationships are set up)
            $asset->employees()->attach($request->employee);

            // Option 2: The Manual Query Builder way (matches your comment)
            // DB::table('asset_employee')->insert([
            //     'asset_id'    => $request->asset,
            //     'employee_id' => $request->employee,
            //     'created_at'  => now(),
            //     'updated_at'  => now(),
            // ]);

            // 3. Commit the transaction if everything works
            DB::commit();

            return response()->json(['message' => 'Asset assigned successfully'], 200);

        } catch (Exception $e) {
            // 4. Rollback if ANY error occurs (validation, SQL error, etc.)
            DB::rollBack();

            // Log the error for debugging: Log::error($e->getMessage());
            return response()->json(['error' => 'Assign failed: ' . $e->getMessage()], 500);
        }
    }

    function return() {
        
    }
}
