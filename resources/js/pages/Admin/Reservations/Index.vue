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
    <template>
    <Head title="Gestion des Réservations" />
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
             <header class="mb-10 text-center">
                <h1 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight font-cinzel uppercase">Gestion des Réservations</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium mt-2">Consultez et administrez l'ensemble des réservations effectuées par les clients.</p>
            </header>

            <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-md border border-gray-100 dark:border-gray-700">
                 <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                                <th class="px-6 py-4 text-gray-500 text-xs font-bold uppercase tracking-wider">Client</th>
                                <th class="px-6 py-4 text-gray-500 text-xs font-bold uppercase tracking-wider">Séance & Film</th>
                                <th class="px-6 py-4 text-gray-500 text-xs font-bold uppercase tracking-wider text-center">Places</th>
                                <th class="px-6 py-4 text-gray-500 text-xs font-bold uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-4 text-gray-500 text-xs font-bold uppercase tracking-wider text-right">Total HT</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            <tr v-for="res in reservations" :key="res.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-all group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center text-gray-500 font-bold border border-gray-200 dark:border-gray-700">
                                            {{ res.user.name.charAt(0) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-gray-900 dark:text-white font-bold leading-tight group-hover:text-[#cc0000] transition-colors">{{ res.user.name }}</span>
                                            <span class="text-gray-500 text-xs">{{ res.user.email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-gray-900 dark:text-white font-bold">{{ res.seance.film.titre }}</span>
                                        <span class="text-gray-500 text-xs font-bold uppercase tracking-wider mt-0.5">{{ formatDate(res.seance.date_seance) }} • {{ res.seance.heure_debut.substring(0, 5) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white font-bold">{{ res.nombre_places }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div :class="res.statut === 'confirme' ? 'bg-green-500' : 'bg-orange-500'" class="w-2 h-2 rounded-full shadow-sm"></div>
                                        <span 
                                            :class="res.statut === 'confirme' ? 'text-green-600 dark:text-green-400' : 'text-orange-600 dark:text-orange-400'"
                                            class="text-xs font-bold uppercase tracking-wider"
                                        >
                                            {{ res.statut === 'confirme' ? 'Confirmé' : 'En attente' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-[#cc0000] font-black text-xl">{{ (res.nombre_places * res.seance.prix).toFixed(2) }}€</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                 </div>
            </div>
            
             <div v-if="reservations.length === 0" class="flex flex-col items-center justify-center py-20 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 mt-6 text-center">
                <p class="text-gray-500 font-medium italic">Aucune réservation dans le système.</p>
            </div>
        </div>
    </div>
</template>
