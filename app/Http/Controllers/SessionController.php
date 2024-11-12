<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{

    public function loginForm()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        if (Auth::attempt(['username' => $request->get('username'), 'password' => $request->get('password')])) {
            return redirect()->route('employeeList');
        }

        return redirect()->route("loginForm")->with("message", [
            'text' => 'Wrong creds',
            'status' => 'danger'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function list()
    {
        $managers = User::whereNot('role', 'admin')->get();

        return view('manager.list', [
            'managers' => $managers
        ]);
    }

    public function update(Request $request) {

        $username = $request->get('username');
            $password = Hash::make($request->get('password'));
            $role = 'manager';

            $data = [
                'username' => $username,
                'role' => $role,
                'password' => $password
            ];

        if ($manager = User::find($request->get('manager_id'))) {
            $manager->update($data);
        } else {
            $newManager = User::create($data);
            $newManager->save();
        }

        return redirect()->route("managerList")->with("message", [
            'text' => 'Manager created',
            'status' => 'success'
        ]);
    }

    public function delete(Request $request)
    {
        $manager = User::find($request->get('manager_delete_id'));
        $manager->delete();

        return redirect()->route("managerList")->with("message", [
            'text' => 'Manager deleted',
            'status' => 'success'
        ]);
    }
}
