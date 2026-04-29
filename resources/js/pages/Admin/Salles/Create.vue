<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { admin as adminRoutes } from '@/routes';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';

const breadcrumbs = [
    { title: 'Administration', href: '#' },
    { title: 'Salles', href: '/admin/salles' },
    { title: 'Nouvelle', href: '#' }
];

const form = useForm({
    nom: '',
    capacite: 50,
});

const submit = () => {
    form.post(adminRoutes.salles.store().url);
};
</script>

<template>
    <Head title="Ajouter une salle" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-8 max-w-2xl mx-auto">
            <header class="mb-12 text-center">
                <h1 class="text-4xl font-black text-white tracking-tighter mb-2">NOUVELLE SALLE</h1>
                <p class="text-zinc-500 font-medium">Configurez une nouvelle salle de projection.</p>
            </header>

            <form @submit.prevent="submit" class="bg-zinc-900/40 backdrop-blur-xl border border-zinc-800/50 p-10 rounded-[3rem] shadow-2xl space-y-8">
                <div>
                    <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-3 px-1">Nom de la salle</label>
                    <input 
                        v-model="form.nom" 
                        type="text" 
                        class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-5 text-white font-black text-2xl tracking-tight focus:border-red-600 focus:ring-0 transition-all placeholder:text-zinc-800"
                        placeholder="Ex: Salle IMAX"
                    />
                    <InputError :message="form.errors.nom" class="mt-2" />
                </div>

                <div>
                    <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-3 px-1">Capacité de sièges</label>
                    <input 
                        v-model="form.capacite" 
                        type="number" 
                        class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-5 text-white font-black text-2xl tracking-tight focus:border-red-600 focus:ring-0 transition-all"
                    />
                    <InputError :message="form.errors.capacite" class="mt-2" />
                    <p class="mt-3 text-zinc-600 text-xs font-bold italic px-1">Note : Les sièges seront automatiquement générés lors de la création.</p>
                </div>

                <div class="pt-8 flex gap-4">
                    <Link :href="adminRoutes.salles.index().url" class="flex-1 py-5 bg-zinc-950 text-zinc-600 text-center font-black rounded-2xl hover:text-white transition-all border border-zinc-800">
                        Annuler
                    </Link>
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="flex-[2] py-5 bg-white text-black font-black text-xl rounded-2xl hover:bg-red-600 hover:text-white transition-all duration-300 shadow-xl disabled:opacity-50"
                    >
                        {{ form.processing ? 'Création...' : 'Créer la salle' }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
