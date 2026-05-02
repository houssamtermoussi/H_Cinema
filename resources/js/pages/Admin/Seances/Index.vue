<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import adminRoutes from "@/routes/admin";
import { Head, Link, router } from '@inertiajs/vue3';

defineProps<{
    seances: any[];
}>();

const breadcrumbs = [
    { title: 'Administration', href: '#' },
    { title: 'SÃ©ances', href: '/admin/seances' }
];

const deleteSeance = (id: number) => {
    if (confirm('ÃŠtes-vous sÃ»r de vouloir supprimer cette sÃ©ance ? Les rÃ©servations existantes seront perdues.')) {
        router.delete(adminRoutes.seances.destroy(id).url);
    }
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
    });
};
</script>

<template>
    <Head title="Gestion des Séances" />
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
             <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                <div>
                    <h1 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight font-cinzel uppercase">Gestion des Séances</h1>
                    <p class="text-gray-500 dark:text-gray-400 font-medium mt-1">Gérez la programmation des films.</p>
                </div>
                <Link :href="adminRoutes.seances.create().url" class="px-6 py-3 bg-[#cc0000] text-white font-bold rounded-xl hover:bg-red-700 transition-all flex items-center gap-2 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Nouvelle Séance
                </Link>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-md border border-gray-100 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                                <th class="px-6 py-4 text-gray-500 text-xs font-bold uppercase tracking-wider">Date & Film</th>
                                <th class="px-6 py-4 text-gray-500 text-xs font-bold uppercase tracking-wider">Horaire</th>
                                <th class="px-6 py-4 text-gray-500 text-xs font-bold uppercase tracking-wider">Salle / Prix</th>
                                <th class="px-6 py-4 text-gray-500 text-xs font-bold uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            <tr v-for="seance in seances" :key="seance.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-all group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-14 rounded-lg bg-gray-100 dark:bg-gray-900 overflow-hidden border border-gray-100 dark:border-gray-700">
                                            <img v-if="seance.film.affiche" :src="seance.film.affiche" class="w-full h-full object-cover" />
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-0.5">{{ formatDate(seance.date_seance) }}</p>
                                            <p class="text-gray-900 dark:text-white font-bold text-lg leading-tight group-hover:text-[#cc0000] transition-colors">{{ seance.film.titre }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-700 dark:text-white font-bold text-sm">
                                        <svg class="w-4 h-4 text-[#cc0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ seance.heure_debut.substring(0, 5) }} — {{ seance.heure_fin.substring(0, 5) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <p class="text-gray-600 dark:text-gray-300 font-medium text-sm">{{ seance.salle.nom }}</p>
                                        <p class="text-[#cc0000] font-black text-xl">{{ seance.prix }}€</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <Link :href="adminRoutes.seances.edit(seance.id).url" class="p-2 text-gray-400 hover:text-[#cc0000] hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all" title="Modifier">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </Link>
                                        <button @click="deleteSeance(seance.id)" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-lg transition-all" title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div v-if="seances.length === 0" class="flex flex-col items-center justify-center py-20 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 mt-6">
                <p class="text-gray-500 font-medium italic">Aucune séance planifiée.</p>
            </div>
        </div>
    </div>
</template>
