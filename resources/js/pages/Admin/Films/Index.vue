<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
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
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-8 max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tighter mb-2">GESTION DU CATALOGUE</h1>
                    <p class="text-zinc-500 font-medium">Administrez les films disponibles à l'affiche.</p>
                </div>
                <Link :href="adminRoutes.films.create().url" class="px-8 py-4 bg-white text-black font-black rounded-2xl hover:bg-red-600 hover:text-white transition-all duration-300 flex items-center gap-3 shadow-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                    Ajouter un film
                </Link>
            </div>

            <div class="bg-zinc-900/40 backdrop-blur-xl border border-zinc-800/50 rounded-[2.5rem] overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-zinc-900/80 border-b border-zinc-800">
                                <th class="px-8 py-6 text-zinc-500 text-[10px] font-black uppercase tracking-widest">Film & Poster</th>
                                <th class="px-8 py-6 text-zinc-500 text-[10px] font-black uppercase tracking-widest">Type / Durée</th>
                                <th class="px-8 py-6 text-zinc-500 text-[10px] font-black uppercase tracking-widest text-right">Gestion</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/30">
                            <tr v-for="film in films" :key="film.id" class="hover:bg-zinc-800/20 transition-all duration-300 group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-6">
                                        <div class="w-16 h-20 rounded-xl overflow-hidden bg-zinc-950 border border-zinc-800 group-hover:scale-105 transition-transform duration-500">
                                            <img v-if="film.affiche" :src="film.affiche" class="w-full h-full object-cover" />
                                            <div v-else class="w-full h-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-white font-black text-xl tracking-tight mb-1 group-hover:text-red-500 transition-colors">{{ film.titre }}</p>
                                            <p class="text-zinc-500 text-xs font-bold">{{ formatDate(film.date_sortie) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col gap-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-zinc-800 text-zinc-300 text-[10px] font-black uppercase tracking-widest border border-zinc-700 w-fit">
                                            {{ film.type }}
                                        </span>
                                        <div class="flex items-center gap-2 text-zinc-400 font-bold text-sm">
                                            <svg class="w-4 h-4 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ film.duree }} min
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-3">
                                        <Link :href="adminRoutes.films.edit(film.id).url" class="p-3 bg-zinc-950 text-zinc-400 hover:text-white hover:bg-zinc-800 rounded-xl transition-all border border-zinc-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </Link>
                                        <button @click="deleteFilm(film.id)" class="p-3 bg-zinc-950 text-zinc-400 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all border border-zinc-800 hover:border-red-500/30">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div v-if="films.length === 0" class="flex flex-col items-center justify-center py-32 bg-zinc-950 rounded-[3rem] border border-dashed border-zinc-800/50 mt-8">
                <p class="text-zinc-500 text-lg font-bold">Aucun film dans le catalogue.</p>
            </div>
        </div>
    </AppLayout>
</template>
