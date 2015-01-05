{{--

The MIT License (MIT)

WebCBT - Web based Cognitive Behavioral Therapy tool

http://webcbt.github.io

Copyright (c) 2014 Prashant Shah <pshah.webcbt@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

--}}

@extends('layouts.master')

@section('define')

@endsection

@section('head')

{{ HTML::style('css/pick-a-color-1.2.3.min.css') }}
{{ HTML::script('js/tinycolor-0.9.15.min.js') }}
{{ HTML::script('js/pick-a-color-1.2.3.min.js') }}

<style type="text/css">
        #color {
                width: 100px;
        }
        #background {
                width: 100px;
        }
</style>

<script type="text/javascript">
	$(document).ready(function () {
		$(".pick-a-color").pickAColor();
	});
</script>

@stop

@section('page-title', 'New Tag')

@section('content')

{{ Form::open() }}

{{ Form::openGroup('name', 'Name') }}
        {{ Form::text('name') }}
{{ Form::closeGroup() }}

{{ Form::openGroup('color', 'Font Color') }}
        {{ Form::text('color', null, array('class' => 'pick-a-color')) }}
{{ Form::closeGroup() }}

{{ Form::openGroup('background', 'Background Color') }}
        {{ Form::text('background', null, array('class' => 'pick-a-color')) }}
{{ Form::closeGroup() }}

{{ Form::submit('Submit') }}
{{ HTML::linkAction('TagsController@getIndex', 'Cancel') }}

{{ Form::close() }}

@stop
