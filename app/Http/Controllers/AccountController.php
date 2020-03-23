<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountReminder;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\UpdateAccountInformation;
use App\Http\Requests\UpdateAccountPassword;
use App\User;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('account.show', [
            'timezones' => timezone_identifiers_list(),
        ]);
    }

    /**
     * @param UpdateAccountInformation $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAccountInformation $request)
    {
        /**
         * @var $user User
         */
        $user = Auth::user();
        $user->fill($request->validated());
        $user->save();

        flash()->success(__('Your account information was successfully updated.'));

        return redirect()->route('account.show');
    }

    /**
     * @param UpdateAccountPassword $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(UpdateAccountPassword $request)
    {
        /**
         * @var $user User
         */
        $user = Auth::user();
        $user->password = Hash::make($request->validated()['password']);
        $user->save();

        flash()->success(__('Your password was successfully updated.'));

        return redirect()->route('account.show');
    }

    /**
     * @param UpdateAccountReminder $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reminder(UpdateAccountReminder $request)
    {
        /**
         * @var $user User
         */
        $user = Auth::user();
        $user->reminder_expired_food = (bool) $request->get('reminder_expired_food');
        $user->save();

        flash()->success(__('Your reminder were successfully updated.'));

        return redirect()->route('account.show');
    }
}
