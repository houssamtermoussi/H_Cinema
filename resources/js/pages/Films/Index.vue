<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { films as filmRoutes } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    films: any[];
}>();

const breadcrumbs = [
    { title: 'Films', href: '/films' }
];
</script>

<template>
    <Head title="Tous les Films" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2 tracking-tight">À l'affiche</h1>
                <p class="text-zinc-400">Découvrez les films du moment et réservez votre séance.</p>
            </header>

            <div v-if="films.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                <div v-for="film in films" :key="film.id" class="group relative bg-zinc-950 rounded-2xl overflow-hidden shadow-2xl transition-all hover:scale-[1.03] border border-zinc-800/50">
                    <div class="aspect-[2/3] w-full bg-zinc-900 relative overflow-hidden">
                        <img v-if="film.affiche" :src="film.affiche" :alt="film.titre" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700" />
                        <div v-else class="w-full h-full flex items-center justify-center text-zinc-600 italic text-center p-4 bg-zinc-900">
                            <svg class="w-12 h-12 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" /></svg>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90 group-hover:opacity-70 transition-opacity"></div>
                        
                        <div class="absolute top-4 right-4">
                            <span class="inline-block px-2.5 py-1 bg-red-600/90 backdrop-blur-md text-[10px] font-black uppercase rounded-full text-white tracking-widest shadow-lg">{{ film.type }}</span>
                        </div>
                    </div>
                    
                    <div class="p-5 relative -mt-20">
                        <h3 class="text-white font-black text-xl leading-tight mb-1 drop-shadow-md group-hover:text-red-500 transition-colors duration-300 truncate">{{ film.titre }}</h3>
                        <div class="flex items-center gap-3 text-zinc-400 text-xs font-medium">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ film.duree }} min
                            </span>
                            <span class="w-1 h-1 rounded-full bg-zinc-700"></span>
                            <span>{{ new Date(film.date_sortie).getFullYear() }}</span>
                        </div>
                        
                        <Link :href="filmRoutes.show(film.id)" class="mt-5 w-full inline-flex items-center justify-center gap-2 text-sm font-bold text-white bg-zinc-900 hover:bg-red-600 px-4 py-3 rounded-xl transition-all duration-300 border border-zinc-800 hover:border-red-500 group-hover:shadow-[0_0_20px_rgba(220,38,38,0.3)]">
                            Voir plus
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        </Link>
                    </div>
                </div>
            </div>
            
            <div v-else class="flex flex-col items-center justify-center py-20 bg-zinc-950/50 rounded-3xl border border-dashed border-zinc-800">
                <div class="p-4 bg-zinc-900 rounded-full mb-4">
                    <svg class="w-12 h-12 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
                <h2 class="text-xl font-bold text-white mb-1">Aucun film disponible</h2>
                <p class="text-zinc-500">Revenez plus tard pour voir les nouveautés.</p>
            </div>
        </div>
    </AppLayout>
</template>
