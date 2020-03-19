<?php

namespace App\Http\Controllers;

use App\Checklist;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $checklists = Checklist::where('user_id', Auth::user()->id)
            ->with('items')
            ->get();

        return view('checklist.index', [
            'checklists' => $checklists,
        ]);
    }
}
