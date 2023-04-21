<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    //

    public function self()
    {
        $user = User::find(auth()->user()->id);
        $token = $user->createToken('authToken')->accessToken;
        return response(['user' => $user, 'access_token' => $token]);
    }

    public function index()
    {
        return view('users');
    }
    public function login(Request $request)
    {
        // return $request;
        $login = $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->where('approve', 1)->first();

        // return $user;
        if (!Auth::attempt($login)) {
            return response(['message' => 'login Credentials are incorrect'], 401);
        }
        $token = $user->createToken('authToken')->accessToken;
        return response(['user' => Auth::user(), 'access_token' => $token]);
    }

    public function getAll(){
        $data = User::where('user_type', 0)->get();
        return $data;
    }
    public function addStaff(Request $request) {
        $data = New User;
        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->email = $request->email;
        $data->password = Hash::make($request->input('password'));
        $data->save();
        return $data;
    }

    public function editStaff($id, Request $request){
        $data = User::find($id);
        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->email = $request->email;
        $data->password = Hash::make($request->input('password'));
        $data->save();

        return $data;
    }

    public function approveStaff($id){
        $data = User::where('id', $id)->first();


        if($data->approve == 1){
            $data->update(['approve' => 0]);
            return "Access Grant Deactivated";
        }else{
            $data->update(['approve' => 1]);
            return "Access Grant Activated";

        }
    }

    public function deleteStaff($id){
        $data = User::where('id', $id)->delete();
        return "Deleted";
    }
}
