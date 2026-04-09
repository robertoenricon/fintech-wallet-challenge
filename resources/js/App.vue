<template>
    <DashboardPage
        v-if="page === 'dashboard'"
        :user-name="userName"
        :balance="balance"
        :transfer-url="transferUrl"
        :transfers-url="transfersUrl"
        :transactions-url="transactionsUrl"
        :recent-transactions="recentTransactions"
    />

    <TransferCreatePage
        v-else-if="page === 'transfer-create'"
        :store-url="storeUrl"
        :dashboard-url="dashboardUrl"
        :initial-email="initialEmail"
        :initial-value="initialValue"
    />

    <TransfersIndexPage
        v-else-if="page === 'transfers-index'"
        :dashboard-url="dashboardUrl"
        :transfer-create-url="transferCreateUrl"
        :transfers="transfers"
    />

    <section v-else class="alert alert-warning mb-0">
        Página Vue não configurada.
    </section>
</template>

<script setup>
import DashboardPage from './pages/DashboardPage.vue';
import TransferCreatePage from './pages/TransferCreatePage.vue';
import TransfersIndexPage from './pages/TransfersIndexPage.vue';

defineProps({
    page: {
        type: String,
        default: '',
    },
    userName: {
        type: String,
        default: '',
    },
    balance: {
        type: Number,
        default: 0,
    },
    transferUrl: {
        type: String,
        default: '',
    },
    transactionsUrl: {
        type: String,
        default: '',
    },
    transfersUrl: {
        type: String,
        default: '',
    },
    storeUrl: {
        type: String,
        default: '',
    },
    recentTransactions: {
        type: Array,
        default: () => [],
    },
    dashboardUrl: {
        type: String,
        default: '',
    },
    transferCreateUrl: {
        type: String,
        default: '',
    },
    transfers: {
        type: Array,
        default: () => [],
    },
    initialEmail: {
        type: String,
        default: '',
    },
    initialValue: {
        type: String,
        default: '',
    },
});
</script>
