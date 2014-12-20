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
        <div class="panel panel-primary">
                <div class="panel-heading">
                        <div class="row">
                                <div class="col-xs-3"><i class="fa fa-list-alt fa-5x"></i></div>
                                <div class="col-xs-9 text-right">
                                        <div class="huge">26</div>
                                        <div>CBT Exercises</div>
                                </div>
                        </div>
                </div>
                <a href="#">
                        <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                        </div>
                </a>
        </div>
        </div>

        <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
                <div class="panel-heading">
                        <div class="row">
                                <div class="col-xs-3"><i class="fa fa-warning fa-5x"></i></div>
                                <div class="col-xs-9 text-right">
                                        <div class="huge">12</div>
                                        <div>Unresolved Situations</div>
                                </div>
                        </div>
                </div>
                <a href="#">
                        <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                        </div>
                </a>
        </div>
        </div>

        <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
                <div class="panel-heading">
                        <div class="row">
                                <div class="col-xs-3"><i class="fa fa-wrench fa-5x"></i></div>
                                <div class="col-xs-9 text-right">
                                        <div class="huge">13</div>
                                        <div>Thoughts To Dispute</div>
                                </div>
                        </div>
                </div>
                <a href="#">
                        <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                        </div>
                </a>
        </div>
        </div>

        <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
                <div class="panel-heading">
                        <div class="row">
                                <div class="col-xs-3"><i class="fa fa-calendar fa-5x"></i></div>
                                <div class="col-xs-9 text-right">
                                        <div class="huge">124</div>
                                        <div>Active Days</div>
                                </div>
                        </div>
                </div>
                <a href="#">
                        <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                        </div>
                </a>
        </div>
        </div>

</div>
<!-- /.row -->


@stop
