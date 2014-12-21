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
        <td>Date of birth</td><td>:</td><td>{{ $user->dob }}</td>
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
        <td>Timezone</td><td>:</td><td>{{ $user->timezone }}</td>
</tr>
<tr>
        <td>Created</td><td>:</td><td>{{ $user->created_at }}</td>
</tr>
</table>

@stop
