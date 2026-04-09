@extends('layouts.app')

@section('content')
<div class="container">
    <div
        id="vue-app"
        data-page="dashboard"
        data-user-name="{{ $user->name }}"
        data-balance="{{ $user->wallet->balance ?? 0 }}"
        data-transfer-url="{{ route('transfers.create') }}"
        data-transfers-url="{{ route('transfers.index') }}"
        data-transactions-url="{{ route('transactions.index') }}"
        data-recent-transactions="{{ json_encode($recentTransactions, JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_TAG | JSON_HEX_QUOT) }}"
    ></div>
</div>
@endsection
