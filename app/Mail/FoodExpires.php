<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

use App\Food;

class FoodExpires extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Collection $food
     */
    public $food;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $food)
    {
        $food->sortBy(function (Food $food) {
            return $food->expired_after->timestamp;
        });

        $this->food = $food;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.food.expires', [
            'foods' => $this->food,
        ]);
    }
}
