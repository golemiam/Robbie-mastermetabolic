<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\TrainingSession;
use Mail;
use DateTime;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TrainingSessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getTrainingSession(Request $request, $client)
    {
        $client = User::find($client);
        return view('sessions', [
            'client' => $client,
        ]);
    }

    public function newTrainingSession(Request $request, $client)
    {
        $lastsession = TrainingSession::where('owner_id', $client)->orderBy('id', 'desc')->first();
        $client = User::find($client);
        return view('newsession', [
            'client' => $client,
            'last' => $lastsession,
        ]);
    }
    
    public function editTrainingSession(Request $request, $client, $session)
    {
        $client = User::find($client);
        $session = TrainingSession::find($session);
        return view('newsession', [
            'client' => $client,
            'session' => $session,
        ]);
    }
    
    public function storeTrainingSession(Request $request, $client)
    {
        
        $full_val = [
            'date' => 'required|max:255',
            'time' => 'required|max:255',
            'location' => 'required|max:255',
            'weight' => 'required|max:255',
            'body_fat' => 'required|max:255',
            'owner_id' => 'required|max:255',
        ];
        
        $future_val = [
            'date' => 'required|max:255',
            'time' => 'required|max:255',
            'owner_id' => 'required|max:255',
        ];
        
        $sessions_date = new DateTime($request->date.$request->time);
        $current_date = new DateTime();
        
        if ($sessions_date > $current_date) {
            $val = $future_val;
        } else {
            $val = $full_val;
        }

        
        $this->validate($request, $val);
        
        $last = TrainingSession::where('owner_id', $client)->orderBy('created_at', 'desc')->first();
        if (!empty($last['session_number'])) {
            $number = $last['session_number']+1;
        } else {
            $number = 1;
        }

        if (isset($request->height)) {
            $user = User::find($request->owner_id);
            $user->height = $request->height;
            $user->save();
        }

        TrainingSession::create([
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'weight' => $request->weight,
            'body_fat' => $request->body_fat,
            'skyndex_setting' => $request->skyndex_setting,
            'neck' => $request->neck,
            'arm' => $request->arm,
            'chest' => $request->chest,
            'waist' => $request->waist,
            'hips' => $request->hips,
            'thigh' => $request->thigh,
            'calf' => $request->calf,
            'forearm' => $request->forearm,
            'owner_id' => $request->owner_id,
            'session_number' => $number,
        ]);

        return redirect('/user/'.$client.'/sessions');
    }
    
    public function updateTrainingSession(Request $request, $client)
    {
        $session = TrainingSession::find(Request::get('id'));
        $session->fill(\Request::all());
        $session->save();
        return redirect('/user/'.$client.'/sessions');
    }
    
    public function destroyTrainingSession(Request $request, $client, $session)
    {
        $Session = TrainingSession::find($session);

        $Session->delete();

        return redirect('/user/'.$client.'/sessions');
    }
    
    public function sessionResults(Request $request, $client, $session = null)
    {
        $client = User::find($client);
        if ($session == null) {
            $session = TrainingSession::with('nutritionProgram')->where('owner_id', $client->id)->orderBy('created_at', 'desc')->first();
            if (!$session) {
                return redirect('/user/'.$client.'/newsession');
            }
        } else {
            $session = TrainingSession::with('nutritionProgram')->where('id', $session)->first();
        }
        return view('sessionresults', [
            'client' => $client,
            'session' => $session
        ]);
    }
    
    public function sendSessionResults(Request $request, $client, $session)
    {
        $session = TrainingSession::find($session);
        $client = User::find($client);
        $url = config('APP_URL', 'http://localhost/');
        Mail::send('emails.sessionresults', ['user' => $client, 'url' => $url], function ($m) use ($client) {
            $m->from(env('MAIL_FROM', 'info@fithero.com'), env('MAIL_NAME', 'Master Metabolic'));
            $m->to($client->email, $client->name)->subject('Results From Your Session');
        });
        $request->session()->flash('alert-success', 'Email was sent!');
        return redirect('/users/myclients');
    }
}
