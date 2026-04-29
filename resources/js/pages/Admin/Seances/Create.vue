<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import adminRoutes from "@/routes/admin";
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';

defineProps<{
    films: any[];
    salles: any[];
}>();

const breadcrumbs = [
    { title: 'Administration', href: '#' },
    { title: 'SÃ©ances', href: '/admin/seances' },
    { title: 'Nouvelle', href: '#' }
];

const form = useForm({
    film_id: '',
    salle_id: '',
    date_seance: '',
    heure_debut: '',
    heure_fin: '',
    prix: 12.00,
});

const submit = () => {
    form.post(adminRoutes.seances.store().url);
};
</script>

<template>
    <Head title="Programmer une sÃ©ance" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-8 max-w-4xl mx-auto">
            <header class="mb-12">
                <h1 class="text-4xl font-black text-white tracking-tighter mb-2">PROGRAMMER UNE SÃ‰ANCE</h1>
                <p class="text-zinc-500 font-medium">DÃ©finissez l'horaire et le lieu pour la projection d'un film.</p>
            </header>

            <form @submit.prevent="submit" class="bg-zinc-900/40 backdrop-blur-xl border border-zinc-800/50 p-10 rounded-[3rem] shadow-2xl space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Film -->
                    <div class="md:col-span-2">
                        <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-3 px-1">Film Ã  projeter</label>
                        <select 
                            v-model="form.film_id" 
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white font-black focus:border-red-600 focus:ring-0 transition-all"
                        >
                            <option value="" disabled>SÃ©lectionnez un film</option>
                            <option v-for="film in films" :key="film.id" :value="film.id">{{ film.titre }}</option>
                        </select>
                        <InputError :message="form.errors.film_id" class="mt-2" />
                    </div>

                    <!-- Salle -->
                    <div>
                        <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-3 px-1">Salle</label>
                        <select 
                            v-model="form.salle_id" 
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white font-black focus:border-red-600 focus:ring-0 transition-all"
                        >
                            <option value="" disabled>Choisir une salle</option>
                            <option v-for="salle in salles" :key="salle.id" :value="salle.id">{{ salle.nom }} ({{ salle.capacite }} places)</option>
                        </select>
                        <InputError :message="form.errors.salle_id" class="mt-2" />
                    </div>

                    <!-- Prix -->
                    <div>
                        <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-3 px-1">Prix de la place (â‚¬)</label>
                        <input 
                            v-model="form.prix" 
                            type="number" 
                            step="0.01"
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white font-black focus:border-red-600 focus:ring-0 transition-all"
                        />
                        <InputError :message="form.errors.prix" class="mt-2" />
                    </div>

                    <!-- Date -->
                    <div class="md:col-span-2">
                        <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-3 px-1">Date de la sÃ©ance</label>
                        <input 
                            v-model="form.date_seance" 
                            type="date" 
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white font-black focus:border-red-600 focus:ring-0 transition-all"
                        />
                        <InputError :message="form.errors.date_seance" class="mt-2" />
                    </div>

                    <!-- Heures -->
                    <div>
                        <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-3 px-1">Heure de dÃ©but</label>
                        <input 
                            v-model="form.heure_debut" 
                            type="time" 
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white font-black focus:border-red-600 focus:ring-0 transition-all"
                        />
                        <InputError :message="form.errors.heure_debut" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-zinc-500 text-[10px] font-black uppercase tracking-widest mb-3 px-1">Heure de fin</label>
                        <input 
                            v-model="form.heure_fin" 
                            type="time" 
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl p-4 text-white font-black focus:border-red-600 focus:ring-0 transition-all"
                        />
                        <InputError :message="form.errors.heure_fin" class="mt-2" />
                    </div>

                </div>

                <div class="pt-8 flex gap-4 border-t border-zinc-800/50">
                    <Link :href="adminRoutes.seances.index().url" class="flex-1 py-5 bg-zinc-950 text-zinc-600 text-center font-black rounded-2xl hover:text-white transition-all border border-zinc-800">
                        Annuler
                    </Link>
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="flex-[2] py-5 bg-white text-black font-black text-xl rounded-2xl hover:bg-red-600 hover:text-white transition-all duration-300 shadow-xl disabled:opacity-50"
                    >
                        {{ form.processing ? 'Programmation...' : 'Programmer la sÃ©ance' }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
