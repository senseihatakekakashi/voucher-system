<?php

namespace App\Http\Controllers;

use App\Models\VoucherCode;
use App\Http\Requests\StoreVoucherCodeRequest;
use App\Http\Requests\UpdateVoucherCodeRequest;
use App\Services\DecryptService;
use App\Services\DataProcessorService;
use App\Services\CUDService;
use Illuminate\Http\Request;
use Redirect;

class VoucherCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = request()->get('page', $request->page); // Get the current page from the request, default to 1
        $paginatedRecords = (new DataProcessorService)->paginateVouchers($page);
        return view('pages.voucher-codes.index')->with('voucher_codes', $paginatedRecords);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherCodeRequest $request)
    {
        if((new DataProcessorService)->maxVoucherNumberReached(auth()->user()->id))
            $request->session()->flash('status', 'Error!');
        else {
            $voucher_code = (new DataProcessorService)->generateUniqueVoucherCode();
            $data = [
                'user_id' => auth()->user()->id,
                'voucher_code' => $voucher_code,
            ];
            VoucherCode::create($data);
        }
                
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    public function show(VoucherCode $voucherCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VoucherCode $voucherCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherCodeRequest $request, VoucherCode $voucherCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $voucher_code = VoucherCode::find((new DecryptService)->decrypt($id));
        (new CUDService)->delete($voucher_code);
        return Redirect::back();
    }
}
