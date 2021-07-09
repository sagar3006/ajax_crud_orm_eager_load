<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\User_detail;

class UsersController extends Controller
{
    // LOAD BLANK CONTENT TO SET UP MASTER LAYOUT
    public function master()
    {
        return view('pages/blank');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages/users', [
            'count' => 1,
            'users' => User::with('detail')
                ->orderBy('id', 'desc')
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages/users_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // PERFORM NECESSARY FORM VALIDATION
        $user       = new User;
        $validator  = Validator::make($request->all(), $user->rules_create);

        if($validator->fails()) {
            // GET PREPARED ERROR MESSAGES FOR VIEW
            $errors = $this->prepare_validation_errors($validator->errors()->all());

            return response()->json([
                'status' => 'false',
                'errors' => $errors
            ]);
        }

        // STORE DATA IN User MODEL
        $input  = $request->all();
        $user   = User::create($input);

        // STORE DATA IN User_detail MODEL
        $input['user_id'] = $user->id;
        User_detail::create($input);

        $request->session()->flash('success_message', 'User created successfully.');

        return response()->json([
            'status'        => 'true',
            'redirect_url'  => url('users')
        ]);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages/users_edit', [
            'user' => User::where('id', $id)->with('detail')->first()
        ]);
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
        // PERFORM NECESSARY FORM VALIDATION
        $user       = new User;
        $validator  = Validator::make($request->all(), $user->rules_update($id));

        if($validator->fails()) {
            // GET PREPARED ERROR MESSAGES FOR VIEW
            $errors = $this->prepare_validation_errors($validator->errors()->all());

            return response()->json([
                'status' => 'false',
                'errors' => $errors
            ]);
        }

        // FETCH DATA BY GIVEN $id AND EAGER LOAD ASSOCIATED User AND User_detail MODELS
        $user = User::where('id', $id)->with('detail')->first();

        // UPDATE DATA IN User MODEL
        $input = $request->all();
        $user->update($input);

        // UPDATE DATA IN User_detail MODEL
        $user->detail->update($input);

        $request->session()->flash('success_message', 'User updated successfully.');

        return response()->json([
            'status'        => 'true',
            'redirect_url'  => url('users')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        User::destroy($id);

        $request->session()->flash('success_message', 'User deleted successfully.');

        return response()->json([
            'status'        => 'true',
            'redirect_url'  => url('users')
        ]);
    }

    // VERIFY GIVEN PHONE INPUT
    public function verify(Request $request)
    {
        // VERIFY FOR INVALID CHARACTERS
        $validity   = 1;
        $numbers    = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $inputs     = str_split($request->phone);

        foreach($inputs as $input)
            if(!in_array($input, $numbers)) {
                $validity = 0;
                break;
            }

        // IF INPUT IS VALID, CHECK FOR DUPLICATES IN User MODEL
        if($validity) {
            if($request->id)
                $number_of_phones = User::where([
                    ['id', '!=', $request->id],
                    ['phone', '=', $request->phone]
                ])->count();
            else
                $number_of_phones = User::where('phone', $request->phone)->count();

            if($number_of_phones > 0)
                $html = '<p style="color: red;">This phone number already exists!</p>';
            else
                $html = '<p style="color: green;">This phone number is valid.</p>';
        } else
            $html = '<p style="color: red;">Please don\'t include invalid characters!</p>';

        echo $html;
    }
}