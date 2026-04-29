<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import { dashboard, login, register, home, logout } from '@/routes';
import { show as filmsShow } from '@/routes/films';
import { index as adminFilmsIndex } from '@/routes/admin/films';

const props = defineProps<{
    canRegister: boolean;
    films: any;
    filters: {
        category?: string;
        search?: string;
    };
    categories: string[];
}>();

const isDark = ref(false);

onMounted(() => {
    // Check initial dark mode preference
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        isDark.value = true;
        document.documentElement.classList.add('dark');
    } else {
        isDark.value = false;
        document.documentElement.classList.remove('dark');
    }
});

const toggleTheme = () => {
    isDark.value = !isDark.value;
    if (isDark.value) {
        document.documentElement.classList.add('dark');
        localStorage.theme = 'dark';
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.theme = 'light';
    }
};

const searchQuery = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category || '');

const filterFilms = () => {
    router.get(home.url(), { 
        category: selectedCategory.value,
        search: searchQuery.value 
    }, { preserveState: true, preserveScroll: true });
};

// Use a watch with a small debounce for the search query
let searchTimeout: any = null;
watch(searchQuery, () => {
    if (searchTimeout) clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        filterFilms();
    }, 400);
});

watch(selectedCategory, () => {
    filterFilms();
});

const isUserMenuOpen = ref(false);

const toggleUserMenu = () => {
    isUserMenuOpen.value = !isUserMenuOpen.value;
};
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    </Head>

    <div class="min-h-screen bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100 transition-colors duration-300 flex flex-col">
        <!-- Header -->
        <header class="bg-[#ff0000] text-white shadow-lg sticky top-0 z-50">
            <div class="container mx-auto px-4 py-3 flex items-center justify-between">
                <!-- Left: Logo & Title -->
                <Link href="/" class="flex items-center gap-3 group">
                    <img src="/images/logo2.png" alt="H-Cinema Logo" class="h-10 w-auto transform group-hover:scale-105 transition-transform duration-300" onerror="this.src='https://ui-avatars.com/api/?name=HC&background=fff&color=f00&rounded=true'" />
                    <span class="font-cinzel text-2xl font-bold tracking-wider">H-CINEMA</span>
                </Link>

                <!-- Right: Search, Theme, User -->
                <div class="flex items-center gap-6">
                    <!-- Search Bar -->
                    <div class="relative hidden md:block">
                        <input 
                            type="text" 
                            v-model="searchQuery"
                            placeholder="Rechercher un film..." 
                            class="bg-white/20 text-white placeholder-white/70 border border-white/30 rounded-full px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-white/50 focus:bg-white/30 transition-all duration-300 w-64"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-1/2 transform -translate-y-1/2 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <!-- Dark Mode Toggle -->
                    <button @click="toggleTheme" class="p-2 rounded-full hover:bg-white/20 transition-colors duration-300 focus:outline-none" aria-label="Toggle Theme">
                        <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <!-- User Section -->
                    <div class="relative">
                        <template v-if="!$page.props.auth.user">
                            <Link :href="login.url()" class="font-semibold px-5 py-2 rounded-full bg-white text-[#ff0000] hover:bg-gray-100 transition-colors duration-300 shadow-sm">
                                Se connecter
                            </Link>
                        </template>
                        <template v-else>
                            <button @click="toggleUserMenu" class="flex items-center gap-2 font-medium hover:text-white/80 transition-colors focus:outline-none relative z-50">
                                <img :src="`https://ui-avatars.com/api/?name=${$page.props.auth.user.name}&background=fff&color=f00&rounded=true`" alt="Avatar" class="h-8 w-8 rounded-full border-2 border-white/50" />
                                <span class="hidden md:inline">{{ $page.props.auth.user.name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <!-- Overlay to close menu -->
                            <div v-if="isUserMenuOpen" class="fixed inset-0 z-40" @click="isUserMenuOpen = false"></div>
                            <!-- Dropdown -->
                            <div v-show="isUserMenuOpen" class="absolute right-0 mt-3 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-xl py-2 border border-gray-100 dark:border-gray-700 overflow-hidden transform origin-top-right transition-all z-50">
                                <Link :href="dashboard.url()" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Mon compte</Link>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Paramètres</a>
                                <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                                <Link v-if="$page.props.auth.user.role === 'admin'" :href="adminFilmsIndex.url()" class="block px-4 py-2 text-sm font-semibold text-[#ff0000] hover:bg-red-50 dark:hover:bg-red-900/20">Admin Dashboard</Link>
                                <Link :href="logout.url()" method="post" as="button" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Déconnexion</Link>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </header>

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
                
                <div class="w-full md:w-auto relative">
                    <select v-model="selectedCategory" class="appearance-none w-full md:w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 py-2 px-4 pr-8 rounded-xl leading-tight focus:outline-none focus:ring-2 focus:ring-[#ff0000]/50 shadow-sm transition-all">
                        <option value="">Toutes catégories</option>
                        <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-400">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Films Grid -->
            <div class="w-full max-w-7xl mx-auto">
                <div v-if="films.data && films.data.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 lg:gap-8">
                    <Link v-for="film in films.data" :key="film.id" :href="filmsShow.url(film.id)" class="group flex flex-col bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-md hover:shadow-2xl hover:shadow-[#ff0000]/20 transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-800">
                        <!-- Poster Container -->
                        <div class="relative aspect-[2/3] w-full overflow-hidden bg-gray-200 dark:bg-gray-700">
                            <img :src="`/images/posters/${film.affiche}`" :alt="film.titre" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" onerror="this.src='/images/posters/default.jpg'" />
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

        <!-- Footer -->
        <footer class="bg-gray-900 text-white pt-16 pb-8 border-t border-gray-800">
            <div class="container mx-auto px-4 max-w-7xl">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-12 border-b border-gray-800 pb-12">
                    <div class="flex flex-col items-center md:items-start">
                        <Link href="/" class="flex items-center gap-3 mb-4">
                            <span class="font-cinzel text-2xl font-bold tracking-wider text-[#ff0000]">H-CINEMA</span>
                        </Link>
                        <p class="text-gray-400 text-center md:text-left max-w-xs">Votre destination premium pour l'expérience cinématographique ultime.</p>
                    </div>
                    
                    <div class="flex flex-col items-center gap-3 text-center">
                        <h4 class="text-lg font-bold mb-2">Contactez-nous</h4>
                        <a href="mailto:contact@h-cinema.com" class="text-gray-300 hover:text-[#ff0000] flex items-center gap-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            contact@h-cinema.com
                        </a>
                        <a href="tel:+212500000000" class="text-gray-300 hover:text-[#ff0000] flex items-center gap-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            +212 500 000 000
                        </a>
                    </div>
                    
                    <div class="flex flex-col items-center md:items-end">
                        <h4 class="text-lg font-bold mb-4">Suivez-nous</h4>
                        <div class="flex gap-4">
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-[#ff0000] transition-colors duration-300">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-[#ff0000] transition-colors duration-300">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.20 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-[#ff0000] transition-colors duration-300">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.323-.593 1.323-1.325V1.325C24 .593 23.407 0 22.675 0z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="text-center text-gray-500 text-sm">
                    &copy; {{ new Date().getFullYear() }} H-Cinema. Tous droits réservés.
                </div>
            </div>
        </footer>
    </div>
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

<style>
body { font-family: 'Inter', sans-serif; }
.font-cinzel { font-family: 'Cinzel', serif; }
</style>
