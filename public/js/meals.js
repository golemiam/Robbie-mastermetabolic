function searchNut(token){
	$.ajax({
	  method: "POST",
	  url: "/settings/nutritions/search",
	  data: { search: $('#search').val(), _token: token }
	}).done(function(result) {
	  $('.modal-body').html(result);
	});
}

$("#search").keyup(function(event){
    if(event.keyCode == 13){
        searchNut($('#token').val());
    }
});

var mealcount = 0;
var currentMeal = 1;
var linecount = 0;

function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}

function addToTime(mealnum){
	var add = 3;
	var hour = parseFloat($('#meal'+mealnum+'time').val().substring(0,2));
	var end = $('#meal1time').val().substring($('#meal1time').val().length-2, $('#meal1time').val().length);
	if(hour + 3 == 13){
		var newhour = 1;
		if(end=='am'){end='pm'}else{end='pm'}
	}
	else if(hour + 3 == 14){
		var newhour = 2;
		if(end=='am'){end='pm'}else{end='pm'}
	}
	else if(hour + 3 == 15){
		var newhour = 3;
		if(end=='am'){end='pm'}else{end='pm'}
	}
	else{
		var newhour = hour + 3;
	}
	if(hour > 9){
		return newhour + $('#meal'+mealnum+'time').val().substring(2,$('#meal1time').val().length-2) + end;
	}
	else{
		return newhour + $('#meal'+mealnum+'time').val().substring(1,$('#meal1time').val().length-2) + end;
	}
}

var meals = {
	meal: []
};

// Object count is 1 less then the meal count

function addMeal(meal){
	mealcount++;
	if(!meal){
		var meal = {
			mealnum: mealcount,
			name: '',
			linecount: 0,
			items: [],
			notes: '',
			time: ''
		};
	}
	meals.meal[mealcount-1] = meal;
	if(meal.mealnum != 1){
		var tabsection = '<div class="panel" id="meal'+mealcount+'"> <div role="tab" id="meal'+mealcount+'label" class="panel-heading panel-title"> <h4 style="float: left; margin-top: 8px;">Meal '+mealcount+'</h4> <input type="text" style="float:left; width: 250px; margin-left: 15px;" class="form-control" id="meal'+mealcount+'name" placeholder="Meal Name" value="'+meal.name+'"> <input type="text" style="float:right; width: 90px;" class="form-control" id="meal'+mealcount+'time" placeholder="Time" data-plugin="timepicker" value="'+meal.time+'"> </div> <div role="tabpanel" id="meal'+mealcount+'panel"> <div class="panel-body"> <table class="table table-bordered"> <thead> <tr style="background-color: #3c3f48;"> <th width="550">Food Name</th> <th>Portion Size</th> <th>Calories</th> <th>Fats</th> <th>Carbs</th> <th>Proteins</th> <th width="41"></th> </tr> </thead> <tbody> <tr class="totals"> <td>Totals</td> <td></td> <td><span id="totalmeal'+mealcount+'calories">0</span></td> <td><span id="totalmeal'+mealcount+'fats">0</span></td> <td><span id="totalmeal'+mealcount+'carbs">0</span></td> <td><span id="totalmeal'+mealcount+'proteins">0</span></td> <td> <button style="float: right;" onclick="openModal('+mealcount+')" data-original-title="Add Line" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"> <i aria-hidden="true" class="icon wb-plus"></i> </button> </td> </tr> </tbody> </table> <div class="col-lg-6" style="padding-left: 0px;"> <textarea rows="3" id="meal'+mealcount+'notes" class="form-control" placeholder="Notes">'+meal.notes+'</textarea> </div> <div class="col-lg-6" style="padding-right: 0px;"> <button onclick="removeMeal('+mealcount+');" style="float: right;" data-original-title="Delete Meal" data-toggle="tooltip" class="removemeal btn btn-sm btn-icon btn-flat btn-default" type="button"> <i aria-hidden="true" class="icon wb-trash"></i> </button> </div> </div> </div> </div>';
		$('#meals').append(tabsection);
		$('#meal'+mealcount+'time').timepicker();
		$('#meal'+mealcount+'time').val(addToTime(mealcount-1));
	}
	else{
		$('#meal1name').val(meal.name);
		$('#meal1time').val(meal.time);
		$('#meal1notes').val(meal.notes);
	}
}


function openModal(mealnum){
	currentMeal = mealnum;
	$('#addNutrition').modal('show');
}

