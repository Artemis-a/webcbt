@extends('layouts.master')

@section('head')

<script type="text/javascript">

$(document).ready(function() {
});

</script>

@stop

@section('page-title', 'Sensations')

@section('content')

{{ HTML::linkAction('SensationsController@getCreate', 'New Sensation', array(), array('class' => 'btn btn-primary')) }}

<br />
<br />

<table class="table table-hover">
        <thead>
                <tr>
                        <th>Sensations</th>
                        <th>Added On</th>
                        <th>Actions</th>
                </tr>
        </thead>
        <tbody>
                @foreach ($sensations as $sensation)
                <tr>
                        <td>{{ $sensation['name'] }}</td>
                        <td>{{ $sensation['created_at'] }}</td>
                        <td>
                                {{ HTML::decode(HTML::linkAction(
                                        'SensationsController@getStats',
                                        '<i class="fa fa-fw fa-list"></i> Stats',
                                        array($sensation['id']),
                                        array('class' => 'no-underline'))) }}

                                <span class="link-pad"></span>

                                {{ HTML::decode(HTML::linkAction(
                                        'SensationsController@getEdit',
                                        '<i class="fa fa-fw fa-edit"></i> Edit',
                                        array($sensation['id']),
                                        array('class' => 'no-underline'))) }}

                                <span class="link-pad"></span>

                                {{ HTML::decode(HTML::linkAction(
                                        'SensationsController@getDelete',
                                        '<i class="fa fa-fw fa-trash"></i> Delete',
                                        array($sensation['id']),
                                        array('class' => 'no-underline'))) }}
                        </td>
                </tr>
                @endforeach
        </tbody>
</table>

@stop
