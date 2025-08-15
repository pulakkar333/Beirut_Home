<?php

namespace App\Http\Controllers;

use App\Models\AdminCalendarDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminCalendarController extends Controller
{
    // Return saved dates as JSON
    public function getDates()
    {
        $dates = AdminCalendarDate::all()->map(function ($item) {
            return [
                'title' => 'Selected',
                'start' => $item->date->toDateString(),
                'display' => 'background',
                'backgroundColor' => '#ff0000',
                'borderColor' => '#ff0000',
            ];
        });

        return response()->json($dates);
    }

    // Save posted dates from admin
    public function saveDates(Request $request)
    {
        $dates = $request->input('dates', []);

        $validator = Validator::make($request->all(), [
            'dates' => 'required|array',
            'dates.*' => 'date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid date format!'], 422);
        }

        AdminCalendarDate::truncate();

        $insertData = [];
        foreach ($dates as $date) {
            $insertData[] = ['date' => $date, 'created_at' => now(), 'updated_at' => now()];
        }

        AdminCalendarDate::insert($insertData);

        return response()->json(['message' => 'Dates saved successfully!']);
    }
}
