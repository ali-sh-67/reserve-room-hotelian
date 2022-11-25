<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\ReserveRequest;
use App\Models\Reserve;
use App\Models\Room;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *
 */
class ReserveController extends Controller
{
    /**
     * @param ReserveRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function reserve(ReserveRequest $request, $id): JsonResponse
    {
        try {
            $room = Room::find($id);
            if (!$room) throw new Exception('اتاقی با این شناسه یافت نشد.');
            if ($room->reserved == 'true') return errorResponse(404, [], ['اتاق مورد نظر قبلا رزرو شده است و فعلا قادر به رزرو این اتاق نیستید.']);

            $roomBreakfast = null;
            if ($request->breakfast == 'true') {
                $roomBreakfast = $room->type->breakfast();
                if ($roomBreakfast == null)
                    return errorResponse(400, [], ['اتاق مورد نظر فاقد صبحانه میباشد.']);
            }

            $reserve = Reserve::create([
                'user_id' => $request->user()->id,
                'room_id' => $room->id,
                'price' => $room->type->price(),
                'breakfast' => $roomBreakfast,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
            ]);

            return successResponse($reserve->toArray(), ['اتاق با موفقیت رزرو شد.'], 200);

        } catch (Exception $e) {
            return errorResponse($e->getCode(), (array)$e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function history(Request $request): JsonResponse
    {
        try {
            $rooms=[];
            if ($request->getQueryString() == null) {

                $rooms = Room::has('reluser')->get()->append(['fromDate', 'toDate', 'price'])->toArray();

            } elseif ($request->query('myReserve') == 'true') {

                $rooms = Room::whereHas('reluser', function ($query) use ($request) {
                    return $query->where('user_id', $request->user()->id);
                })->get()->append(['fromDate', 'toDate', 'price'])->toArray();

            } elseif ($request->query('type')) {

                $rooms = Room::where('type', 'like', '%' . $request->query('type') . '%')->has('reluser')->get()->append(['fromDate', 'toDate', 'price'])->toArray();
            }

            return successResponse($rooms, ['اطلاعات با موفقیت ارسال شد.'], 200);

        } catch (Exception $e) {
            return errorResponse($e->getCode(), (array)$e->getMessage());
        }
    }
}
