<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('page.login');
    }

    protected function authenticated(Request $request, $user)
    {
        if (!empty(auth()->user()->company_id)) {
            session(['company_id' => auth()->user()->company_id]);
        } else {
            $firstCompanies = auth()->user()->companies()->first();
            if (!empty($firstCompanies)) {
                session(['company_id' => $firstCompanies->id]);
            }
        }

        $intendedUrl = session()->pull('url.intended', null);

        if (!empty($intendedUrl)) {
            return redirect($intendedUrl);
        }

        if (!empty(session('company_id'))) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        $locale = session('locale');
        session(['last_visited_url' => url()->current()]);

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        session(['locale' => $locale]);

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
