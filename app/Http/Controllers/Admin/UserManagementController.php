<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerBranch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with(['customer','branch'])
            ->orderBy('name')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.form', [
            'user' => new User(),
            'customers' => Customer::orderBy('name')->get(),
            'branches' => CustomerBranch::with('customer')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','string','min:6'],
            'role' => ['required','string'],
            'customer_id' => ['nullable','exists:customers,id'],
            'customer_access_scope' => ['nullable','in:ho,branch'],
            'customer_branch_id' => ['nullable','exists:customer_branches,id'],
            'is_approved' => ['nullable'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_approved'] = $request->boolean('is_approved');

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success','User created.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', [
            'user' => $user,
            'customers' => Customer::orderBy('name')->get(),
            'branches' => CustomerBranch::with('customer')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:users,email,'.$user->id],
            'password' => ['nullable','string','min:6'],
            'role' => ['required','string'],
            'customer_id' => ['nullable','exists:customers,id'],
            'customer_access_scope' => ['nullable','in:ho,branch'],
            'customer_branch_id' => ['nullable','exists:customer_branches,id'],
            'is_approved' => ['nullable'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_approved'] = $request->boolean('is_approved');

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success','User updated.');
    }

    public function destroy(User $user)
    {
        abort_if(auth()->id() === $user->id, 422, 'Cannot delete your own account.');

        $user->delete();

        return back()->with('success','User deleted.');
    }
}
