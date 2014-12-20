@extends('layouts.master')

@section('define')

@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {
});

</script>

@stop

@section('page-title', 'Edit Feeling')

@section('content')

{{ Form::model($feeling) }}

{{ Form::openGroup('name', 'Name') }}
        {{ Form::text('name') }}
{{ Form::closeGroup() }}

{{ Form::submit('Submit') }}
{{ HTML::linkAction('FeelingsController@getIndex', 'Cancel') }}

{{ Form::close() }}

@stop
