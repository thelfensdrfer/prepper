<?php

use Illuminate\Database\Seeder;

use App\Checklist;
use App\ChecklistItem;

class ChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Checklist::class, 20)->create([
            'user_id' => 1,
        ])->each(function (Checklist $checklist) {
            $checklist->items()->createMany(factory(ChecklistItem::class, rand(5, 15))->make()->toArray());
        });
    }
}
