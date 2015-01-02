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

        $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
                $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
        });

        /************ Hide extra rows ************/
        var addDistortions = 0;
        var addBalancedThoughts = 0;
        var forevidence = 0;
        var againstevidence = 0;
        var experiment = 0;
        var survey = 0;
        var advantage = 0;
        var disadvantage = 0;
        var iftrue = 0;
        var reattribution = 0;
        var reframe = 0;
        var rationalize = 0;

        for (var i = {{$hideStart}}; i <= {{$maxRows}}; i++) {
                if ($("[name='distortions[" + i + "]']").val() == 0) {
                        $("#distortions-" + i).hide();
                        addDistortions++;
                }
                if ($("[name='balancedthoughts[" + i + "]']").val() == 0) {
                        $("#balancedthoughts-" + i).hide();
                }

                if ($("[name='forevidence[" + i + "]']").val() == "") {
                        $("#forevidence-" + i).hide();
                }
                if ($("[name='againstevidence[" + i + "]']").val() == "") {
                        $("#againstevidence-" + i).hide();
                }
                if ($("[name='experiment[" + i + "]']").val() == "") {
                        $("#experiment-" + i).hide();
                }
                if ($("[name='survey[" + i + "]']").val() == "") {
                        $("#survey-" + i).hide();
                }
                if ($("[name='advantage[" + i + "]']").val() == "") {
                        $("#advantage-" + i).hide();
                }
                if ($("[name='disadvantage[" + i + "]']").val() == "") {
                        $("#disadvantage-" + i).hide();
                }
                if ($("[name='iftrue[" + i + "]']").val() == "") {
                        $("#iftrue-" + i).hide();
                }
                if ($("[name='reattribution[" + i + "]']").val() == "") {
                        $("#reattribution-" + i).hide();
                }
                if ($("[name='reframe[" + i + "]']").val() == "") {
                        $("#reframe-" + i).hide();
                }
                if ($("[name='rationalize[" + i + "]']").val() == "") {
                        $("#rationalize-" + i).hide();
                }
        }

        /************ Distortions ************/
        if (addDistortions < {{$hideStart}}) {
                addDistortions = {{$hideStart}};
        }
        $("#add-distortions").click(function() {
                for (var i = 0; i <= {{$showCount}}; i++) {
                        if (addDistortions > {{$maxRows}}) {
                                $("#add-distortions").hide();
                                break;
                        }
                        $("#distortions-" + addDistortions).show();
                        addDistortions++;
                }
        });

        /************ Balanced thoughts ************/
        if (addBalancedThoughts < {{$hideStart}}) {
                addBalancedThoughts = {{$hideStart}};
        }
        $("#add-balancedthoughts").click(function() {
                for (var i = 0; i <= {{$showCount}}; i++) {
                        if (addBalancedThoughts > {{$maxRows}}) {
                                $("#add-balancedthoughts").hide();
                                break;
                        }
                        $("#balancedthoughts-" + addBalancedThoughts).show();
                        addBalancedThoughts++;
                }
        });

        /************** DISPUTE START **************/

        /************ forevidence ************/
        if (forevidence < {{$hideStart}}) {
                forevidence = {{$hideStart}};
        }
        $("#add-forevidence").click(function() {
                if (forevidence > {{$maxRows}}) {
                        $("#add-forevidence").hide();
                        return;
                }
                $("#forevidence-" + forevidence).show();
                forevidence++;
        });
        /************ againstevidence ************/
        if (againstevidence < {{$hideStart}}) {
                againstevidence = {{$hideStart}};
        }
        $("#add-againstevidence").click(function() {
                if (againstevidence > {{$maxRows}}) {
                        $("#add-againstevidence").hide();
                        return;
                }
                $("#againstevidence-" + againstevidence).show();
                againstevidence++;
        });
        /************ experiment ************/
        if (experiment < {{$hideStart}}) {
                experiment = {{$hideStart}};
        }
        $("#add-experiment").click(function() {
                if (experiment > {{$maxRows}}) {
                        $("#add-experiment").hide();
                        return;
                }
                $("#experiment-" + experiment).show();
                experiment++;
        });
        /************ survey ************/
        if (survey < {{$hideStart}}) {
                survey = {{$hideStart}};
        }
        $("#add-survey").click(function() {
                if (survey > {{$maxRows}}) {
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
        var labelmeaning = {{$hideStart}};
        $("#add-labelmeaning").click(function() {
                if (labelmeaning > {{$maxRows}}) {
                        $("#add-labelmeaning").hide();
                        return;
                }
                $("#label-" + labelmeaning).show();
                $("#hypen-" + labelmeaning).show();
                $("#meaning-" + labelmeaning).show();
                labelmeaning++;
        });
        /************ advantage ************/
        if (advantage < {{$hideStart}}) {
                advantage = {{$hideStart}};
        }
        $("#add-advantage").click(function() {
                if (advantage > {{$maxRows}}) {
                        $("#add-advantage").hide();
                        return;
                }
                $("#advantage-" + advantage).show();
                advantage++;
        });
        /************ disadvantage ************/
        if (disadvantage < {{$hideStart}}) {
                disadvantage = {{$hideStart}};
        }
        $("#add-disadvantage").click(function() {
                if (disadvantage > {{$maxRows}}) {
                        $("#add-disadvantage").hide();
                        return;
                }
                $("#disadvantage-" + disadvantage).show();
                disadvantage++;
        });
        /************ iftrue ************/
        if (iftrue < {{$hideStart}}) {
                iftrue = {{$hideStart}};
        }
        $("#add-iftrue").click(function() {
                if (iftrue > {{$maxRows}}) {
                        $("#add-iftrue").hide();
                        return;
                }
                $("#iftrue-" + iftrue).show();
                iftrue++;
        });
        /************ reattribution ************/
        if (reattribution < {{$hideStart}}) {
                reattribution = {{$hideStart}};
        }
        $("#add-reattribution").click(function() {
                if (reattribution > {{$maxRows}}) {
                        $("#add-reattribution").hide();
                        return;
                }
                $("#reattribution-" + reattribution).show();
                reattribution++;
        })
        /************ reframe ************/
        if (reframe < {{$hideStart}}) {
                reframe = {{$hideStart}};
        }
        $("#add-reframe").click(function() {
                if (reframe > {{$maxRows}}) {
                        $("#add-reframe").hide();
                        return;
                }
                $("#reframe-" + reframe).show();
                reframe++;
        })
        /************ rationalize ************/
        if (rationalize < {{$hideStart}}) {
                rationalize = {{$hideStart}};
        }
        $("#add-rationalize").click(function() {
                if (rationalize > {{$maxRows}}) {
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
        <span class="dispute-title">Irrational thought to dispute : &ldquo;{{ $thought->thought }}&rdquo;</span>
</div>

{{ Form::open() }}

{{ Form::label('Distortions') }}

@define $i = 0
@foreach ($thought->cbtThoughtDistortions as $thoughtDistortion)
<div id="distortions-{{$i}}">
        {{ Form::openGroup('distortions[' . $i . ']', '') }}
                {{ Form::select('distortions[' . $i . ']', $distortions_list,
                        $thoughtDistortion->distortion_id) }}
        {{ Form::closeGroup() }}
        @define $i = $i + 1
</div>
@endforeach

@for (; $i <= $maxRows; $i++)
<div id="distortions-{{$i}}">
                {{ Form::openGroup('distortions[' . $i . ']', '') }}
                        {{ Form::select('distortions[' . $i . ']', $distortions_list) }}
                {{ Form::closeGroup() }}
</div>
@endfor

<div><button type="button" class="btn btn-default" id="add-distortions">add more</button></div>

<br />

@define $dispute = unserialize($thought->dispute)

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

@define $i = 0
@if (isset($dispute['forevidence']))
@foreach ($dispute['forevidence'] as $forevidence)
<div id="forevidence-{{$i}}">
        {{ Form::openGroup('forevidence[' . $i . ']', '') }}
                {{ Form::text('forevidence[' . $i . ']', $forevidence) }}
        {{ Form::closeGroup() }}
        @define $i = $i + 1
</div>
@endforeach
@endif

@for (; $i <= $maxRows; $i++)
<div id="forevidence-{{$i}}">
        {{ Form::openGroup('forevidence[' . $i . ']', '') }}
                {{ Form::text('forevidence[' . $i . ']') }}
        {{ Form::closeGroup() }}
</div>
@endfor

<div><button type="button" class="btn btn-default" id="add-forevidence">add more</button></div>

<br />

{{ Form::rawLabel('What are the evidences (facts / observtaions) against the thought ?') }}

@define $i = 0
@if (isset($dispute['againstevidence']))
@foreach ($dispute['againstevidence'] as $againstevidence)
<div id="againstevidence-{{$i}}">
        {{ Form::openGroup('againstevidence[' . $i . ']', '') }}
                {{ Form::text('againstevidence[' . $i . ']', $againstevidence) }}
        {{ Form::closeGroup() }}
        @define $i = $i + 1
</div>
@endforeach
@endif

@for (; $i <= $maxRows; $i++)
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

@define $i = 0
@if (isset($dispute['experiment']))
@foreach ($dispute['experiment'] as $experiment)
<div id="experiment-{{$i}}">
        {{ Form::openGroup('experiment[' . $i . ']', '') }}
                {{ Form::text('experiment[' . $i . ']', $experiment) }}
        {{ Form::closeGroup() }}
        @define $i = $i + 1
</div>
@endforeach
@endif

@for (; $i <= $maxRows; $i++)
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
        @if (isset($dispute['experiment']))
                {{ Form::textarea('experimentresult', $dispute['experimentresult'], ['size' => '50x3']) }}
        @else
                {{ Form::textarea('experimentresult', null, ['size' => '50x3']) }}
        @endif
{{ Form::closeGroup() }}

</div>

<!-- Double-Standards section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Double-Standard method</div>

{{ Form::rawLabel('What would I say to a friend who is in the same situation or facing the same problem ?') }}
{{ Form::openGroup('doublestandard', '') }}
        @if (isset($dispute['doublestandard']))
                {{ Form::textarea('doublestandard', $dispute['doublestandard'], ['size' => '50x10']) }}
        @else
                {{ Form::textarea('doublestandard', null, ['size' => '50x10']) }}
        @endif
{{ Form::closeGroup() }}

</div>

<!-- Survey section -->
<div class="bhoechie-tab-content">

<div class="tab-content-title">Survey</div>

{{ Form::rawLabel('What questions can I ask people to find out if the thought or attitude is valid ?') }}

@define $i = 0
@if (isset($dispute['survey']))
@foreach ($dispute['survey'] as $survey)
<div id="survey-{{$i}}">
        {{ Form::openGroup('survey[' . $i . ']', '') }}
                {{ Form::text('survey[' . $i . ']', $survey) }}
        {{ Form::closeGroup() }}
        @define $i = $i + 1
</div>
@endforeach
@endif

@for (; $i <= $maxRows; $i++)
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
        @if (isset($dispute['surveyresult']))
                {{ Form::textarea('surveyresult', $dispute['surveyresult'], ['size' => '50x3']) }}
        @else
                {{ Form::textarea('surveyresult', null, ['size' => '50x3']) }}
        @endif
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

@define $i = 0
@if (isset($dispute['advantage']))
@foreach ($dispute['advantage'] as $advantage)
<div id="advantage-{{$i}}">
        {{ Form::openGroup('advantage[' . $i . ']', '') }}
                {{ Form::text('advantage[' . $i . ']', $advantage) }}
        {{ Form::closeGroup() }}
        @define $i = $i + 1
</div>
@endforeach
@endif

@for (; $i <= $maxRows; $i++)
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

@define $i = 0
@if (isset($dispute['disadvantage']))
@foreach ($dispute['disadvantage'] as $disadvantage)
<div id="disadvantage-{{$i}}">
        {{ Form::openGroup('disadvantage[' . $i . ']', '') }}
                {{ Form::text('disadvantage[' . $i . ']', $disadvantage) }}
        {{ Form::closeGroup() }}
        @define $i = $i + 1
</div>
@endforeach
@endif

@for (; $i <= $maxRows; $i++)
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

@define $i = 0
@if (isset($dispute['iftrue']))
@foreach ($dispute['iftrue'] as $iftrue)
<div id="iftrue-{{$i}}">
        @if ($i != 0)
                <center><i class="glyphicon glyphicon-arrow-down"></i></center><br />
        @endif
        {{ Form::rawLabel('If it was true what would it mean to me ? Why would it be so upsetting to me ?') }}
        {{ Form::openGroup('iftrue[' . $i . ']', '') }}
                {{ Form::text('iftrue[' . $i . ']', $iftrue) }}
        {{ Form::closeGroup() }}
        @define $i = $i + 1
</div>
@endforeach
@endif

@for (; $i <= $maxRows; $i++)
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

@define $i = 0
@if (isset($dispute['reattribution']))
@foreach ($dispute['reattribution'] as $reattribution)
<div id="reattribution-{{$i}}">
        {{ Form::openGroup('reattribution[' . $i . ']', '') }}
                {{ Form::text('reattribution[' . $i . ']', $reattribution) }}
        {{ Form::closeGroup() }}
        @define $i = $i + 1
</div>
@endforeach
@endif

@for (; $i <= $maxRows; $i++)
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

@define $i = 0
@if (isset($dispute['reframe']))
@foreach ($dispute['reframe'] as $reframe)
<div id="reframe-{{$i}}">
        {{ Form::openGroup('reframe[' . $i . ']', '') }}
                {{ Form::text('reframe[' . $i . ']', $reframe) }}
        {{ Form::closeGroup() }}
        @define $i = $i + 1
</div>
@endforeach
@endif

@for (; $i <= $maxRows; $i++)
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

@define $i = 0
@if (isset($dispute['rationalize']))
@foreach ($dispute['rationalize'] as $rationalize)
<div id="rationalize-{{$i}}">
        {{ Form::openGroup('rationalize[' . $i . ']', '') }}
                {{ Form::text('rationalize[' . $i . ']', $rationalize) }}
        {{ Form::closeGroup() }}
        @define $i = $i + 1
</div>
@endforeach
@endif

@for (; $i <= $maxRows; $i++)
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
@define $balanced_thoughts = unserialize($thought->balanced_thoughts)
@define $i = 0
@if (isset($balanced_thoughts))
@foreach ($balanced_thoughts as $balanced_thought)
<div id="balancedthoughts-{{$i}}">
        {{ Form::openGroup('balancedthoughts[' . $i . ']', '') }}
                {{ Form::text('balancedthoughts[' . $i . ']', $balanced_thought) }}
        {{ Form::closeGroup() }}
        @define $i = $i + 1
</div>
@endforeach
@endif

@for (; $i <= $maxRows; $i++)
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
