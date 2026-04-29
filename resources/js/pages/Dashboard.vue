<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard, reservations as reservationRoutes } from '@/routes';

defineProps<{
    recent_reservations: any[];
    total_bookings: number;
    confirmed_bookings: number;
}>();

const breadcrumbs = [
    {
        title: 'Tableau de bord',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Tableau de bord" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 md:p-10 space-y-10">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-zinc-900/50 border border-zinc-800 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-600/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <p class="text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-2">Total Réservations</p>
                        <p class="text-5xl font-black text-white tracking-tighter">{{ total_bookings }}</p>
                    </div>
                </div>
                
                <div class="bg-zinc-900/50 border border-zinc-800 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-green-600/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <p class="text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-2">Séances Confirmées</p>
                        <p class="text-5xl font-black text-green-500 tracking-tighter">{{ confirmed_bookings }}</p>
                    </div>
                </div>

                <div class="bg-zinc-900/50 border border-zinc-800 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-600/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <p class="text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-2">Prochaine Séance</p>
                        <p v-if="recent_reservations.length > 0" class="text-xl font-black text-white tracking-tight mt-2 truncate">
                            {{ recent_reservations[0].seance.film.titre }}
                        </p>
                        <p v-else class="text-xl font-bold text-zinc-700 mt-2 italic">Aucune</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="space-y-6">
                <div class="flex items-end justify-between px-2">
                    <h2 class="text-3xl font-black text-white tracking-tighter">ACTIVITÉ RÉCENTE</h2>
                    <Link :href="reservationRoutes.index().url" class="text-red-500 font-black text-sm uppercase tracking-widest hover:underline">Voir tout</Link>
                </div>

                <div class="bg-zinc-900/40 backdrop-blur-xl border border-zinc-800/50 rounded-[3rem] overflow-hidden shadow-2xl">
                    <div v-if="recent_reservations.length > 0" class="divide-y divide-zinc-800/50">
                        <div v-for="res in recent_reservations" :key="res.id" class="p-8 hover:bg-zinc-800/20 transition-all flex items-center justify-between">
                            <div class="flex items-center gap-6">
                                <div class="w-12 h-16 rounded-xl bg-zinc-950 border border-zinc-800 overflow-hidden shadow-lg">
                                    <img v-if="res.seance.film.affiche" :src="res.seance.film.affiche" class="w-full h-full object-cover" />
                                </div>
                                <div>
                                    <h4 class="text-xl font-black text-white tracking-tight mb-1">{{ res.seance.film.titre }}</h4>
                                    <p class="text-zinc-500 font-bold text-xs uppercase tracking-widest">
                                        {{ new Date(res.seance.date_seance).toLocaleDateString() }} • {{ res.seance.heure_debut.substring(0, 5) }} • {{ res.seance.salle.nom }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-6">
                                <span 
                                    :class="res.statut === 'confirme' ? 'text-green-500 bg-green-500/5 border-green-500/20' : 'text-orange-500 bg-orange-500/5 border-orange-500/20'"
                                    class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border"
                                >
                                    {{ res.statut === 'confirme' ? 'Payé' : 'À régler' }}
                                </span>
                                <Link :href="reservationRoutes.show(res.id).url" class="p-3 bg-zinc-950 text-zinc-500 hover:text-white rounded-xl border border-zinc-800 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                    
                    <div v-else class="p-20 text-center">
                        <p class="text-zinc-600 font-bold italic">Aucune réservation récente.</p>
                        <Link href="/films" class="mt-6 inline-flex px-8 py-3 bg-white text-black font-black rounded-2xl hover:bg-red-600 hover:text-white transition-all">
                            Réserver un film
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
