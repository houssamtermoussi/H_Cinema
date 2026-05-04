<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import adminRoutes from "@/routes/admin";
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { ref } from 'vue';


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
    affiche: null as File | null,
    type: 'Action',
});

const previewUrl = ref<string | null>(null);

const onFileChange = (e: any) => {
    const file = e.target.files[0];
    if (file) {
        form.affiche = file;
        previewUrl.value = URL.createObjectURL(file);
    }
};


const submit = () => {
    form.post(adminRoutes.films.store().url, {
        forceFormData: true,
    });
};

const types = ['Action', 'Comédie', 'Drame', 'Horreur', 'Science-Fiction', 'Animation', 'Documentaire'];
</script>

<template>
    <Head title="Ajouter un film" />
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 md:px-8">
            <header class="mb-10 text-center">
                <h1 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight font-cinzel uppercase">Ajouter un Film</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium mt-2">Remplissez les informations pour le nouveau film.</p>
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
                            placeholder="Ex: Inception"
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
                    <div class="md:col-span-2">
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Affiche du film</label>
                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            <div v-if="previewUrl" class="w-32 h-48 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 flex-shrink-0 shadow-sm">
                                <img :src="previewUrl" class="w-full h-full object-cover" />
                            </div>
                            <div v-else class="w-32 h-48 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center flex-shrink-0 text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <div class="flex-1 w-full">
                                <input 
                                    type="file" 
                                    @input="onFileChange($event)"
                                    class="w-full text-sm text-gray-500 dark:text-gray-400
                                        file:mr-4 file:py-3 file:px-6
                                        file:rounded-xl file:border-0
                                        file:text-sm file:font-bold
                                        file:bg-[#cc0000] file:text-white
                                        hover:file:bg-red-700
                                        transition-all cursor-pointer"
                                    accept="image/*"
                                />
                                <p class="mt-2 text-xs text-gray-500">PNG, JPG ou JPEG (Max. 2MB)</p>
                                <InputError :message="form.errors.affiche" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Synopsis / Description</label>
                        <textarea 
                            v-model="form.description" 
                            rows="5"
                            class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all"
                            placeholder="Entrez le résumé du film..."
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
                        {{ form.processing ? 'Enregistrement...' : 'Enregistrer le film' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
