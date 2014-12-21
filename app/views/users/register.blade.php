@extends('layouts.user')

@section('head')

<script type="text/javascript">

$(document).ready(function() {

});

</script>

@stop

@section('page-title', 'Register')

@section('content')

{{ Form::open() }}

{{ Form::openGroup('username', 'Username') }}
        {{ Form::text('username') }}
{{ Form::closeGroup() }}

{{ Form::openGroup('password', 'Password') }}
        {{ Form::password('password') }}
{{ Form::closeGroup() }}

{{ Form::openGroup('email', 'Email') }}
        {{ Form::text('email') }}
{{ Form::closeGroup() }}

{{ Form::submit('Submit') }}
{{ HTML::linkAction('UsersController@getLogin', 'Login') }}

{{ Form::close() }}

@stop
