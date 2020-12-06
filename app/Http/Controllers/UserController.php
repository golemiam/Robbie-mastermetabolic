<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as HttpRequest;
use App\User;
use Auth;
use App\TrainingSession;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (Auth::user()->role == 'trainer') {
            $users = User::with('client')->orderBy('name', 'ASC')->get();
            return view('users', [
                'users' => $users,
            ]);
        }
        return redirect('/user/'.Auth::user()->id.'/dashboard');
    }

    public function addNew(Request $request)
    {
        if (Auth::user()->role == 'trainer') {
            $users = User::where('role', 'trainer')->get();
            return view('adduser', [
                'users' => $users,
            ]);
        }
    }
    
    public function getAccount($id)
    {
        if (Auth::user()->role == 'trainer' || Auth::user()->id == $id) {
            $user = User::find($id);
            $trainers = User::where('role', 'trainer')->get();
            $newtrainers = ['' => ''];
            foreach ($trainers as $trainer) {
                $newtrainers[$trainer['id']] = $trainer['name'];
            }
            return view('userprofile', [
                'user' => $user,
                'trainers' => $newtrainers,
            ]);
        }
    }
    
    public function myClients(Request $request, $id = null)
    {
        if ($id == null) {
            $user = Auth::user();
        } else {
            $user = User::find($id);
        }
        $users = User::with('sessions')->with('groups')->where('owner_id', $user->id)->where('status', 'active')->orderBy('name', 'ASC')->get();
        $groups = [];
        foreach ($users as $user) {
            foreach ($user->groups as $group) {
                if (!in_array($group->name, $groups)) {
                    array_push($groups, $group->name);
                }
            }
        }
        return view('myclients', [
            'users' => $users,
            'user' => $user,
            'groups' => $groups,
        ]);
    }

    public function myCalendar(Request $request)
    {
        $users = User::with('sessions')->where('owner_id', Auth::user()->id)->get();
        
        return view('calendar', [
            'users' => $users,
        ]);
    }
    
    public function updateAccount(HttpRequest $request, $user)
    {
        $user = User::find($user);
        if (Request::get('password') != '' && Request::get('password') == Request::get('password_confirmation')) {
            $user->fill(['password' => bcrypt(Request::get('password'))]);
        }
        $user->fill(\Request::except('password', 'password_confirmation'));
        $user['has_dashboard'] = $request->input('has_dashboard', 0);
        $user['has_nutrition'] = $request->input('has_nutrition', 0);
        $user['has_exercise'] = $request->input('has_exercise', 0);
        $user['can_edit'] = $request->input('can_edit', 0);
        $user->save();
        $request->session()->flash('alert-success', 'User updated.');
        return redirect('users');
    }
    
    public function destroyAccount(Request $request, $id)
    {
        if (Auth::user()->role == 'trainer') {
            $user = User::find($id);

            $user->delete();

            return redirect('/users');
        }
    }
}
