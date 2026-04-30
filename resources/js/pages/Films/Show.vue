<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import seanceRoutes from "@/routes/seances";
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps<{
    film: any;
}>();

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
};

const getDay = (dateString: string) => new Date(dateString).getDate();
const getWeekday = (dateString: string) => new Date(dateString).toLocaleDateString('fr-FR', { weekday: 'short' }).replace('.', '');
</script>

<template>
    <Head :title="film.titre" />
    <div class="min-h-screen bg-white dark:bg-gray-950">
        <!-- Hero Section with Background Blur -->
        <div class="relative w-full h-[70vh] md:h-[85vh] overflow-hidden -mt-[112px] md:-mt-[128px]">
            <div class="absolute inset-0">
                <img v-if="film.affiche" :src="film.affiche" :alt="film.titre" class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-gray-950 via-white/80 dark:via-gray-950/80 to-transparent"></div>
                <div class="absolute inset-0 backdrop-blur-[2px]"></div>
            </div>
            
            <div class="absolute inset-0 flex items-end">
                <div class="max-w-7xl mx-auto w-full px-4 md:px-8 pb-12">
                    <div class="flex flex-col md:flex-row gap-8 md:gap-12 items-center md:items-end text-center md:text-left">
                        <!-- Poster Card -->
                        <div class="w-48 h-72 md:w-64 md:h-[24rem] flex-shrink-0 rounded-2xl overflow-hidden shadow-2xl border border-white/20 transform md:-rotate-2 hover:rotate-0 transition-transform duration-500 hidden sm:block">
                            <img v-if="film.affiche" :src="film.affiche" :alt="film.titre" class="w-full h-full object-cover" onerror="this.src='/images/posters/default.jpg'" />
                        </div>
                        
                        <!-- Info -->
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-4">
                                <span class="px-3 py-1 bg-[#cc0000] text-[10px] font-black uppercase rounded-full text-white tracking-widest shadow-lg shadow-red-600/20">{{ film.type }}</span>
                                <span class="px-3 py-1 bg-gray-200 dark:bg-gray-800 text-[10px] font-bold uppercase rounded-full text-gray-700 dark:text-gray-300 tracking-wider">HD / 4K</span>
                            </div>
                            
                            <h1 class="text-4xl md:text-7xl font-black text-gray-900 dark:text-white mb-4 tracking-tighter leading-none font-cinzel">{{ film.titre }}</h1>
                            
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 md:gap-6 text-gray-600 dark:text-gray-400 mb-6">
                                <div class="flex items-center gap-2 bg-white/50 dark:bg-gray-900/50 backdrop-blur-md px-3 py-1.5 rounded-xl border border-gray-200 dark:border-gray-800">
                                    <svg class="w-5 h-5 text-[#cc0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span class="font-bold">{{ film.duree }} min</span>
                                </div>
                                <div class="flex items-center gap-2 bg-white/50 dark:bg-gray-900/50 backdrop-blur-md px-3 py-1.5 rounded-xl border border-gray-200 dark:border-gray-800">
                                    <svg class="w-5 h-5 text-[#cc0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z" /></svg>
                                    <span class="font-bold">{{ formatDate(film.date_sortie) }}</span>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 dark:text-gray-400 text-lg md:text-xl max-w-3xl leading-relaxed font-medium line-clamp-3 md:line-clamp-none">{{ film.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sessions Section -->
        <div class="bg-gray-50 dark:bg-gray-950 py-20">
            <div class="max-w-7xl mx-auto px-4 md:px-8">
                <div class="flex flex-col md:flex-row items-center md:items-end justify-between mb-12 text-center md:text-left">
                    <div class="mb-6 md:mb-0">
                        <h2 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-2 tracking-tight">Séances disponibles</h2>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Réservez vos places dès maintenant pour vivre la magie du cinéma.</p>
                    </div>
                    <div class="flex gap-2">
                        <div class="w-12 h-1.5 bg-[#cc0000] rounded-full"></div>
                        <div class="w-4 h-1.5 bg-gray-300 dark:bg-gray-800 rounded-full"></div>
                        <div class="w-4 h-1.5 bg-gray-300 dark:bg-gray-800 rounded-full"></div>
                    </div>
                </div>
                
                <div v-if="film.seances && film.seances.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="seance in film.seances" :key="seance.id" class="group bg-white dark:bg-gray-900 p-8 rounded-3xl border border-gray-200 dark:border-gray-800 hover:border-[#cc0000]/30 transition-all duration-500 shadow-xl hover:shadow-[#cc0000]/5 overflow-hidden relative">
                        <!-- Background decoration -->
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#cc0000]/5 rounded-full blur-2xl group-hover:bg-[#cc0000]/10 transition-colors"></div>
                        
                        <div class="flex justify-between items-start mb-8 relative z-10">
                            <div class="bg-gray-50 dark:bg-gray-950 px-4 py-2 rounded-2xl border border-gray-200 dark:border-gray-800">
                                <h4 class="text-gray-400 dark:text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1 text-center">Salle</h4>
                                <p class="text-gray-900 dark:text-white font-black text-lg">{{ seance.salle.nom }}</p>
                            </div>
                            <div class="text-right">
                                <h4 class="text-gray-400 dark:text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Prix</h4>
                                <p class="text-3xl font-black text-[#cc0000] drop-shadow-sm">{{ seance.prix }} €</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-6 py-6 border-y border-gray-100 dark:border-gray-800 mb-8 relative z-10">
                            <div class="bg-[#cc0000] p-4 rounded-2xl text-center min-w-[70px] shadow-lg shadow-red-600/20 group-hover:scale-105 transition-transform duration-500">
                                <span class="block text-[10px] font-black text-red-100 uppercase tracking-tighter mb-1">{{ getWeekday(seance.date_seance) }}</span>
                                <span class="block text-2xl font-black text-white leading-none">{{ getDay(seance.date_seance) }}</span>
                            </div>
                            <div>
                                <p class="text-gray-900 dark:text-white font-black text-3xl tracking-tighter mb-1">{{ seance.heure_debut.substring(0, 5) }} — {{ seance.heure_fin.substring(0, 5) }}</p>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-widest">{{ new Date(seance.date_seance).toLocaleDateString('fr-FR', { month: 'long' }) }}</p>
                            </div>
                        </div>
                        
                        <Link :href="seanceRoutes.show(seance.id)" class="w-full flex items-center justify-center gap-3 py-4 bg-gray-900 dark:bg-white hover:bg-[#cc0000] dark:hover:bg-[#cc0000] text-white dark:text-gray-900 hover:text-white dark:hover:text-white font-black text-lg rounded-2xl transition-all duration-300 shadow-lg relative z-10">
                            Réserver mes places
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </Link>
                    </div>
                </div>
                
                <div v-else class="flex flex-col items-center justify-center py-24 bg-white dark:bg-gray-900 rounded-[3rem] border border-dashed border-gray-200 dark:border-gray-800">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-xl font-bold">Aucune séance prévue</p>
                    <p class="text-gray-400 dark:text-gray-500 font-medium">Revenez plus tard pour les prochaines séances.</p>
                </div>
            </div>
        </div>
    </div>
</template>

