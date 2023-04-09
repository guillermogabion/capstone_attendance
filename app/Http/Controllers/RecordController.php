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
        $data->student_id = $request->code;
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
        // return Record::participated()->get();

        $data = Record::query();
        $xx = $data->with('participated', 'event')->get();
        return $xx;
    }
}
