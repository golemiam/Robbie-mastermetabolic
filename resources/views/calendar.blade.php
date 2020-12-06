@extends('layouts.dashboard')

@section('pagetitle')
{{ Auth::user()->name }} Calendar
@endsection

@section('content')

<!-- Display Validation Errors -->
@include('common.errors')

	
	<?php
	if(Auth::user()->calendar == ''){
	
		$events = array();
		$current_time = new DateTime();
		foreach($users as $c){
			foreach($c->sessions as $s){
				if($s['time'] == ''){
					$time = new DateTime($s['date'].'T'.'00:00:00');
					$date = $time->format('Y-m-d');
				}
				else{
					$dateString = $s['date'].' '.$s['time'];
					$time = DateTime::createFromFormat('m/d/Y g:ia', $dateString);
					$date = $time->format('Y-m-d H:i:s');
				}
				if($time < $current_time){
					$color = 'lightgrey';
				}
				else{
					$color = '#62a8ea';			
				}
				$event = array(
					'title' => $c['name'],
					'start' => $date,
					'backgroundColor' => $color,
					'borderColor' => $color,
				);
				array_push($events, $event);
			}
		}
		?>
		<div class="padding-30" id="calendar"></div>
		<script>
		var my_events = <?php echo json_encode($events); ?>;
		</script>
		
	<?php } 
	else{
		echo '<div class="padding-30" id="calendar"><iframe src="https://calendar.google.com/calendar/embed?src='.Auth::user()->calendar.'&ctz=America/Denver" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe></div>';
	}
	
	?>


@endsection

@section('scripts')
    <script src="/js/app.js"></script>
    <?php if(Auth::user()->calendar == ''){echo '<script src="/js/mycalendar.js"></script>';} ?>
    <link rel="stylesheet" href="/examples/css/apps/calendar.css">
@endsection