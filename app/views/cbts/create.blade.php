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
                dateFormat: "{{ $dateformat_cal }}"
        });

        /************ Hide extra rows ************/
        for (var i = {{ $hideStart }}; i <= {{ $maxRows }}; i++) {
                $("#thoughts-" + i).hide();
                $("#feelings-" + i).hide();
                $("#symptoms-" + i).hide();
                $("#behaviours-" + i).hide();
        }

        /************ Thoughts ************/
        var addThoughtsCounter = {{ $hideStart }};
        $("#add-thoughts").click(function() {
                for (var i = 0; i <= {{ $showCount }}; i++) {
                        if (addThoughtsCounter > {{ $maxRows }}) {
                                $("#add-thoughts").hide();
                                break;
                        }
                        $("#thoughts-" + addThoughtsCounter).show();
                        addThoughtsCounter++;
                }
        });

        /************ Feelings ************/
        for (var i = 0; i <= {{ $maxRows }}; i++) {
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
                $("input[name='feelingsintensity[" + i + "]']").val($("#feelings-intensity-" + i).slider("value"));
                $("#feelings-intensity-value-" + i).text($("#feelings-intensity-" + i).slider("value"));
        }

        var addFeelingsCounter = {{ $hideStart }};
        $("#add-feelings").click(function() {
                for (var i = 0; i <= {{ $showCount }}; i++) {
                        if (addFeelingsCounter > {{ $maxRows }}) {
                                $("#add-feelings").hide();
                                break;
                        }
                        $("#feelings-" + addFeelingsCounter).show();
                        addFeelingsCounter++;
                }
        });

        /************ Symptoms ************/
        for (var i = 0; i <= {{ $maxRows }}; i++) {
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
                $("input[name='symptomsintensity[" + i + "]']").val($("#symptoms-intensity-" + i).slider("value"));
                $("#symptoms-intensity-value-" + i).text($("#symptoms-intensity-" + i).slider("value"));
        }

        var addSymptomsCounter = {{ $hideStart }};
        $("#add-symptoms").click(function() {
                for (var i = 0; i <= {{ $showCount }}; i++) {
                        if (addSymptomsCounter > {{ $maxRows }}) {
                                $("#add-symptoms").hide();
                                break;
                        }
                        $("#symptoms-" + addSymptomsCounter).show();
                        addSymptomsCounter++;
                }
        });

        /************ Behaviours ************/
        var addBehavioursCounter = {{ $hideStart }};
        $("#add-behaviours").click(function() {
                for (var i = 0; i <= {{ $showCount }}; i++) {
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

@section('page-title', 'New CBT Exercise')

@section('content')

{{ Form::open() }}

{{ Form::openGroup('date', 'Date and Time') }}
        {{ Form::text('date') }}
{{ Form::closeGroup() }}

{{ Form::openGroup('situation', 'Situation') }}
        {{ Form::textarea('situation', null, ['size' => '50x3']) }}
{{ Form::closeGroup() }}

<!-- Thoughts -->
{{ Form::label('Thoughts') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="thoughts-{{$i}}">
        {{ Form::openGroup('thoughts[' . $i . ']', '') }}
                {{ Form::text('thoughts[' . $i . ']') }}
        {{ Form::closeGroup() }}
</div>
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
                @for ($i = 0; $i <= $maxRows; $i++)
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
                @for ($i = 0; $i <= $maxRows; $i++)
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
@for ($i = 0; $i <= $maxRows; $i++)
<div id="behaviours-{{$i}}">
        {{ Form::openGroup('behaviours[' . $i . ']', '') }}
                {{ Form::text('behaviours[' . $i . ']') }}
        {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-behaviours">add more</button></div>

<br />

{{ Form::label('Tags') }}
{{ Form::openGroup('tag', '') }}
        {{ Form::select('tag', $tags_list) }}
{{ Form::closeGroup() }}

<br />

{{ Form::submit('Submit') }}
{{ HTML::linkAction('CbtsController@getIndex', 'Cancel') }}

{{ Form::close() }}

@stop
