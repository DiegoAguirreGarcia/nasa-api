<?php

namespace App\Http\Controllers\Api;

use App\Services\NasaService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NasaController extends Controller
{
    protected NasaService $nasaService;

    public function __construct(NasaService $nasaService)
    {
        $this->nasaService = $nasaService;
    }

    public function getInstruments(): JsonResponse
    {
        $instruments = $this->nasaService->getInstruments();
        return response()->json(['instruments' => $instruments]);
    }

    public function getActivityIds(): JsonResponse
    {
        $activitiesIds = $this->nasaService->getActivityIds();
        return response()->json(['activityIDs' => $activitiesIds]);
    }

    public function getInstrumentUsage(): JsonResponse
    {
        $instrumentUsage = $this->nasaService->getInstrumentUsage();
        return response()->json(['instrument_use' => $instrumentUsage]);
    }

    public function getInstrumentUsageByName(Request $request): JsonResponse
    {
        try {
            $request->validate(
                [
                    'instrument' => 'required'
                ],
                [
                    'instrument.required' => 'The field instrument is required.'
                ]
            );
            $usage = $this->nasaService->getInstrumentUsageByName($request->instrument);
            return response()->json(['instrument_activity' => [$request->instrument => $usage]]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
            ], $e->status);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getData(Request $request)
    {
        $url = env('NASA_BASE_URL') . '';
        return 'Endpoint reached!';
    }
}
