var totalchart = new Chartist.Pie('#chartLineTime .chart-pie-right', {
  series: [30,30,30]
}, {
  donut: true,
  donutWidth: 10,
  startAngle: 0,
  showLabel: false
});

function searchNut(token){
	$.ajax({
	  method: "POST",
	  url: "/settings/nutritions/search",
	  data: { search: $('#search').val(), _token: token }
	}).done(function(result) {
	  $('#addNutrition .modal-body').html(result);
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

function removeNulls(obj){
  var isArray = obj instanceof Array;
  for (var k in obj){
	if (obj[k]===null) isArray ? obj.splice(k,1) : delete obj[k];
	else if (typeof obj[k]=="object") removeNulls(obj[k]);
  }
}

Array.prototype.move = function (from, to) {
  this.splice(to, 0, this.splice(from, 1)[0]);
};

function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}

function addToTime(mealnum){
	var add = 3;
	if($('#meal'+mealnum+'time').val() && $('#meal'+mealnum+'time').val() != ''){
		var hour = parseFloat($('#meal'+mealnum+'time').val().substring(0,2));
		var end = $('#meal'+mealnum+'time').val().substring($('#meal'+mealnum+'time').val().length-2, $('#meal'+mealnum+'time').val().length);
		if(hour + 3 == 12){
			var newhour = 12;
			if(end=='am'){end='pm'}else{end='pm'}
		}
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
			return newhour + $('#meal'+mealnum+'time').val().substring(2,$('#meal'+mealnum+'time').val().length-2) + end;
		}
		else{
			return newhour + $('#meal'+mealnum+'time').val().substring(1,$('#meal'+mealnum+'time').val().length-2) + end;
		}
	}
	else{
		return '';
	}
}

var meals = {
	meal: []
};

// Object count is 1 less then the meal count

function addMeal(meal){
	if(mealcount != 0){
		var next = meals.meal[mealcount-1].mealnum + 1;
	}
	else{
		var next = mealcount+1;
	}
	mealcount++;
	if(!meal){
		var meal = {
			mealnum: next,
			name: '',
			linecount: 0,
			items: [],
			notes: '',
			time: ''
		};
	}
	meals.meal[mealcount-1] = meal;
	var tabsection = ' \
	<div class="panel" id="meal'+next+'"> \
		<div role="tab" id="meal'+next+'label" class="panel-heading panel-title"> \
			<h4 style="float: left; margin-top: 8px;">Meal '+next+'</h4> <input type="text" style="float:left; width: 250px; margin-left: 15px;" class="form-control" id="meal'+next+'name" placeholder="Meal Name" value="'+meal.name+'"> <input type="text" style="float:right; width: 90px;" class="form-control" id="meal'+next+'time" placeholder="Time" data-plugin="timepicker" value="'+meal.time+'"> </div> \
		<div role="tabpanel" id="meal'+next+'panel"> \
			<div class="panel-body"> \
				<table class="table table-bordered"> \
					<thead> \
						<tr style="background-color: #3c3f48;"> \
							<th width="550">Food Name</th> \
							<th>Portion Size</th> \
							<th>Calories</th> \
							<th>Fats</th> \
							<th>Carbs</th> \
							<th>Proteins</th> \
							<th width="150"></th> \
						</tr> \
					</thead> \
					<tbody> \
						<tr class="totals"> \
							<td>Totals</td> \
							<td></td> \
							<td><span id="totalmeal'+next+'calories">0</span></td> \
							<td><span id="totalmeal'+next+'fats">0</span> ( <span id="totalmeal'+next+'fatsper">30</span>% )</td> \
							<td><span id="totalmeal'+next+'carbs">0</span> ( <span id="totalmeal'+next+'carbsper">30</span>% )</td> \
							<td><span id="totalmeal'+next+'proteins">0</span> ( <span id="totalmeal'+next+'proteinsper">30</span>% )</td> \
							<td> <button style="float: right;" onclick="openModal('+next+')" data-original-title="Add Line" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default" type="button"> <i aria-hidden="true" class="icon wb-plus"></i> </button> </td> \
						</tr> \
					</tbody> \
				</table> \
				<div class="col-lg-6" style="padding-left: 0px;"> <textarea rows="3" id="meal'+next+'notes" class="form-control" placeholder="Notes">'+meal.notes+'</textarea> </div> \
				<div class="col-lg-6" style="padding-right: 0px;"> <button onclick="removeMeal('+next+');" style="float: right;" data-original-title="Delete Meal" data-toggle="tooltip" class="removemeal btn btn-sm btn-icon btn-flat btn-default" type="button"> <i aria-hidden="true" class="icon wb-trash"></i> </button> </div> \
			</div> \
		</div> \
	</div> \
	';
	$('#meals').append(tabsection);
	$('#meal'+mealcount+'time').timepicker();
	if(meal.mealnum != 1){
		$('#meal'+mealcount+'time').val(addToTime(mealcount-1));
	}
}

function addMobileMeal(meal){
	if(mealcount != 0){
		var next = meals.meal[mealcount-1].mealnum + 1;
	}
	else{
		var next = mealcount+1;
	}
	mealcount++;
	if(!meal){
		var meal = {
			mealnum: next,
			name: '',
			linecount: 0,
			items: [],
			notes: '',
			time: ''
		};
	}
	meals.meal[mealcount-1] = meal;
	var tabsection = ' \
	<div class="panel" id="meal'+next+'"> \
		<div role="tab" id="meal'+next+'label" class="panel-heading panel-title"> \
			<h4 style="float: left; margin-top: 8px;">Meal '+next+' '+meal.name+' '+meal.time+'</h4></div> \
		<div role="tabpanel" id="meal'+next+'panel"> \
			<div class="panel-body"> \
				<table data-tablesaw-minimap="" data-tablesaw-mode="columntoggle" class="tablesaw table-striped table-bordered tablesaw-columntoggle" id="table-1102"> \
					<thead> \
						<tr style="background-color: #3c3f48;"> \
							<th data-tablesaw-priority="persist">Food Name</th> \
							<th data-tablesaw-priority="1">Portion</th> \
							<th data-tablesaw-priority="2">Cals</th> \
							<th data-tablesaw-priority="3">Fats</th> \
							<th data-tablesaw-priority="4">Carbs</th> \
							<th data-tablesaw-priority="5">Proteins</th> \
						</tr> \
					</thead> \
					<tbody> \
						<tr class="totals"> \
							<td>Totals</td> \
							<td></td> \
							<td><span id="totalmeal'+next+'calories">0</span></td> \
							<td><span id="totalmeal'+next+'fats">0</span> ( <span id="totalmeal'+next+'fatsper">30</span>% )</td> \
							<td><span id="totalmeal'+next+'carbs">0</span> ( <span id="totalmeal'+next+'carbsper">30</span>% )</td> \
							<td><span id="totalmeal'+next+'proteins">0</span> ( <span id="totalmeal'+next+'proteinsper">30</span>% )</td> \
						</tr> \
					</tbody> \
				</table> \
				<div class="col-lg-6" style="padding: 0px; margin-top: 20px;"> <textarea rows="3" id="meal'+next+'notes" class="form-control" style="width: 100%" placeholder="Notes">'+meal.notes+'</textarea> </div> \
				<div class="col-lg-6" style="padding-right: 0px;"> <button onclick="removeMeal('+next+');" style="float: right;" data-original-title="Delete Meal" data-toggle="tooltip" class="removemeal btn btn-sm btn-icon btn-flat btn-default" type="button"> <i aria-hidden="true" class="icon wb-trash"></i> </button> </div> \
			</div> \
		</div> \
	</div> \
	';
	$('#meals').append(tabsection);
	$('#meal'+mealcount+'time').timepicker();
	if(meal.mealnum != 1){
		$('#meal'+mealcount+'time').val(addToTime(mealcount-1));
	}
}

function removeMeal(mealnum){
	validate();
	var oldmeals = meals;
	meals = {
		meal: []
	};
	mealcount = 0;
	$.each(oldmeals, function(i, omeals) {
		$.each(omeals, function(i, meal) {
			//console.log(meal);
			var count = mealcount+1;
			$('#meal'+meal.mealnum).remove();
			if(meal.mealnum != parseFloat(mealnum)){
				var newmeal = {
					mealnum: count,
					name: meal.name,
					linecount: 0,
					items: [],
					notes: meal.notes,
					time: meal.time
				};
				addMeal(newmeal);
				$.each(meal.items, function(i, item) {
					//console.log(item);
					addNutrtion([item.name, item.portion_name, item.calories, item.fats, item.carbs, item.proteins, item.category], item.lcount, newmeal.mealnum, item.mulipiler)
				});
			}
		});
	});
	updateTotals();
}

function openModal(mealnum){
	currentMeal = mealnum;
	$('#addNutrition').modal('show');
}

function mealModal(){
	$('#addMeal').modal('show');
}

function templateModal(){
	$('#templates').modal('show');
}

function importTemplate(template){
	$('#templates').modal('hide');
	meals = {
		meal: []
	};
	$('#meals').empty();
	var tempmeals = template;
	console.log(template);
	mealcount = 0;
	$.each($.parseJSON(tempmeals), function(i, omeals) {
		$.each(omeals, function(i, meal) {
			var newmeal = {
				mealnum: meal.mealnum,
				name: meal.name,
				linecount: 0,
				items: [],
				notes: meal.notes,
				time: meal.time
			};
			addMeal(newmeal);
			$.each(meal.items, function(i, item) {
				console.log(item);
				if(item != null){
					addNutrtion([item.name, item.portion_name, item.calories, item.fats, item.carbs, item.proteins, item.category], item.lcount, meal.mealnum, item.mulipiler);
				}
			});
		});
	});
}

function addNewMeal(meal){
	$('#addMeal').modal('hide');
	currentMeal = mealcount+1;
	var newmeal = {
		mealnum: currentMeal,
		name: meal.name,
		linecount: 0,
		items: [],
		notes: meal.notes
	};
	addMeal(newmeal);
	
	$.each(meal.items, function(i, item) {
		addNutrtion([item.name, item.portion_name, item.calories, item.fats, item.carbs, item.proteins, item.category], item.lcount, currentMeal, item.mulipiler)
	});
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
		$('#search').val('');
		searchNut($('#token').val());
		$('#addNutrition').modal('hide');
		var mulipiler = $('#multiplier'+line).val(); 
		var vals = [
			roundToTwo(parseFloat(nutrition[2])*parseFloat(mulipiler)),
			roundToTwo(parseFloat(nutrition[3])*parseFloat(mulipiler)), 
			roundToTwo(parseFloat(nutrition[4])*parseFloat(mulipiler)), 
			roundToTwo(parseFloat(nutrition[5])*parseFloat(mulipiler))
		];
	}
	else{
		currentMeal = meal;
		var vals = [parseFloat(nutrition[2]), parseFloat(nutrition[3]), parseFloat(nutrition[4]), parseFloat(nutrition[5])];
	}
	var cssclss = getColor(nutrition[6]);
	var row = ' \
	<tr id="line'+linecount+'" class="MoveableRow"> \
		<td><span class="label '+cssclss+'">'+nutrition[6]+'</span>'+nutrition[0]+'</td> \
		<td><input type="text" style="text-align: center; float: left; margin-right: 20px; height: 26px; font-size: 13px; padding: 3px; width: 65px;" class="form-control" id="multi'+linecount+'" value="'+mulipiler+'" data-current="'+mulipiler+'" />'+nutrition[1]+'</td> \
		<td class="calories">'+vals[0]+'</td> \
		<td class="fats">'+vals[1]+'</td> \
		<td class="carbs">'+vals[2]+'</td> \
		<td class="proteins">'+vals[3]+'</td> \
		<td> \
			<button onclick="moveLine(this, '+currentMeal+', \'up\')" data-row-id="'+meals.meal[currentMeal-1].linecount+'" class="btn btn-sm btn-icon btn-flat btn-default up" type="button"> <i aria-hidden="true" class="icon wb-arrow-up"></i></button> \
			<button onclick="moveLine(this, '+currentMeal+', \'down\')" data-row-id="'+meals.meal[currentMeal-1].linecount+'" class="btn btn-sm btn-icon btn-flat btn-default down" type="button"> <i aria-hidden="true" class="icon wb-arrow-down"></i></button> \
			<button onclick="updateLine('+linecount+', '+currentMeal+')" class="btn btn-sm btn-icon btn-flat btn-default multiinput" type="button"> <i aria-hidden="true" class="icon wb-refresh"></i></button> \
			<button onclick="removeLine('+linecount+','+currentMeal+')" data-original-title="Remove Line" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default removeline" type="button"> <i aria-hidden="true" class="icon wb-minus"></i></button> \
		</td> \
	</tr> \
	';
	$(row).insertBefore('#meal'+currentMeal+' .totals');
	$('#totalmeal'+currentMeal+'calories').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'calories').text())+vals[0]));
	$('#totalmeal'+currentMeal+'fats').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'fats').text())+vals[1]));
	$('#totalmeal'+currentMeal+'carbs').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'carbs').text())+vals[2]));
	$('#totalmeal'+currentMeal+'proteins').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'proteins').text())+vals[3]));
	updateMealPer(currentMeal);
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

