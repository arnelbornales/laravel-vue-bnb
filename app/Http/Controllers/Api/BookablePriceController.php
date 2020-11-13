<?php

namespace App\Http\Controllers\Api;

use App\Models\Bookable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookablePriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        $bookable = Bookable::findOrFail($id);
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from'
        ]);

        // $days = (new Carbon($data['from']))->diffInDays(new Carbon($data['to']));
        // if ($days == 0) {
        //     $days += 1;
        // }

        // $price = $days * $bookable->price;
        // return response()->json([
        //     'data' => [
        //         'total' => $price,
        //         'breakdown' => [
        //             $bookable->price => $days
        //         ]
        //     ]
        // ]);

        return response()->json([
            'data' => $bookable->priceFor($data['from'],$data['to'])
        ]);
    }
}
