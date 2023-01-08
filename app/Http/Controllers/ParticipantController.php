<?php

namespace App\Http\Controllers;

use App\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    //


    public function index()
    {
        return Participant::all();
        // return 'Hi';
    }

    public function new_record(Request $request)
    {
        // $data = new Participant();
        // $requestData = $request->all();
        // $register = $data->create($requestData);

        // return response()->json([
        //     'message' => 'New Participant Added',
        //     'info' => $register
        // ], 201);

        $data = Participant::where('student_id', $request->student_id)->exists();
        if ($data) {
            return response()->json([
                'message' => "User has existing saved data"
            ]);
        } else {
            $input = $request->all();
            $students = Participant::create($input);
            return response()->json([
                'message' => "User Successfully added",
                'data' => $students
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $data = Participant::find($id);
        $requestData = $request->all();
        $data->update($requestData);

        return response()->json([
            'message' => 'Participant Updated',
            'info' => $data
        ], 200);
    }

    public function destroy($id)
    {
        $data = Participant::where('id', $id)->delete();

        return response()->json([
            'message' => 'Participant Removed'
        ], 200);
    }
    public function search(Request $request)
    {
        $data = Participant::query();
        if ($request->input('searchkey') != "") {
            $keyword = $request->input('searchkey');
            $data->where(function ($query) use ($keyword) {
                $query->where('first_name', 'LIKE', "%$keyword%")
                    ->orWhere('last_name', 'LIKE', "%$keyword%");
            });
        }
        return $data->orderBy('last_name', 'desc')->get();
    }

    public function pagination(Request $request)
    {
        $data = Participant::query();
        if ($request->input('keyword') != "") {
            $keyword = $request->input('keyword');
            $data->where(function ($query) use ($keyword) {
                $query->where('last_name', 'LIKE', "%$keyword%");
            });
        }
        return $data->orderBy('last_name', 'asc')->paginate(10);
    }
}
