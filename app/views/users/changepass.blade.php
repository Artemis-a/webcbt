@extends('layouts.master')

@section('define')
        {{ $maxRows = 20 }}
@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {

});

</script>

@stop

@section('page-title', 'Change Password')

@section('content')

{{ Form::open() }}

{{ Form::openGroup('oldpassword', 'Old Password') }}
        {{ Form::password('oldpassword') }}
{{ Form::closeGroup() }}

{{ Form::openGroup('newpassword', 'New Password') }}
        {{ Form::password('newpassword') }}
{{ Form::closeGroup() }}

{{ Form::submit('Submit') }}
{{ HTML::linkAction('UsersController@getProfile', 'Cancel') }}

{{ Form::close() }}

@stop
