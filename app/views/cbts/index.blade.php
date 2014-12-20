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

<br />
<br />

<table class="table table-hover">
        <thead>
                <tr>
                        <th class="col-width-1">Date</th>
                        <th>Situation</th>
                        <th>Thoughts</th>
                        <th>Feelings</th>
                        <th>Sensations</th>
                        <th>Behaviours</th>
                        <th></th>
                </tr>
        </thead>
        <tbody>
                @foreach ($cbts as $cbt)
                <tr>
                        <td>{{ $cbt['date'] }}</td>
                        <td>{{ $cbt['situation'] }}</td>
                        <td>
                                <ul class="list-unstyled">
                                @foreach ($cbt->cbtThoughts as $thought)
                                        <li class="list-pad">
                                                @if ($thought['is_challenged'] == 0)
                                                        {{ HTML::linkAction(
                                                                'ThoughtsController@getDispute',
                                                                $thought['thought'],
                                                                array($thought['id']),
                                                                array('class' => 'link-pending')) }}
                                                @else
                                                        {{ HTML::linkAction(
                                                                'ThoughtsController@getDispute',
                                                                $thought['thought'],
                                                                array($thought['id']),
                                                                array('class' => 'link-completed')) }}
                                                @endif
                                        </li>
                                @endforeach
                                </ul>
                        </td>
                        <td>
                                <ul class="list-unstyled">
                                @foreach ($cbt->cbtFeelings as $feeling)
                                        @if ($feeling['when'] == 'B')
                                                <li>
                                                        {{ $feeling->feeling['name'] }}
                                                        <span class="badge">{{ $feeling['percent'] }}</span>
                                                </li>
                                        @endif
                                @endforeach
                                </ul>
                        </td>
                        <td>
                                <ul class="list-unstyled">
                                @foreach ($cbt->cbtSensations as $sensation)
                                        @if ($sensation['when'] == 'B')
                                                <li>
                                                        {{ $sensation->sensation['name'] }}
                                                        <span class="badge">{{ $sensation['percent'] }}</span>
                                                </li>
                                        @endif
                                @endforeach
                                </ul>
                        </td>
                        <td>
                                <ul class="list-unstyled">
                                @foreach ($cbt->cbtBehaviours as $behaviour)
                                        @if ($behaviour['when'] == 'B')
                                                <li>{{ $behaviour['behaviour'] }}</li>
                                        @endif
                                @endforeach
                                </ul>
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
                                                array($cbt['id']),
                                                array('class' => '')) }}
                                </li>
                                <li><a href="#">Show analysis</a></li>
                                <li><a href="#">Mark as resolved</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Edit exercise</a></li>
                                <li><a href="#">Delete exercise</a></li>
                                </ul>
                                </div>
                        </td>
                </tr>
                @endforeach
        </tbody>
</table>

@stop
