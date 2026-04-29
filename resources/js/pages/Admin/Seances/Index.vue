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
    <Head title="Gestion des SÃ©ances" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-8 max-w-7xl mx-auto">
             <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tighter mb-2">PLANIFICATION DES SÃ‰ANCES</h1>
                    <p class="text-zinc-500 font-medium">GÃ©rez la programmation des films dans vos salles.</p>
                </div>
                <Link :href="adminRoutes.seances.create().url" class="px-8 py-4 bg-white text-black font-black rounded-2xl hover:bg-red-600 hover:text-white transition-all duration-300 flex items-center gap-3 shadow-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                    Nouvelle SÃ©ance
                </Link>
            </div>

            <div class="bg-zinc-900/40 backdrop-blur-xl border border-zinc-800/50 rounded-[2.5rem] overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-zinc-900/80 border-b border-zinc-800">
                                <th class="px-8 py-6 text-zinc-500 text-[10px] font-black uppercase tracking-widest">Date & Film</th>
                                <th class="px-8 py-6 text-zinc-500 text-[10px] font-black uppercase tracking-widest">Horaire</th>
                                <th class="px-8 py-6 text-zinc-500 text-[10px] font-black uppercase tracking-widest">Salle / Prix</th>
                                <th class="px-8 py-6 text-zinc-500 text-[10px] font-black uppercase tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/30">
                            <tr v-for="seance in seances" :key="seance.id" class="hover:bg-zinc-800/20 transition-all duration-300 group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-14 rounded-lg bg-zinc-950 overflow-hidden border border-zinc-800">
                                            <img v-if="seance.film.affiche" :src="seance.film.affiche" class="w-full h-full object-cover" />
                                        </div>
                                        <div>
                                            <p class="text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-0.5">{{ formatDate(seance.date_seance) }}</p>
                                            <p class="text-white font-black text-lg tracking-tight group-hover:text-red-500 transition-colors">{{ seance.film.titre }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-zinc-950 border border-zinc-800 rounded-xl text-white font-bold tracking-tighter">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ seance.heure_debut.substring(0, 5) }} â€” {{ seance.heure_fin.substring(0, 5) }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col gap-1">
                                        <p class="text-zinc-300 font-bold">{{ seance.salle.nom }}</p>
                                        <p class="text-red-500 font-black tracking-tight text-xl">{{ seance.prix }}â‚¬</p>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-3">
                                        <Link :href="adminRoutes.seances.edit(seance.id).url" class="p-3 bg-zinc-950 text-zinc-400 hover:text-white hover:bg-zinc-800 rounded-xl transition-all border border-zinc-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </Link>
                                        <button @click="deleteSeance(seance.id)" class="p-3 bg-zinc-950 text-zinc-400 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all border border-zinc-800 hover:border-red-500/30">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div v-if="seances.length === 0" class="flex flex-col items-center justify-center py-32 bg-zinc-950 rounded-[3rem] border border-dashed border-zinc-800/50 mt-8">
                <p class="text-zinc-500 text-lg font-bold">Aucune sÃ©ance planifiÃ©e.</p>
            </div>
        </div>
    </AppLayout>
</template>
