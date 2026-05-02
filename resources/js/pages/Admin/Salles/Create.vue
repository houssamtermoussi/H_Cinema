<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import adminRoutes from "@/routes/admin";
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
    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 md:px-8">
            <header class="mb-10 text-center">
                <h1 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight font-cinzel uppercase">Nouvelle Salle</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium mt-2">Configurez une nouvelle salle de projection.</p>
            </header>

            <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 p-8 rounded-2xl shadow-md space-y-6">
                <div>
                    <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Nom de la salle</label>
                    <input 
                        v-model="form.nom" 
                        type="text" 
                        class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all"
                        placeholder="Ex: Salle IMAX"
                    />
                    <InputError :message="form.errors.nom" class="mt-2" />
                </div>

                <div>
                    <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Capacité de sièges</label>
                    <input 
                        v-model="form.capacite" 
                        type="number" 
                        class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all"
                    />
                    <InputError :message="form.errors.capacite" class="mt-2" />
                    <p class="mt-2 text-gray-500 text-xs font-medium italic">Note : Les sièges seront automatiquement générés lors de la création.</p>
                </div>

                <div class="pt-6 flex gap-4">
                    <Link :href="adminRoutes.salles.index().url" class="flex-1 py-4 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-white text-center font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                        Annuler
                    </Link>
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="flex-[2] py-4 bg-[#cc0000] text-white font-bold text-lg rounded-xl hover:bg-red-700 transition-all duration-300 shadow-lg disabled:opacity-50"
                    >
                        {{ form.processing ? 'Création...' : 'Créer la salle' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
