@extends('layouts.user')

@section('head')

<script type="text/javascript">

$(document).ready(function() {

});

</script>

@stop

@section('page-title', 'Forgot Password')

@section('content')

{{ Form::open() }}

{{ Form::openGroup('userinput', 'Username / Email') }}
        {{ Form::text('userinput') }}
{{ Form::closeGroup() }}

{{ Form::submit('Submit') }}
{{ HTML::linkAction('UsersController@getLogin', 'Login') }}
{{ HTML::linkAction('UsersController@getRegister', 'Register') }}

{{ Form::close() }}

@stop
