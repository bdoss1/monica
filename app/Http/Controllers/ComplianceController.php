<?php

namespace App\Http\Controllers;

use App\Services\User\AcceptPolicy;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComplianceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return View|Factory
     */
    public function index(Request $request)
    {
        return view('compliance.index');
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        app(AcceptPolicy::class)->execute([
            'account_id' => auth()->user()->account->id,
            'user_id' => auth()->user()->id,
            'ip_address' => \Request::ip(),
        ]);

        return redirect()->route('dashboard.index');
    }
}