function addMobileNutrtion(nutrition, line, meal, mulipiler){
	if(!meal){ 
		$('#search').val('');
		searchNut($('#token').val());
		$('#addNutrition').modal('hide');
		var mulipiler = $('#multiplier'+line).val(); 
		var vals = [
			roundToTwo(parseFloat(nutrition[2])*parseFloat(mulipiler)),
			roundToTwo(parseFloat(nutrition[3])*parseFloat(mulipiler)), 
			roundToTwo(parseFloat(nutrition[4])*parseFloat(mulipiler)), 
			roundToTwo(parseFloat(nutrition[5])*parseFloat(mulipiler))
		];
	}
	else{
		currentMeal = meal;
		var vals = [parseFloat(nutrition[2]), parseFloat(nutrition[3]), parseFloat(nutrition[4]), parseFloat(nutrition[5])];
	}
	var cssclss = getColor(nutrition[6]);
	var row = ' \
	<tr id="line'+linecount+'" class="MoveableRow"> \
		<td class="">'+nutrition[0]+'</td> \
		<td class="tablesaw-priority-1">'+mulipiler+' '+nutrition[1]+'</td> \
		<td class="calories tablesaw-priority-2">'+vals[0]+'</td> \
		<td class="fats tablesaw-priority-3">'+vals[1]+'</td> \
		<td class="carbs tablesaw-priority-4">'+vals[2]+'</td> \
		<td class="proteins tablesaw-priority-5">'+vals[3]+'</td> \
	</tr> \
	';
	$(row).insertBefore('#meal'+currentMeal+' .totals');
	$('#totalmeal'+currentMeal+'calories').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'calories').text())+vals[0]));
	$('#totalmeal'+currentMeal+'fats').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'fats').text())+vals[1]));
	$('#totalmeal'+currentMeal+'carbs').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'carbs').text())+vals[2]));
	$('#totalmeal'+currentMeal+'proteins').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'proteins').text())+vals[3]));
	updateMealPer(currentMeal);
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

