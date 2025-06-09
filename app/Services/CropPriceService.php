<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CropPriceService
{
    public function getPrice(string $crop): ?float
    {
        // Normalize crop input to match API
        $map = [
            'rice' => 'Paddy',
            'ganna' => 'Sugarcane',
            'Ganna' => 'Sugarcane',
            'sugarcane' => 'Sugarcane',
            'gehu' => 'Wheat',
            'wheat' => 'Wheat',
            'apple' => 'Apple',
            'banana' => 'Banana',
            'potato' => 'Potato',
            'onion' => 'Onion',
            'tomato' => 'Tomato',
        ];

        $cropKey = strtolower(trim($crop));
        $mappedCrop = $map[$cropKey] ?? ucfirst($cropKey);

        $apiKey = env('DATA_GOV_API_KEY');
        $resourceId = env('DATA_GOV_RESOURCE_ID');

        $response = Http::retry(3, 2000)->timeout(60)->get('https://api.data.gov.in/resource/' . $resourceId, [
        'api-key' => $apiKey,
        'format' => 'json',
        'filters[commodity]' => $mappedCrop,
        'limit' => 10000,
        'sort' => 'desc',
    ]);


        if ($response->successful()) {
        $data = $response->json();
        foreach ($data['records'] as $record) {
            if (!empty($record['modal_price'])) {
                $pricePerQuintal = (float) $record['modal_price'];
                return round($pricePerQuintal / 100, 2); // ₹/kg
            }
        }
    }


        return null; // No price found
    }
}


?>