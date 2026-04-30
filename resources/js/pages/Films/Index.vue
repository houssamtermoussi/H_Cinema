<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import filmRoutes from "@/routes/films";
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    films: any[];
}>();
</script>

<template>
    <Head title="Tous les Films" />
        <div class="py-12 md:py-20 bg-gray-50 dark:bg-gray-950 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 md:px-8">
                <header class="mb-12 text-center md:text-left">
                    <h1 class="text-4xl md:text-6xl font-black text-gray-900 dark:text-white mb-4 tracking-tight font-cinzel">À L'AFFICHE</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium max-w-2xl">Découvrez les films du moment et réservez votre séance pour une expérience inoubliable.</p>
                </header>

                <div v-if="films.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-8">
                    <div v-for="film in films" :key="film.id" class="group relative bg-white dark:bg-gray-900 rounded-3xl overflow-hidden shadow-xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 dark:border-gray-800 hover:shadow-2xl hover:shadow-[#cc0000]/10">
                        <div class="aspect-[2/3] w-full bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                            <img v-if="film.affiche" :src="film.affiche" :alt="film.titre" class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700" onerror="this.src='/images/posters/default.jpg'" />
                            <div v-else class="w-full h-full flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" /></svg>
                            </div>
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                                <Link :href="filmRoutes.show(film.id)" class="w-full py-3 bg-[#cc0000] text-white font-bold rounded-xl text-center shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                    Réserver
                                </Link>
                            </div>

                            <div class="absolute top-4 left-4">
                                <span class="inline-block px-3 py-1 bg-black/60 backdrop-blur-md text-[10px] font-black uppercase rounded-lg text-white tracking-widest border border-white/10 shadow-lg">{{ film.type }}</span>
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <h3 class="text-gray-900 dark:text-white font-black text-xl leading-tight mb-2 group-hover:text-[#cc0000] transition-colors duration-300 truncate" :title="film.titre">{{ film.titre }}</h3>
                            <div class="flex items-center justify-between text-gray-500 dark:text-gray-400 text-sm font-bold">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#cc0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ film.duree }} min
                                </div>
                                <span>{{ new Date(film.date_sortie).getFullYear() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div v-else class="flex flex-col items-center justify-center py-32 bg-white dark:bg-gray-900 rounded-[3rem] border border-dashed border-gray-200 dark:border-gray-800">
                    <div class="w-20 h-20 bg-gray-50 dark:bg-gray-950 rounded-full flex items-center justify-center mb-6 shadow-inner">
                        <svg class="w-10 h-10 text-gray-300 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-2">Aucun film disponible</h2>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">Revenez plus tard pour découvrir nos prochaines sorties.</p>
                </div>
            </div>
        </div>
</template>

