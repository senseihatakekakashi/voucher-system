<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoucherCodeRequest;
use App\Models\VoucherCode;
use App\Services\CUDService;
use App\Services\DataProcessorService;
use App\Services\DecryptService;
use Illuminate\Http\Request;
use Redirect;

/**
 * Class VoucherCodeController
 *
 * Controller for managing voucher codes.
 *
 * @package App\Http\Controllers
 */
class VoucherCodeController extends Controller
{
    /**
     * @var CUDService $CUDService
     */
    protected $CUDService;

    /**
     * @var DataProcessorService $dataProcessorService
     */
    protected $dataProcessorService;

    /**
     * @var DecryptService $decryptService
     */
    protected $decryptService;

    /**
     * VoucherCodeController constructor.
     */
    public function __construct()
    {
        $this->CUDService = new CUDService;
        $this->dataProcessorService = new DataProcessorService;
        $this->decryptService = new DecryptService;
    }

    /**
     * Display a paginated list of voucher codes.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $page = request()->get('page', $request->page); // Get the current page from the request, default to 1
        $paginatedRecords = $this->dataProcessorService->paginateVouchers($page);
        return view('pages.voucher-codes.index')->with('voucher_codes', $paginatedRecords);
    }

    /**
     * Store a newly created voucher code.
     *
     * @param StoreVoucherCodeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVoucherCodeRequest $request)
    {
        if ($this->dataProcessorService->maxVoucherNumberReached(auth()->user()->id))
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

    /**
     * Remove the specified voucher code from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $voucher_code = VoucherCode::find($this->decryptService->decrypt($id));
        $this->authorize('delete', $voucher_code);
        $this->CUDService->delete($voucher_code);
        return Redirect::back();
    }
}