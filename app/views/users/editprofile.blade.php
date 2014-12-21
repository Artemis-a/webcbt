@extends('layouts.master')

@section('define')
        {{ $maxRows = 20 }}
@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {
        /* Date and time picker */
        $('#dob').datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                minDate: new Date(1900, 1 - 1, 1),
                maxDate: "-1D",
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
        {{ Form::select('gender', array('' => 'Please select...', 'M' => 'Male', 'F' => 'Female', 'U' => 'Undisclosed')) }}
{{ Form::closeGroup() }}

{{ Form::openGroup('dob', 'Date of birth') }}
        {{ Form::text('dob') }}
{{ Form::closeGroup() }}

{{ Form::openGroup('dateformat', 'Date format') }}
        {{ Form::select('dateformat', array(
                '' => 'Please select...',
                'd-M-Y|dd-M-yy' => 'Day-Month-Year',
                'M-d-Y|M-dd-yy' => 'Month-Day-Year',
                'Y-M-d|yy-M-dd' => 'Year-Month-Day')) }}
{{ Form::closeGroup() }}

{{ Form::openGroup('timezone', 'Timezone') }}
        {{ Form::select('timezone', array('' => 'Please select...', 'India' => 'India')) }}
{{ Form::closeGroup() }}

{{ Form::submit('Submit') }}
{{ HTML::linkAction('UsersController@getProfile', 'Cancel') }}

{{ Form::close() }}


@stop
