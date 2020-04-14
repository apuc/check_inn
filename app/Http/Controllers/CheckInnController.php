<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckInnFormRequest;
use App\Services\CheckInnService;

class CheckInnController extends Controller
{
    /**
     * @var CheckInnService
     */
    protected $service;

    /**
     * CheckInnController constructor.
     * @param CheckInnService $service
     */
    public function __construct(CheckInnService $service)
    {
        $this->service = $service;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $checkedInn = $this->service->index();
        return view('check.index', compact('checkedInn'));
    }

    /**
     * @param CheckInnFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function check(CheckInnFormRequest $request)
    {
        $checkedInn = $this->service->checkInn($request->inn);
        session()->flash('checkedInnId', $checkedInn->id);
        return back();
    }
}
