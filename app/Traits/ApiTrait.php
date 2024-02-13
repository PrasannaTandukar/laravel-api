<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiTrait
{
    public function successResponse(array $data, string $message, int $code): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function errorResponse(array $data, string $message, int $code): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
