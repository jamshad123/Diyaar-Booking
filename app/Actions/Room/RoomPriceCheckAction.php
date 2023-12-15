<?php

namespace App\Actions\Room;

use App\Models\Room;
use App\Models\Views\OfferView;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class RoomPriceCheckAction
{
    public function execute($selectedRooms, $roomIds, $check_in_date, $check_out_date)
    {
        $Rooms = Room::where('building_id', session('building_id'))->whereIn('id', $roomIds)->get();
        $check_in_date = Carbon::createFromFormat('Y-m-d', $check_in_date);
        $check_out_date = Carbon::createFromFormat('Y-m-d', $check_out_date);
        $dateRange = CarbonPeriod::create($check_in_date, $check_out_date)->toArray();
        $dateList = [];
        foreach($dateRange as $date) {
            $dateList[] = date('Y-m-d', strtotime($date));
        }
        foreach ($Rooms as $room) {
            foreach($dateList as $date) {
                $datePriceList[] = [
                    'date' => $date,
                    'price' => round($room['amount'], 2),
                ];
            }
            $offers = OfferView::where('building_id', session('building_id'))->whereIn('date', $dateList)->active()->pluck('amount', 'date');
            foreach($datePriceList as $key => $date) {
                if(isset($offers[$date['date']])) {
                    $datePriceList[$key]['price'] = round($offers[$date['date']], 2);
                }
            }
            $roomDateList = [];
            $old_date = '';
            foreach($datePriceList as $key => $date) {
                $new_date = $date['date'];
                $single['check_in_date'] = $new_date;
                $single['check_out_date'] = $new_date;
                $single['price'] = $date['price'];
                if(isset($datePriceList[$key - 1])) {
                    if($datePriceList[$key - 1]['price'] == $date['price']) {
                        if(isset($roomDateList[$date['price']])) {
                            $roomDateList[$date['price']][$old_date]['check_out_date'] = $new_date;
                        } else {
                            $roomDateList[$date['price']][$date['date']] = $single;
                            $old_date = $date['date'];
                        }
                    } else {
                        $roomDateList[$date['price']][$date['date']] = $single;
                        $old_date = $date['date'];
                    }
                } else {
                    $roomDateList[$date['price']][$date['date']] = $single;
                        $old_date = $date['date'];
                }
            }
            foreach($roomDateList as $date) {
                foreach($date as $value) {
                    $check_in_date = Carbon::parse($value['check_in_date']);
                    $check_out_date = Carbon::parse($value['check_out_date']);
                    $no_of_days = $check_in_date->diffInDays($check_out_date) + 1;
                    $single = [
                        'room_id' => $room['id'],
                        'room_no' => $room['room_no'],
                        'floor' => $room['floor'],
                        'type' => $room['type'],
                        'status' => $room['status'],
                        'hygiene_status' => $room['hygiene_status'],
                        'check_in_date' => $check_in_date,
                        'check_out_date' => $check_out_date,
                        'no_of_beds' => $room['no_of_beds'],
                        'price' => $value['price'],
                        'no_of_days' => $no_of_days,
                        'total' => $value['price'] * $no_of_days,
                    ];
                    $id = $single['room_id'].'-'.$single['check_in_date'].'-'.$single['check_out_date'];
                    $selectedRooms[$id] = $single;
                }
            }
        }

        return $selectedRooms;
    }
}
