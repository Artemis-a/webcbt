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

@section('head')

<script type="text/javascript">

$(document).ready(function() {
});

</script>

@stop

@section('page-title', 'Analysis of CBT exercise')

@section('content')

&nbsp;&nbsp;{{ Form::label('Date :') }}
        {{ date_format(date_create_from_format('Y-m-d H:i:s', $cbt->date), explode('|', $dateformat)[0] . ' h:i A') }}

<br />
<br />

&nbsp;&nbsp;{{ Form::label('Situation :') }}
        {{ $cbt->situation }}

<br />
<br />

<table class="table">
        <thead>
                <tr>
                        <th width="300px">{{ Form::label('Distorted Thoughts') }}</th>
                        <th width="100px"></th>
                        <th>{{ Form::label('Distortions') }}</th>
                        <th width="100px"></th>
                        <th>{{ Form::label('Balanced Thoughts') }}</th>
                </tr>
        </thead>
        <tbody>
        @foreach ($cbt->cbtThoughts as $thought)
        <tr>
        <td>
                @if ($thought->is_challenged == 0)
                        <div>{{ $thought->thought }}</div>
                @else
                        <div>{{ $thought->thought }}</div>
                @endif
        </td>
        <td>
                <i class="fa fa-arrow-right fa-6"></i>
        </td>
        <td>
                @if ($thought->is_challenged == 0)
                        <div>(Not yet challenged)</div>
                @else
                        @foreach ($thought->cbtThoughtDistortions as $thoughtDistortion)
                                <div>{{ $thoughtDistortion->distortion->name }}</div>
                        @endforeach
                @endif
        </td>
        <td>
                <i class="fa fa-arrow-right fa-6"></i>
        </td>
        <td>
                @if ($thought->is_challenged == 0)
                        <div>(Not yet challenged)</div>
                @else
                        @define $new_thoughts = unserialize($thought->balanced_thoughts);
                        @foreach ($new_thoughts as $new_thought)
                                <div>{{ $new_thought }}</div>
                        @endforeach
                @endif
        </td>
        </tr>
        @endforeach
        </tbody>
</table>

<br />

<table class="table">
        <thead>
                <tr>
                        <th width="300px">{{ Form::label('Old Feelings') }}</th>
                        <th width="100px"></th>
                        <th>{{ Form::label('New Feelings') }}</th>
                </tr>
        </thead>
        <tbody>
        <tr>
        <td>
                @foreach ($cbt->cbtFeelings as $feeling)
                        @if ($feeling->status == 'B')
                                <div>
                                        {{ $feeling->feeling->name }}
                                        <span class="badge">{{ $feeling->intensity }}</span>
                                </div>
                        @endif
                @endforeach
        </td>
        <td>
                <i class="fa fa-arrow-right fa-6"></i>
        </td>
        <td>
                @foreach ($cbt->cbtFeelings as $feeling)
                        @if ($feeling->status == 'A')
                                <div>
                                        {{ $feeling->feeling->name }}
                                        <span class="badge">{{ $feeling->intensity }}</span>
                                </div>
                        @endif
                @endforeach
        </td>
        </tr>
        </tbody>
</table>

<br />

<table class="table">
        <thead>
                <tr>
                        <th width="300px">{{ Form::label('Old Physical Symptom') }}</th>
                        <th width="100px"></th>
                        <th>{{ Form::label('New Physical Symptom') }}</th>
                </tr>
        </thead>
        <tbody>
        <tr>
        <td>
                @foreach ($cbt->cbtSymptoms as $symptom)
                        @if ($symptom->status == 'B')
                                <div>
                                        {{ $symptom->symptom->name }}
                                        <span class="badge">{{ $symptom->intensity }}</span>
                                </div>
                        @endif
                @endforeach
        </td>
        <td>
                <i class="fa fa-arrow-right fa-6"></i>
        </td>
        <td>
                @foreach ($cbt->cbtSymptoms as $symptom)
                        @if ($symptom->status == 'A')
                                <div>
                                        {{ $symptom->symptom->name }}
                                        <span class="badge">{{ $symptom->intensity }}</span>
                                </div>
                        @endif
                @endforeach
        </td>
        </tr>
        </tbody>
</table>

<br />

<table class="table">
        <thead>
                <tr>
                        <th width="300px">{{ Form::label('Old Behaviour') }}</th>
                        <th width="100px"></th>
                        <th>{{ Form::label('New Behaviour') }}</th>
                </tr>
        </thead>
        <tbody>
        <tr>
        <td>
                @foreach ($cbt->cbtBehaviours as $behaviour)
                        @if ($behaviour->status == 'B')
                                <div>{{ $behaviour->behaviour }}</div>
                        @endif
                @endforeach
        </td>
        <td>
                <i class="fa fa-arrow-right fa-6"></i>
        </td>
        <td>
                @foreach ($cbt->cbtBehaviours as $behaviour)
                        @if ($behaviour->status == 'A')
                                <div>{{ $behaviour->behaviour }}</div>
                        @endif
                @endforeach
        </td>
        </tr>
        </tbody>
</table>

<br />

{{ HTML::linkAction('CbtsController@getIndex', 'Back', array(), array('class' => 'btn btn-primary')) }}

@stop
