<?php

namespace App\Http\Controllers;

use App\Api\StooqApi;
use App\Helpers\StockRequestHelper;
use App\Http\Requests\StockStoreRequest;
use App\Http\Requests\StockUpdateRequest;
use App\Http\Resources\StockCollection;
use App\Http\Resources\StockResource;
use App\Models\Stock;
use App\Notifications\StockRequested;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class StockController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $response = StooqApi::getStock($request->query('q'));

        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error has ocurred.'], 500);
        }

        $stockHelper = new StockRequestHelper($response);
        if (!$stockHelper->isDataValid()) {
            return response()->json(['message' => 'Stock data not found'], 404);
        }

        $stock = $stockHelper->getStockData();

        $user = Auth::user();
        if ($user) {
            Notification::send($user, new StockRequested($stock));
        }

        $stock->save();
        $stock = collect($stock);
        $stock->forget('id');
        $stock->forget('created_at');
        $stock->forget('updated_at');

        Log::info('Stock data requested', ['stock' => $stock]);

        return response()->json($stock, 200);
    }

    public function history(StockStoreRequest $request): StockResource
    {
        $stock = Stock::create($request->validated());

        return new StockResource($stock);
    }

    public function show(Request $request, Stock $stock): StockResource
    {
        return new StockResource($stock);
    }

    public function update(StockUpdateRequest $request, Stock $stock): StockResource
    {
        $stock->update($request->validated());

        return new StockResource($stock);
    }

    public function destroy(Request $request, Stock $stock): Response
    {
        $stock->delete();

        return response()->noContent();
    }
}
