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

@section('page-title', 'Dashboard')

@section('content')

<!-- Top panels -->
<div class="row">

        <div class="col-lg-3 col-md-6">
        <div class="panel panel-info">
                <div class="panel-heading">
                        <div class="row">
                                <div class="col-xs-3"><i class="fa fa-warning fa-5x"></i></div>
                                <div class="col-xs-9 text-right">
                                        <div class="huge">{{ $unresolved_count }}</div>
                                        <div>Unresolved Situations</div>
                                </div>
                        </div>
                </div>
                {{ HTML::decode(HTML::linkAction('CbtsController@getIndex', '
                        <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                        </div>
                ')) }}
        </div>
        </div>

        <div class="col-lg-3 col-md-6">
        <div class="panel panel-info">
                <div class="panel-heading">
                        <div class="row">
                                <div class="col-xs-3"><i class="fa fa-wrench fa-5x"></i></div>
                                <div class="col-xs-9 text-right">
                                        <div class="huge">{{ $undisputed_count }}</div>
                                        <div>Thoughts To Dispute</div>
                                </div>
                        </div>
                </div>
                {{ HTML::decode(HTML::linkAction('CbtsController@getIndex', '
                        <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                        </div>
                ')) }}
        </div>
        </div>

        <div class="col-lg-3 col-md-6">
        <div class="panel panel-info">
                <div class="panel-heading">
                        <div class="row">
                                <div class="col-xs-3"><i class="fa fa-list-alt fa-5x"></i></div>
                                <div class="col-xs-9 text-right">
                                        <div class="huge">{{ $exercise_count }}</div>
                                        <div>CBT Exercises</div>
                                </div>
                        </div>
                </div>
                {{ HTML::decode(HTML::linkAction('CbtsController@getIndex', '
                        <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                        </div>
                ')) }}
        </div>
        </div>

        <div class="col-lg-3 col-md-6">
        <div class="panel panel-info">
                <div class="panel-heading">
                        <div class="row">
                                <div class="col-xs-3"><i class="fa fa-calendar fa-5x"></i></div>
                                <div class="col-xs-9 text-right">
                                        <div class="huge">{{ $diff_days }}</div>
                                        <div>Active Days</div>
                                </div>
                        </div>
                </div>
                {{ HTML::decode(HTML::linkAction('UsersController@getProfile', '
                        <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                        </div>
                ')) }}
        </div>
        </div>

</div>
<!-- /.row -->

Last Login On : {{ date_format(date_create_from_format('Y-m-d H:i:s', Auth::user()->last_login), $dateformat_php . ' h:i A') }}


@stop
