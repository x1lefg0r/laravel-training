import './bootstrap';
import { createApp } from 'vue';
import NotificationComponent from './components/NotificationComponent.vue';

const app = createApp({
    components: {
        NotificationComponent
    }
});

app.mount('#app');