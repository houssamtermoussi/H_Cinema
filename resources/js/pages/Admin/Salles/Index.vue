<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { admin as adminRoutes } from '@/routes';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps<{
    salles: any[];
}>();

const breadcrumbs = [
    { title: 'Administration', href: '#' },
    { title: 'Salles', href: '/admin/salles' }
];

const deleteSalle = (id: number) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette salle ? Toutes les séances et réservations associées seront impactées.')) {
        router.delete(adminRoutes.salles.destroy(id).url);
    }
};
</script>

<template>
    <Head title="Gestion des Salles" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-8 max-w-7xl mx-auto">
             <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tighter mb-2">GESTION DES SALLES</h1>
                    <p class="text-zinc-500 font-medium">Configurez les salles de projection et leurs capacités.</p>
                </div>
                <Link :href="adminRoutes.salles.create().url" class="px-8 py-4 bg-white text-black font-black rounded-2xl hover:bg-red-600 hover:text-white transition-all duration-300 flex items-center gap-3 shadow-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                    Nouvelle Salle
                </Link>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="salle in salles" :key="salle.id" class="group bg-zinc-900/40 backdrop-blur-xl border border-zinc-800/50 p-8 rounded-[3rem] hover:border-zinc-600 transition-all duration-500 shadow-2xl relative overflow-hidden">
                    <!-- Background Decoration -->
                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-red-600/5 rounded-full group-hover:bg-red-600/10 group-hover:scale-150 transition-all duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-3 bg-zinc-950 rounded-2xl border border-zinc-800 text-red-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                            </div>
                            <h3 class="text-3xl font-black text-white tracking-tighter group-hover:text-red-500 transition-colors">{{ salle.nom }}</h3>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-10">
                            <div class="bg-zinc-950/80 p-4 rounded-2xl border border-zinc-800/50">
                                <p class="text-zinc-600 text-[9px] font-black uppercase tracking-widest mb-1">Capacité Max</p>
                                <p class="text-white font-black text-2xl tracking-tighter">{{ salle.capacite }} <span class="text-xs text-zinc-500">p.</span></p>
                            </div>
                            <div class="bg-zinc-950/80 p-4 rounded-2xl border border-zinc-800/50">
                                <p class="text-zinc-600 text-[9px] font-black uppercase tracking-widest mb-1">Configurés</p>
                                <p class="text-white font-black text-2xl tracking-tighter">{{ salle.sieges_count }} <span class="text-xs text-zinc-500">s.</span></p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <Link :href="adminRoutes.salles.edit(salle.id).url" class="flex-1 py-4 bg-zinc-800 text-white text-center font-black rounded-2xl hover:bg-zinc-700 transition-all border border-zinc-700/50">
                                Modifier
                            </Link>
                            <button @click="deleteSalle(salle.id)" class="px-5 py-4 bg-zinc-950 text-zinc-600 hover:text-red-500 rounded-2xl transition-all border border-zinc-800 hover:border-red-500/30">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
             <div v-if="salles.length === 0" class="flex flex-col items-center justify-center py-32 bg-zinc-950 rounded-[4rem] border border-dashed border-zinc-800/50 mt-8 text-center">
                <div class="w-20 h-20 bg-zinc-900 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
                <p class="text-zinc-500 text-2xl font-bold uppercase tracking-tight">Aucune salle disponible</p>
                <p class="text-zinc-600 font-medium">Commencez par créer votre première salle de cinéma.</p>
            </div>
        </div>
    </AppLayout>
</template>
