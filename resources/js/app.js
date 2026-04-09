import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';

const vueRoot = document.getElementById('vue-app');

if (vueRoot) {
    createApp(App, {
        page: vueRoot.dataset.page ?? '',
        userName: vueRoot.dataset.userName ?? '',
        balance: Number(vueRoot.dataset.balance ?? 0),
        transferUrl: vueRoot.dataset.transferUrl ?? '',
        transactionsUrl: vueRoot.dataset.transactionsUrl ?? '',
        storeUrl: vueRoot.dataset.storeUrl ?? '',
        dashboardUrl: vueRoot.dataset.dashboardUrl ?? '',
        initialEmail: vueRoot.dataset.email ?? '',
        initialValue: vueRoot.dataset.value ?? '',
    }).mount(vueRoot);
}
