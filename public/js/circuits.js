function searchcircuit(token){
	$.ajax({
	  method: "POST",
	  url: "/settings/exercises/search",
	  data: { search: $('#search').val(), _token: token }
	}).done(function(result) {
	  $('#addExercise .modal-body').html(result);
	});
}

$("#search").keyup(function(event){
    if(event.keyCode == 13){
        searchcircuit($('#token').val());
    }
});

// Auto Populate Reps
// -----------------

var reps = ['8, 8, 8, 8','12, 12, 12, 12','15, 15, 15, 15',
			'20, 15, 12, 10, 8','20, 15, 12, 10','25','30','50',
			'30 seconds','60 seconds','5 minutes','15 minutes','30 minutes',
			'45 minutes','60 minutes'];

  var substringMatcher = function(strs) {
	return function findMatches(q, cb) {
	  var matches, substrRegex;

	  // an array that will be populated with substring matches
	  matches = [];

	  // regex used to determine if a string contains the substring `q`
	  substrRegex = new RegExp(q, 'i');

	  // iterate through the pool of strings and for any string that
	  // contains the substring `q`, add it to the `matches` array
	  $.each(strs, function(i, str) {
		if (substrRegex.test(str)) {
		  matches.push(str);
		}
	  });

	  cb(matches);
	};
  };

var circuitcount = 0;
var currentcircuit = 1;
var linecount = 0;

function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}

function addToTime(circuitnum){
	var add = 3;
	var hour = parseFloat($('#circuit'+circuitnum+'time').val().substring(0,2));
	var end = $('#circuit1time').val().substring($('#circuit1time').val().length-2, $('#circuit1time').val().length);
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
		return newhour + $('#circuit'+circuitnum+'time').val().substring(2,$('#circuit1time').val().length-2) + end;
	}
	else{
		return newhour + $('#circuit'+circuitnum+'time').val().substring(1,$('#circuit1time').val().length-2) + end;
	}
}

var circuits = {
	circuit: []
};

Array.prototype.move = function (from, to) {
  this.splice(to, 0, this.splice(from, 1)[0]);
};

// Object count is 1 less then the circuit count

// function addCircuit(circuit){
// 	circuitcount++;
// 	if(!circuit){
// 		var circuit = {
// 			circuitnum: circuitcount,
// 			name: '',
// 			linecount: 0,
// 			items: [],
// 			notes: '',
// 			time: '',
// 		};
// 	}
// 	circuits.circuit[circuitcount-1] = circuit;
// 	var tabsection = '<div class="panel" id="circuit'+circuitcount+'"> <div role="tab" id="circuit'+circuitcount+'label" class="panel-heading panel-title"> <h4 style="float: left; margin-top: 8px;">Circuit '+circuitcount+'</h4> <input type="text" style="float:left; width: 250px; margin-left: 15px;" class="form-control" id="circuit'+circuitcount+'name" placeholder="Circuit Name" value="'+circuit.name+'"> <h4 style="float: right; margin-top: 7px; width: 130px; margin-left: 20px;" class="times">Times Per Week</h4><input type="text" style="float:right; width: 50px;" class="form-control" id="circuit'+circuitcount+'time" placeholder="" data-plugin="" value="'+circuit.time+'"></div> <div role="tabpanel" id="circuit'+circuitcount+'panel"> <div class="panel-body"> <table class="table table-bordered"> <thead> <tr style="background-color: #3c3f48;"> <th width="550">Exercise Name</th> <th>Sets</th> <th>Reps</th> <th>Speed</th> <th>Weights</th> <th width="120"></th> </tr> </thead> <tbody> <tr class="totals"> <td></td> <td></td> <td></td> <td></td> <td></td> <td> <button style="float: right;" onclick="openModal('+circuitcount+')" data-original-title="Add Line" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default addline" type="button"> <i aria-hidden="true" class="icon wb-plus"></i> </button> </td> </tr> </tbody> </table> <div class="col-lg-6" style="padding-left: 0px;"> <textarea rows="3" id="circuit'+circuitcount+'notes" class="form-control" placeholder="Notes">'+circuit.notes+'</textarea> </div> <div class="col-lg-6" style="padding-right: 0px;"> <button onclick="removeCircuit('+circuitcount+');" style="float: right;" data-original-title="Delete Circuit" data-toggle="tooltip" class="removecircuit btn btn-sm btn-icon btn-flat btn-default" type="button"> <i aria-hidden="true" class="icon wb-trash"></i> </button> </div> </div> </div> </div>';
// }

