@extends('layouts.master')

@section('define')
        {{ $count = 1 }}
@endsection

@section('head')

<script type="text/javascript">

$(document).ready(function() {
});

</script>

@stop

@section('page-title', 'Help')

@section('content')

<h3>Disclaimer</h3>

This application is provided for general informational purposes only and is not intended as, nor should it be considered a substitute for professional medical care by a qualified doctor or other health care professional. ALWAYS check with your doctor if you have any concerns about your condition or treatment. Do not use the application for diagnosing or treating any medical or mental health condition. If you have or suspect you have a mental health problem, please contact your professional healthcare or mental health provider immediately.
<br />
<br />
This application is not responsible or liable, directly or indirectly, for ANY form of damages whatsoever resulting from the use (or misuse) of information contained in or implied by the application.

@stop
