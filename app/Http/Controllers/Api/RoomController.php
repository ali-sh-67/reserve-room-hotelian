<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reserve;
use App\Models\Room;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *
 */
class RoomController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function showRooms(Request $request)
    {
        try {
            $queryParam = $request->getQueryString();
            if ($request->query('page') || $queryParam == null) $rooms = Room::orderBy('id')->paginate(20)->toArray();
            else $rooms = $this->filterRoom($request);
            return successResponse($rooms, ['اطلاعات با موفقیت ارسال شد.'], 200);

        } catch (Exception $e) {
            return errorResponse(500, (array)$e->getMessage());
        }

    }

    /**
     * @param $request
     * @return array
     */
    protected function filterRoom($request): array
    {
        $rooms = [];
        if ($request->query('type'))
            $rooms = Room::where('type', $request->query('type'))->orderBy('id')->get()->toArray();

        elseif ($request->query('price')) {
            $queryParam = $request->query('price');
            $queryParam = explode('-', $queryParam);
            sort($queryParam);

            $rooms = Room::where('price', '>', $queryParam[0]);

            if (isset($queryParam[1])) $rooms->where('price', '<=', $queryParam[1]);

            return $rooms->orderBy('price')->get()->toArray();

        } elseif ($request->query('name')) {

            return Room::where('name', 'LIKE', '%' . $request->query('name') . '%')->orderBy('id')->get()->toArray();

        } elseif ($request->query('room_no')) {

            return Room::where('room_no', $request->query('room_no'))->orderBy('id')->get()->toArray();

        } elseif ($request->query('breakfast')) {

            if ($request->query('breakfast') == 'false')
                return $rooms = Room::whereNull('breakfast')->orderBy('id')->get()->toArray();

            elseif ($request->query('breakfast') == 'true')
                return $rooms = Room::whereNotNull('breakfast')->orderBy('id')->get()->toArray();

            else {
                $queryParam = $request->query('breakfast');
                $queryParam = explode('-', $queryParam);
                sort($queryParam);

                $rooms = Room::where('breakfast', '>=', $queryParam[0]);
                if (isset($queryParam[1]))
                    $rooms->where('breakfast', '<=', $queryParam[1]);
                return ($rooms->orderBy('breakfast')->get()->toArray());
            }
        } elseif ($request->query('reserved')) {
            $rooms = Room::get();
            $rooms = $rooms->where('reserved', $request->query('reserved'));

            return array_merge_recursive($rooms->toArray());
        }

        return $rooms;
    }
}
