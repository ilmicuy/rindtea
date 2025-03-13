<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        return view('pages.delivery');
    }

    public function calculateDistance(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Constants
        $ratePerKm = 4000; // 4000 IDR per km
        $maxDistanceKm = 10; // Max distance for local courier
        $sellerLatitude = -6.986817;
        $sellerLongitude = 110.454872;

        // Get user location
        $userLatitude = $request->input('latitude');
        $userLongitude = $request->input('longitude');

        // Calculate distance
        $distance = $this->calculateDistanceInKm(
            $sellerLatitude,
            $sellerLongitude,
            $userLatitude,
            $userLongitude
        );

        // Calculate cost
        $cost = 0;
        if ($distance <= $maxDistanceKm) {
            $cost = $distance * $ratePerKm;
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Jarak melebihi batas pengiriman kurir toko.'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'distance' => number_format($distance, 2),
            'cost' => number_format($cost, 0)
        ]);
    }

    // Helper method to calculate distance between two points
    private function calculateDistanceInKm($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Radius of Earth in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c; // Distance in kilometers

        // Pembulatan ke 2 tempat desimal
        $roundedDistance = round($distance, 2);

        return $roundedDistance;
    }
}