function addCircuit(circuit){
	if(circuitcount != 0){
		var next = circuits.circuit[circuitcount-1].circuitnum + 1;
	}
	else{
		var next = circuitcount+1;
	}
	circuitcount++;
	if(!circuit){
		var circuit = {
			circuitnum: next,
			name: '',
			linecount: 0,
			items: [],
			notes: '',
			time: ''
		};
	}
	circuits.circuit[circuitcount-1] = circuit;
	var tabsection = '\
		<div class="panel" id="circuit'+next+'"> \
			<div role="tab" id="circuit'+next+'label" class="panel-heading panel-title"> \
				<h4 style="float: left; margin-top: 8px;">Circuit '+next+'</h4>\
				<input type="text" style="float:left; width: 250px; margin-left: 15px;" class="form-control" id="circuit'+next+'name" placeholder="Circuit Name" value="'+circuit.name+'">\
				<h4 style="float: right; margin-top: 7px; width: 130px; margin-left: 20px;" class="times">Times Per Week</h4>\
				<input type="text" style="float:right; width: 50px;" class="form-control" id="circuit'+next+'time" placeholder="" data-plugin="" value="'+circuit.time+'">\
			</div>\
			<div role="tabpanel" id="circuit'+next+'panel"> \
				<div class="panel-body"> \
					<table class="table table-bordered"> \
						<thead> \
							<tr style="background-color: #3c3f48;"> \
								<th width="550">Exercise Name</th> \
								<th>Sets</th> \
								<th>Reps</th> \
								<th>Speed</th> \
								<th>Weights</th> \
								<th width="120"></th> \
							</tr> \
						</thead> \
						<tbody> \
							<tr class="totals"> \
								<td></td> \
								<td></td> \
								<td></td> \
								<td></td> \
								<td></td> \
								<td> <button style="float: right;" onclick="openModal('+next+')" data-original-title="Add Line" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default addline" type="button"> <i aria-hidden="true" class="icon wb-plus"></i> </button> </td> \
							</tr> \
						</tbody>\
					</table> \
					<div class="col-lg-6" style="padding-left: 0px;"> \
						<textarea rows="3" id="circuit'+next+'notes" class="form-control" placeholder="Notes">'+circuit.notes+'</textarea> \
					</div> \
					<div class="col-lg-6" style="padding-right: 0px;"> \
						<button onclick="removeCircuit('+next+');" style="float: right;" data-original-title="Delete Circuit" data-toggle="tooltip" class="removecircuit btn btn-sm btn-icon btn-flat btn-default" type="button"> <i aria-hidden="true" class="icon wb-trash"></i> </button> \
					</div> \
				</div> \
			</div> \
		</div>';
		$('#circuits').append(tabsection);
}

