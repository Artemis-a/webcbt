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

@section('page-title', 'CBT Exercises')

@section('content')

{{ HTML::linkAction('CbtsController@getCreate', 'New CBT Exercise', array(), array('class' => 'btn btn-primary')) }}

<span class="pull-right">
        <select class="selectpicker" multiple>
                <option>Resolved</option>
                <option>Unresolved</option>
                @if ($tags->count() > 0)
                <optgroup label="Tags">
                        @foreach ($tags as $tag)
                                <option>{{ $tag->name }}</option>
                        @endforeach
                </optgroup>
                @endif
        </select>
        <button type="button" class="btn btn-info">Filter</button>
</span>

<br />
<br />

<table class="table table-hover">
        <thead>
                <tr>
                        <th class="col-width-1">Date</th>
                        <th>Situation</th>
                        <th>Tags</th>
                        <th>Thoughts</th>
                        <th>Feelings</th>
                        <th>Physical Symptoms</th>
                        <th>Behaviours</th>
                        <th>Resolved</th>
                        <th></th>
                </tr>
        </thead>
        <tbody>
                @foreach ($cbts as $cbt)
                <tr>
                        <td>
                                {{ date_format(date_create_from_format('Y-m-d H:i:s', $cbt->date), explode('|', $dateformat)[0]) }}
                                <br />
                                {{ date_format(date_create_from_format('Y-m-d H:i:s', $cbt->date), 'h:i A') }}
                        </td>
                        <td>
                                {{ $cbt->situation }}
                        </td>
                        <td>
                                @define $tag = $cbt->tag
                                @if (isset($tag))
                                <span style="color:#{{ $tag['color'] }}; background:#{{ $tag['background'] }};" class="tag">
                                        {{ $tag['name'] }}
                                </span>
                                @endif
                        </td>
                        <td>
                                <ul class="list-unstyled">
                                @foreach ($cbt->cbtThoughts as $thought)
                                        <li class="list-pad">
                                                @if ($thought['is_challenged'] == 0)
                                                        {{ HTML::linkAction(
                                                                'ThoughtsController@getDispute',
                                                                $thought->thought,
                                                                array($thought->id),
                                                                array('class' => 'link-pending')) }}
                                                @else
                                                        {{ HTML::linkAction(
                                                                'ThoughtsController@getDispute',
                                                                $thought->thought,
                                                                array($thought->id),
                                                                array('class' => 'link-completed')) }}
                                                @endif
                                        </li>
                                @endforeach
                                </ul>
                        </td>
                        <td>
                                <ul class="list-unstyled">
                                @foreach ($cbt->cbtFeelings as $feeling)
                                        @if ($feeling->status == 'B')
                                                <li>
                                                        {{ $feeling->feeling->name }}
                                                        <span class="badge">{{ $feeling->intensity }}</span>
                                                </li>
                                        @endif
                                @endforeach
                                </ul>
                        </td>
                        <td>
                                <ul class="list-unstyled">
                                @foreach ($cbt->cbtSymptoms as $symptom)
                                        @if ($symptom->status == 'B')
                                                <li>
                                                        {{ $symptom->symptom->name }}
                                                        <span class="badge">{{ $symptom->intensity }}</span>
                                                </li>
                                        @endif
                                @endforeach
                                </ul>
                        </td>
                        <td>
                                <ul class="list-unstyled">
                                @foreach ($cbt->cbtBehaviours as $behaviour)
                                        @if ($behaviour->status == 'B')
                                                <li>{{ $behaviour->behaviour }}</li>
                                        @endif
                                @endforeach
                                </ul>
                        </td>
                        <td>
                                @if ($cbt->is_resolved == 1)
                                        Yes
                                @else
                                        No
                                @endif
                        </td>
                        <td>
                                <!-- Split button -->
                                <div class="btn-group">
                                <button type="button" class="btn btn-primary">Actions</button>
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                <li>
                                        {{ HTML::linkAction(
                                                'CbtsController@getPostdispute',
                                                'Post-dispute',
                                                array($cbt->id),
                                                array('class' => '')) }}
                                </li>
                                <li>
                                        {{ HTML::linkAction(
                                                'CbtsController@getAnalysis',
                                                'Show analysis',
                                                array($cbt->id),
                                                array('class' => '')) }}
                                </li>
                                @if ($cbt['is_resolved'] == 0)
                                        <li>
                                        {{ HTML::linkAction(
                                                'CbtsController@putResolved',
                                                'Mark as resolved',
                                                array($cbt->id),
                                                array('class' => '', 'data-method' => 'PUT')) }}
                                        </li>
                                @else
                                        <li>
                                        {{ HTML::linkAction(
                                                'CbtsController@putUnresolved',
                                                'Mark as unresolved',
                                                array($cbt->id),
                                                array('class' => '', 'data-method' => 'PUT')) }}
                                        </li>
                                @endif
                                <li class="divider"></li>
                                <li>
                                        {{ HTML::linkAction(
                                                'CbtsController@getEdit',
                                                'Edit exercise',
                                                array($cbt->id),
                                                array('class' => '')) }}
                                </li>
                                <li>
                                        {{ HTML::linkAction(
                                                'CbtsController@deleteDestroy',
                                                'Delete exercise',
                                                array($cbt->id),
                                                array(
                                                        'class' => '',
                                                        'data-method' => 'DELETE',
                                                        'data-confirm' => 'Are you sure you want to delete the CBT exercise ?'
                                                )) }}
                                </li>
                                </ul>
                                </div>
                        </td>
                </tr>
                @endforeach
        </tbody>
</table>

@stop
