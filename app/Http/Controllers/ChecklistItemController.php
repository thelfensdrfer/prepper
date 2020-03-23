<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\ChecklistItem;
use App\Http\Requests\StoreChecklistItem;
use App\Http\Requests\UpdateChecklistItem;

class ChecklistItemController extends Controller
{
    /**
     * @param StoreChecklistItem $request
     * @param Checklist $checklist
     * @return ChecklistItem
     */
    public function store(StoreChecklistItem $request, Checklist $checklist)
    {
        $item = new ChecklistItem;
        $item->fill($request->validated());
        $item->checklist_id = $checklist->id;

        $item->save();

        return $item;
    }

    /**
     * @param UpdateChecklistItem $request
     * @param ChecklistItem $item
     * @return ChecklistItem
     */
    public function update(UpdateChecklistItem $request, ChecklistItem $item)
    {
        $item->fill($request->validated())
            ->save();

        return $item;
    }

    /**
     * @param ChecklistItem $item
     * @return void
     * @throws \Exception
     */
    public function delete(ChecklistItem $item)
    {
        $item->delete();
    }
}
