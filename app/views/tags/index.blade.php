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

@section('head')

<script type="text/javascript">

$(document).ready(function() {
});

</script>

@stop

@section('page-title', 'Tags')

@section('content')

{{ HTML::linkAction('TagsController@getCreate', 'New Tag', array(), array('class' => 'btn btn-primary')) }}

<br />
<br />

<table class="table table-hover">
        <thead>
                <tr>
                        <th>Tags</th>
                        <th></th>
                        <th>Added On</th>
                        <th>Actions</th>
                </tr>
        </thead>
        <tbody>
                @foreach ($tags as $tag)
                <tr>
                        <td><span class="pad-name"></span>{{ $tag->name }}</td>
                        <td>
                                <span style="color:#{{ $tag->color }}; background:#{{ $tag->background }};" class="tag">
                                        {{ $tag->name }}
                                </span>
                        </td>
                        <td>{{ date_format(date_create_from_format('Y-m-d H:i:s', $tag->created_at), $dateformat_php) }}</td>
                        <td>
                                {{ HTML::decode(HTML::linkAction(
                                        'TagsController@getEdit',
                                        '<i class="fa fa-fw fa-edit"></i> Edit',
                                        array($tag->id),
                                        array('class' => 'no-underline'))) }}

                                <span class="link-pad"></span>

                                {{ HTML::decode(HTML::linkAction(
                                        'TagsController@deleteDestroy',
                                        '<i class="fa fa-fw fa-trash"></i> Delete',
                                        array($tag->id),
                                        array(
                                                'class' => 'no-underline',
                                                'data-method' => 'DELETE',
                                                'data-confirm' => 'Are you sure you want to delete the tag ?'
                                        ))) }}
                        </td>
                </tr>
                @endforeach
        </tbody>
</table>

@stop
