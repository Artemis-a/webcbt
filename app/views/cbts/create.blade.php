@extends('layouts.master')

@section('define')
        {{ $maxRows = 20 }}
@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {

        /* Date and time picker */
        $('#date').datetimepicker({
                timeFormat: "hh:mm TT",
                dateFormat: "dd M yy"
        });

        /************ Thoughts ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#tr-thoughts-{{$i}}").hide();
        @endfor

        var addThoughtsCounter = 3;
        $("#add-thoughts").click(function() {
                for (var i = 0; i <= 3; i++) {
                        if (addThoughtsCounter > {{ $maxRows }}) {
                                $("#add-thoughts").hide();
                                break;
                        }
                        $("#tr-thoughts-" + addThoughtsCounter).show();
                        addThoughtsCounter++;
                }
        });

        /************ Feelings ************/
        @for ($i = 0; $i <= $maxRows; $i++)
                $("#slider-intensity-{{$i}}").slider({
                        range: "min",
                        value: 0,
                        min: 0,
                        max: 10,
                        slide: function(event, ui) {
                                $("input[name='intensity[{{$i}}]']").val(ui.value);
                                $("#slider-intensity-value-{{$i}}").text(ui.value);
                        }
                });
                $("input[name='intensity[{{$i}}]']").val($("#slider-intensity-{{$i}}").slider("value"));
                $("#slider-intensity-value-{{$i}}").text($("#slider-intensity-{{$i}}").slider("value"));
        @endfor

        @for ($i = 3; $i <= $maxRows; $i++)
                $("#tr-feelings-{{$i}}").hide();
        @endfor

        var addFeelingsCounter = 3;
        $("#add-feelings").click(function() {
                for (var i = 0; i <= 3; i++) {
                        if (addFeelingsCounter > {{ $maxRows }}) {
                                $("#add-feelings").hide();
                                break;
                        }
                        $("#tr-feelings-" + addFeelingsCounter).show();
                        addFeelingsCounter++;
                }
        });

        /************ Behaviours ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#tr-behaviours-{{$i}}").hide();
        @endfor

        var addBehavioursCounter = 3;
        $("#add-behaviours").click(function() {
                for (var i = 0; i <= 3; i++) {
                        if (addBehavioursCounter > {{ $maxRows }}) {
                                $("#add-behaviours").hide();
                                break;
                        }
                        $("#tr-behaviours-" + addBehavioursCounter).show();
                        addBehavioursCounter++;
                }
        });
});

</script>

@stop

@section('page-title', 'Create a new CBT exercise entry')

@section('content')

{{ Form::open() }}

{{ Form::openGroup('date', 'Date and Time') }}
        {{ Form::text('date') }}
{{ Form::closeGroup() }}

{{ Form::openGroup('situation', 'Situation') }}
        {{ Form::textarea('situation') }}
{{ Form::closeGroup() }}

{{ Form::label('Thoughts') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="tr-thoughts-{{$i}}">
                {{ Form::openGroup('thoughts[' . $i . ']', '') }}
                        {{ Form::text('thoughts[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-thoughts">add more</button></div>

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
                <tr id="tr-feelings-{{$i}}">
                        <td>
                                {{ Form::openGroup('feelings[' . $i . ']', '') }}
                                {{ Form::select('feelings[' . $i . ']', $emotions_list) }}
                                {{ Form::closeGroup() }}
                        </td>
                        <td class="intensity">
                                <div id="slider-intensity-{{$i}}" class="slider-pad"></div>
                        </td>
                        <td width="20">
                                <div id="slider-intensity-value-{{$i}}"></div>
                        </td>
                        <td width="1">
                                {{ Form::openGroup('intensity[' . $i . ']', '') }}
                                {{ Form::hidden('intensity[' . $i . ']') }}
                                {{ Form::closeGroup() }}
                        </td>
                </tr>
                @endfor
                <tr>
                        <td><button type="button" class="btn btn-default" id="add-feelings">add more</button></td>
                </tr>
        </tbody>
</table>

{{ Form::label('Behaviour') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="tr-behaviours-{{$i}}">
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
