import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';

const vueRoot = document.getElementById('vue-app');
const recentTransactions = vueRoot?.dataset.recentTransactions
    ? JSON.parse(vueRoot.dataset.recentTransactions)
    : [];
const transfers = vueRoot?.dataset.transfers
    ? JSON.parse(vueRoot.dataset.transfers)
    : [];

if (vueRoot) {
    createApp(App, {
        page: vueRoot.dataset.page ?? '',
        userName: vueRoot.dataset.userName ?? '',
        balance: Number(vueRoot.dataset.balance ?? 0),
        transferUrl: vueRoot.dataset.transferUrl ?? '',
        transfersUrl: vueRoot.dataset.transfersUrl ?? '',
        transactionsUrl: vueRoot.dataset.transactionsUrl ?? '',
        recentTransactions,
        storeUrl: vueRoot.dataset.storeUrl ?? '',
        dashboardUrl: vueRoot.dataset.dashboardUrl ?? '',
        transferCreateUrl: vueRoot.dataset.transferCreateUrl ?? '',
        transfers,
        initialEmail: vueRoot.dataset.email ?? '',
        initialValue: vueRoot.dataset.value ?? '',
    }).mount(vueRoot);
}
