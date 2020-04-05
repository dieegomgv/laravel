<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
       $users = User::select('id','name','email','telefono')
       ->get();
        //

        return response()->json($users,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {


        $data = $request->all();
        Log::info(json_encode($data));

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        return response()->json(['result'=>'ok'],200);

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $campos = [
            'id',
            'name',
            'email',
            'telefono'
        ];
        $user = User::select($campos)
            ->where('id', $id)
            ->first();

        $user = User::select($campos)
            ->where('id', $id)
            ->firstOrFail();

        $user = User::select($campos)
            ->find($id);

        $user = User::select($campos)
            ->findOrFail($id);

        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::findOrFail($id);
        $data = $request->except('password');
        Log::info('ENTRA EDIT'.json_encode($data));
        $user-> update($data);

        return response()->json(['result', 'ok'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['result' =>'ok'], 200);
        //
    }
}
