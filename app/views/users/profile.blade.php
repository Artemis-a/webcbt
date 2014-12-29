{{--

The MIT License (MIT)

WebCBT - Web based Cognitive Behavioral Therapy tool

http://mindtools.github.io/webcbt/

Copyright (c) 2014 Prashant Shah <pshah.mindtools@gmail.com>

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
        {{ $maxRows = 20 }}
@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {

});

</script>

@stop

@section('page-title', 'Profile')

@section('content')


{{ HTML::linkAction('UsersController@getEditprofile', 'Edit Profile', array(), array('class' => 'btn btn-primary')) }}

<table class="table borderless table-pad">
<tr>
        <td width="120px">Fullname</td><td width="1px">:</td><td>{{ $user->fullname }}</td>
</tr>
<tr>
        <td>Username</td><td>:</td><td>{{ $user->username }}</td>
</tr>
<tr>
        <td>Email</td><td>:</td><td>{{ $user->email }}</td>
</tr>
<tr>
        <td>Gender</td><td>:</td>
        <td>
                @if ($user->gender == 'M')
                        {{ 'Male' }}
                @elseif ($user->gender == 'F')
                        {{ 'Female' }}
                @elseif ($user->gender == 'U')
                        {{ 'Undisclosed' }}
                @else
                        {{ 'ERROR' }}
                @endif
        </td>
</tr>
<tr>
        <td>Date format</td><td>:</td>
        <td>
                @if ($user->dateformat == 'd-M-Y|dd-M-yy')
                        {{ 'Day-Month-Year' }}
                @elseif ($user->dateformat == 'M-d-Y|M-dd-yy')
                        {{ 'Month-Day-Year' }}
                @elseif ($user->dateformat == 'Y-M-d|yy-M-dd')
                        {{ 'Year-Month-Day' }}
                @else
                        {{ 'ERROR' }}
                @endif
        </td>
</tr>
<tr>
        <td>Date of birth</td><td>:</td><td>{{ $dob }}</td>
</tr>
<tr>
        <td>Timezone</td><td>:</td><td>{{ $timezone_options[$user->timezone] }}</td>
</tr>
<tr>
        <td>Created</td><td>:</td><td>{{ $user->created_at }}</td>
</tr>
</table>

{{ HTML::linkAction('UsersController@getChangepass', 'Change Password', array()) }}

@stop
