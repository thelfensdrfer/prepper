<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Checklist;
use App\Http\Requests\StoreChecklist;

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

    /**
     * @param StoreChecklist $request
     * @return Checklist
     */
    public function store(StoreChecklist $request)
    {
        /**
         * @var $checklist Checklist
         */
        $checklist = Checklist::create($request->validated() + [
            'user_id' => Auth::user()->id,
        ]);

        $checklist->load('items');

        return $checklist;
    }
}
