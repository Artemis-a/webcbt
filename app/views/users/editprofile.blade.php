@extends('layouts.master')

@section('head')

<script type="text/javascript">

$(document).ready(function() {
        /* Date and time picker */
        $('#dob').datepicker({
                dateFormat: $("#dateformat").val().split('|')[1],
                changeMonth: true,
                changeYear: true,
                minDate: new Date(1900, 1 - 1, 1),
                maxDate: "-1D",
        });

	$("#dateformat").change(function() {
                /* On change update the date format in the datepicker */
		$("#dob").datepicker("option", {
                        dateFormat: $("#dateformat").val().split('|')[1],
                        changeMonth: true,
                        changeYear: true,
                        minDate: new Date(1900, 1 - 1, 1),
                        maxDate: "-1D",
                });

	});
});

</script>

@stop

@section('page-title', 'Edit Profile')

@section('content')

{{ Form::model($user) }}

{{ Form::openGroup('fullname', 'Fullname') }}
        {{ Form::text('fullname') }}
{{ Form::closeGroup() }}

{{ Form::openGroup('email', 'Email') }}
        {{ Form::text('email') }}
{{ Form::closeGroup() }}

{{ Form::openGroup('gender', 'Gender') }}
        {{ Form::select('gender', $gender_options) }}
{{ Form::closeGroup() }}

{{ Form::openGroup('dateformat', 'Date format') }}
        {{ Form::select('dateformat', $dateformat_options) }}
{{ Form::closeGroup() }}

{{ Form::openGroup('dob', 'Date of birth') }}
        {{ Form::text('dob', $dob) }}
{{ Form::closeGroup() }}

{{ Form::openGroup('timezone', 'Timezone') }}
        {{ Form::select('timezone', $timezone_options) }}
{{ Form::closeGroup() }}

{{ Form::submit('Submit') }}
{{ HTML::linkAction('UsersController@getProfile', 'Cancel') }}

{{ Form::close() }}


@stop
