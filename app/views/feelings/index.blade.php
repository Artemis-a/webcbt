@extends('layouts.master')

@section('head')

<script type="text/javascript">

$(document).ready(function() {
});

</script>

@stop

@section('page-title', 'Feelings')

@section('content')

{{ HTML::linkAction('FeelingsController@getCreate', 'New Feeling', array(), array('class' => 'btn btn-primary')) }}

<br />
<br />

<table class="table table-hover">
        <thead>
                <tr>
                        <th>Feelings</th>
                        <th>Added On</th>
                        <th>Actions</th>
                </tr>
        </thead>
        <tbody>
                @foreach ($feelings as $feeling)
                <tr>
                        <td>{{ $feeling['name'] }}</td>
                        <td>{{ $feeling['created_at'] }}</td>
                        <td>
                                {{ HTML::decode(HTML::linkAction(
                                        'FeelingsController@getStats',
                                        '<i class="fa fa-fw fa-list"></i> Stats',
                                        array($feeling['id']),
                                        array('class' => 'no-underline'))) }}

                                <span class="link-pad"></span>

                                {{ HTML::decode(HTML::linkAction(
                                        'FeelingsController@getEdit',
                                        '<i class="fa fa-fw fa-edit"></i> Edit',
                                        array($feeling['id']),
                                        array('class' => 'no-underline'))) }}

                                <span class="link-pad"></span>

                                {{ HTML::decode(HTML::linkAction(
                                        'FeelingsController@getDelete',
                                        '<i class="fa fa-fw fa-trash"></i> Delete',
                                        array($feeling['id']),
                                        array('class' => 'no-underline'))) }}
                        </td>
                </tr>
                @endforeach
        </tbody>
</table>

@stop
