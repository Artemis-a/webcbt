@extends('layouts.user')

@section('head')

<script type="text/javascript">

$(document).ready(function() {

});

</script>

@stop

@section('page-title', 'Login')

@section('content')

{{ Form::open() }}

{{ Form::openGroup('username', 'Username') }}
        {{ Form::text('username') }}
{{ Form::closeGroup() }}

{{ Form::openGroup('password', 'Password') }}
        {{ Form::password('password') }}
{{ Form::closeGroup() }}

{{ Form::submit('Submit') }}
{{ HTML::linkAction('UsersController@getRegister', 'Register') }}

{{ Form::close() }}

@stop
