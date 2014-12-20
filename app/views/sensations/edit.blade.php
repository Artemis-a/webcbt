@extends('layouts.master')

@section('define')

@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {
});

</script>

@stop

@section('page-title', 'Edit Sensation')

@section('content')

{{ Form::model($sensation) }}

{{ Form::openGroup('name', 'Name') }}
        {{ Form::text('name') }}
{{ Form::closeGroup() }}

{{ Form::submit('Submit') }}
{{ HTML::linkAction('SensationsController@getIndex', 'Cancel') }}

{{ Form::close() }}

@stop
