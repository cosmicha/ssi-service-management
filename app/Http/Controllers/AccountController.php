<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $users = User::with('customer')->latest()->paginate(15);

        return view('accounts.index', compact('users'));
    }

    public function create()
    {
        return view('accounts.create', [
            'customers' => Customer::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:6'],
            'role' => ['required','in:admin,engineer,customer'],
            'customer_id' => ['nullable','exists:customers,id'],
        ]);

        if ($data['role'] === 'customer' && empty($data['customer_id'])) {
            return back()->withErrors([
                'customer_id' => 'Customer account must be linked to a company.'
            ])->withInput();
        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'customer_id' => $data['customer_id'] ?? null,
        ]);

        return redirect()->route('accounts.index')->with('success', 'Account created.');
    }

    public function edit(User $account)
    {
        return view('accounts.edit', [
            'user' => $account,
            'customers' => Customer::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $account)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,' . $account->id],
            'password' => ['nullable','string','min:6'],
            'role' => ['required','in:admin,engineer,customer'],
            'customer_id' => ['nullable','exists:customers,id'],
        ]);

        if ($data['role'] === 'customer' && empty($data['customer_id'])) {
            return back()->withErrors([
                'customer_id' => 'Customer account must be linked to a company.'
            ])->withInput();
        }

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'customer_id' => $data['role'] === 'customer' ? ($data['customer_id'] ?? null) : null,
        ];

        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $account->update($payload);

        return redirect()->route('accounts.index')->with('success', 'Account updated.');
    }

    public function destroy(User $account)
    {
        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Account deleted.');
    }
}
