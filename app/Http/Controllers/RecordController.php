<?php

namespace App\Http\Controllers;

use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    //
    public function store(Request $request)
    {
        $data = new Record();
        $data->event_name = $request->event_name;
        $data->student_record_id = preg_replace('/[^0-9]/', '', $request->code);
        $data->save();
        // $requestData = $request->all();
        // $data->create($requestData);

        // return response()->json([
        //     'message' => 'Recorded',
        //     'data' => $data
        // ], 201);
    }

    public function destroy($id)
    {
        $data = Record::where('id', $id)->delete();
        return response()->json([
            'message' => 'Removed'
        ]);
    }

    public function pagination(Request $request)
    {
        $data = Record::query();
        if ($request->input('keyword') != "") {
            $keyword = $request->input('keyword');
            $data->where(function ($query) use ($keyword) {
                $query->with('participated', 'event')->where('participant_id', 'LIKE', "%$keyword%");
            });
        }
        return $data->orderBy('participant_id', 'asc')->paginate(10);
    }

    public function get()
    {
       $data = Record::with(['student' => function ($query) {
        $query->select('student_id', 'first_name', 'last_name');
    }])
    ->select('event_name', 'created_at', 'student_record_id')
    ->get();
return $data;

    }


    
}
