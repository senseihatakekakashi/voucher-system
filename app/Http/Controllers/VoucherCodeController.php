<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoucherCodeRequest;
use App\Models\VoucherCode;
use App\Services\CUDService;
use App\Services\DataProcessorService;
use App\Services\DecryptService;
use Illuminate\Http\Request;
use Redirect;

class VoucherCodeController extends Controller
{
    protected $cudService;
    protected $dataProcessorService;
    protected $decryptService;

    public function __construct()
    {
        $this->cudService = new CUDService;
        $this->dataProcessorService = new DataProcessorService;
        $this->decryptService = new DecryptService;
    }

    public function index(Request $request)
    {
        $page = request()->get('page', $request->page); // Get the current page from the request, default to 1
        $paginatedRecords = $this->dataProcessorService->paginateVouchers($page);
        return view('pages.voucher-codes.index')->with('voucher_codes', $paginatedRecords);
    }

    public function store(StoreVoucherCodeRequest $request)
    {
        if($this->dataProcessorService->maxVoucherNumberReached(auth()->user()->id))
            $request->session()->flash('status', 'Error!');
        else {
            $voucher_code = $this->dataProcessorService->generateUniqueVoucherCode();
            $data = [
                'user_id' => auth()->user()->id,
                'voucher_code' => $voucher_code,
            ];
            VoucherCode::create($data);
        }                
        return Redirect::back();
    }

    public function destroy($id)
    {
        $voucher_code = VoucherCode::find($this->decryptService->decrypt($id));
        $this->cudService->delete($voucher_code);
        return Redirect::back();
    }
}
