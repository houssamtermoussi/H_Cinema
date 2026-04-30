<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { show as filmsShow } from '@/routes/films';
import GuestLayout from '@/layouts/GuestLayout.vue';

const props = defineProps<{
    canRegister: boolean;
    films: any;
    filters: {
        category?: string;
        search?: string;
    };
    categories: string[];
}>();

const selectedCategory = ref(props.filters.category || '');
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" >
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    </Head>

    <GuestLayout :search-query="filters.search">
        <div class="flex flex-col">
            <!-- Main Content -->
            <main class="flex-grow flex flex-col items-center justify-start w-full px-4 py-12 md:py-20">
                <!-- Hero Title -->
                <div class="text-center mb-16 animate-fade-in-up">
                    <h1 class="text-5xl md:text-7xl font-bold mb-2">
                        <span class="text-gray-900 dark:text-white">Welcome </span>
                        <span class="text-[#ff0000] font-cinzel">H-Cinema</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mt-4">Découvrez les meilleurs films, réservez vos places et vivez la magie du cinéma avec nous.</p>
                </div>

                <!-- Filters -->
                <div class="w-full max-w-7xl mx-auto mb-10 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-3 w-full md:w-auto overflow-x-auto pb-2 md:pb-0 scrollbar-hide">
                        <button 
                            @click="selectedCategory = ''"
                            :class="['px-5 py-2 rounded-full font-medium whitespace-nowrap transition-all shadow-sm', selectedCategory === '' ? 'bg-[#ff0000] text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700']"
                        >
                            Tous les films
                        </button>
                        <button 
                            v-for="category in categories" 
                            :key="category"
                            @click="selectedCategory = category"
                            :class="['px-5 py-2 rounded-full font-medium whitespace-nowrap transition-all shadow-sm', selectedCategory === category ? 'bg-[#ff0000] text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700']"
                        >
                            {{ category }}
                        </button>
                    </div>
                </div>

                <!-- Films Grid -->
                <div class="w-full max-w-7xl mx-auto">
                    <div v-if="films.data && films.data.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 lg:gap-8">
                        <Link v-for="film in films.data" :key="film.id" :href="filmsShow.url(film.id)" class="group flex flex-col bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-md hover:shadow-2xl hover:shadow-[#ff0000]/20 transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-800">
                            <!-- Poster Container -->
                            <div class="relative aspect-[2/3] w-full overflow-hidden bg-gray-200 dark:bg-gray-700">
                                <img :src="film.affiche" :alt="film.titre" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" onerror="this.src='/images/posters/default.jpg'" />
                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                    <span class="bg-[#ff0000] text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-lg">Réserver</span>
                                </div>
                                <!-- Category Badge -->
                                <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-md text-white text-xs px-2 py-1 rounded-md shadow-sm border border-white/10">
                                    {{ film.type }}
                                </div>
                            </div>
                            <!-- Content -->
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="font-bold text-lg leading-tight mb-1 group-hover:text-[#ff0000] transition-colors line-clamp-1" :title="film.titre">{{ film.titre }}</h3>
                                <div class="mt-auto flex justify-between items-center text-sm text-gray-500 dark:text-gray-400 font-medium">
                                    <span>{{ new Date(film.date_sortie).getFullYear() }}</span>
                                    <span class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ film.duree }} min
                                    </span>
                                </div>
                            </div>
                        </Link>
                    </div>
                    
                    <!-- Empty State -->
                    <div v-else class="py-20 text-center bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                        </svg>
                        <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300">Aucun film trouvé</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Essayez de modifier vos filtres ou de réinitialiser la recherche.</p>
                        <button @click="selectedCategory = ''; searchQuery = ''" class="mt-6 px-6 py-2 bg-[#ff0000] text-white font-medium rounded-full hover:bg-red-700 transition-colors shadow-md">
                            Voir tous les films
                        </button>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="films.last_page > 1" class="mt-16 flex items-center justify-center gap-2">
                    <Link 
                        v-if="films.prev_page_url" 
                        :href="films.prev_page_url" 
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-[#ff0000] transition-colors shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </Link>
                    <div class="flex gap-1">
                        <Link 
                            v-for="link in films.links.filter(l => !l.label.includes('Previous') && !l.label.includes('Next') && !l.label.includes('&laquo;') && !l.label.includes('&raquo;'))" 
                            :key="link.label"
                            :href="link.url || '#'"
                            :class="[
                                'flex items-center justify-center w-10 h-10 rounded-full font-medium transition-colors shadow-sm',
                                link.active 
                                    ? 'bg-[#ff0000] text-white shadow-md' 
                                    : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-[#ff0000]'
                            ]"
                            v-html="link.label"
                        ></Link>
                    </div>
                    <Link 
                        v-if="films.next_page_url" 
                        :href="films.next_page_url" 
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-[#ff0000] transition-colors shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </Link>
                </div>
            </main>
        </div>
    </GuestLayout>
</template>

<style scoped>
/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
}

/* Hide scrollbar for category filter container */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>

