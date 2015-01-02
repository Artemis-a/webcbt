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
        {{ $maxRows = 20 }}
        {{ $hideStart = 3 }}
        {{ $showCount = 2 }}
@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {

        /* Date and time picker */
        $('#date').datetimepicker({
                timeFormat: "hh:mm TT",
                dateFormat: "{{ explode('|', $dateformat)[1] }}"
        });

        /************ Hide extra rows ************/
        for (var i = {{$hideStart}}; i <= {{$maxRows}}; i++) {
                if ($("[name='thoughts[" + i + "]']").val() == "") {
                        $("#thoughts-" + i).hide();
                }
                if ($("[name='feelings[" + i + "]']").val() == 0) {
                        $("#feelings-" + i).hide();
                }
                if ($("[name='symptoms[" + i + "]']").val() == 0) {
                        $("#symptoms-" + i).hide();
                }
                if ($("[name='behaviours[" + i + "]']").val() == "") {
                        $("#behaviours-" + i).hide();
                }
        }

        /************ Thoughts ************/
        var addThoughtsCounter = {{$hideStart}};
        $("#add-thoughts").click(function() {
                for (var i = 0; i <= {{$showCount}}; i++) {
                        if (addThoughtsCounter > {{ $maxRows }}) {
                                $("#add-thoughts").hide();
                                break;
                        }
                        $("#thoughts-" + addThoughtsCounter).show();
                        addThoughtsCounter++;
                }
        });

        /************ Feelings ************/
        for (var i = 0; i <= {{$maxRows}}; i++) {
                $("#feelings-intensity-" + i).slider({
                        range: "min",
                        value: 0,
                        min: 0,
                        max: 10,
                        slide: function(event, ui) {
                                var sliderId = $(this).attr('id').split("-")[2];
                                $("input[name='feelingsintensity[" + sliderId + "]']").val(ui.value);
                                $("#feelings-intensity-value-" + sliderId).text(ui.value);
                        }
                });
                $("#feelings-intensity-" + i).slider("value", $("input[name='feelingsintensity[" + i + "]']").val());
                $("#feelings-intensity-value-" + i).text($("input[name='feelingsintensity[" + i + "]']").val());
        }

        var addFeelingsCounter = {{$hideStart}};
        $("#add-feelings").click(function() {
                for (var i = 0; i <= {{$showCount}}; i++) {
                        if (addFeelingsCounter > {{ $maxRows }}) {
                                $("#add-feelings").hide();
                                break;
                        }
                        $("#feelings-" + addFeelingsCounter).show();
                        addFeelingsCounter++;
                }
        });

        /************ Symptoms ************/
        for (var i = 0; i <= {{$maxRows}}; i++) {
                $("#symptoms-intensity-" + i).slider({
                        range: "min",
                        value: 0,
                        min: 0,
                        max: 10,
                        slide: function(event, ui) {
                                var sliderId = $(this).attr('id').split("-")[2];
                                $("input[name='symptomsintensity[" + sliderId + "]']").val(ui.value);
                                $("#symptoms-intensity-value-" + sliderId).text(ui.value);
                        }
                });
                $("#symptoms-intensity-" + i).slider("value", $("input[name='symptomsintensity[" + i + "]']").val());
                $("#symptoms-intensity-value-" + i).text($("input[name='symptomsintensity[" + i + "]']").val());
        }

        var addSymptomsCounter = {{$hideStart}};
        $("#add-symptoms").click(function() {
                for (var i = 0; i <= {{$showCount}}; i++) {
                        if (addSymptomsCounter > {{ $maxRows }}) {
                                $("#add-symptoms").hide();
                                break;
                        }
                        $("#symptoms-" + addSymptomsCounter).show();
                        addSymptomsCounter++;
                }
        });

        /************ Behaviours ************/
        var addBehavioursCounter = {{$hideStart}};
        $("#add-behaviours").click(function() {
                for (var i = 0; i <= {{$showCount}}; i++) {
                        if (addBehavioursCounter > {{ $maxRows }}) {
                                $("#add-behaviours").hide();
                                break;
                        }
                        $("#behaviours-" + addBehavioursCounter).show();
                        addBehavioursCounter++;
                }
        });
});

</script>

@stop

@section('page-title', 'Edit CBT Exercise')

@section('content')

{{ Form::model($cbt) }}

{{ Form::openGroup('date', 'Date and Time') }}
        {{ Form::text('date', $date) }}
{{ Form::closeGroup() }}

{{ Form::openGroup('situation', 'Situation') }}
        {{ Form::textarea('situation', null, ['size' => '50x3']) }}
{{ Form::closeGroup() }}

<!-- Thoughts -->
{{ Form::label('Thoughts') }}
@for ($i = 0; $i <= $maxRows; $i++)
        @if (isset($cbt->cbtThoughts[$i]))
                @define $index = $cbt->cbtThoughts[$i]->id
                <div id="thoughts-{{$index}}">
                {{ Form::openGroup('thoughts[' . $index . ']', '') }}
                        {{ Form::text('thoughts[' . $index . ']', $cbt->cbtThoughts[$i]->thought) }}
                {{ Form::closeGroup() }}
                </div>
        @else
                <div id="thoughts-{{$i}}">
                {{ Form::openGroup('thoughts[' . $i . ']', '') }}
                        {{ Form::text('thoughts[' . $i . ']') }}
                {{ Form::closeGroup() }}
                </div>
        @endif
@endfor
<div><button type="button" class="btn btn-default" id="add-thoughts">add more</button></div>

