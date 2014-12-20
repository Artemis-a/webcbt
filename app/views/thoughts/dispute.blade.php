@extends('layouts.master')

@section('define')
        {{ $maxRows = 20 }}
@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {

        $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
                $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
        });

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
                $("#balancedthoughts-{{$i}}").hide();
        @endfor

        var addBalancedThoughts = 3;
        $("#add-balancedthoughts").click(function() {
                for (var i = 0; i <= 2; i++) {
                        if (addBalancedThoughts > {{ $maxRows }}) {
                                $("#add-balancedthoughts").hide();
                                break;
                        }
                        $("#balancedthoughts-" + addBalancedThoughts).show();
                        addBalancedThoughts++;
                }
        });

        /************** DISPUTE START **************/

        /************ forevidence ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#forevidence-{{$i}}").hide();
        @endfor
        var forevidence = 3;
        $("#add-forevidence").click(function() {
                if (forevidence > {{ $maxRows }}) {
                        $("#add-forevidence").hide();
                        return;
                }
                $("#forevidence-" + forevidence).show();
                forevidence++;
        });
        /************ againstevidence ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#againstevidence-{{$i}}").hide();
        @endfor
        var againstevidence = 3;
        $("#add-againstevidence").click(function() {
                if (againstevidence > {{ $maxRows }}) {
                        $("#add-againstevidence").hide();
                        return;
                }
                $("#againstevidence-" + againstevidence).show();
                againstevidence++;
        });
        /************ experiment ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#experiment-{{$i}}").hide();
        @endfor
        var experiment = 3;
        $("#add-experiment").click(function() {
                if (experiment > {{ $maxRows }}) {
                        $("#add-experiment").hide();
                        return;
                }
                $("#experiment-" + experiment).show();
                experiment++;
        });
        /************ survey ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#survey-{{$i}}").hide();
        @endfor
        var survey = 3;
        $("#add-survey").click(function() {
                if (survey > {{ $maxRows }}) {
                        $("#add-survey").hide();
                        return;
                }
                $("#survey-" + survey).show();
                survey++;
        });
        /************ labelmeaning ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#label-{{$i}}").hide();
                $("#hypen-{{$i}}").hide();
                $("#meaning-{{$i}}").hide();
        @endfor
        var labelmeaning = 3;
        $("#add-labelmeaning").click(function() {
                if (labelmeaning > {{ $maxRows }}) {
                        $("#add-labelmeaning").hide();
                        return;
                }
                $("#label-" + labelmeaning).show();
                $("#hypen-" + labelmeaning).show();
                $("#meaning-" + labelmeaning).show();
                labelmeaning++;
        });
        /************ advantage ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#advantage-{{$i}}").hide();
        @endfor
        var advantage = 3;
        $("#add-advantage").click(function() {
                if (advantage > {{ $maxRows }}) {
                        $("#add-advantage").hide();
                        return;
                }
                $("#advantage-" + advantage).show();
                advantage++;
        });
        /************ disadvantage ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#disadvantage-{{$i}}").hide();
        @endfor
        var disadvantage = 3;
        $("#add-disadvantage").click(function() {
                if (disadvantage > {{ $maxRows }}) {
                        $("#add-disadvantage").hide();
                        return;
                }
                $("#disadvantage-" + disadvantage).show();
                disadvantage++;
        });
        /************ iftrue ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#iftrue-{{$i}}").hide();
        @endfor
        var iftrue = 3;
        $("#add-iftrue").click(function() {
                if (iftrue > {{ $maxRows }}) {
                        $("#add-iftrue").hide();
                        return;
                }
                $("#iftrue-" + iftrue).show();
                iftrue++;
        });
        /************ reattribution ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#reattribution-{{$i}}").hide();
        @endfor
        var reattribution = 3;
        $("#add-reattribution").click(function() {
                if (reattribution > {{ $maxRows }}) {
                        $("#add-reattribution").hide();
                        return;
                }
                $("#reattribution-" + reattribution).show();
                reattribution++;
        })
        /************ reframe ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#reframe-{{$i}}").hide();
        @endfor
        var reframe = 3;
        $("#add-reframe").click(function() {
                if (reframe > {{ $maxRows }}) {
                        $("#add-reframe").hide();
                        return;
                }
                $("#reframe-" + reframe).show();
                reframe++;
        })
        /************ rationalize ************/
        @for ($i = 3; $i <= $maxRows; $i++)
                $("#rationalize-{{$i}}").hide();
        @endfor
        var rationalize = 3;
        $("#add-rationalize").click(function() {
                if (rationalize > {{ $maxRows }}) {
                        $("#add-rationalize").hide();
                        return;
                }
                $("#rationalize-" + rationalize).show();
                rationalize++;
        })
});

</script>

@stop

