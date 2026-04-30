<script setup lang="ts">
import { Link, usePage, router } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import { dashboard, home, login, logout, register } from '@/routes';
import { index as adminFilmsIndex } from '@/routes/admin/films';

const props = defineProps<{
    searchQuery?: string;
}>();

const isDark = ref(false);
const isUserMenuOpen = ref(false);
const localSearchQuery = ref(props.searchQuery || '');

onMounted(() => {
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

const toggleUserMenu = () => {
    isUserMenuOpen.value = !isUserMenuOpen.value;
};

const handleSearch = () => {
    router.get(home.url(), { 
        search: localSearchQuery.value 
    }, { preserveState: true });
};

// Debounced search watch
let searchTimeout: any = null;
watch(localSearchQuery, () => {
    if (searchTimeout) clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        handleSearch();
    }, 400);
});

const page = usePage();
</script>

<template>
    <div class="min-h-screen bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100 transition-colors duration-300 flex flex-col">
        <!-- Floating Header Wrapper -->
        <div class="sticky top-0 z-50 px-4 pt-4 pb-4 md:px-8 md:pt-5 md:pb-6">
            <header class="bg-[#cc0000]/95 backdrop-blur-md text-white rounded-2xl shadow-[0_8px_32px_rgba(204,0,0,0.35)] border border-white/10 transition-all duration-300">
                <div class="px-5 py-3 flex items-center justify-between">
                    <!-- Left: Logo & Title -->
                    <Link href="/" class="flex items-center gap-3 group">
                        <img src="/images/logo2.png" alt="H-Cinema Logo" class="h-9 w-auto transform group-hover:scale-105 transition-transform duration-300" onerror="this.src='https://ui-avatars.com/api/?name=HC&background=fff&color=cc0000&rounded=true'" />
                        <span class="font-cinzel text-xl font-bold tracking-wider">𝓗-𝓒𝓲𝓷𝓮𝓶𝓪</span>
                    </Link>

                    <!-- Right: Search, Theme, User -->
                    <div class="flex items-center gap-4">
                        <!-- Search Bar -->
                        <div class="relative hidden md:block">
                            <input
                                type="text"
                                v-model="localSearchQuery"
                                placeholder="Rechercher un film..."
                                class="bg-white/15 text-white placeholder-white/60 border border-white/25 rounded-full px-4 py-1.5 pr-10 focus:outline-none focus:ring-2 focus:ring-white/40 focus:bg-white/25 transition-all duration-300 w-56 text-sm"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute right-3 top-1/2 transform -translate-y-1/2 text-white/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <!-- Dark Mode Toggle -->
                        <button @click="toggleTheme" class="p-2 rounded-full hover:bg-white/20 transition-colors duration-300 focus:outline-none" aria-label="Toggle Theme">
                            <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>

                        <!-- Separator -->
                        <div class="hidden md:block w-px h-6 bg-white/25"></div>

                        <!-- User Section -->
                        <div class="relative">
                            <template v-if="!$page.props.auth.user">
                                <div class="flex items-center gap-2">
                                    <Link :href="login.url()" class="font-semibold text-sm px-4 py-1.5 rounded-full bg-white text-[#cc0000] hover:bg-gray-100 transition-colors duration-300 shadow-sm">
                                        Se connecter
                                    </Link>
                                    <Link :href="register.url()" class="font-semibold text-sm px-4 py-1.5 rounded-full border border-white/60 text-white hover:bg-white hover:text-[#cc0000] transition-all duration-300">
                                        S'inscrire
                                    </Link>
                                </div>
                            </template>
                            <template v-else>
                                <!-- Authenticated user controls -->
                                <div class="flex items-center gap-3">
                                    <!-- Settings button -->
                                    <Link :href="dashboard.url()" class="flex items-center gap-1.5 text-sm font-medium px-3 py-1.5 rounded-full bg-white/15 hover:bg-white/25 border border-white/20 transition-all duration-300" title="Paramètres">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="hidden lg:inline">Paramètres</span>
                                    </Link>

                                    <!-- Avatar dropdown -->
                                    <div class="relative">
                                        <button @click="toggleUserMenu" class="flex items-center gap-2 font-medium hover:text-white/80 transition-colors focus:outline-none">
                                            <img :src="`https://ui-avatars.com/api/?name=${$page.props.auth.user.name}&background=fff&color=cc0000&rounded=true`" alt="Avatar" class="h-8 w-8 rounded-full border-2 border-white/40 shadow-sm" />
                                            <span class="hidden md:inline text-sm">{{ $page.props.auth.user.name }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <!-- Overlay to close menu -->
                                        <div v-if="isUserMenuOpen" class="fixed inset-0 z-40" @click="isUserMenuOpen = false"></div>
                                        <!-- Dropdown -->
                                        <div v-show="isUserMenuOpen" class="absolute right-0 mt-3 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-xl py-2 border border-gray-100 dark:border-gray-700 overflow-hidden transform origin-top-right transition-all z-50">
                                            <Link :href="dashboard.url()" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Mon compte</Link>
                                            <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                                            <Link v-if="$page.props.auth.user.role === 'admin'" :href="adminFilmsIndex.url()" class="block px-4 py-2 text-sm font-semibold text-[#cc0000] hover:bg-red-50 dark:hover:bg-red-900/20">Admin Dashboard</Link>
                                            <Link :href="logout.url()" method="post" as="button" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Déconnexion</Link>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </header>
        </div>

        <!-- Main Content -->
        <main class="flex-grow w-full">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white pt-16 pb-8 border-t border-gray-800">
            <div class="container mx-auto px-4 max-w-7xl">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-12 border-b border-gray-800 pb-12">
                    <div class="flex flex-col items-center md:items-start">
                        <Link href="/" class="flex items-center gap-3 mb-4">
                            <span class="font-cinzel text-2xl font-bold tracking-wider text-[#cc0000]">H-CINEMA</span>
                        </Link>
                        <p class="text-gray-400 text-center md:text-left max-w-xs">Votre destination premium pour l'expérience cinématographique ultime.</p>
                    </div>
                    
                    <div class="flex flex-col items-center gap-3 text-center">
                        <h4 class="text-lg font-bold mb-2">Contactez-nous</h4>
                        <a href="mailto:contact@h-cinema.com" class="text-gray-300 hover:text-[#cc0000] flex items-center gap-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            contact@h-cinema.com
                        </a>
                        <a href="tel:+212500000000" class="text-gray-300 hover:text-[#cc0000] flex items-center gap-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            +212 500 000 000
                        </a>
                    </div>
                    
                    <div class="flex flex-col items-center md:items-end">
                        <h4 class="text-lg font-bold mb-4">Suivez-nous</h4>
                        <div class="flex gap-4">
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-[#cc0000] transition-colors duration-300">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-[#cc0000] transition-colors duration-300">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204 013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.20 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-[#cc0000] transition-colors duration-300">
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

<style>
body { font-family: 'Inter', sans-serif; }
.font-cinzel { font-family: 'Cinzel', serif; }
</style>
