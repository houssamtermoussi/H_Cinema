<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    reservations: any[];
}>();

const breadcrumbs = [
    { title: 'Administration', href: '#' },
    { title: 'Toutes les Réservations', href: '/admin/reservations' }
];

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
};
</script>

<template>
    <Head title="Gestion des Réservations" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-8 max-w-7xl mx-auto">
             <header class="mb-12">
                <h1 class="text-4xl font-black text-white tracking-tighter mb-2 uppercase">GESTION DES RÉSERVATIONS</h1>
                <p class="text-zinc-500 font-medium">Consultez et administrez l'ensemble des réservations effectuées par les clients.</p>
            </header>

            <div class="bg-zinc-900/40 backdrop-blur-xl border border-zinc-800/50 rounded-[3rem] overflow-hidden shadow-2xl">
                 <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-zinc-900/80 border-b border-zinc-800">
                                <th class="px-8 py-6 text-zinc-500 text-[10px] font-black uppercase tracking-widest">Client</th>
                                <th class="px-8 py-6 text-zinc-500 text-[10px] font-black uppercase tracking-widest">Séance & Film</th>
                                <th class="px-8 py-6 text-zinc-500 text-[10px] font-black uppercase tracking-widest text-center">Places</th>
                                <th class="px-8 py-6 text-zinc-500 text-[10px] font-black uppercase tracking-widest">Statut</th>
                                <th class="px-8 py-6 text-zinc-500 text-[10px] font-black uppercase tracking-widest text-right">Total HT</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/30">
                            <tr v-for="res in reservations" :key="res.id" class="hover:bg-zinc-800/20 transition-all duration-300 group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-500 font-black border border-zinc-700">
                                            {{ res.user.name.charAt(0) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-white font-black tracking-tight group-hover:text-red-500 transition-colors">{{ res.user.name }}</span>
                                            <span class="text-zinc-500 text-[10px] font-bold uppercase tracking-tighter">{{ res.user.email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-zinc-300 font-bold tracking-tight">{{ res.seance.film.titre }}</span>
                                        <span class="text-zinc-500 text-[10px] font-black uppercase tracking-widest">{{ formatDate(res.seance.date_seance) }} • {{ res.seance.heure_debut.substring(0, 5) }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-zinc-950 border border-zinc-800 text-white font-black">{{ res.nombre_places }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-2">
                                        <div :class="res.statut === 'confirme' ? 'bg-green-500' : 'bg-orange-500'" class="w-1.5 h-1.5 rounded-full shadow-[0_0_8px_currentColor]"></div>
                                        <span 
                                            :class="res.statut === 'confirme' ? 'text-green-500' : 'text-orange-500'"
                                            class="text-[10px] font-black uppercase tracking-widest"
                                        >
                                            {{ res.statut === 'confirme' ? 'Confirmé' : 'En attente' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="text-white font-black text-2xl tracking-tighter">{{ (res.nombre_places * res.seance.prix).toFixed(2) }}€</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                 </div>
            </div>
            
             <div v-if="reservations.length === 0" class="flex flex-col items-center justify-center py-32 bg-zinc-950 rounded-[4rem] border border-dashed border-zinc-800/50 mt-8">
                <p class="text-zinc-500 text-lg font-bold">Aucune réservation dans le système.</p>
            </div>
        </div>
    </AppLayout>
</template>
