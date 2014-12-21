@extends('layouts.master')

@section('define')
        {{ $count = 1 }}
@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {
});

</script>

@stop

@section('page-title', 'Physical Symptom')

@section('content')

{{ HTML::linkAction('SymptomsController@getIndex', 'Back', array(), array('class' => 'btn btn-primary')) }}

<br />
<br />

<div class="secondary-title">{{ $symptom['name'] }} Stats</div>

<div>
	<canvas id="canvas" height="" width="500"></canvas>
</div>

<script>

var dataset = [
@foreach ($rawdataset as $data)
        "{{ $data['percent']}}",
@endforeach
];

var labelset = [
@foreach ($rawdataset as $data)
        "{{ $count++ }}",
@endforeach
];

var barChartData = {
	labels : labelset,
	datasets : [
		{
			label: "{{ $symptom['name'] }}",
			fillColor : "rgba(151,187,205,0.4)",
			strokeColor : "rgba(151,187,205,1)",
			pointColor : "rgba(151,187,205,1)",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(151,187,205,1)",
			data : dataset
		}
	]

}

window.onload = function(){
	var ctx = document.getElementById("canvas").getContext("2d");
	window.barChart = new Chart(ctx).Bar(barChartData, {
		responsive: true,
                scaleOverride : true,
                scaleSteps : 10,
                scaleStepWidth : 1,
                scaleStartValue : 0
	});
}


</script>

@stop