function addMobileCircuit(circuit){
	if(circuitcount != 0){
		var next = circuits.circuit[circuitcount-1].circuitnum + 1;
	}
	else{
		var next = circuitcount+1;
	}
	circuitcount++;
	if(!circuit){
		var circuit = {
			circuitnum: next,
			name: '',
			linecount: 0,
			items: [],
			notes: '',
			time: ''
		};
	}
	circuits.circuit[circuitcount-1] = circuit;
	var tabsection = '\
		<div class="panel" id="circuit'+next+'"> \
			<div role="tab" id="circuit'+next+'label" class="panel-heading panel-title"> \
				<h4 style="float: left; margin-top: 8px;">Circuit '+next+' - '+circuit.name+' - '+circuit.time+' Times Per Week</h4>\
			</div>\
			<div role="tabpanel" id="circuit'+next+'panel"> \
				<div class="panel-body"> \
					<table data-tablesaw-minimap="" data-tablesaw-mode="columntoggle" class="tablesaw table-striped table-bordered tablesaw-columntoggle" id="table-1102"> \
						<thead> \
							<tr style="background-color: #3c3f48;"> \
								<th data-tablesaw-priority="persist">Exercise Name</th> \
								<th data-tablesaw-priority="1">Sets</th> \
								<th data-tablesaw-priority="2">Reps</th> \
								<th data-tablesaw-priority="3">Speed</th> \
								<th data-tablesaw-priority="4">Weights</th> \
							</tr> \
						</thead> \
						<tbody> \
							<tr class="totals"> \
								<td></td> \
								<td></td> \
								<td></td> \
								<td></td> \
								<td></td> \
							</tr>\
						</tbody>\
					</table> \
					<div class="col-lg-6" style="padding: 0px; margin-top: 20px;"> \
						<textarea rows="3" id="circuit'+next+'notes" class="form-control" placeholder="Notes">'+circuit.notes+'</textarea> \
					</div> \
					<div class="col-lg-6" style="padding-right: 0px;"> \
						<button onclick="removeCircuit('+next+');" style="float: right;" data-original-title="Delete Circuit" data-toggle="tooltip" class="removecircuit btn btn-sm btn-icon btn-flat btn-default" type="button"> <i aria-hidden="true" class="icon wb-trash"></i> </button> \
					</div> \
				</div> \
			</div> \
		</div>';
	$('#circuits').append(tabsection);
}


function removeCircuit(circuitnum){
	validate();
	var oldcircuits = circuits;
	circuits = {
		circuit: []
	};
	circuitcount = 0;
	$.each(oldcircuits, function(i, ocir) {
		$.each(ocir, function(i, circuit) {
			//console.log(meal);
			var count = circuitcount+1;
			$('#circuit'+circuit.circuitnum).remove();
			if(circuit.circuitnum != parseFloat(circuitnum)){
				var newcir = {
					circuitnum: count,
					name: circuit.name,
					linecount: 0,
					items: [],
					notes: circuit.notes,
					time: circuit.time
				};
				addCircuit(newcir);
				$.each(circuit.items, function(i, item) {
					//console.log(item);
					addExercise([item.name, item.sets, item.reps, item.speed, item.weight, item.proteins, item.category], item.lcount, newcir.circuitnum, item.mulipiler)
				});
			}
		});
	});
	updateTotals();
}

function openModal(circuitnum){
	currentcircuit = circuitnum;
	$('#addExercise').modal('show');
}

function circuitModal(){
	$('#addCircuit').modal('show');
}

function templateModal(){
	$('#templates').modal('show');
}

function importTemplate(template){
	$('#templates').modal('hide');
	circuits = {
		circuit: []
	};
	$('#circuits').empty();
	var tempcir = template;
	console.log(template);
	circuitcount = 0;
	$.each($.parseJSON(tempcir), function(i, ocircuits) {
		$.each(ocircuits, function(i, circuit) {
			var newcircuit = {
				circuitnum: circuit.circuitnum,
				name: circuit.name,
				linecount: 0,
				items: [],
				notes: circuit.notes,
				time: circuit.time
			};
			addCircuit(newcircuit);
			$.each(circuit.items, function(i, item) {
				console.log(item);
				if(item != null){
					addExercise([item.name, item.sets, item.reps, item.speed, item.weight, item.proteins, item.category], item.lcount, circuit.circuitnum, item.mulipiler);
				}
			});
		});
	});
}

