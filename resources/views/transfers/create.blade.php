@extends('layouts.app')

@section('content')
<div class="container">
    <div
        id="vue-app"
        data-page="transfer-create"
        data-store-url="{{ route('transfers.store') }}"
        data-dashboard-url="{{ route('dashboard') }}"
        data-email="{{ old('email', '') }}"
        data-value="{{ old('value', '') }}"
    ></div>
</div>
@endsection
