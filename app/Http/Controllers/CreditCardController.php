<?php

namespace App\Http\Controllers;

use App\Models\CreditCard;
use App\Http\Requests\StoreCreditCardRequest;
use App\Http\Requests\UpdateCreditCardRequest;

class CreditCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('credit-card.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('credit-card.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCreditCardRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CreditCard $creditCards)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CreditCard $creditCards)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCreditCardRequest $request, CreditCard $creditCards)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreditCard $creditCards)
    {
        //
    }
}
