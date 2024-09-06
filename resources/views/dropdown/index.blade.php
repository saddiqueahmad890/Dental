@extends('layouts.app')

@section('content')
    <h1>Manage Dropdowns</h1>
    <ul>
        <li><a href="{{ route('blood_groups.index') }}">Blood Groups</a></li>
        <li><a href="{{ route('marital_statuses.index') }}">Marital Statuses</a></li>
        <!-- Add more dropdowns here -->
    </ul>
@endsection
