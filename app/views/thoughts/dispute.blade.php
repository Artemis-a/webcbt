@extends('layouts.master')

@section('define')
        {{ $maxRows = 2 }}
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


    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });


});

</script>

@stop

@section('page-title', 'Dispute thoughts')

@section('content')

<div class="alert alert-danger" role="alert">
        <span class="dispute-title">Irrational thought to dispute : &ldquo;{{ $thought['thought'] }}&rdquo;</span>
</div>

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

<!-- BHOECHIE TAB START -->

<div class="row">
<div class="bhoechie-tab-element">
<div class="col-xs-12 bhoechie-tab-container">

<div class="col-xs-2 bhoechie-tab-menu">
<div class="list-group">

<a href="#" class="list-group-item active text-center">
<div class="tab-menu-title">What's the evidence ?</div>
</a>

<a href="#" class="list-group-item text-center">
<div class="tab-menu-title">Experiments</div>
</a>

<a href="#" class="list-group-item text-center">
<div class="tab-menu-title">Double-Standard method</div>
</a>

<a href="#" class="list-group-item text-center">
<div class="tab-menu-title">Survey</div>
</a>

<a href="#" class="list-group-item text-center">
<div class="tab-menu-title">What do I mean by...</div>
</a>

<a href="#" class="list-group-item text-center">
<div class="tab-menu-title">Cost-Benifit analysis</div>
</a>

<a href="#" class="list-group-item text-center">
<div class="tab-menu-title">What if it was true ?</div>
</a>

<a href="#" class="list-group-item text-center">
<div class="tab-menu-title">Re-attribution</div>
</a>

<a href="#" class="list-group-item text-center">
<div class="tab-menu-title">Re-framing</div>
</a>

<a href="#" class="list-group-item text-center">
<div class="tab-menu-title">Rationalize</div>
</a>

</div><!-- END list-group -->
</div><!-- END bhoechie-tab-menu -->

<div class="col-xs-9 bhoechie-tab">

<!-- Evidence section -->
<div class="bhoechie-tab-content active">

<div class="tab-content-title">What's the evidence ?</div>

{{ Form::rawLabel('What are the evidences (facts / observtaions) that support the thought ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="forevidences-{{$i}}">
                {{ Form::openGroup('forevidences[' . $i . ']', '') }}
                        {{ Form::text('forevidences[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-forevidences">add more</button></div>

<br />

{{ Form::rawLabel('What are the evidences (facts / observtaions) against the thought ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="againstevidences-{{$i}}">
                {{ Form::openGroup('againstevidences[' . $i . ']', '') }}
                        {{ Form::text('againstevidences[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-againstevidences">add more</button></div>

</div>

<!-- Experiments section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Experiments</div>

{{ Form::rawLabel('What experiments can I do to test the validity of the thought ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="validity-{{$i}}">
                {{ Form::openGroup('validity[' . $i . ']', '') }}
                        {{ Form::text('validity[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-validity">add more</button></div>

<br />

{{ Form::rawLabel('What was the results of the experiments ?') }}
{{ Form::openGroup('validityresult', '') }}
        {{ Form::textarea('validityresult', null, ['size' => '50x3']) }}
{{ Form::closeGroup() }}

</div>

<!-- Double-Standards section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Double-Standard method</div>

{{ Form::rawLabel('What would I say to a friend who is in the same situation or facing the same problem ?') }}
{{ Form::openGroup('doublestandard', '') }}
        {{ Form::textarea('doublestandard', null, ['size' => '50x10']) }}
{{ Form::closeGroup() }}

</div>

<!-- Survey section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Survey</div>

{{ Form::rawLabel('What questions can I ask people to find out if the thought or attitude is valid ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="survey-{{$i}}">
                {{ Form::openGroup('survey[' . $i . ']', '') }}
                        {{ Form::text('survey[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-validity">add more</button></div>

<br />

{{ Form::rawLabel('What was the results of the survey ?') }}
{{ Form::openGroup('surveyresult', '') }}
        {{ Form::textarea('surveyresult', null, ['size' => '50x3']) }}
{{ Form::closeGroup() }}

</div>

<!-- What do I mean by section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">What do I mean by...</div>

<table class="table">
<tr>

<td width="80px">
{{ Form::rawLabel('Labels') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="forbenifit-{{$i}}">
                {{ Form::openGroup('forbenifit[' . $i . ']', '') }}
                        {{ Form::text('forbenifit[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-forbenifit">add more</button></div>
</td>

<td>
{{ Form::rawLabel('What do I really mean by it ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="againstbenifit-{{$i}}">
                {{ Form::openGroup('againstbenifit[' . $i . ']', '') }}
                        {{ Form::text('againstbenifit[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
</td>

</tr>
</table>

</div>

<!-- Cost-Benifit section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Cost-Benifit analysis</div>

<table class="table">
<tr>

<td>
{{ Form::rawLabel('What are the advantedges of believing the thought ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="forbenifit-{{$i}}">
                {{ Form::openGroup('forbenifit[' . $i . ']', '') }}
                        {{ Form::text('forbenifit[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-forbenifit">add more</button></div>
</td>

<td>
{{ Form::rawLabel('What are the dis-advantedges of believing the thought ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="againstbenifit-{{$i}}">
                {{ Form::openGroup('againstbenifit[' . $i . ']', '') }}
                        {{ Form::text('againstbenifit[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-againstbenifit">add more</button></div>
</td>

</tr>
</table>

</div>

<!-- What if it was true section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">What if it was true ?</div>

@for ($i = 0; $i <= $maxRows; $i++)
<div id="true-{{$i}}">
        @if ($i != 0)
                <center><i class="glyphicon glyphicon-arrow-down"></i></center><br />
        @endif
        {{ Form::rawLabel('If it was true what would it mean to me ? Why would it be so upsetting to me ?') }}
        {{ Form::openGroup('true[' . $i . ']', '') }}
                {{ Form::text('true[' . $i . ']') }}
        {{ Form::closeGroup() }}
</div>
@endfor

</div>

<!-- Re-attribution section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Re-attribution</div>

{{ Form::rawLabel('What other factors might have contributed to the problem ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="reattributes-{{$i}}">
                {{ Form::openGroup('reattributes[' . $i . ']', '') }}
                        {{ Form::text('reattributes[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-reattributes">add more</button></div>

</div>

<!-- Re-framing section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Re-framing</div>

{{ Form::rawLabel('Substitute language what is less colorfull and emotionally loaded.') }}
{{ Form::rawLabel('Relace all should\'s, must\'s, have to\'s, etc with words like want to, prefer to, like to, etc.') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="reattributes-{{$i}}">
                {{ Form::openGroup('reattributes[' . $i . ']', '') }}
                        {{ Form::text('reattributes[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-reattributes">add more</button></div>

</div>

<!-- Rationalize section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Rationalize</div>

{{ Form::rawLabel('What are the more realistic / rational / less extreme ways of looking at it ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="rational-{{$i}}">
                {{ Form::openGroup('rational[' . $i . ']', '') }}
                        {{ Form::text('rational[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-rational">add more</button></div>

</div>

</div><!-- END bhoechie-tab -->

</div><!-- END bhoechie-tab-container -->
</div><!-- END bhoechie-tab-element -->
</div><!-- END row -->

<!-- BHOECHIE TAB END -->

{{ Form::label('More balanced thoughts') }}
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
