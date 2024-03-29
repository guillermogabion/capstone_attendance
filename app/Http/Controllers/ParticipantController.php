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
        $student = preg_replace('/[^0-9]/', '', $request->input('student_id'));

        $data = Participant::where('student_id', $student)->exists();
        if ($data) {
            return response()->json([
                'message' => "User has existing saved data"
            ]);
        } else {

            // $studentID = preg_replace('/[^0-9]/', '', $request->input('student_id'));
            // $input = $request->all();
            // $students = Participant::create($input);
            // return response()->json([
            //     'message' => "User Successfully added",
            //     'data' => $students
            // ]);

            $participant = Participant::create([
                'student_id' => $student,
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'contact' => $request->input('contact'),
                'age' => $request->input('age'),
                'address' => $request->input('address'),
                // Add other input fields here
            ]);
            return response()->json([
                'message' => 'User successfully added',
                'data' => $participant
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

    public function update_status($id)
    {
        $data = Participant::findOrFail($id);

    if ($data->is_exist == 1) {
        $data->update(['is_exist' => 0]);
        return "Student Status OFF";
    } else {
        $data->update(['is_exist' => 1]);
        return "Student Status ON";
    }

    
    }
}
