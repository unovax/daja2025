<?php
    namespace App\Helpers;

    use Symfony\Component\HttpFoundation\JsonResponse;

    class ResponseManager {

        public static function success(string $message, array $data = [], int $code = 200): JsonResponse{
            return response()->json([
                'message' => $message,
                'data' => $data,
                'error' => false
            ], $code);
        }

        public static function error(string $message, int $code = 500): JsonResponse{
            return response()->json([
                'message' => $message,
                'error' => true
            ], $code);
        }
    }
