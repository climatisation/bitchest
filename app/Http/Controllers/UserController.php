<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CryptoList;
use App\User;
use App\Transaction;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->cryptos = CryptoList::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        // $userTransactionData = [];

        // foreach ($users as $user) {
        //     $transactions = Transaction::where('user_id', $user->id)->get();
        //     $userTransactionData[$user->name] = [];
        //     foreach ($transactions as $transaction) {
        //         $userTransactionData[$user->name][$transaction->crypto][] = $transaction->crypto_quantity;
        //     }
        // }

        return view('admin', ['crypto' => $this->cryptos, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // switch ($request->input('action')) {
        //         case 'save':
        //             // Save model
        //             break;

        //         case 'preview':
        //             // Preview model
        //             break;

        //         case 'advanced_edit':
        //             // Redirect to advanced edit
        //             break;
        //     }
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
        $userData = User::find($id);
        return view('user', ['userData' => $userData]);
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

        $validatedData = $request->validate([
            'name' => 'bail|required|max:100|unique:users,name,' . $id,
            'email' => 'bail|required|email|max:255|unique:users,email,' . $id,
            'isAdmin' => 'bail|required|boolean',
        ]);

        $userData = User::find($id);
        $userData->update($request->only(['name', 'email', 'isAdmin']));
        return back()->with('status', 'User has been modified.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }

}
