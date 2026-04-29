<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { reservations as reservationRoutes, paiements as paiementRoutes } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    reservations: any[];
}>();

const breadcrumbs = [
    { title: 'Mes Réservations', href: '/reservations' }
];

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
    });
};
</script>

<template>
    <Head title="Mes Réservations" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-black p-8 md:p-16">
            <div class="max-w-7xl mx-auto">
                <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
                    <div>
                        <h1 class="text-5xl font-black text-white mb-4 tracking-tighter">MES RÉSERVATIONS</h1>
                        <p class="text-zinc-500 font-bold text-lg">Retrouvez vos tickets et l'historique de vos séances.</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="px-6 py-3 bg-zinc-900 rounded-2xl border border-zinc-800">
                            <span class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-1">Total</span>
                            <span class="block text-2xl font-black text-white leading-none">{{ reservations.length }}</span>
                        </div>
                    </div>
                </header>
                
                <div v-if="reservations.length > 0" class="space-y-6">
                    <div v-for="res in reservations" :key="res.id" class="group relative bg-zinc-900/40 backdrop-blur-xl border border-zinc-800/50 p-8 rounded-[2.5rem] flex flex-col md:flex-row items-center justify-between gap-10 hover:bg-zinc-900/60 transition-all duration-500 hover:border-zinc-700 shadow-2xl overflow-hidden">
                        <!-- Decorative element -->
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-600/5 blur-[80px] rounded-full group-hover:bg-red-600/10 transition-all duration-700"></div>
                        
                        <!-- Film Info -->
                        <div class="flex items-center gap-8 w-full md:w-auto relative z-10">
                            <div class="w-24 h-32 rounded-2xl overflow-hidden flex-shrink-0 bg-zinc-950 border border-zinc-800 shadow-lg group-hover:scale-105 transition-transform duration-500">
                                <img v-if="res.seance.film.affiche" :src="res.seance.film.affiche" class="w-full h-full object-cover" />
                                <div v-else class="w-full h-full bg-zinc-900"></div>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-0.5 bg-red-600/20 text-red-500 text-[10px] font-black uppercase rounded-full border border-red-600/20 tracking-tighter">Billet #{{ res.id }}</span>
                                </div>
                                <h3 class="text-3xl font-black text-white mb-2 tracking-tighter group-hover:text-red-500 transition-colors duration-300">{{ res.seance.film.titre }}</h3>
                                <div class="flex flex-wrap items-center gap-4 text-zinc-400 font-bold text-sm">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        {{ formatDate(res.seance.date_seance) }}
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-zinc-800"></span>
                                    <span class="flex items-center gap-2 uppercase tracking-widest text-[11px] text-zinc-500">
                                        <svg class="w-4 h-4 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        {{ res.seance.salle.nom }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Reservation Data -->
                        <div class="flex items-center gap-12 w-full md:w-auto justify-between md:justify-end relative z-10">
                            <div class="text-center md:text-right">
                                <p class="text-zinc-600 text-[10px] font-black uppercase tracking-widest mb-1">Places</p>
                                <p class="text-white font-black text-3xl tracking-tighter">{{ res.nombre_places }}</p>
                            </div>
                            
                            <div class="text-center md:text-right">
                                <p class="text-zinc-600 text-[10px] font-black uppercase tracking-widest mb-1">Statut</p>
                                <span 
                                    :class="[
                                        res.statut === 'confirme' ? 'text-green-500 bg-green-500/5 border-green-500/20' : 'text-orange-500 bg-orange-500/5 border-orange-500/20'
                                    ]"
                                    class="px-4 py-1.5 rounded-full text-[11px] font-black uppercase tracking-widest border"
                                >
                                    {{ res.statut === 'confirme' ? 'Payé' : 'À régler' }}
                                </span>
                            </div>
                            
                            <div class="flex flex-col gap-3 min-w-[160px]">
                                <Link 
                                    v-if="res.statut === 'en_attente'" 
                                    :href="paiementRoutes.create(res.id)" 
                                    class="w-full py-3.5 bg-red-600 text-white text-center font-black rounded-2xl hover:bg-red-500 transition-all shadow-xl shadow-red-900/20 active:scale-95"
                                >
                                    Payer maintenant
                                </Link>
                                <Link 
                                    :href="reservationRoutes.show(res.id)" 
                                    class="w-full py-3.5 bg-zinc-800 text-white text-center font-black rounded-2xl hover:bg-zinc-700 transition-all active:scale-95 border border-zinc-700/50"
                                >
                                    Détails & Ticket
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div v-else class="flex flex-col items-center justify-center py-32 bg-zinc-950 rounded-[3rem] border border-dashed border-zinc-800/50">
                    <div class="w-24 h-24 bg-zinc-900 rounded-full flex items-center justify-center mb-8">
                        <svg class="w-12 h-12 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                    </div>
                    <h2 class="text-2xl font-black text-white mb-2 tracking-tight">AUCUNE RÉSERVATION TROUVÉE</h2>
                    <p class="text-zinc-500 font-medium mb-10">Il est temps de réserver votre première séance !</p>
                    <Link href="/films" class="px-10 py-5 bg-white text-black font-black text-xl rounded-2xl hover:bg-red-600 hover:text-white transition-all duration-300 shadow-2xl">
                        Voir les films à l'affiche
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
