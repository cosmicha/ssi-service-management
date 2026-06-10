<?php

namespace App\Http\Controllers;

use App\Models\CustomerBranch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerPortalAccountController extends Controller
{
    private function admin()
    {
        abort_unless(auth()->check(), 403);
        abort_unless(auth()->user()->role === 'customer_admin', 403);

        return auth()->user();
    }

    private function branches()
    {
        $admin = $this->admin();

        return CustomerBranch::where('customer_id', $admin->customer_id)
            ->orderBy('name')
            ->get();
    }

    public function index()
    {
        $admin = $this->admin();

        $accounts = User::with('customerBranch')
            ->where('customer_id', $admin->customer_id)
            ->whereIn('role', ['customer_admin', 'customer'])
            ->latest()
            ->paginate(15);

        return view('customer-portal.accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('customer-portal.accounts.create', [
            'branches' => $this->branches(),
        ]);
    }

    public function store(Request $request)
    {
        $admin = $this->admin();

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:6'],
            'role' => ['required','in:customer_admin,customer'],
            'customer_access_scope' => ['required','in:ho,branch'],
            'customer_branch_id' => ['nullable','exists:customer_branches,id'],
        ]);

        if ($data['customer_access_scope'] === 'branch' && empty($data['customer_branch_id'])) {
            return back()->withErrors([
                'customer_branch_id' => 'Branch is required for branch access.'
            ])->withInput();
        }

        if (!empty($data['customer_branch_id'])) {
            $branch = CustomerBranch::findOrFail($data['customer_branch_id']);
            abort_unless($branch->customer_id == $admin->customer_id, 403);
        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'customer_id' => $admin->customer_id,
            'customer_access_scope' => $data['customer_access_scope'],
            'customer_branch_id' => $data['customer_access_scope'] === 'branch' ? $data['customer_branch_id'] : null,
        ]);

        return redirect()->route('customer.portal.accounts.index')->with('success', 'Account created.');
    }

    public function edit(User $account)
    {
        $admin = $this->admin();

        abort_unless($account->customer_id == $admin->customer_id, 403);

        return view('customer-portal.accounts.edit', [
            'account' => $account,
            'branches' => $this->branches(),
        ]);
    }

    public function update(Request $request, User $account)
    {
        $admin = $this->admin();

        abort_unless($account->customer_id == $admin->customer_id, 403);

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,' . $account->id],
            'password' => ['nullable','string','min:6'],
            'role' => ['required','in:customer_admin,customer'],
            'customer_access_scope' => ['required','in:ho,branch'],
            'customer_branch_id' => ['nullable','exists:customer_branches,id'],
        ]);

        if ($data['customer_access_scope'] === 'branch' && empty($data['customer_branch_id'])) {
            return back()->withErrors([
                'customer_branch_id' => 'Branch is required for branch access.'
            ])->withInput();
        }

        if (!empty($data['customer_branch_id'])) {
            $branch = CustomerBranch::findOrFail($data['customer_branch_id']);
            abort_unless($branch->customer_id == $admin->customer_id, 403);
        }

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'customer_access_scope' => $data['customer_access_scope'],
            'customer_branch_id' => $data['customer_access_scope'] === 'branch' ? $data['customer_branch_id'] : null,
        ];

        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $account->update($payload);

        return redirect()->route('customer.portal.accounts.index')->with('success', 'Account updated.');
    }

    public function destroy(User $account)
    {
        $admin = $this->admin();

        abort_unless($account->customer_id == $admin->customer_id, 403);
        abort_if($account->id === $admin->id, 403);

        $account->delete();

        return redirect()->route('customer.portal.accounts.index')->with('success', 'Account deleted.');
    }
}
