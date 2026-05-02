<script setup lang="ts">

import adminRoutes from "@/routes/admin";
import { Head, Link, router } from '@inertiajs/vue3';

defineProps<{
    films: any[];
}>();


const deleteFilm = (id: number) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce film ? Toutes les séances associées seront également supprimées.')) {
        router.delete(adminRoutes.films.destroy(id).url);
    }
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('fr-FR');
};
</script>

<template>
    <Head title="Gestion des Films" />
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                <div>
                    <h1 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight font-cinzel uppercase">Gestion des Films</h1>
                    <p class="text-gray-500 dark:text-gray-400 font-medium mt-1">Administrez le catalogue de votre cinéma.</p>
                </div>
                <Link :href="adminRoutes.films.create().url" class="px-6 py-3 bg-[#cc0000] text-white font-bold rounded-xl hover:bg-red-700 transition-all flex items-center gap-2 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Ajouter un film
                </Link>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-md border border-gray-100 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                                <th class="px-6 py-4 text-gray-500 text-xs font-bold uppercase tracking-wider">Film & Poster</th>
                                <th class="px-6 py-4 text-gray-500 text-xs font-bold uppercase tracking-wider">Type / Durée</th>
                                <th class="px-6 py-4 text-gray-500 text-xs font-bold uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            <tr v-for="film in films" :key="film.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-all group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-16 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 group-hover:scale-105 transition-transform duration-300">
                                            <img v-if="film.affiche" :src="film.affiche" class="w-full h-full object-cover" />
                                            <div v-else class="w-full h-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-gray-900 dark:text-white font-bold text-lg leading-tight group-hover:text-[#cc0000] transition-colors">{{ film.titre }}</p>
                                            <p class="text-gray-500 text-xs">{{ formatDate(film.date_sortie) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-[10px] font-bold uppercase tracking-wider border border-gray-200 dark:border-gray-600 w-fit">
                                            {{ film.type }}
                                        </span>
                                        <div class="flex items-center gap-1.5 text-gray-500 text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ film.duree }} min
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <Link :href="adminRoutes.films.edit(film.id).url" class="p-2 text-gray-400 hover:text-[#cc0000] hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all" title="Modifier">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </Link>
                                        <button @click="deleteFilm(film.id)" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-lg transition-all" title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div v-if="films.length === 0" class="flex flex-col items-center justify-center py-20 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 mt-6">
                <p class="text-gray-500 font-medium italic">Aucun film dans le catalogue.</p>
            </div>
        </div>
    </div>
</template>emplate>
