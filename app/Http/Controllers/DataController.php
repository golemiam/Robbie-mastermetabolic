<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as HttpRequest;
use App;
use App\User;
use App\Nutritions;
use App\Exercise;
use App\TrainingSession;
use App\NutritionProgramTemplate;
use App\ExerciseProgramTemplate;
use App\Meal;
use App\Circuit;
use Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\ServiceProvider;
use Jenssegers\Agent\Agent;

;

class DataController extends Controller
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
    
    public function index(HttpRequest $request, $client)
    {
        if (Auth::user()->role == 'trainer' || Auth::user()->id == $client) {
            $trainingsessions = TrainingSession::where('owner_id', $client)->where('weight', '!=', '')->orderBy('id', 'asc')->get();
            if (count($trainingsessions) == 0) {
                $request->session()->flash('alert-danger', 'User must have a session.');
                return redirect('/user/'.$client.'/newsession');
            }
            $firstsession = $trainingsessions[0];
            $currentsession = $trainingsessions[count($trainingsessions)-1];
        
            $client = User::find($client);
            
            $agent = new Agent();
            
            if ($agent->isMobile()) {
                return view('mobile.dashboard', [
                    'client' => $client,
                    'first' => $firstsession,
                    'current' => $currentsession,
                    'trainingsessions' => $trainingsessions,
            
                ]);
            } else {
                return view('dashboard', [
                    'client' => $client,
                    'first' => $firstsession,
                    'current' => $currentsession,
                    'trainingsessions' => $trainingsessions,
            
                ]);
            }
        }
    }
    
    public function clientIndex(HttpRequest $request, $client)
    {
        if (Auth::user()->role == 'trainer' || Auth::user()->id == $client) {
            $trainingsessions = TrainingSession::where('owner_id', $client)->where('weight', '!=', '')->orderBy('id', 'asc')->get();
            if (count($trainingsessions) == 0) {
                $request->session()->flash('alert-danger', 'User must have a session.');
                return redirect('/user/'.$client.'/newsession');
            }
            $firstsession = $trainingsessions[0];
            $currentsession = $trainingsessions[count($trainingsessions)-1];
        
            $client = User::find($client);
            
            $agent = new Agent();
            
            return view('mobile.dashboard', [
                'client' => $client,
                'first' => $firstsession,
                'current' => $currentsession,
                'trainingsessions' => $trainingsessions,
        
            ]);
        }
    }
    
    public function makePDF(HttpRequest $request, $client)
    {
        if (Auth::user()->role == 'trainer' || Auth::user()->id == $client) {
            $trainingsessions = TrainingSession::where('owner_id', $client)->where('weight', '!=', '')->orderBy('id', 'asc')->get();
            if (count($trainingsessions) == 0) {
                $request->session()->flash('alert-danger', 'User must have a session.');
                return redirect('/user/'.$client.'/newsession');
            }
            $firstsession = $trainingsessions[0];
            $currentsession = $trainingsessions[count($trainingsessions)-1];
        
            $client = User::find($client);

            $data = [
                'client' => $client,
                'first' => $firstsession,
                'current' => $currentsession,
                'trainingsessions' => $trainingsessions,
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdf.dashboard', $data);
            $pdf->setPaper('letter', 'portrait');
            return $pdf->stream();
        }
    }
    
    public function testPDF(HttpRequest $request, $client)
    {
        if (Auth::user()->role == 'trainer' || Auth::user()->id == $client) {
            $trainingsessions = TrainingSession::where('owner_id', $client)->where('weight', '!=', '')->orderBy('id', 'asc')->get();
            if (count($trainingsessions) == 0) {
                $request->session()->flash('alert-danger', 'User must have a session.');
                return redirect('/user/'.$client.'/newsession');
            }
            $firstsession = $trainingsessions[0];
            $currentsession = $trainingsessions[count($trainingsessions)-1];
        
            $client = User::find($client);

            return view('pdf.dashboard', [
                'client' => $client,
                'first' => $firstsession,
                'current' => $currentsession,
                'trainingsessions' => $trainingsessions,
            
            ]);
        }
    }
    
    public function goalTracker(Request $request)
    {
        if (Auth::user()->role == 'trainer' || Auth::user()->id == $client) {
            $trainer = Auth::user();
            return view('goaltracker', [
                'trainer' => $trainer,
            ]);
        }
    }
    
    public function settings(Request $request)
    {
        return view('settings/settings');
    }

    public function freeFoods(Request $request, $client)
    {
        $client = User::find($client);
        return view('pages/freefoods', ['client' => $client]);
    }

    public function restaurantFood(Request $request, $client)
    {
        $client = User::find($client);
        return view('pages/restaurantfood', ['client' => $client]);
    }
    
    // Nutrition
    
    public function addNutritions(Request $request)
    {
        return view('settings/addnutrition');
    }
    
    public function getNutritions(Request $request)
    {
        $nutritions = Nutritions::all();
        $categories = $this->unique_multidim_array($nutritions, 'category');
        return view('settings/nutritions', [
            'nutritions' => $nutritions,
            'categories' => $categories,
        ]);
    }
    
    public function storeNutrition(HttpRequest $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'portion_name' => 'required|max:255',
            'category' => 'required|max:255',
            'calories' => 'required|max:255',
            'fats' => 'required|max:255',
            'carbs' => 'required|max:255',
            'proteins' => 'required|max:255',
        ]);

        Nutritions::create([
            'name' => $request->name,
            'portion_name' => $request->portion_name,
            'category' => $request->category,
            'calories' => $request->calories,
            'fats' => $request->fats,
            'carbs' => $request->carbs,
            'proteins' => $request->proteins,
        ]);

        return redirect('settings/nutritions');
    }
    
    public function destroyNutrition(HttpRequest $request, $id)
    {
        $nutrition = Nutritions::find($id);

        $nutrition->delete();
        $request->session()->flash('alert-danger', 'Nutrtion Removed.');
        return redirect('settings/nutritions');
    }
    
    public function searchNutrition(Request $request)
    {
        if (Request::get('search') != '') {
            $nutritions = Nutritions::where('name', 'like', '%'.Request::get('search').'%')->get();
            $categories = $this->unique_multidim_array($nutritions, 'category');
            return view('settings/nutritionmodal', [
                'nutritions' => $nutritions,
                'categories' => $categories,
            ]);
        } else {
            $nutritions = Nutritions::get();
            $categories = $this->unique_multidim_array($nutritions, 'category');
            return view('settings/nutritionsmodal', [
                'nutritions' => $nutritions,
                'categories' => $categories,
            ]);
        }
    }
    
    public function favNutrition(HttpRequest $request, $id, $val)
    {
        $nutrition = Nutritions::find($id);
        $nutrition->fill(['favorite' => $val]);
        $nutrition->save();
        $request->session()->flash('alert-success', 'Nutrtion Updated.');
        return redirect('settings/nutritions');
    }
    
    // Exercises
    
    public function addExercise(Request $request)
    {
        return view('settings/addexercise');
    }
    
    public function getExercises(Request $request)
    {
        $exercise = Exercise::all();
        $categories = $this->unique_multidim_array($exercise, 'category');
        return view('settings/exercises', [
            'exercise' => $exercise,
            'categories' => $categories,
        ]);
    }
    
    public function storeExercise(HttpRequest $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'category' => 'required|max:255',
        ]);

        Exercise::create([
            'name' => $request->name,
            'category' => $request->category,
        ]);

        return redirect('settings/exercises');
    }
    
    public function destroyExercise(HttpRequest $request, $id)
    {
        $exercise = Exercise::find($id);

        $exercise->delete();
        $request->session()->flash('alert-danger', 'Exercise Removed.');
        return redirect('settings/exercises');
    }
    
    public function searchExercise(Request $request)
    {
        if (Request::get('search') != '') {
            $exercises = Exercise::where('name', 'like', '%'.Request::get('search').'%')->get();
            $categories = $this->unique_multidim_array($exercises, 'category');
            return view('settings/exercisemodal', [
                'exercises' => $exercises,
                'categories' => $categories,
            ]);
        } else {
            $exercises = Exercise::get();
            $categories = $this->unique_multidim_array($exercises, 'category');
            return view('settings/exercisesmodal', [
                'exercises' => $exercises,
                'categories' => $categories,
            ]);
        }
    }
    
    public function favExercise(HttpRequest $request, $id, $val)
    {
        $exercise = Exercise::find($id);
        $exercise->fill(['favorite' => $val]);
        $exercise->save();
        $request->session()->flash('alert-success', 'Exercise Updated.');
        return redirect('settings/exercises');
    }
    
    // Meal
    
    public function getMeals(Request $request)
    {
        $meals = Meal::all();
        return view('settings/meals', [
            'meals' => $meals
        ]);
    }
    
    public function addMeal(Request $request)
    {
        $nutritions = Nutritions::all();
        $categories = $this->unique_multidim_array($nutritions, 'category');
        return view('settings/addmeal', [
            'nutritions' => $nutritions,
            'categories' => $categories,
        ]);
    }
    
    public function editMeal(Request $request, $id)
    {
        $meal = Meal::find($id);
        $nutritions = Nutritions::all();
        $categories = $this->unique_multidim_array($nutritions, 'category');
        return view('settings/editmeal', [
            'nutritions' => $nutritions,
            'categories' => $categories,
            'meal' => $meal,
        ]);
    }
    
    public function storeMeal(HttpRequest $request)
    {
        Meal::create([
            'name' => $request->name,
            'meal' => $request->meal,
        ]);

        return redirect('settings/meals');
    }
    
    public function updateMeal(Request $request)
    {
        $meal = Meal::find(Request::get('meal_id'));
        $meal->fill(\Request::all());
        $meal->save();
        return redirect('settings/meals');
    }
    
    public function destroyMeal(Request $request, $id)
    {
        $meal = Meal::find($id);

        $meal->delete();

        return redirect('settings/meals');
    }
    
    // Nutirtion Template
    
    public function getNutritionProgramTemplates(Request $request)
    {
        $templates = NutritionProgramTemplate::all();
        return view('settings/nutritiontemplates', [
            'templates' => $templates
        ]);
    }
    
    public function addNutritionProgramTemplate(Request $request)
    {
        $nutritions = Nutritions::all();
        $meals = Meal::all();
        $templates = NutritionProgramTemplate::all();
        $categories = $this->unique_multidim_array($nutritions, 'category');
        return view('settings/addnutritiontemplate', [
            'nutritions' => $nutritions,
            'categories' => $categories,
            'meals' => $meals,
            'templates' => $templates
        ]);
    }
    
    public function editNutritionProgramTemplate(Request $request, $id)
    {
        $template = NutritionProgramTemplate::find($id);
        $nutritions = Nutritions::all();
        $meals = Meal::all();
        $templates = NutritionProgramTemplate::all();
        $categories = $this->unique_multidim_array($nutritions, 'category');
        return view('settings/editnutritiontemplate', [
            'nutritions' => $nutritions,
            'categories' => $categories,
            'template' => $template,
            'meals' => $meals,
            'templates' => $templates
        ]);
    }
    
    public function storeNutritionProgramTemplate(HttpRequest $request)
    {
        NutritionProgramTemplate::create([
            'name' => $request->templatename,
            'mealtemplate' => $request->meals,
            'program_notes' => $request->program_notes,
        ]);

        return redirect('settings/nutritiontemplates');
    }
    
    public function updateNutritionProgramTemplate(Request $request)
    {
        $template = NutritionProgramTemplate::find(Request::get('program_id'));
        $template->fill(\Request::all());
        $template->mealtemplate = $_POST['meals'];
        $template->save();
        return redirect('settings/nutritiontemplates');
    }
    
    public function destroyNutritionProgramTemplate(Request $request, $id)
    {
        $template = NutritionProgramTemplate::find($id);

        $template->delete();

        return redirect('settings/nutritiontemplates');
    }
    
    // Exercise Template
    
    public function getExerciseProgramTemplates(Request $request)
    {
        $templates = ExerciseProgramTemplate::all();
        return view('settings/exercisetemplates', [
            'templates' => $templates
        ]);
    }
    
    public function addExerciseProgramTemplate(Request $request)
    {
        $exercises = Exercise::all();
        $circuits = Circuit::all();
        $templates = ExerciseProgramTemplate::all();
        $categories = $this->unique_multidim_array($exercises, 'category');
        return view('settings/addexercisetemplate', [
            'exercises' => $exercises,
            'categories' => $categories,
            'circuits' => $circuits,
            'templates' => $templates
        ]);
    }
    
    public function editExerciseProgramTemplate(Request $request, $id)
    {
        $template = ExerciseProgramTemplate::find($id);
        $exercises = Exercise::all();
        $templates = ExerciseProgramTemplate::all();
        $circuits = Circuit::all();
        $categories = $this->unique_multidim_array($exercises, 'category');
        return view('settings/editexercisetemplate', [
            'exercises' => $exercises,
            'categories' => $categories,
            'template' => $template,
            'circuits' => $circuits,
            'templates' => $templates
        ]);
    }
    
    public function storeExerciseProgramTemplate(HttpRequest $request)
    {
        ExerciseProgramTemplate::create([
            'name' => $request->templatename,
            'circuittemplate' => $request->circuits,
            'program_notes' => $request->program_notes,
        ]);

        return redirect('settings/exercisetemplates');
    }
    
    public function updateExerciseProgramTemplate(Request $request)
    {
        $template = ExerciseProgramTemplate::find(Request::get('program_id'));
        $template->fill(\Request::all());
        $template->circuittemplate = $_POST['circuits'];
        $template->save();
        return redirect('settings/exercisetemplates');
    }
    
    public function destroyExerciseProgramTemplate(Request $request, $id)
    {
        $template = ExerciseProgramTemplate::find($id);

        $template->delete();

        return redirect('settings/exercisetemplates');
    }
    
    // Circuit
    
    public function getCircuits(Request $request)
    {
        $circuits = Circuit::all();
        return view('settings/circuits', [
            'circuits' => $circuits
        ]);
    }
    
    public function addCircuit(Request $request)
    {
        $exercises = Exercise::all();
        $categories = $this->unique_multidim_array($exercises, 'category');
        return view('settings/addcircuit', [
            'exercises' => $exercises,
            'categories' => $categories,
        ]);
    }
    
    public function editCircuit(Request $request, $id)
    {
        $circuit = Circuit::find($id);
        $exercises = Exercise::all();
        $categories = $this->unique_multidim_array($exercises, 'category');
        return view('settings/editcircuit', [
            'exercises' => $exercises,
            'categories' => $categories,
            'circuit' => $circuit,
        ]);
    }
    
    public function storeCircuit(HttpRequest $request)
    {
        Circuit::create([
            'name' => $request->name,
            'circuit' => $request->circuit,
        ]);

        return redirect('settings/circuits');
    }
    
    public function updateCircuit(Request $request)
    {
        $circuit = Circuit::find(Request::get('circuit_id'));
        $circuit->fill(\Request::all());
        $circuit->save();
        return redirect('settings/circuits');
    }
    
    public function destroyCircuit(HttpRequest $request, $id)
    {
        $circuit = Circuit::find($id);

        $circuit->delete();
        $request->session()->flash('alert-danger', 'Circuit Removed.');
        return redirect('settings/circuits');
    }
}
