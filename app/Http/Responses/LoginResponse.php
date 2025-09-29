<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // Kalau user admin → ke /admin/dashboard
        if ($request->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Kalau guru biasa → ke assistances
        return redirect()->route('assistances.index');
    }
}
