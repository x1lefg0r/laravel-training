<template>
    <!-- Уведомление о новой статье -->
    <transition name="fade">
        <div v-if="article" class="fixed top-4 right-4 z-50 max-w-md">
            <div class="bg-gradient-to-r from-violet-600 to-indigo-600 text-white rounded-xl shadow-2xl p-6 border border-violet-400">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <h3 class="font-bold text-lg">Новая статья!</h3>
                    </div>
                    <button @click="closeNotification" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="mb-4">
                    <p class="font-semibold text-lg mb-1">{{ article.title }}</p>
                    <p class="text-sm opacity-90">Автор: {{ article.author }}</p>
                    <p class="text-xs opacity-75 mt-1">{{ article.published_at }}</p>
                </div>
                
                <a 
                    :href="`/articles/${article.id}`" 
                    class="block w-full bg-white text-violet-600 text-center py-2 px-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors"
                >
                    Посмотреть статью →
                </a>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    data() {
        return {
            article: null
        }
    },
    
    mounted() {
        console.log('Notification component mounted');
        
        // Слушаем канал "articles" на событие "NewArticleEvent"
        window.Echo.channel('articles')
            .listen('NewArticleEvent', (data) => {
                console.log('New article received:', data);
                this.article = data.article;
                
                // Автоматически скрываем через 10 секунд
                setTimeout(() => {
                    this.closeNotification();
                }, 10000);
            });
    },
    
    methods: {
        closeNotification() {
            this.article = null;
        }
    }
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: all 0.3s ease;
}

.fade-enter-from {
    opacity: 0;
    transform: translateX(100px);
}

.fade-leave-to {
    opacity: 0;
    transform: translateX(100px);
}
</style>