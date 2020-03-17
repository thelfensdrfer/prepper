<?php

namespace App\Http\Controllers;

use App\FoodGroup;

class OverviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('overview', [
            'foodGroups' => FoodGroup::
                with([
                    'foods',
                    'foodPlan',
                ])
                ->get(),
        ]);
    }
}
