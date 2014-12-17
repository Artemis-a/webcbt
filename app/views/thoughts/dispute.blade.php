@extends('layouts.master')

@section('define')
        {{ $maxRows = 20 }}
@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {

        /************ Distortions ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#distortions-{{$i}}").hide();
        @endfor

        var addDistortions = 3;
        $("#add-distortions").click(function() {
                for (var i = 0; i <= 2; i++) {
                        if (addDistortions > {{ $maxRows }}) {
                                $("#add-distortions").hide();
                                break;
                        }
                        $("#distortions-" + addDistortions).show();
                        addDistortions++;
                }
        });

        /************ Balanced thoughts ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#balanced-thoughts-{{$i}}").hide();
        @endfor

        var addBalancedThoughts = 3;
        $("#add-balanced-thoughts").click(function() {
                for (var i = 0; i <= 2; i++) {
                        if (addBalancedThoughts > {{ $maxRows }}) {
                                $("#add-balanced-thoughts").hide();
                                break;
                        }
                        $("#balanced-thoughts-" + addBalancedThoughts).show();
                        addBalancedThoughts++;
                }
        });

});

</script>

@stop

@section('page-title', 'Dispute thoughts')

@section('content')

<button type="button" class="btn btn-danger">
        <span class="dispute-title">Irrational thought to dispute : &ldquo; {{ $thought['thought'] }} &rdquo;</span>
</button>

<br />
<br />

{{ Form::open() }}

{{ Form::label('Distortions') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="distortions-{{$i}}">
                {{ Form::openGroup('distortions[' . $i . ']', '') }}
                        {{ Form::select('distortions[' . $i . ']', $distortions_list) }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-distortions">add more</button></div>

<br />

{{ Form::label('Methods to dispute irrational thoughts') }}
<br />
<br />
<div class="row dispute-container">
<ul class="nav nav-pills nav-stacked col-md-2">
        <li class="active"><a href="#tab_evidence" data-toggle="pill">What's the evidence ?</a></li>
        <li><a href="#tab_validation" data-toggle="pill">Validation experiment</a></li>
        <li><a href="#tab_survey" data-toggle="pill">Survey</a></li>
        <li><a href="#tab_mean" data-toggle="pill">What do I mean by ...</a></li>
        <li><a href="#tab_costbenifit" data-toggle="pill">Cost-Benifit analysis</a></li>
        <li><a href="#tab_true" data-toggle="pill">What if it was true ?</a></li>
        <li><a href="#tab_reattribution" data-toggle="pill">Re-attribution</a></li>
        <li><a href="#tab_reality" data-toggle="pill">Reality check</a></li>
        <li><a href="#tab_reframe" data-toggle="pill">Re-framing</a></li>
        <li><a href="#tab_rationalize" data-toggle="pill">Rationalize</a></li>
</ul>
<div class="tab-content col-md-10">
        <div class="tab-pane active" id="tab_evidence">
                <h4>What's the evidence ?</h4>
        </div>
        <div class="tab-pane" id="tab_validation">
                <h4>Validation experiment</h4>
        </div>
        <div class="tab-pane" id="tab_survey">
                <h4>Survey</h4>
        </div>
        <div class="tab-pane" id="tab_mean">
                <h4>What do I mean by ...</h4>
        </div>
        <div class="tab-pane" id="tab_costbenifit">
                <h4>Cost-Benifit analysis</h4>
        </div>
        <div class="tab-pane" id="tab_true">
                <h4>What if it was true ?</h4>
        </div>
        <div class="tab-pane" id="tab_reattribution">
                <h4>Re-attribution</h4>
        </div>
        <div class="tab-pane" id="tab_reality">
                <h4>Reality check</h4>
        </div>
        <div class="tab-pane" id="tab_reframe">
                <h4>Re-framing</h4>
        </div>
        <div class="tab-pane" id="tab_rationalize">
                <h4>Rationalize</h4>
        </div>
</div>
</div>

<br />

{{ Form::label('Balanced thoughts') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="balanced-thoughts-{{$i}}">
                {{ Form::openGroup('balancedthoughts[' . $i . ']', '') }}
                        {{ Form::text('balancedthoughts[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-balanced-thoughts">add more</button></div>

<br />

{{ Form::submit('Submit') }}
{{ HTML::linkAction('CbtsController@getIndex', 'Cancel') }}

{{ Form::close() }}

@stop
