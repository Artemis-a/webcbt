@extends('layouts.master')

@section('define')

@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {
});

</script>

@stop

@section('page-title', 'New Physical Symptom')

@section('content')

{{ Form::open() }}

{{ Form::openGroup('name', 'Name') }}
        {{ Form::text('name') }}
{{ Form::closeGroup() }}

{{ Form::submit('Submit') }}
{{ HTML::linkAction('SymptomsController@getIndex', 'Cancel') }}

{{ Form::close() }}

@stop