@section('page-title', 'Dispute Thoughts')

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
<div id="forevidence-{{$i}}">
                {{ Form::openGroup('forevidence[' . $i . ']', '') }}
                        {{ Form::text('forevidence[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-forevidence">add more</button></div>

<br />

{{ Form::rawLabel('What are the evidences (facts / observtaions) against the thought ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="againstevidence-{{$i}}">
                {{ Form::openGroup('againstevidence[' . $i . ']', '') }}
                        {{ Form::text('againstevidence[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-againstevidence">add more</button></div>

</div>

<!-- Experiments section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Experiments</div>

{{ Form::rawLabel('What experiments can I do to test the validity of the thought ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="experiment-{{$i}}">
                {{ Form::openGroup('experiment[' . $i . ']', '') }}
                        {{ Form::text('experiment[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-experiment">add more</button></div>

<br />

{{ Form::rawLabel('What was the results of the experiments ?') }}
{{ Form::openGroup('experimentresult', '') }}
        {{ Form::textarea('experimentresult', null, ['size' => '50x3']) }}
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
<div><button type="button" class="btn btn-default" id="add-survey">add more</button></div>

<br />

{{ Form::rawLabel('What was the results of the survey ?') }}
{{ Form::openGroup('surveyresult', '') }}
        {{ Form::textarea('surveyresult', null, ['size' => '50x3']) }}
{{ Form::closeGroup() }}

</div>

<!-- What do I mean by section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">What do I mean by...</div>

<table class="table borderless table-meaning">
<tr>
        <th>{{ Form::rawLabel('Labels') }}</th>
        <th></th>
        <th>{{ Form::rawLabel('What do I really mean by it ?') }}</th>
</tr>

@for ($i = 0; $i <= $maxRows; $i++)
<tr>
<td width="150px" class="td-label">
        <div id="label-{{$i}}">
                {{ Form::openGroup('label[' . $i . ']', '') }}
                        {{ Form::text('label[' . $i . ']') }}
                {{ Form::closeGroup() }}
        </div>
</td>
<td width="10px"><div id="hypen-{{$i}}">&nbsp;&nbsp;-&nbsp;&nbsp;</div></td>
<td>
        <div id="meaning-{{$i}}">
                {{ Form::openGroup('meaning[' . $i . ']', '') }}
                        {{ Form::text('meaning[' . $i . ']') }}
                {{ Form::closeGroup() }}
        </div>
</td>
</tr>
@endfor

</table>

<div><button type="button" class="btn btn-default" id="add-labelmeaning">add more</button></div>

</div>

<!-- Cost-Benifit section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Cost-Benifit analysis</div>

<table class="table">
<tr>

<td>
{{ Form::rawLabel('What are the advantages of believing the thought ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="advantage-{{$i}}">
                {{ Form::openGroup('advantage[' . $i . ']', '') }}
                        {{ Form::text('advantage[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-advantage">add more</button></div>
</td>

<td>
{{ Form::rawLabel('What are the dis-advantages of believing the thought ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="disadvantage-{{$i}}">
                {{ Form::openGroup('disadvantage[' . $i . ']', '') }}
                        {{ Form::text('disadvantage[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-disadvantage">add more</button></div>
</td>

</tr>
</table>

</div>

<!-- What if it was true section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">What if it was true ?</div>

@for ($i = 0; $i <= $maxRows; $i++)
<div id="iftrue-{{$i}}">
        @if ($i != 0)
                <center><i class="glyphicon glyphicon-arrow-down"></i></center><br />
        @endif
        {{ Form::rawLabel('If it was true what would it mean to me ? Why would it be so upsetting to me ?') }}
        {{ Form::openGroup('iftrue[' . $i . ']', '') }}
                {{ Form::text('iftrue[' . $i . ']') }}
        {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-iftrue">add more</button></div>

</div>

<!-- Re-attribution section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Re-attribution</div>

{{ Form::rawLabel('What other factors might have contributed to the problem ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="reattribution-{{$i}}">
                {{ Form::openGroup('reattribution[' . $i . ']', '') }}
                        {{ Form::text('reattribution[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-reattribution">add more</button></div>

</div>

<!-- Re-framing section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Re-framing</div>

{{ Form::rawLabel('Substitute language that is less colorfull and emotionally loaded.') }}
{{ Form::rawLabel('Relace all should\'s, must\'s, have to\'s, etc with words like want to, prefer to, like to, etc.') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="reframe-{{$i}}">
                {{ Form::openGroup('reframe[' . $i . ']', '') }}
                        {{ Form::text('reframe[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-reframe">add more</button></div>

</div>

<!-- Rationalize section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Rationalize</div>

{{ Form::rawLabel('What are the more realistic / rational / less extreme ways of looking at it ?') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="rationalize-{{$i}}">
                {{ Form::openGroup('rationalize[' . $i . ']', '') }}
                        {{ Form::text('rationalize[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-rationalize">add more</button></div>

</div>

</div><!-- END bhoechie-tab -->

</div><!-- END bhoechie-tab-container -->
</div><!-- END bhoechie-tab-element -->
</div><!-- END row -->

<!-- BHOECHIE TAB END -->

{{ Form::label('More balanced thoughts') }}
@for ($i = 0; $i <= $maxRows; $i++)
<div id="balancedthoughts-{{$i}}">
                {{ Form::openGroup('balancedthoughts[' . $i . ']', '') }}
                        {{ Form::text('balancedthoughts[' . $i . ']') }}
                {{ Form::closeGroup() }}
</div>
@endfor
<div><button type="button" class="btn btn-default" id="add-balancedthoughts">add more</button></div>

<br />

{{ Form::submit('Submit') }}
{{ HTML::linkAction('CbtsController@getIndex', 'Cancel') }}

{{ Form::close() }}


@stop