function addNewCircuit(circuit){
	$('#addCircuit').modal('hide');
	currentcircuit = circuitcount+1;
	var newcircuit = {
		circuitnum: currentcircuit,
		name: circuit.name,
		linecount: 0,
		items: [],
		notes: circuit.notes,
		time: ''
	};
	addCircuit(newcircuit);
	
	$.each(circuit.items, function(i, item) {
		addExercise([item.name, item.sets, item.reps, item.speed, item.weight, item.proteins, item.category], item.lcount, currentcircuit, item.mulipiler)
	})
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

function addExercise(exercise, line, circuit, mulipiler){
	if(!circuit){ 
		$('#search').val('');
		searchcircuit($('#token').val());
		$('#addExercise').modal('hide');
		var vals = ['','','',''];
	}
	else{
		currentcircuit = circuit;
		var vals = [exercise[1], exercise[2], exercise[3], exercise[4]];
	}
	var cssclss = getColor(exercise[6]);
	
	var speedopt = ['N/A', '1/2', '1/3', '1/4', '3/3'];
	var speed = '<select id="speed" class="speed form-control">';
	for (var i = 0; i < speedopt.length; i++) {
		var sel = '';
		if(vals[2] == speedopt[i]){
			sel = 'selected';
		}
		speed = speed + '<option '+sel+'>'+speedopt[i]+'</option>';
	}
	speed = speed + '</select>';
	
	var row = ' \
	<tr id="line'+linecount+'" class="MoveableRow"> \
		<td><span class="label '+cssclss+'">'+exercise[6]+'</span>'+exercise[0]+'</td> \
		<td> \
			<input type="text" name="sets" class="sets form-control" value="'+vals[0]+'" /> \
		</td> \
		<td> \
			<input type="text" name="reps" class="reps form-control" value="'+vals[1]+'" /> \
		</td> \
		<td>'+speed+'</td> \
		<td> \
			<input type="text" name="weight" class="weight form-control" value="'+vals[3]+'" /> \
		</td> \
		<td> \
			<button onclick="moveLine(this, '+currentcircuit+', \'up\')" data-row-id="'+circuits.circuit[currentcircuit-1].linecount+'" class="btn btn-sm btn-icon btn-flat btn-default up" type="button"> <i aria-hidden="true" class="icon wb-arrow-up"></i></button> \
			<button onclick="moveLine(this, '+currentcircuit+', \'down\')" data-row-id="'+circuits.circuit[currentcircuit-1].linecount+'" class="btn btn-sm btn-icon btn-flat btn-default down" type="button"> <i aria-hidden="true" class="icon wb-arrow-down"></i></button> \
			<button onclick="removeLine('+linecount+','+currentcircuit+')" data-original-title="Remove Line" data-toggle="tooltip" class="btn btn-sm btn-icon btn-flat btn-default removeline" type="button"> <i aria-hidden="true" class="icon wb-minus"></i></button> \
		</td> \
	</tr> \
	';
	$(row).insertBefore('#circuit'+currentcircuit+' .totals');

	
	// Auto populator
	//   $('#line'+linecount+' .reps').typeahead({
	// 	hint: true,
	// 	highlight: true,
	// 	minLength: 1
	//   }, {
	// 	name: 'repsin'+linecount,
	// 	source: substringMatcher(reps)
	//   });
	  //$('#line'+linecount+' .reps').typeahead('val', vals[1]);

	updateTotals();
	var item = {
		lcount: linecount,
		category: exercise[6],
		name: exercise[0],
		sets: vals[0],
		reps: vals[1],
		speed: vals[2],
		weight: vals[3],
		circuit: currentcircuit
	};
	var lc = circuits.circuit[currentcircuit-1].linecount;
	circuits.circuit[currentcircuit-1].items[lc] = item;
	circuits.circuit[currentcircuit-1].linecount++;
	linecount++;
}

function addMobileExercise(exercise, line, circuit, mulipiler){
	if(!circuit){ 
		$('#search').val('');
		searchcircuit($('#token').val());
		$('#addExercise').modal('hide');
		var vals = ['','','',''];
	}
	else{
		currentcircuit = circuit;
		var vals = [exercise[1], exercise[2], exercise[3], exercise[4]];
	}
	var cssclss = getColor(exercise[6]);
	
	var speedopt = ['N/A', '1/2', '1/3', '1/4', '3/3'];
	var speed = '<select id="speed" class="speed form-control">';
	for (var i = 0; i < speedopt.length; i++) {
		var sel = '';
		if(vals[2] == speedopt[i]){
			sel = 'selected';
		}
		speed = speed + '<option '+sel+'>'+speedopt[i]+'</option>';
	}
	speed = speed + '</select>';
	
	var row = ' \
	<tr id="line'+linecount+'" class="MoveableRow"> \
		<td>'+exercise[0]+'</td> \
		<td class="tablesaw-priority-1"> \
			<input type="text" name="sets" class="sets form-control" value="'+vals[0]+'" /> \
		</td> \
		<td class="tablesaw-priority-2"> \
			<input type="text" name="reps" class="reps form-control" value="'+vals[1]+'" /> \
		</td> \
		<td class="tablesaw-priority-3">'+vals[2]+'</td> \
		<td class="tablesaw-priority-4"> \
			<input type="text" name="weight" class="weight form-control" value="'+vals[3]+'" /> \
		</td> \
	</tr> \
	';
	$(row).insertBefore('#circuit'+currentcircuit+' .totals');

	
	// Auto populator
	  $('#line'+linecount+' .reps').typeahead({
		hint: true,
		highlight: true,
		minLength: 1
	  }, {
		name: 'repsin'+linecount,
		source: substringMatcher(reps)
	  });
	  //$('#line'+linecount+' .reps').typeahead('val', vals[1]);

	updateTotals();
	var item = {
		lcount: linecount,
		category: exercise[6],
		name: exercise[0],
		sets: vals[0],
		reps: vals[1],
		speed: vals[2],
		weight: vals[3],
		circuit: currentcircuit
	};
	var lc = circuits.circuit[currentcircuit-1].linecount;
	circuits.circuit[currentcircuit-1].items[lc] = item;
	circuits.circuit[currentcircuit-1].linecount++;
	linecount++;
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
function moveLine(el, cir, dir){
	var line = parseInt(el.getAttribute("data-row-id"));
	if(dir == 'up'){
		var newline = line-1;
	}
	else{
		var newline = line+1;
	}
	circuits.circuit[cir-1].items.move(line,newline);
	$("button[data-row-id='" + newline + "']").attr('data-row-id', line);
	$("button[data-row-id='" + line + "']").each(function(index, value) { 
		$(this).attr('data-row-id', newline); 
	});
}

function removeLine(line, circuit){
	$('#line'+line).remove();
	var i;
	var e = 0;
	var items = circuits.circuit[circuit-1].items;
	var newitems = [];
	for (i = 0; i < items.length; ++i) {
		if(items[i].lcount != parseFloat(line)){
			newitems[e] = items[i];
			e++;
		}
	}
	circuits.circuit[circuit-1].items = newitems;
	circuits.circuit[circuit-1].linecount--;
	updateTotals();
}

function updateTotals(){
	for (i = 1; i < circuitcount+1; ++i) {	
		for (c = 0; c < circuits.circuit[i-1].items.length; ++c) {	
			circuits.circuit[i-1].items[c].sets = $('#line'+circuits.circuit[i-1].items[c].lcount+' .sets').val();
			circuits.circuit[i-1].items[c].reps = $('#line'+circuits.circuit[i-1].items[c].lcount+' .reps').val();
			circuits.circuit[i-1].items[c].speed = $('#line'+circuits.circuit[i-1].items[c].lcount+' .speed').val();
			circuits.circuit[i-1].items[c].weight = $('#line'+circuits.circuit[i-1].items[c].lcount+' .weight').val();
		}
	}
	if(single){
		$('#circuitsinput').val(JSON.stringify(circuits.circuit[0]));
	}
	else{
		$('#circuitsinput').val(JSON.stringify(circuits));
	}
	$('#nameinput').val($('#circuit1name').val());
}

//Final Check
function validate( form ){
	// Gather Notes, Names and Times
	for (i = 1; i < circuitcount+1; ++i) {	
		circuits.circuit[i-1].notes = $('#circuit'+ i +'notes').val();
		circuits.circuit[i-1].time = $('#circuit'+ i +'time').val();
		circuits.circuit[i-1].name = $('#circuit'+ i +'name').val();
	}

	updateTotals();
	return true;
}

function massUpdate(){
	var sets = $('#updateSets').val();
	if(sets != ''){
		$('.sets').each(function(i, obj) {
			$(this).val(sets);
		});
	}
	var reps = $('#updateReps').val();
	if(reps != ''){
		$('.reps').each(function(i, obj) {
			$(this).val(reps);
		});
	}
	var speed = $( "#updateSpeed option:selected" ).text();
	if(speed != ''){
		$('.speed').each(function(i, obj) {
			$(this).val(speed);
		});
	}
}

// Auto populator
$('#updateReps').typeahead({
	hint: true,
	highlight: true,
	minLength: 1
}, {
	name: 'reps',
	source: substringMatcher(reps)
});