function getColor(cat){
	var cssclss;
	if(cat == 'Carbs'){
		cssclss = 'label-success';
	}
	else if(cat == 'Protiens'){
		cssclss = 'label-primary';
	}
	else if(cat == 'Fats'){
		cssclss = 'label-warning';
	}
	else if(cat == 'Sugars'){
		cssclss = 'label-danger';
	}
	else{
		cssclss = 'label-primary';
	}
	return cssclss;
}

function addNutrtion(nutrition, line, meal, mulipiler){
	if(!meal){ 
		$('#addNutrition').modal('hide');
		var mulipiler = $('#multiplier'+line+' option:selected').text(); 
		var vals = [
			roundToTwo(parseFloat(nutrition[2])*parseFloat(mulipiler)),
			roundToTwo(parseFloat(nutrition[3])*parseFloat(mulipiler)), 
			roundToTwo(parseFloat(nutrition[4])*parseFloat(mulipiler)), 
			roundToTwo(parseFloat(nutrition[5])*parseFloat(mulipiler))
		];
	}
	else{
		currentMeal = meal;
		var vals = [
			parseFloat(nutrition[2]), 
			parseFloat(nutrition[3]), 
			parseFloat(nutrition[4]), 
			parseFloat(nutrition[5])];
	}
	var cssclss = getColor(nutrition[6]);
	var row = '<tr id="line'+linecount+'"> <td><span class="label '+cssclss+'">'+nutrition[6]+'</span>'+nutrition[0]+'</td> <td>'+mulipiler+' '+nutrition[1]+'</td> <td class="calories">'+vals[0]+'</td> <td class="fats">'+vals[1]+'</td> <td class="carbs">'+vals[2]+'</td> <td class="proteins">'+vals[3]+'</td> <td> <button onclick="removeLine('+linecount+','+currentMeal+')" data-original-title="Remove Line" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default removeline" type="button"> <i aria-hidden="true" class="icon wb-minus"></i></button> </td> </tr>';
	$(row).insertBefore('#meal'+currentMeal+' .totals');
	$('#totalmeal'+currentMeal+'calories').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'calories').text())+vals[0]));
	$('#totalmeal'+currentMeal+'fats').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'fats').text())+vals[1]));
	$('#totalmeal'+currentMeal+'carbs').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'carbs').text())+vals[2]));
	$('#totalmeal'+currentMeal+'proteins').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'proteins').text())+vals[3]));
	updateTotals();
	var item = {
		lcount: linecount,
		category: nutrition[6],
		name: nutrition[0],
		mulipiler: mulipiler,
		portion_name: nutrition[1],
		calories: vals[0],
		fats: vals[1],
		carbs: vals[2],
		proteins: vals[3],
		meal: currentMeal
	};
	var lc = meals.meal[currentMeal-1].linecount;
	meals.meal[currentMeal-1].items[lc] = item;
	meals.meal[currentMeal-1].linecount++;
	linecount++;
}

function removeLine(line, meal){
	$('#totalmeal'+meal+'calories').text(roundToTwo(parseFloat($('#totalmeal'+meal+'calories').text())-parseFloat($('#line'+line+' td.calories').text())));
	$('#totalmeal'+meal+'fats').text(roundToTwo(parseFloat($('#totalmeal'+meal+'fats').text())-parseFloat($('#line'+line+' td.fats').text())));
	$('#totalmeal'+meal+'carbs').text(roundToTwo(parseFloat($('#totalmeal'+meal+'carbs').text())-parseFloat($('#line'+line+' td.carbs').text())));
	$('#totalmeal'+meal+'proteins').text(roundToTwo(parseFloat($('#totalmeal'+meal+'proteins').text())-parseFloat($('#line'+line+' td.proteins').text())));
	$('#line'+line).remove();
	var i;
	var e = 0;
	var items = meals.meal[meal-1].items;
	var newitems = [];
	for (i = 0; i < items.length; ++i) {
		if(items[i].lcount != parseFloat(line)){
			newitems[e] = items[i];
			e++;
		}
	}
	meals.meal[meal-1].items = newitems;
	meals.meal[meal-1].linecount--;
	updateTotals();
}

function updateTotals(){
	$('#mealsinput').val(JSON.stringify(meals.meal[0]));
	$('#nameinput').val($('#meal1name').val());
}

//Final Check
function validate( form ){
	// Gather Notes, Names and Times
	for (i = 1; i < mealcount+1; ++i) {	
		meals.meal[i-1].notes = $('#meal'+ i +'notes').val();
		meals.meal[i-1].time = $('#meal'+ i +'time').val();
		meals.meal[i-1].name = $('#meal'+ i +'name').val();
	}

	updateTotals();
	return true;
}