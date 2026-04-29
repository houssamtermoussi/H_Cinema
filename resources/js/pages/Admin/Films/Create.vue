<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { admin as adminRoutes } from '@/routes';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';

const breadcrumbs = [
    { title: 'Administration', href: '#' },
    { title: 'Films', href: '/admin/films' },
    { title: 'Nouveau', href: '/admin/films/create' }
];

const form = useForm({
    titre: '',
    description: '',
    duree: 120,
    date_sortie: '',
    affiche: '',
    type: 'Action',
});

const submit = () => {
    form.post(adminRoutes.films.store().url);
};

const types = ['Action', 'Comédie', 'Drame', 'Horreur', 'Science-Fiction', 'Animation', 'Documentaire'];
</script>

<template>
    <Head title="Ajouter un film" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-8 max-w-4xl mx-auto">
            <header class="mb-12">
                <h1 class="text-4xl font-black text-white tracking-tighter mb-2">AJOUTER UN FILM</h1>
                <p class="text-zinc-500 font-medium">Remplissez les informations pour le nouveau film.</p>
            </header>

            <form @submit.prevent="submit" class="bg-zinc-900/40 backdrop-blur-xl border border-zinc-800/50 p-10 rounded-[2.5rem] shadow-2xl space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Titre -->
                    <div class="md:col-span-2">
                        <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-2 px-1">Titre du film</label>
                        <input 
                            v-model="form.titre" 
                            type="text" 
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white font-bold focus:border-red-600 focus:ring-0 transition-all placeholder:text-zinc-700"
                            placeholder="Ex: Inception"
                        />
                        <InputError :message="form.errors.titre" class="mt-2" />
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-2 px-1">Genre</label>
                        <select 
                            v-model="form.type" 
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white font-bold focus:border-red-600 focus:ring-0 transition-all"
                        >
                            <option v-for="t in types" :key="t" :value="t">{{ t }}</option>
                        </select>
                        <InputError :message="form.errors.type" class="mt-2" />
                    </div>

                    <!-- Durée -->
                    <div>
                        <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-2 px-1">Durée (minutes)</label>
                        <input 
                            v-model="form.duree" 
                            type="number" 
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white font-bold focus:border-red-600 focus:ring-0 transition-all"
                        />
                        <InputError :message="form.errors.duree" class="mt-2" />
                    </div>

                    <!-- Date de sortie -->
                    <div>
                        <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-2 px-1">Date de sortie</label>
                        <input 
                            v-model="form.date_sortie" 
                            type="date" 
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white font-bold focus:border-red-600 focus:ring-0 transition-all"
                        />
                        <InputError :message="form.errors.date_sortie" class="mt-2" />
                    </div>

                    <!-- Affiche (URL pour le moment) -->
                    <div>
                        <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-2 px-1">URL de l'affiche</label>
                        <input 
                            v-model="form.affiche" 
                            type="text" 
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white font-bold focus:border-red-600 focus:ring-0 transition-all placeholder:text-zinc-700"
                            placeholder="https://..."
                        />
                        <InputError :message="form.errors.affiche" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-2 px-1">Synopsis / Description</label>
                        <textarea 
                            v-model="form.description" 
                            rows="5"
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white font-bold focus:border-red-600 focus:ring-0 transition-all placeholder:text-zinc-700"
                            placeholder="Entrez le résumé du film..."
                        ></textarea>
                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>
                </div>

                <div class="pt-8 flex justify-end gap-4 border-t border-zinc-800/50">
                    <Link :href="adminRoutes.films.index().url" class="px-8 py-4 bg-zinc-950 text-zinc-500 font-black rounded-2xl hover:text-white transition-all">
                        Annuler
                    </Link>
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="px-10 py-4 bg-white text-black font-black rounded-2xl hover:bg-red-600 hover:text-white transition-all duration-300 shadow-xl disabled:opacity-50"
                    >
                        {{ form.processing ? 'Enregistrement...' : 'Enregistrer le film' }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
