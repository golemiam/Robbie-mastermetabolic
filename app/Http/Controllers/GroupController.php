<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as HttpRequest;
use App\User;
use App\Group;
use Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (Auth::user()->role == 'trainer') {
            $groups = Group::all();
            $users = User::all();
            return view('settings/groups', [
                'groups' => $groups,
            ]);
        }
        return redirect('/user/'.Auth::user()->id.'/dashboard');
    }
    
    public function addGroup(Request $request)
    {
        if (Auth::user()->role == 'trainer') {
            $users = User::all();
            return view('settings/addgroup', [
                'users' => $users,
            ]);
        }
        return redirect('/user/'.Auth::user()->id.'/dashboard');
    }
    
    public function editGroup(Request $request, $id)
    {
        if (Auth::user()->role == 'trainer') {
            $users = User::all();
            $group = Group::find($id);
            $exclude = [];
            foreach ($group->users as $u) {
                $bi = 0;
                foreach ($users as $user) {
                    if ($u['id'] == $user['id']) {
                        array_push($exclude, $bi);
                        break;
                    }
                    $bi++;
                }
            }
            return view('settings/addgroup', [
                'users' => $users,
                'group' => $group,
                'exclude' => $exclude,
            ]);
        }
        return redirect('/user/'.Auth::user()->id.'/dashboard');
    }
    
    public function storeGroup(HttpRequest $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'desc' => 'required',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'desc' => $request->desc,
        ]);
        
        if (count($request->user) <= 0) {
            $request->session()->flash('alert-danger', 'Group must have members');
            return redirect('settings/addgroup');
        }
        
        foreach ($request->user as $c) {
            $group->users()->attach($c);
        }

        return redirect('settings/groups');
    }
    
    public function updateGroup(Request $request, $id)
    {
        $group = Group::find($id);
        $group->fill(\Request::all());
        $group->save();
      
        if (count(Request::get('user')) <= 0) {
            $request->session()->flash('alert-danger', 'Group must have members');
            return redirect('settings/addgroup');
        }

        $group->users()->detach();
        foreach (Request::get('user') as $c) {
            $group->users()->attach($c);
        }
      
        $request->session()->flash('alert-success', 'Group was updated.');
        return redirect('settings/groups');
    }

    public function destroyGroup(Request $request, $id)
    {
        $group = Group::find($id);

        $group->delete();

        $request->session()->flash('alert-success', 'Group was deleted.');
        return redirect('settings/groups');
    }
}
