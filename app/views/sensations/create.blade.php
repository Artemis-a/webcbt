@extends('layouts.master')

@section('define')

@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {
});

</script>

@stop

@section('page-title', 'New Sensation')

@section('content')

{{ Form::open() }}

{{ Form::openGroup('name', 'Name') }}
        {{ Form::text('name') }}
{{ Form::closeGroup() }}

{{ Form::submit('Submit') }}
{{ HTML::linkAction('SensationsController@getIndex', 'Cancel') }}

{{ Form::close() }}

@stop
