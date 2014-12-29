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
@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {

        /************ Feelings ************/
        @for ($i = 0; $i <= $maxRows; $i++)
                $("#feelings-intensity-{{$i}}").slider({
                        range: "min",
                        value: 0,
                        min: 0,
                        max: 10,
                        slide: function(event, ui) {
                                $("input[name='feelingsintensity[{{$i}}]']").val(ui.value);
                                $("#feelings-intensity-value-{{$i}}").text(ui.value);
                        }
                });
                $("input[name='feelingsintensity[{{$i}}]']").val($("#feelings-intensity-{{$i}}").slider("value"));
                $("#feelings-intensity-value-{{$i}}").text($("#feelings-intensity-{{$i}}").slider("value"));
        @endfor

        @for ($i = 3; $i <= $maxRows; $i++)
                $("#feelings-{{$i}}").hide();
        @endfor

        var addFeelingsCounter = 3;
        $("#add-feelings").click(function() {
                for (var i = 0; i <= 2; i++) {
                        if (addFeelingsCounter > {{ $maxRows }}) {
                                $("#add-feelings").hide();
                                break;
                        }
                        $("#feelings-" + addFeelingsCounter).show();
                        addFeelingsCounter++;
                }
        });

        /************ Symptoms ************/
        @for ($i = 0; $i <= $maxRows; $i++)
                $("#symptoms-intensity-{{$i}}").slider({
                        range: "min",
                        value: 0,
                        min: 0,
                        max: 10,
                        slide: function(event, ui) {
                                $("input[name='symptomsintensity[{{$i}}]']").val(ui.value);
                                $("#symptoms-intensity-value-{{$i}}").text(ui.value);
                        }
                });
                $("input[name='symptomsintensity[{{$i}}]']").val($("#symptoms-intensity-{{$i}}").slider("value"));
                $("#symptoms-intensity-value-{{$i}}").text($("#symptoms-intensity-{{$i}}").slider("value"));
        @endfor

        @for ($i = 3; $i <= $maxRows; $i++)
                $("#symptoms-{{$i}}").hide();
        @endfor

        var addSymptomsCounter = 3;
        $("#add-symptoms").click(function() {
                for (var i = 0; i <= 2; i++) {
                        if (addSymptomsCounter > {{ $maxRows }}) {
                                $("#add-symptoms").hide();
                                break;
                        }
                        $("#symptoms-" + addSymptomsCounter).show();
                        addSymptomsCounter++;
                }
        });

        /************ Behaviours ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#behaviours-{{$i}}").hide();
        @endfor

        var addBehavioursCounter = 3;
        $("#add-behaviours").click(function() {
                for (var i = 0; i <= 2; i++) {
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

@section('page-title', 'Post-dispute')

@section('content')

{{ Form::open() }}

<table class="table borderless compressed">
        <thead>
                <tr>
                        <th>New Feelings</th>
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

<table class="table borderless compressed">
        <thead>
                <tr>
                        <th>New Physical Symptoms</th>
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


{{ Form::label('New Behaviours') }}
@for ($i = 0; $i <= $maxRows; $i++)
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
