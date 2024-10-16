<?php

namespace App\Http\Controllers;

use App\Repositories\ClientRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.clients'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function dashboard()
    {
        return view('admin.dashboard', ['page' => 'dashboard']);
    }

    public function clients(Request $request)
    {
        $paginatedClients = $this->clientRepository->paginatedSearch($request->query());
        $clientNames = $this->clientRepository->findCurrentClientNames()->map(fn ($item) => $item->name)->sort()->values();
        $assignedTokens = $this->clientRepository->findCurrentAssignedTokens()->map(fn ($item) => $item->token_number)->sort()->values();

        return view('admin.clients', [
            'page' => 'clients',
            'pagination' => $paginatedClients->onEachSide(0)->links(),
            'clients' => $paginatedClients->toJson(),
            'filters' => collect($request->query())->toJson(),
            'clientNames' => $clientNames->toJson(),
            'assignedTokens' => $assignedTokens->toJson(),
        ]);
    }

    public function bills()
    {
        return view('admin.bills', ['page' => 'bills']);
    }
}
