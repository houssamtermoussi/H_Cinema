<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import adminRoutes from "@/routes/admin";
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';

const props = defineProps<{
    seance: any;
    films: any[];
    salles: any[];
}>();

const breadcrumbs = [
    { title: 'Administration', href: '#' },
    { title: 'Séances', href: '/admin/seances' },
    { title: 'Modifier', href: '#' }
];

const form = useForm({
    film_id: props.seance.film_id,
    salle_id: props.seance.salle_id,
    date_seance: props.seance.date_seance,
    heure_debut: props.seance.heure_debut.substring(0, 5),
    heure_fin: props.seance.heure_fin.substring(0, 5),
    prix: props.seance.prix,
});

const submit = () => {
    form.put(adminRoutes.seances.update(props.seance.id).url);
};
</script>

<template>
    <Head :title="'Modifier Séance ' + seance.id" />
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 md:px-8">
            <header class="mb-10 text-center">
                <h1 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight font-cinzel uppercase">Modifier la Séance</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium mt-2">Ajustez les détails de la séance de projection.</p>
            </header>

            <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 p-8 rounded-2xl shadow-md space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Film -->
                    <div>
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Film</label>
                        <select v-model="form.film_id" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-3 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all">
                            <option v-for="film in films" :key="film.id" :value="film.id">{{ film.titre }}</option>
                        </select>
                        <InputError :message="form.errors.film_id" class="mt-2" />
                    </div>

                    <!-- Salle -->
                    <div>
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Salle</label>
                        <select v-model="form.salle_id" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-3 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all">
                            <option v-for="salle in salles" :key="salle.id" :value="salle.id">{{ salle.nom }}</option>
                        </select>
                        <InputError :message="form.errors.salle_id" class="mt-2" />
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Date de la séance</label>
                        <input v-model="form.date_seance" type="date" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-3 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all" />
                        <InputError :message="form.errors.date_seance" class="mt-2" />
                    </div>

                    <!-- Prix -->
                    <div>
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Prix (€)</label>
                        <input v-model="form.prix" type="number" step="0.01" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-3 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all" />
                        <InputError :message="form.errors.prix" class="mt-2" />
                    </div>

                    <!-- Heure Debut -->
                    <div>
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Heure de début</label>
                        <input v-model="form.heure_debut" type="time" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-3 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all" />
                        <InputError :message="form.errors.heure_debut" class="mt-2" />
                    </div>

                    <!-- Heure Fin -->
                    <div>
                        <label class="block text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Heure de fin</label>
                        <input v-model="form.heure_fin" type="time" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-3 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-[#cc0000] focus:border-transparent transition-all" />
                        <InputError :message="form.errors.heure_fin" class="mt-2" />
                    </div>
                </div>

                <div class="pt-8 flex justify-end gap-4 border-t border-gray-100 dark:border-gray-700">
                    <Link :href="adminRoutes.seances.index().url" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-white font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                        Annuler
                    </Link>
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="px-8 py-3 bg-[#cc0000] text-white font-bold rounded-xl hover:bg-red-700 transition-all duration-300 shadow-lg disabled:opacity-50"
                    >
                        {{ form.processing ? 'Mise à jour...' : 'Enregistrer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
