<?php

use Illuminate\Http\JsonResponse;

/**
 * @param array $data
 * @param array $messages
 * @param int $statusCode
 * @param array $errors
 * @return JsonResponse
 * @noinspection PhpFunctionNamingConventionInspection
 */
function successResponse(array $data, array $messages, int $statusCode, array $errors = []): JsonResponse
{
    $structure = [
        'success' => 1,
        'messages' => $messages,
        'errors' => $errors,
        'data' => $data,
    ];
    return response()->json($structure, $statusCode);
}

/**
 * @param int $statusCode
 * @param array $errors
 * @param array $messages
 * @param array $data
 * @return JsonResponse
 * @noinspection PhpFunctionNamingConventionInspection
 */
function errorResponse(int $statusCode = 404, array $errors = [], array $messages = [], array $data = []): JsonResponse
{
    if (empty($messages)) {
        $messages = match ($statusCode) {
            400 => 'خطا در ارسال اطلاعات',
            401 => 'احراز هویت انجام نشده است.',
            403 => 'مجوز دسترسی به این بخش را ندارید.',
            404 => 'اطلاعات درخواستی موجود نیست',
            422 => 'خطا در اطلاعات ورودی',
            500 => 'خطای پیش بینی نشده',
        };
    }

    $structure = [
        'success' => 0,
        'messages' => $messages,
        'errors' => $errors,
        'data' => $data,
    ];
    return response()->json($structure, $statusCode);
}
