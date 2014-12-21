@extends('layouts.master')

@section('head')

<script type="text/javascript">

$(document).ready(function() {
});

</script>

@stop

@section('page-title', 'Physical Symptoms')

@section('content')

{{ HTML::linkAction('SymptomsController@getCreate', 'New Physical Symptom', array(), array('class' => 'btn btn-primary')) }}

<br />
<br />

<table class="table table-hover">
        <thead>
                <tr>
                        <th>Physical Symptom</th>
                        <th>Added On</th>
                        <th>Actions</th>
                </tr>
        </thead>
        <tbody>
                @foreach ($symptoms as $symptom)
                <tr>
                        <td>{{ $symptom['name'] }}</td>
                        <td>{{ $symptom['created_at'] }}</td>
                        <td>
                                {{ HTML::decode(HTML::linkAction(
                                        'SymptomsController@getStats',
                                        '<i class="fa fa-fw fa-list"></i> Stats',
                                        array($symptom['id']),
                                        array('class' => 'no-underline'))) }}

                                <span class="link-pad"></span>

                                {{ HTML::decode(HTML::linkAction(
                                        'SymptomsController@getEdit',
                                        '<i class="fa fa-fw fa-edit"></i> Edit',
                                        array($symptom['id']),
                                        array('class' => 'no-underline'))) }}

                                <span class="link-pad"></span>

                                {{ HTML::decode(HTML::linkAction(
                                        'SymptomsController@getDelete',
                                        '<i class="fa fa-fw fa-trash"></i> Delete',
                                        array($symptom['id']),
                                        array('class' => 'no-underline'))) }}
                        </td>
                </tr>
                @endforeach
        </tbody>
</table>

@stop
