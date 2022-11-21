<?php
function successResponse(array $data, array $messages, int $statusCode, array $errors = null): \Illuminate\Http\JsonResponse
{
    $structure = [
        'success' => 1,
        'messages' => $messages,
        'errors' => $errors,
        'data' => $data,
    ];
    return response()->json($structure, $statusCode);
}

function errorResponse(int $statusCode = 404, array $errors = null, array $messages = null, array $data = null): \Illuminate\Http\JsonResponse
{
    if (empty($messages)) {
        switch ($statusCode) {
            case 400 :
                $messages = 'خطا در ارسال اطلاعات';
                break;
            case 401 :
                $messages = 'احراز هویت انجام نشده است.';
                break;
            case 403 :
                $messages = 'مجوز دسترسی به این بخش را ندارید.';
                break;
            case 404 :
                $messages = 'اطلاعات درخواستی موجود نیست';
                break;
            case 422 :
                $messages = 'خطا در اطلاعات ورودی';
                break;
            case 500 :
                $messages = 'خطای پیش بینی نشده';
                break;
        }
    }

    $structure = [
        'success' => 0,
        'messages' => $messages,
        'errors' => $errors,
        'data' => $data,
    ];
    return response()->json($structure, $statusCode);
}