function updateMealPer(currentMeal){
	var totalfats = parseFloat($('#totalmeal'+currentMeal+'fats').text()) * 9;
	var totalcarbs = parseFloat($('#totalmeal'+currentMeal+'carbs').text()) * 4;
	var totalproteins = parseFloat($('#totalmeal'+currentMeal+'proteins').text()) * 4;
	
	// Update Percentages
	// Multiply by how many calories in each type
	var parttotal = totalfats + totalcarbs + totalproteins;
	var percent = {
		fats: Math.floor((totalfats / parttotal) * 100),
		carbs: Math.floor((totalcarbs / parttotal) * 100),
		proteins: Math.floor((totalproteins / parttotal) * 100)
	}
	
	$('#totalmeal'+currentMeal+'fatsper').text(percent.fats);
	$('#totalmeal'+currentMeal+'carbsper').text(percent.carbs);
	$('#totalmeal'+currentMeal+'proteinsper').text(percent.proteins);
}

$('body').on('click', '.down', function(){
	var rowToMove = $(this).parents('tr.MoveableRow:first');
	var next = rowToMove.next('tr.MoveableRow');
	if (next.length == 1) { next.after(rowToMove); }
});

$('body').on('click', '.up', function(){
	var rowToMove = $(this).parents('tr.MoveableRow:first');
	var prev = rowToMove.prev('tr.MoveableRow')
	if (prev.length == 1) { prev.before(rowToMove); }
});

