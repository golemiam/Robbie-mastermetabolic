<?php

namespace App\Http\Controllers;

use App;
use App\User;
use App\Circuit;
use App\TrainingSession;
use App\ExerciseProgram;
use App\ExerciseProgramTemplate;
use App\Exercise;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as HttpRequest;
use Auth;
use Jenssegers\Agent\Agent;

class ExerciseProgramController extends Controller
{
    public function unique_multidim_array($array, $key)
    {
        $temp_array = [];
        $i = 0;
        $ki = 0;
        $key_array = [];
   
        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$ki] = $val;
                $ki++;
            }
            $i++;
        }
        return $temp_array;
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getExerciseProgram(Request $request, $client, $session = null)
    {
        if (Auth::user()->role == 'trainer' || Auth::user()->id == $client) {
            if ($session == null) {
                $session = TrainingSession::with('ExerciseProgram')->where('owner_id', $client)->where('weight', '!=', '')->orderBy('created_at', 'desc')->first();
                if (!$session) {
                    return redirect('/user/'.$client.'/newsession');
                }
            } else {
                $session = TrainingSession::with('ExerciseProgram')->where('id', $session)->first();
            }
            if (empty($session->exerciseProgram['id']) && Auth::user()->role == 'trainer') {
                return redirect('/user/'.$client.'/copyexerciseprogram/'.$session->id);
            }
            $sessions = TrainingSession::where('owner_id', $client)->get();
            $latestSession = $sessions[count($sessions)-1];
            $sessionkeys = [];
            foreach ($sessions as $s) {
                $sessionkeys[$s->id] = $s->session_number;
            }
            $circuits = Circuit::all();
            $exercises = Exercise::all();
            $categories = $this->unique_multidim_array($exercises, 'category');
            $client = User::find($client);

            $agent = new Agent();

            if ($agent->isMobile()) {
                return view('mobile.exerciseprogram', [
                    'client' => $client,
                    'session' => $session,
                    'sessions' => $sessionkeys,
                    'latestsession' => $latestSession,
                    'exercises' => $exercises,
                    'categories' => $categories,
                    'circuits' => $circuits,
                ]);
            }

            return view('exerciseprogram', [
                'client' => $client,
                'session' => $session,
                'sessions' => $sessionkeys,
                'latestsession' => $latestSession,
                'exercises' => $exercises,
                'categories' => $categories,
                'circuits' => $circuits,
            ]);
        }
    }
    
    public function getExercisePDF(Request $request, $client, $session = null)
    {
        if (Auth::user()->role == 'trainer' || Auth::user()->id == $client) {
            if ($session == null) {
                $session = TrainingSession::with('ExerciseProgram')->where('owner_id', $client)->where('weight', '!=', '')->orderBy('created_at', 'desc')->first();
                if (!$session) {
                    return redirect('/user/'.$client.'/newsession');
                }
            } else {
                $session = TrainingSession::with('ExerciseProgram')->where('id', $session)->first();
            }
            if (empty($session->exerciseProgram['id'])) {
                return redirect('/user/'.$client.'/copyexerciseprogram/'.$session->id);
            }
            $sessions = TrainingSession::where('owner_id', $client)->get();
            $latestSession = $sessions[count($sessions)-1];
            $sessionkeys = [];
            foreach ($sessions as $s) {
                $sessionkeys[$s->id] = $s->session_number;
            }
            $circuits = Circuit::all();
            $exercises = Exercise::all();
            $categories = $this->unique_multidim_array($exercises, 'category');
            $client = User::find($client);
            $data = [
                'client' => $client,
                'session' => $session,
                'sessions' => $sessionkeys,
                'latestsession' => $latestSession,
                'exercises' => $exercises,
                'categories' => $categories,
                'circuits' => $circuits,
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdf.exerciseprogram', $data);
            $pdf->setPaper('letter', 'portrait');
            return $pdf->stream();
        }
    }

    public function editExerciseProgram(Request $request, $client, $session)
    {
        
        $session = TrainingSession::with('ExerciseProgram')->where('id', $session)->first();
        $circuits = Circuit::all();
        $exercises = Exercise::all();
        $templates = ExerciseProgramTemplate::all();
        $categories = $this->unique_multidim_array($exercises, 'category');
        $client = User::find($client);
        return view('editexerciseprogram', [
            'client' => $client,
            'session' => $session,
            'exercises' => $exercises,
            'categories' => $categories,
            'circuits' => $circuits,
            'templates' => $templates,
        ]);
    }
    
    public function copyExerciseProgram(Request $request, $client, $session, $pastSession = null)
    {
        
        if ($pastSession == null) {
            $pastSessions = TrainingSession::with('ExerciseProgram')->where('owner_id', $client)->where('weight', '!=', '')->orderBy('created_at', 'desc')->get();
            if (!isset($pastSessions[1]) || $pastSessions[1]->exerciseProgram()->count() == 0) {
                return redirect('/user/'.$client.'/newexerciseprogram/'.$session);
            }
            $pastSession = $pastSessions[1];
        } else {
            $pastSession = TrainingSession::with('ExerciseProgram')->where('id', $pastSession)->first();
        }
        $sessions = TrainingSession::with('ExerciseProgram')->where('owner_id', $client)->orderBy('created_at', 'asc')->get();

        // Clear date on old session
        unset($pastSession->ExerciseProgram['date']);

        $latestSession = $sessions[count($sessions)-1];
        $templates = ExerciseProgramTemplate::all();
        $sessionkeys = [];
        foreach ($sessions as $s) {
            $sessionkeys[$s->id] = $s->session_number;
        }
        $circuits = Circuit::all();
        $exercises = Exercise::all();
        $categories = $this->unique_multidim_array($exercises, 'category');
        $client = User::find($client);
        return view('copyexerciseprogram', [
            'client' => $client,
            'session' => $pastSession,
            'sessions' => $sessionkeys,
            'exercises' => $exercises,
            'categories' => $categories,
            'newsession' => $session,
            'circuits' => $circuits,
            'templates' => $templates,
        ]);
    }
    
    public function newExerciseProgram(Request $request, $client, $session)
    {
        $session = TrainingSession::find($session);
        $templates = ExerciseProgramTemplate::all();
        $sessions = TrainingSession::where('owner_id', $client)->get();
        $sessionkeys = [];
        foreach ($sessions as $s) {
            $sessionkeys[$s->id] = $s->session_number;
        }
        $client = User::find($client);
        $exercises = Exercise::all();
        $circuits = Circuit::all();
        $categories = $this->unique_multidim_array($exercises, 'category');
        return view('newexerciseprogram', [
            'client' => $client,
            'session' => $session,
            'sessions' => $sessionkeys,
            'exercises' => $exercises,
            'categories' => $categories,
            'circuits' => $circuits,
            'templates' => $templates,
        ]);
    }
    
    public function storeExerciseProgram(HttpRequest $request, $client, $session)
    {

        ExerciseProgram::create([
            'date' => $request->date,
            'circuits' => $request->circuits,
            'program_notes' => $request->program_notes,
            'owner_id' => $request->session_id
        ]);

        return redirect('/user/'.$client.'/exerciseprogram/'.$session);
    }
    
    public function updateExerciseProgram(Request $request, $client, $session)
    {
        $ExerciseProgram = ExerciseProgram::find(Request::get('program_id'));
        $ExerciseProgram->fill(\Request::all());
        $ExerciseProgram->save();
        return redirect('/user/'.$client.'/exerciseprogram/'.$session);
    }
}
