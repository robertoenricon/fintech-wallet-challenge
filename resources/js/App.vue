<template>
    <DashboardPage
        v-if="page === 'dashboard'"
        :user-name="userName"
        :balance="balance"
        :transfer-url="transferUrl"
        :transactions-url="transactionsUrl"
    />

    <TransferCreatePage
        v-else-if="page === 'transfer-create'"
        :store-url="storeUrl"
        :dashboard-url="dashboardUrl"
        :initial-email="initialEmail"
        :initial-value="initialValue"
    />

    <section v-else class="alert alert-warning mb-0">
        Página Vue não configurada.
    </section>
</template>

<script setup>
import DashboardPage from './pages/DashboardPage.vue';
import TransferCreatePage from './pages/TransferCreatePage.vue';

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
    storeUrl: {
        type: String,
        default: '',
    },
    dashboardUrl: {
        type: String,
        default: '',
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
