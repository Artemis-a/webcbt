{{--

The MIT License (MIT)

WebCBT - Web based Cognitive Behavioral Therapy tool

http://webcbt.github.io

Copyright (c) 2014 Prashant Shah <pshah.webcbt@gmail.com>

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

@section('head')

<script type="text/javascript">

$(document).ready(function() {
});

</script>

@stop

@section('page-title', 'Statistics')

@section('content')

<table class="table-centered text-center stats-table">
        <tr>
                <td colspan="2">
                        <div class="text-center">
                                <div class="chart-title">Distortions Statistics</div>
                        	<canvas id="distortionsCountChart" width="800px" height="700px"></canvas>
                        </div>
                </td>
        </tr>
        <tr>
                <td>
                        <div>
                                <div class="chart-title">Resolved Vs Unresolved CBT Exercises</div>
                        	<canvas id="resolvedChart" height="200px"></canvas>
                        </div>
                </td>
                <td>
                        <div>
                                <div class="chart-title">Disputed Vs Undisputed Thoughts</div>
                        	<canvas id="disputedChart" height="200px"></canvas>
                        </div>
                </td>
        </tr>
        <tr>
                <td>
                        <div>
                                <div class="chart-title">Feelings Count</div>
                        	<canvas id="feelingCountChart" height="600px"></canvas>
                        </div>
                </td>
                <td>
                        <div>
                                <div class="chart-title">Feelings Average</div>
                        	<canvas id="feelingAverageChart" height="600px"></canvas>
                        </div>
                </td>
        </tr>
        <tr>
                <td>
                        <div>
                                <div class="chart-title">Physical Symptoms Count</div>
                        	<canvas id="symptomCountChart" height="600px"></canvas>
                        </div>
                </td>
                <td>
                        <div>
                                <div class="chart-title">Physical Symptoms Average</div>
                        	<canvas id="symptomAverageChart" height="600px"></canvas>
                        </div>
                </td>
        </tr>
</table>

<script type="text/javascript">

/******************************************************************************/
/******************************** DISTORTIONS *********************************/
/******************************************************************************/

var distortionsCountChartData = {
	labels : {{ $distortions_count['labelset'] }},
	datasets : [
		{
			label: "Distortions",
                        fillColor: "rgba(220,220,220,0.5)",
                        strokeColor: "rgba(220,220,220,0.8)",
                        highlightFill: "rgba(220,220,220,0.75)",
                        highlightStroke: "rgba(220,220,220,1)",
			data : {{ $distortions_count['dataset'] }},
		}
	]

};

/******************************************************************************/
/******************************** PIE CHARTS **********************************/
/******************************************************************************/

var resolvedChartData = [
        {
                value: {{ $unresolved_count }},
                color: "#F7464A",
                highlight: "#FF5A5E",
                label: "Unresolved"
        },
        {
                value: {{ $resolved_count }},
                color: "#46BFBD",
                highlight: "#5AD3D1",
                label: "Resolved"
        },
];

var disputedChartData = [
        {
                value: {{ $undisputed_count }},
                color: "#F7464A",
                highlight: "#FF5A5E",
                label: "Undisputed Thoughts"
        },
        {
                value: {{ $disputed_count }},
                color: "#46BFBD",
                highlight: "#5AD3D1",
                label: "Disputed Thoughts"
        },
];

/******************************************************************************/
/********************************** FEELINGS **********************************/
/******************************************************************************/

var feelingsCountChartData = {
	labels : {{ $feelings_count['labelset'] }},
	datasets : [
		{
			label: "Before",
                        fillColor: "rgba(220,220,220,0.5)",
                        strokeColor: "rgba(220,220,220,0.8)",
                        highlightFill: "rgba(220,220,220,0.75)",
                        highlightStroke: "rgba(220,220,220,1)",
			data : {{ $feelings_count['before']['dataset'] }},
		},
		{
			label: "After",
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
			data : {{ $feelings_count['after']['dataset'] }},
		}
	]

};

var feelingsAverageChartData = {
	labels : {{ $feelings_average['labelset'] }},
	datasets : [
		{
			label: "Before",
                        fillColor: "rgba(220,220,220,0.5)",
                        strokeColor: "rgba(220,220,220,0.8)",
                        highlightFill: "rgba(220,220,220,0.75)",
                        highlightStroke: "rgba(220,220,220,1)",
			data : {{ $feelings_average['before']['dataset'] }},
		},
		{
			label: "After",
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
			data : {{ $feelings_average['after']['dataset'] }},
		}
	]

};

/******************************************************************************/
/********************************** SYMPTOMS **********************************/
/******************************************************************************/

var symptomsCountChartData = {
	labels : {{ $symptoms_count['labelset'] }},
	datasets : [
		{
			label: "Before",
                        fillColor: "rgba(220,220,220,0.5)",
                        strokeColor: "rgba(220,220,220,0.8)",
                        highlightFill: "rgba(220,220,220,0.75)",
                        highlightStroke: "rgba(220,220,220,1)",
			data : {{ $symptoms_count['before']['dataset'] }},
		},
		{
			label: "After",
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
			data : {{ $symptoms_count['after']['dataset'] }},
		}
	]

};

var symptomsAverageChartData = {
	labels : {{ $symptoms_average['labelset'] }},
	datasets : [
		{
			label: "Before",
                        fillColor: "rgba(220,220,220,0.5)",
                        strokeColor: "rgba(220,220,220,0.8)",
                        highlightFill: "rgba(220,220,220,0.75)",
                        highlightStroke: "rgba(220,220,220,1)",
			data : {{ $symptoms_average['before']['dataset'] }},
		},
		{
			label: "After",
                        fillColor: "rgba(151,187,205,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(151,187,205,0.75)",
                        highlightStroke: "rgba(151,187,205,1)",
			data : {{ $symptoms_average['after']['dataset'] }},
		}
	]

};

window.onload = function(){

        /*************************** DISTORTIONS ******************************/

	var distortionsCountCtx = document.getElementById("distortionsCountChart").getContext("2d");
	window.distortionsCountChart = new Chart(distortionsCountCtx).Bar(distortionsCountChartData, {
		responsive: false,
                scaleOverride : false,
                scaleStartValue : 0,
	});

        /**************************** PIE CHART *******************************/

        var resolvedChartCtx = document.getElementById("resolvedChart").getContext("2d");
        var resolvedChart = new Chart(resolvedChartCtx).Pie(resolvedChartData, {});

        var disputedChartCtx = document.getElementById("disputedChart").getContext("2d");
        var disputedChart = new Chart(disputedChartCtx).Pie(disputedChartData, {});

        /***************************** FEELINGS *******************************/

	var feelingCountCtx = document.getElementById("feelingCountChart").getContext("2d");
	window.feelingCountChart = new Chart(feelingCountCtx).Bar(feelingsCountChartData, {
		responsive: false,
                scaleOverride : false,
                scaleStartValue : 0,
	});

	var feelingAverageCtx = document.getElementById("feelingAverageChart").getContext("2d");
	window.feelingAverageChart = new Chart(feelingAverageCtx).Bar(feelingsAverageChartData, {
		responsive: false,
                scaleOverride : false,
                scaleStartValue : 0,
	});

        /***************************** SYMPTOMS *******************************/

	var symptomCountCtx = document.getElementById("symptomCountChart").getContext("2d");
	window.symptomCountChart = new Chart(symptomCountCtx).Bar(symptomsCountChartData, {
		responsive: false,
                scaleOverride : false,
                scaleStartValue : 0,
	});

	var symptomAverageCtx = document.getElementById("symptomAverageChart").getContext("2d");
	window.symptomAverageChart = new Chart(symptomAverageCtx).Bar(symptomsAverageChartData, {
		responsive: false,
                scaleOverride : false,
                scaleStartValue : 0,
	});

}

</script>

@stop