// Handles object item movement
function moveLine(el, meal, dir){
	var line = el.getAttribute("data-row-id");
	if(dir == 'up'){
		var newline = line-1;
	}
	else{
		var newline = line+1;
	}
	meals.meal[meal-1].items.move(line,newline);
	$("button[data-row-id='" + line + "']").each(function(index, value) { 
		$(this).attr('data-row-id', newline); 
	});
}

function updateLine(line, currentMeal){
	var count = parseFloat($('#multi'+ line).attr('data-current'));
	
	var cal = parseFloat($('#line'+ line +' .calories').text());
	var ncal = roundToTwo((cal / count) * $('#multi'+ line).val());
	$('#totalmeal'+currentMeal+'calories').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'calories').text())-cal));
	$('#line'+ line +' .calories').text(ncal);
	$('#totalmeal'+currentMeal+'calories').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'calories').text())+ncal));
	
	var fat = parseFloat($('#line'+ line +' .fats').text());
	var nfat = roundToTwo((fat / count) * $('#multi'+ line).val());
	$('#totalmeal'+currentMeal+'fats').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'fats').text())-fat));
	$('#line'+ line +' .fats').text(nfat);
	$('#totalmeal'+currentMeal+'fats').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'fats').text())+nfat));
	
	var carbs = parseFloat($('#line'+ line +' .carbs').text());
	var ncarbs = roundToTwo((carbs / count) * $('#multi'+ line).val());
	$('#totalmeal'+currentMeal+'carbs').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'carbs').text())-carbs));
	$('#line'+ line +' .carbs').text(ncarbs);
	$('#totalmeal'+currentMeal+'carbs').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'carbs').text())+ncarbs));
	
	var proteins = parseFloat($('#line'+ line +' .proteins').text());
	var nproteins = roundToTwo((proteins / count) * $('#multi'+ line).val());
	$('#totalmeal'+currentMeal+'proteins').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'proteins').text())-proteins));
	$('#line'+ line +' .proteins').text(nproteins);
	$('#totalmeal'+currentMeal+'proteins').text(roundToTwo(parseFloat($('#totalmeal'+currentMeal+'proteins').text())+nproteins));
	
	$('#multi'+ line).attr('data-current', $('#multi'+ line).val());
	updateTotals();
	updateMealPer(currentMeal);

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
	updateMealPer(meal);
}

