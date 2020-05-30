<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail, HasLocalePreference
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * TODO: Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale()
    {
        return 'en';
    }

    /**
     * @return Collection
     */
    public function foodAboutToExpire()
    {
        return Food::where('user_id', $this->id)
            ->where('expired_after', '<=', DB::raw('DATE_ADD(NOW(), INTERVAL 1 MONTH)'))
            ->get();
    }
}
