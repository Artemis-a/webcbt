{{--

The MIT License (MIT)

WebCBT - Web based Cognitive Behavioral Therapy tool

http://mindtools.github.io/webcbt/

Copyright (c) 2014 Prashant Shah <pshah.mindtools@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

--}}

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

@section('page-title', 'Physical Symptom Statistics')

@section('content')

{{ HTML::linkAction('SymptomsController@getIndex', 'Back', array(), array('class' => 'btn btn-primary')) }}

<br />
<br />

<div>
        <div class="chart-title">Before Statistics - {{ $symptom->name }}</div>
	<canvas id="beforeChart"></canvas>
</div>
<br /><br />
<div>
        <div class="chart-title">After Statistics - {{ $symptom->name }}</div>
	<canvas id="afterChart"></canvas>
</div>

<script>

var before_dataset = [
@foreach ($before_dataset as $data)
        "{{ $data->percent }}",
@endforeach
];

var before_labelset = [
@foreach ($before_dataset as $data)
        "{{ date_format(date_create_from_format('Y-m-d H:i:s', $data->date), explode('|', $dateformat)[0]) }}",
@endforeach
];

var after_dataset = [
@foreach ($after_dataset as $data)
        "{{ $data->percent }}",
@endforeach
];

var after_labelset = [
@foreach ($after_dataset as $data)
        "{{ date_format(date_create_from_format('Y-m-d H:i:s', $data->date), explode('|', $dateformat)[0]) }}",
@endforeach
];

var beforeChartData = {
	labels : before_labelset,
	datasets : [
		{
			label: "{{ $symptom->name }}",
			fillColor : "rgba(151,187,205,0.4)",
			strokeColor : "rgba(151,187,205,1)",
			pointColor : "rgba(151,187,205,1)",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(151,187,205,1)",
			data : before_dataset
		}
	]

}

var afterChartData = {
	labels : after_labelset,
	datasets : [
		{
			label: "{{ $symptom->name }}",
			fillColor : "rgba(151,187,205,0.4)",
			strokeColor : "rgba(151,187,205,1)",
			pointColor : "rgba(151,187,205,1)",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(151,187,205,1)",
			data : after_dataset
		}
	]

}

window.onload = function(){
	var beforeCtx = document.getElementById("beforeChart").getContext("2d");
	window.beforeChart = new Chart(beforeCtx).Bar(beforeChartData, {
		responsive: true,
                scaleOverride : true,
                scaleSteps : 10,
                scaleStepWidth : 1,
                scaleStartValue : 0,
                barValueSpacing: 5
	});

	var afterCtx = document.getElementById("afterChart").getContext("2d");
	window.afterChart = new Chart(afterCtx).Bar(afterChartData, {
		responsive: true,
                scaleOverride : true,
                scaleSteps : 10,
                scaleStepWidth : 1,
                scaleStartValue : 0,
                barValueSpacing: 5
	});
}


</script>

@stop
