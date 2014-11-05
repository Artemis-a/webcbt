@extends('layouts.master')

@section('head')

<script type="text/javascript">

$(document).ready(function() {
});

</script>

@stop

@section('page-title', 'Dashboard')

@section('content')

{{ HTML::linkAction('CbtsController@getCreate', 'ADD', array(), array('class' => 'btn btn-primary')) }}

<br />
<br />

<table class="table table-hover">
        <thead>
                <tr>
                        <th class="col-width-1">Date</th>
                        <th>Situation</th>
                        <th>Thoughts</th>
                        <th>Feelings</th>
                        <th>Behaviour</th>
                </tr>
        </thead>
        <tbody>
                @foreach ($cbts as $cbt)
                <tr>
                        <td>{{ $cbt['date'] }}</td>
                        <td>{{ $cbt['situation'] }}</td>
                        <td>
                                <ul class="list-unstyled">
                                @foreach ($cbt->thoughts as $thought)
                                        <li class="list-pad">
                                                @if ($thought['is_challenged'] == 0)
                                                        {{ HTML::linkAction(
                                                                'ThoughtsController@getDispute',
                                                                $thought['thought'],
                                                                array($thought['id']),
                                                                array('class' => 'btn btn-xs btn-warning')) }}
                                                @else
                                                        {{ HTML::linkAction(
                                                                'ThoughtsController@getDispute',
                                                                $thought['thought'],
                                                                array($thought['id']),
                                                                array('class' => 'btn btn-xs btn-success')) }}
                                                @endif
                                        </li>
                                @endforeach
                                </ul>
                        </td>
                        <td>
                                <ul class="list-unstyled">
                                @foreach ($cbt->feelings as $feeling)
                                        @if ($feeling['before_after'] == 0)
                                                <li>
                                                        {{ $feeling->emotion['name'] }}
                                                        <span class="badge">{{ $feeling['percent'] }}</span>
                                                </li>
                                        @endif
                                @endforeach
                                </ul>
                        </td>
                        <td>
                                <ul class="list-unstyled">
                                @foreach ($cbt->behaviours as $behaviour)
                                        <li>{{ $behaviour['behaviour'] }}</li>
                                @endforeach
                                </ul>
                        </td>
                </tr>
                @endforeach
        </tbody>
</table>

@stop