<!-- Feelings -->
<table class="table borderless compressed">
        <thead>
                <tr>
                        <th>Feelings</th>
                        <th class="intensity">Intensity</th>
                        <th></th>
                        <th></th>
                </tr>
        </thead>
        <tbody>
                @define $i = 0
                @foreach ($cbt->cbtFeelings as $feeling)
                        @if ($feeling->when == 'B')
                        <tr id="feelings-{{$i}}">
                                <td>
                                        {{ Form::openGroup('feelings[' . $i . ']', '') }}
                                                {{ Form::select('feelings[' . $i . ']', $feelings_list,
                                                        $feeling->feeling_id) }}
                                        {{ Form::closeGroup() }}
                                </td>
                                <td class="intensity">
                                        <div id="feelings-intensity-{{$i}}" class="slider-pad"></div>
                                </td>
                                <td width="20">
                                        <div id="feelings-intensity-value-{{$i}}"></div>
                                </td>
                                <td width="1">
                                        {{ Form::openGroup('feelingsintensity[' . $i . ']', '') }}
                                                {{ Form::hidden('feelingsintensity[' . $i . ']',
                                                        $feeling->percent) }}
                                        {{ Form::closeGroup() }}
                                </td>
                                @define $i = $i + 1
                        </tr>
                        @endif
                @endforeach

                @for (; $i <= $maxRows; $i++)
                <tr id="feelings-{{$i}}">
                        <td>
                                {{ Form::openGroup('feelings[' . $i . ']', '') }}
                                        {{ Form::select('feelings[' . $i . ']', $feelings_list) }}
                                {{ Form::closeGroup() }}
                        </td>
                        <td class="intensity">
                                <div id="feelings-intensity-{{$i}}" class="slider-pad"></div>
                        </td>
                        <td width="20">
                                <div id="feelings-intensity-value-{{$i}}"></div>
                        </td>
                        <td width="1">
                                {{ Form::openGroup('feelingsintensity[' . $i . ']', '') }}
                                        {{ Form::hidden('feelingsintensity[' . $i . ']') }}
                                {{ Form::closeGroup() }}
                        </td>
                </tr>
                @endfor

                <tr>
                        <td><button type="button" class="btn btn-default" id="add-feelings">add more</button></td>
                </tr>
        </tbody>
</table>

<!-- Symptoms -->
<table class="table borderless compressed">
        <thead>
                <tr>
                        <th>Physical Symptoms</th>
                        <th class="intensity">Intensity</th>
                        <th></th>
                        <th></th>
                </tr>
        </thead>
        <tbody>
                @define $i = 0
                @foreach ($cbt->cbtSymptoms as $symptom)
                        @if ($symptom->when == 'B')
                        <tr id="symptoms-{{$i}}">
                                <td>
                                        {{ Form::openGroup('symptoms[' . $i . ']', '') }}
                                                {{ Form::select('symptoms[' . $i . ']', $symptoms_list,
                                                        $symptom->symptom_id ) }}
                                        {{ Form::closeGroup() }}
                                </td>
                                <td class="intensity">
                                        <div id="symptoms-intensity-{{$i}}" class="slider-pad"></div>
                                </td>
                                <td width="20">
                                        <div id="symptoms-intensity-value-{{$i}}"></div>
                                </td>
                                <td width="1">
                                        {{ Form::openGroup('symptomsintensity[' . $i . ']', '') }}
                                                {{ Form::hidden('symptomsintensity[' . $i . ']',
                                                        $symptom->percent ) }}
                                        {{ Form::closeGroup() }}
                                </td>
                                @define $i = $i + 1
                        </tr>
                        @endif
                @endforeach

                @for (; $i <= $maxRows; $i++)
                <tr id="symptoms-{{$i}}">
                        <td>
                                {{ Form::openGroup('symptoms[' . $i . ']', '') }}
                                        {{ Form::select('symptoms[' . $i . ']', $symptoms_list) }}
                                {{ Form::closeGroup() }}
                        </td>
                        <td class="intensity">
                                <div id="symptoms-intensity-{{$i}}" class="slider-pad"></div>
                        </td>
                        <td width="20">
                                <div id="symptoms-intensity-value-{{$i}}"></div>
                        </td>
                        <td width="1">
                                {{ Form::openGroup('symptomsintensity[' . $i . ']', '') }}
                                        {{ Form::hidden('symptomsintensity[' . $i . ']') }}
                                {{ Form::closeGroup() }}
                        </td>
                </tr>
                @endfor

                <tr>
                        <td><button type="button" class="btn btn-default" id="add-symptoms">add more</button></td>
                </tr>
        </tbody>
</table>

<!-- Behaviours -->
{{ Form::label('Behaviours') }}

@define $i = 0
@foreach ($cbt->cbtBehaviours as $behaviour)
        @if ($behaviour->when == 'B')
        <div id="behaviours-{{$i}}">
                {{ Form::openGroup('behaviours[' . $i . ']', '') }}
                        {{ Form::text('behaviours[' . $i . ']', $behaviour->behaviour) }}
                {{ Form::closeGroup() }}
                @define $i = $i + 1
        </div>
        @endif
@endforeach

@for (; $i <= $maxRows; $i++)
<div id="behaviours-{{$i}}">
        {{ Form::openGroup('behaviours[' . $i . ']', '') }}
                {{ Form::text('behaviours[' . $i . ']') }}
        {{ Form::closeGroup() }}
</div>
@endfor

<div><button type="button" class="btn btn-default" id="add-behaviours">add more</button></div>

<br />

{{ Form::submit('Submit') }}
{{ HTML::linkAction('CbtsController@getIndex', 'Cancel') }}

{{ Form::close() }}

@stop
