@extends('emails.layout')

@section('content')
@endsection

@php
ob_start();
@endphp

<h2>New Incident Created</h2>

<p>
A new incident has been registered in the system.
</p>

<div class="card">

<div class="label">Ticket Number</div>
<div class="value">{{ $incident->incident_no }}</div>

<div class="label">Title</div>
<div class="value">{{ $incident->title }}</div>

<div class="label">Severity</div>
<div class="value">{{ strtoupper($incident->severity) }}</div>

<div class="label">Status</div>
<div class="value">{{ strtoupper($incident->status) }}</div>

</div>

<br>

<a
href="{{ url('/incidents/'.$incident->id) }}"
class="button">
Open Incident
</a>

@php
$slot = ob_get_clean();
echo view('emails.layout', compact('slot'))->render();
@endphp
