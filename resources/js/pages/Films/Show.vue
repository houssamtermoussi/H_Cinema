<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import seanceRoutes from "@/routes/seances";
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps<{
    film: any;
}>();

const breadcrumbs = [
    { title: 'Films', href: '/films' },
    { title: props.film.titre, href: `/films/${props.film.id}` }
];

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
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-black">
            <!-- Hero Section -->
            <div class="relative w-full h-[70vh] overflow-hidden">
                <div class="absolute inset-0">
                    <img v-if="film.affiche" :src="film.affiche" :alt="film.titre" class="w-full h-full object-cover opacity-40 blur-2xl scale-110" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/80 to-transparent"></div>
                </div>
                
                <div class="absolute inset-0 flex items-end">
                    <div class="max-w-7xl mx-auto w-full px-8 pb-16">
                        <div class="flex flex-col md:flex-row gap-12 items-end">
                            <!-- Poster -->
                            <div class="w-64 h-[24rem] flex-shrink-0 rounded-2xl overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-zinc-800/50 hidden md:block transform -rotate-2 hover:rotate-0 transition-transform duration-500">
                                <img v-if="film.affiche" :src="film.affiche" :alt="film.titre" class="w-full h-full object-cover" />
                                <div v-else class="w-full h-full bg-zinc-900 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" /></svg>
                                </div>
                            </div>
                            
                            <!-- Info -->
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-3 mb-6">
                                    <span class="px-3 py-1 bg-red-600 text-[10px] font-black uppercase rounded-full text-white tracking-widest shadow-lg shadow-red-600/20">{{ film.type }}</span>
                                    <span class="px-3 py-1 bg-zinc-800/80 backdrop-blur-md border border-zinc-700 text-[10px] font-bold uppercase rounded-full text-zinc-300 tracking-wider">HD / 4K</span>
                                </div>
                                
                                <h1 class="text-6xl md:text-8xl font-black text-white mb-6 tracking-tighter leading-none">{{ film.titre }}</h1>
                                
                                <div class="flex flex-wrap items-center gap-8 text-zinc-300 mb-8">
                                    <div class="flex items-center gap-2 bg-zinc-900/50 backdrop-blur-md px-4 py-2 rounded-xl border border-zinc-800/50">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span class="font-bold text-lg">{{ film.duree }} min</span>
                                    </div>
                                    <div class="flex items-center gap-2 bg-zinc-900/50 backdrop-blur-md px-4 py-2 rounded-xl border border-zinc-800/50">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        <span class="font-bold text-lg">{{ formatDate(film.date_sortie) }}</span>
                                    </div>
                                </div>
                                
                                <p class="text-zinc-400 text-xl max-w-4xl leading-relaxed font-medium mb-2">{{ film.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sessions Section -->
            <div class="bg-zinc-950 border-t border-zinc-900">
                <div class="max-w-7xl mx-auto px-8 py-24">
                    <div class="flex items-end justify-between mb-16">
                        <div>
                            <h2 class="text-4xl font-black text-white mb-4 tracking-tight">Prochaines SÃ©ances</h2>
                            <p class="text-zinc-500 font-medium">SÃ©lectionnez l'horaire qui vous convient pour rÃ©server vos places.</p>
                        </div>
                        <div class="hidden md:flex gap-2">
                            <div class="w-12 h-1 bg-red-600 rounded-full"></div>
                            <div class="w-4 h-1 bg-zinc-800 rounded-full"></div>
                            <div class="w-4 h-1 bg-zinc-800 rounded-full"></div>
                        </div>
                    </div>
                    
                    <div v-if="film.seances.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div v-for="seance in film.seances" :key="seance.id" class="group bg-zinc-900/40 hover:bg-zinc-900/80 p-8 rounded-3xl border border-zinc-800/50 hover:border-red-500/30 transition-all duration-500 shadow-xl hover:shadow-red-950/10">
                            <div class="flex justify-between items-start mb-8">
                                <div class="bg-zinc-950 px-4 py-2 rounded-2xl border border-zinc-800">
                                    <h4 class="text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-1 text-center">Salle</h4>
                                    <p class="text-white font-black text-lg">{{ seance.salle.nom }}</p>
                                </div>
                                <div class="text-right">
                                    <h4 class="text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-1">Tarif Unique</h4>
                                    <p class="text-3xl font-black text-red-500 drop-shadow-[0_0_15px_rgba(239,68,68,0.2)]">{{ seance.prix }}â‚¬</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-6 py-6 border-y border-zinc-800/50 mb-8">
                                <div class="bg-red-600 p-4 rounded-2xl text-center min-w-[70px] shadow-lg shadow-red-600/20 group-hover:scale-110 transition-transform duration-500">
                                    <span class="block text-[10px] font-black text-red-100 uppercase tracking-tighter mb-1">{{ getWeekday(seance.date_seance) }}</span>
                                    <span class="block text-2xl font-black text-white leading-none">{{ getDay(seance.date_seance) }}</span>
                                </div>
                                <div>
                                    <p class="text-white font-black text-3xl tracking-tighter mb-1">{{ seance.heure_debut.substring(0, 5) }} â€” {{ seance.heure_fin.substring(0, 5) }}</p>
                                    <p class="text-zinc-500 text-sm font-bold uppercase tracking-widest">{{ new Date(seance.date_seance).toLocaleDateString('fr-FR', { month: 'long' }) }}</p>
                                </div>
                            </div>
                            
                            <Link :href="seanceRoutes.show(seance.id)" class="w-full flex items-center justify-center gap-3 py-5 bg-white hover:bg-red-600 text-black hover:text-white font-black text-lg rounded-2xl transition-all duration-300 shadow-lg group-active:scale-95">
                                RÃ©server mes places
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </Link>
                        </div>
                    </div>
                    
                    <div v-else class="flex flex-col items-center justify-center py-32 bg-zinc-950 rounded-[3rem] border border-dashed border-zinc-800/50">
                        <div class="w-20 h-20 bg-zinc-900 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <p class="text-zinc-500 text-2xl font-bold">BientÃ´t disponible</p>
                        <p class="text-zinc-600 font-medium">Les prochaines sÃ©ances arrivent trÃ¨s vite.</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
