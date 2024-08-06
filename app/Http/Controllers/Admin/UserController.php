<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $user->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $user->paginate(10)->appends(['search' => $request->input('search')]);

        return view('admin.user.index', compact('users'));
    }


    public function updateRole(User $user)
    {

        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'You cannot change your own role.');
        }
        if ($user->role === 'admin') {
            $user->role = 'user';
        } else if ($user->role === 'user') {
            $user->role = 'admin';
        }

        $user->save();
        return redirect()->back()->with('success', 'Role updated successfully.');
    }

    public function updateStatus(User $user)
    {

        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'You cannot change your own satatus.');
        }
        if ($user->status === 1) {
            $user->status = 0;
        } else if ($user->status === 0) {
            $user->status = 1;
        }
        $user->save();
        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            if (Auth::id() == $id) {
                return redirect()->back()->with('error', 'You cannot delete your own.');
            }

            $user = User::findOrFail($id);
            $this->removeImage($user->avatar);
            $user->delete();
            toastr('Delete user Successfuly!', 'success');
            return to_route('admin.user.index');
        } catch (\Exception $e) {
            toastr('Delete user ERROR!', 'danger');
            return to_route('admin.user.index');
        }
    }
}
