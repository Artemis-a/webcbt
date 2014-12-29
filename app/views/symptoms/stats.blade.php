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
