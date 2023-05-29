<?php

namespace App\Http\Controllers;
use App\Record;
use App\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RecordController extends Controller
{
    //
    public function store(Request $request)
    {
        $student = preg_replace('/[^0-9]/', '', $request->input('code'));
        $data_filter = Participant::where('student_id', $student)->where('is_exist', 0)->first();
        $data = Record::where('student_record_id', preg_replace('/[^0-9]/', '', $request->code))->where('event_name', $request->event_name)->exists();

        if($data_filter) {
            return response()->json([
                'status' => 'error',
                'message' => "User is not Active"
            ]);
        }else{
            if($data) {
                return response()->json([
                    'message' => "User has existing saved data"
                ]);
            }else {
                $new = new Record();
                $new->event_name = $request->event_name;
                $new->student_record_id = $student;
                $new->save();
    
                return $new;
            }
        }


        
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
    ->select('event_name', 'created_at', 'updated_at', 'student_record_id')
    ->get();
return $data;

    }


    
}
