<?php

namespace App\Http\Controllers;

use App\Models\Cancle;
use App\Http\Requests\StoreCancleRequest;
use App\Http\Requests\UpdateCancleRequest;

class CancleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCancleRequest $request)
    {
        $data = $request->all();

        $model = Cancle::query()->create($data);
        if ($model) {
            return redirect()->back()->with('success', 'Thêm liên hệ thành công');
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(Cancle $cancle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cancle $cancle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCancleRequest $request, Cancle $cancle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cancle $cancle)
    {
        //
    }
}
