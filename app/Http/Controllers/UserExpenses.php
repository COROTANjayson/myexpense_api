<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserExpenses extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {   
        $user = User::find($id);
        if($user == NULL){
            return User::find($id)->json(array(
                'message' => 'User is not found'
            ), 404);
        }
        //return $user->expenses()->paginate(100);
        return response()->json(( $user->expenses));
        //return response()->json($user->expenses());
        // public function successResponse($data, $code = Response::HTTP_OK){
        //     return response()->json(['data' => $data, 'site'=>1], $code);
        // }
        
    }

}
