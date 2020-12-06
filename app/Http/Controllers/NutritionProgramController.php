<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as HttpRequest;
use App;
use App\User;
use App\Meal;
use App\TrainingSession;
use App\NutritionProgram;
use App\NutritionProgramTemplate;
use App\Nutritions;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Jenssegers\Agent\Agent;

class NutritionProgramController extends Controller
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
    
    public function getNutritionProgram(Request $request, $client, $session = null)
    {
        if (Auth::user()->role == 'trainer' || Auth::user()->id == $client) {
            if ($session == null) {
                $session = TrainingSession::with('nutritionProgram')->where('owner_id', $client)->where('weight', '!=', '')->orderBy('created_at', 'desc')->first();
                if (!$session) {
                    return redirect('/user/'.$client.'/newsession');
                }
            } else {
                $session = TrainingSession::with('nutritionProgram')->where('id', $session)->first();
            }
            $sessions = TrainingSession::with('nutritionProgram')->where('owner_id', $client)->orderBy('created_at', 'asc')->get();
            $latestSession = $sessions[count($sessions)-1];
            if (empty($session->nutritionProgram['id']) && Auth::user()->role == 'trainer') {
                //return redirect('/user/'.$client.'/newnutritionprogram/'.$session->id);
                return redirect('/user/'.$client.'/copynutritionprogram/'.$session->id);
            }
            $sessionkeys = [];
            foreach ($sessions as $s) {
                $sessionkeys[$s->id] = $s->session_number;
            }
            $meals = Meal::all();
            $nutritions = Nutritions::all();
            $categories = $this->unique_multidim_array($nutritions, 'category');
            $client = User::find($client);

            $agent = new Agent();

            if ($agent->isMobile()) {
                return view('mobile.nutritionprogram', [
                    'client' => $client,
                    'session' => $session,
                    'sessions' => $sessionkeys,
                    'latestsession' => $latestSession,
                    'nutritions' => $nutritions,
                    'categories' => $categories,
                    'meals' => $meals,
                ]);
            }

            return view('nutritionprogram', [
                'client' => $client,
                'session' => $session,
                'sessions' => $sessionkeys,
                'latestsession' => $latestSession,
                'nutritions' => $nutritions,
                'categories' => $categories,
                'meals' => $meals,
            ]);
        }
    }
    
    public function getNutritionPDF(Request $request, $client, $session = null)
    {
        if (Auth::user()->role == 'trainer' || Auth::user()->id == $client) {
            if ($session == null) {
                $session = TrainingSession::with('nutritionProgram')->where('owner_id', $client)->where('weight', '!=', '')->orderBy('created_at', 'desc')->first();
                if (!$session) {
                    return redirect('/user/'.$client.'/newsession');
                }
            } else {
                $session = TrainingSession::with('nutritionProgram')->where('id', $session)->first();
            }
            $sessions = TrainingSession::with('nutritionProgram')->where('owner_id', $client)->orderBy('created_at', 'asc')->get();
            $latestSession = $sessions[count($sessions)-1];
            if (empty($session->nutritionProgram['id'])) {
                //return redirect('/user/'.$client.'/newnutritionprogram/'.$session->id);
                return redirect('/user/'.$client.'/copynutritionprogram/'.$session->id);
            }
            $sessionkeys = [];
            foreach ($sessions as $s) {
                $sessionkeys[$s->id] = $s->session_number;
            }
            $meals = Meal::all();
            $nutritions = Nutritions::all();
            $categories = $this->unique_multidim_array($nutritions, 'category');
            $client = User::find($client);
            $data = [
                'client' => $client,
                'session' => $session,
                'sessions' => $sessionkeys,
                'latestsession' => $latestSession,
                'nutritions' => $nutritions,
                'categories' => $categories,
                'meals' => $meals,
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdf.nutritionprogram', $data);
            $pdf->setPaper('letter', 'portrait');
            return $pdf->stream();
        }
    }

    public function getShoppingList(Request $request, $client, $session = null)
    {
        if (Auth::user()->role == 'trainer' || Auth::user()->id == $client) {
            if ($session == null) {
                $session = TrainingSession::with('nutritionProgram')->where('owner_id', $client)->where('weight', '!=', '')->orderBy('created_at', 'desc')->first();
                if (!$session) {
                    return redirect('/user/'.$client.'/newsession');
                }
            } else {
                $session = TrainingSession::with('nutritionProgram')->where('id', $session)->first();
            }
            $sessions = TrainingSession::with('nutritionProgram')->where('owner_id', $client)->orderBy('created_at', 'asc')->get();
            $latestSession = $sessions[count($sessions)-1];
            if (empty($session->nutritionProgram['id'])) {
                //return redirect('/user/'.$client.'/newnutritionprogram/'.$session->id);
                return redirect('/user/'.$client.'/copynutritionprogram/'.$session->id);
            }
            $sessionkeys = [];
            foreach ($sessions as $s) {
                $sessionkeys[$s->id] = $s->session_number;
            }
            $meals = Meal::all();
            $nutritions = Nutritions::all();
            $categories = $this->unique_multidim_array($nutritions, 'category');
            $client = User::find($client);
            $data = [
                'client' => $client,
                'session' => $session,
                'sessions' => $sessionkeys,
                'latestsession' => $latestSession,
                'nutritions' => $nutritions,
                'categories' => $categories,
                'meals' => $meals,
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('shoppinglist', $data);
            $pdf->setPaper('letter', 'portrait');
            return $pdf->stream();
        }
    }

    public function editNutritionProgram(Request $request, $client, $session)
    {
        
        $session = TrainingSession::with('nutritionProgram')->where('id', $session)->first();
        $meals = Meal::all();
        $templates = NutritionProgramTemplate::all();
        $nutritions = Nutritions::all();
        $categories = $this->unique_multidim_array($nutritions, 'category');
        $client = User::find($client);
        return view('editnutritionprogram', [
            'client' => $client,
            'session' => $session,
            'nutritions' => $nutritions,
            'categories' => $categories,
            'meals' => $meals,
            'templates' => $templates,
        ]);
    }
    
    public function copyNutritionProgram(Request $request, $client, $session, $pastSession = null)
    {
    
        if ($pastSession == null) {
            $pastSessions = TrainingSession::with('nutritionProgram')->where('owner_id', $client)->where('weight', '!=', '')->orderBy('created_at', 'desc')->get();
            if (!isset($pastSessions[1]) || $pastSessions[1]->nutritionProgram()->count() == 0) {
                return redirect('/user/'.$client.'/newnutritionprogram/'.$session);
            }
            $pastSession = $pastSessions[1];
        } else {
            $pastSession = TrainingSession::with('nutritionProgram')->where('id', $pastSession)->first();
        }

        // Clear date on old session
        unset($pastSession->NutritionProgram['date']);

        $sessions = TrainingSession::with('nutritionProgram')->where('owner_id', $client)->orderBy('created_at', 'asc')->get();
        $latestSession = $sessions[count($sessions)-1];
        $sessionkeys = [];
        foreach ($sessions as $s) {
            $sessionkeys[$s->id] = $s->session_number;
        }
        $meals = Meal::all();
        $templates = NutritionProgramTemplate::all();
        $nutritions = Nutritions::all();
        $categories = $this->unique_multidim_array($nutritions, 'category');
        $client = User::find($client);
        return view('copynutritionprogram', [
            'client' => $client,
            'session' => $pastSession,
            'sessions' => $sessionkeys,
            'nutritions' => $nutritions,
            'categories' => $categories,
            'newsession' => $session,
            'meals' => $meals,
            'templates' => $templates,
        ]);
    }
    
    public function newNutritionProgram(Request $request, $client, $session)
    {
        $session = TrainingSession::find($session);
        $sessions = TrainingSession::where('owner_id', $client)->get();
        $sessionkeys = [];
        $templates = NutritionProgramTemplate::all();
        foreach ($sessions as $s) {
            $sessionkeys[$s->id] = $s->session_number;
        }
        $client = User::find($client);
        $nutritions = Nutritions::all();
        $meals = Meal::all();
        $categories = $this->unique_multidim_array($nutritions, 'category');
        return view('newnutritionprogram', [
            'client' => $client,
            'session' => $session,
            'sessions' => $sessionkeys,
            'nutritions' => $nutritions,
            'categories' => $categories,
            'meals' => $meals,
            'templates' => $templates,
        ]);
    }
    
    public function storeNutritionProgram(HttpRequest $request, $client, $session)
    {

        NutritionProgram::create([
            'date' => $request->date,
            'water_intake' => $request->water_intake,
            'meals' => $request->meals,
            'program_notes' => $request->program_notes,
            'owner_id' => $request->session_id
        ]);

        return redirect('/user/'.$client.'/nutritionprogram/'.$session);
    }
    
    public function updateNutritionProgram(Request $request, $client, $session)
    {
        $nutritionProgram = NutritionProgram::find(Request::get('program_id'));
        $nutritionProgram->fill(\Request::all());
        $nutritionProgram->save();
        return redirect('/user/'.$client.'/nutritionprogram/'.$session);
    }
}
