<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import adminRoutes from "@/routes/admin";
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';

const props = defineProps<{
    film: any;
}>();

const breadcrumbs = [
    { title: 'Administration', href: '#' },
    { title: 'Films', href: '/admin/films' },
    { title: 'Modifier', href: '#' }
];

const form = useForm({
    titre: props.film.titre,
    description: props.film.description,
    duree: props.film.duree,
    date_sortie: props.film.date_sortie.substring(0, 10), // Extract YYYY-MM-DD
    affiche: props.film.affiche || '',
    type: props.film.type,
});

const submit = () => {
    form.put(adminRoutes.films.update(props.film.id).url);
};

const types = ['Action', 'Comédie', 'Drame', 'Horreur', 'Science-Fiction', 'Animation', 'Documentaire'];
</script>

<template>
    <Head :title="'Modifier ' + film.titre" />
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 md:px-8">
            <header class="mb-10 text-center">
                <h1 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight font-cinzel uppercase">Modifier le Film</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium mt-2">Mettez à jour les informations de {{ film.titre }}.</p>
            </header>

            <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 p-8 rounded-2xl shadow-md space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Titre -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Titre du film</label>
                        <input 
                            v-model="form.titre" 
                            type="text" 
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all"
                        />
                        <InputError :message="form.errors.titre" class="mt-2" />
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Genre</label>
                        <select 
                            v-model="form.type" 
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all"
                        >
                            <option v-for="t in types" :key="t" :value="t">{{ t }}</option>
                        </select>
                        <InputError :message="form.errors.type" class="mt-2" />
                    </div>

                    <!-- Durée -->
                    <div>
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Durée (minutes)</label>
                        <input 
                            v-model="form.duree" 
                            type="number" 
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all"
                        />
                        <InputError :message="form.errors.duree" class="mt-2" />
                    </div>

                    <!-- Date de sortie -->
                    <div>
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Date de sortie</label>
                        <input 
                            v-model="form.date_sortie" 
                            type="date" 
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all"
                        />
                        <InputError :message="form.errors.date_sortie" class="mt-2" />
                    </div>

                    <!-- Affiche -->
                    <div>
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">URL de l'affiche</label>
                        <input 
                            v-model="form.affiche" 
                            type="text" 
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all"
                        />
                        <InputError :message="form.errors.affiche" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Synopsis / Description</label>
                        <textarea 
                            v-model="form.description" 
                            rows="5"
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all"
                        ></textarea>
                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>
                </div>

                <div class="pt-8 flex justify-end gap-4 border-t border-gray-100 dark:border-gray-700">
                    <Link :href="adminRoutes.films.index().url" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-white font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                        Annuler
                    </Link>
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="px-8 py-3 bg-[#cc0000] text-white font-bold rounded-xl hover:bg-red-700 transition-all duration-300 shadow-lg disabled:opacity-50"
                    >
                        {{ form.processing ? 'Mise à jour...' : 'Mettre à jour le film' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