function updateTotals(){
	var totals = {
		calories: 0,
		fats: 0,
		carbs: 0,
		proteins: 0
	}
	var i;
	for (i = 1; i < mealcount+1; ++i) {	
		totals.calories = roundToTwo(totals.calories + parseFloat($('#totalmeal'+ i +'calories').text()));
		totals.fats = roundToTwo(totals.fats + parseFloat($('#totalmeal'+ i +'fats').text()));
		totals.carbs = roundToTwo(totals.carbs + parseFloat($('#totalmeal'+ i +'carbs').text()));
		totals.proteins = roundToTwo(totals.proteins + parseFloat($('#totalmeal'+ i +'proteins').text()));
	}
	$('#totalcalories').text(totals.calories);
	$('#totalfats').text(totals.fats);
	$('#totalcarbs').text(totals.carbs);
	$('#totalproteins').text(totals.proteins);
	
	// Update line totals
	
//	for (i = 1; i < linecount; ++i) {	
//		var calories = parseFloat($('#line'+ i +' .calories').text();
//		var count = calories / $('#multi'+ i).attr('data-current');
//	}

	// Update trigger for move function
// 	$('body').on('click', '.up,.down,.top,.bottom', function(){
//         var row = $(this).parents("tr:first");
//         if ($(this).is(".up")) {
//             row.insertBefore(row.prev());
//         } else if ($(this).is(".down")) {
//             row.insertAfter(row.next());
//         } else if ($(this).is(".top")) {
//             row.insertBefore($("table tr:first"));
//         }else {
//             row.insertAfter($("table tr:last"));
//         }
//     });

	// Change Totals so they are based on calories
	totals.fats = totals.fats * 9;
	totals.proteins = totals.proteins * 4;
	totals.carbs = totals.carbs * 4;

	// Controller for Pie Chart
	totalchart.data.series = [totals.fats , totals.proteins, totals.carbs];
	totalchart.update();

	var parttotal = totals.fats + totals.carbs + totals.proteins;
	var percent = {
		fats: Math.floor((totals.fats / parttotal) * 100),
		carbs: Math.floor((totals.carbs / parttotal) * 100),
		proteins: Math.floor((totals.proteins / parttotal) * 100)
	}

	var calpercent = (totals.calories / 2000) * 100;
	$('.counter-cal .progress-bar').css('width', calpercent+'%').attr('aria-valuenow', calpercent);
	$('.counter-fats .progress-bar').css('width', percent.fats+'%').attr('aria-valuenow', percent.fats);
	$('.counter-carb .progress-bar').css('width', percent.carbs+'%').attr('aria-valuenow', percent.carbs);
	$('.counter-pro .progress-bar').css('width', percent.proteins+'%').attr('aria-valuenow', percent.proteins);

	$('.counter-cal .counter-number').html(totals.calories);
	$('.counter-fats .counter-number').html(percent.fats);
	$('.counter-carb .counter-number').html(percent.carbs);
	$('.counter-pro .counter-number').html(percent.proteins);

	$('#totalcal').html(totals.calories);

	$('#mealsinput').val(JSON.stringify(meals));
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