<script setup lang="ts">
import { Form, Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import DeleteUser from '@/components/DeleteUser.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { edit } from '@/routes/profile';
import { send } from '@/routes/verification';

type Props = {
    mustVerifyEmail: boolean;
    status?: string;
};

defineProps<Props>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Paramètres du profil',
                href: edit(),
            },
        ],
    },
});

const page = usePage();
const user = computed(() => (page.props.auth as any).user);
</script>

<template>
    <Head title="Paramètres du profil" />

    <div class="flex flex-col space-y-8">
        <div>
            <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Informations du profil</h2>
            <p class="text-sm text-gray-500 dark:text-zinc-500 font-medium mt-1">Mettez à jour votre nom et votre adresse e-mail.</p>
        </div>

        <Form
            v-bind="ProfileController.update.form()"
            class="space-y-6 max-w-xl"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-3">
                <Label for="name" class="font-bold text-gray-700 dark:text-zinc-300">Nom complet</Label>
                <Input
                    id="name"
                    class="bg-gray-50 dark:bg-zinc-950 border-gray-200 dark:border-zinc-800 rounded-xl focus:ring-[#cc0000] focus:border-[#cc0000]"
                    name="name"
                    :default-value="user.name"
                    required
                    autocomplete="name"
                    placeholder="Votre nom complet"
                />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-3">
                <Label for="email" class="font-bold text-gray-700 dark:text-zinc-300">Adresse e-mail</Label>
                <Input
                    id="email"
                    type="email"
                    class="bg-gray-50 dark:bg-zinc-950 border-gray-200 dark:border-zinc-800 rounded-xl focus:ring-[#cc0000] focus:border-[#cc0000]"
                    name="email"
                    :default-value="user.email"
                    required
                    autocomplete="username"
                    placeholder="votre@email.com"
                />
                <InputError :message="errors.email" />
            </div>

            <div v-if="mustVerifyEmail && !user.email_verified_at">
                <p class="text-sm text-amber-600 dark:text-amber-500 font-medium">
                    Votre adresse e-mail n'est pas vérifiée.
                    <Link
                        :href="send()"
                        as="button"
                        class="underline decoration-amber-300 hover:text-amber-700 dark:hover:text-amber-400 transition-colors"
                    >
                        Cliquez ici pour renvoyer l'e-mail de vérification.
                    </Link>
                </p>

                <div
                    v-if="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-bold text-green-600 dark:text-green-500"
                >
                    Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
                </div>
            </div>

            <div class="pt-2">
                <Button 
                    :disabled="processing" 
                    class="bg-[#cc0000] hover:bg-[#b30000] text-white font-black uppercase tracking-widest px-8 py-6 rounded-2xl transition-all duration-300 shadow-lg shadow-red-600/20 active:scale-95 disabled:opacity-50"
                >
                    {{ processing ? 'Enregistrement...' : 'Enregistrer les modifications' }}
                </Button>
            </div>
        </Form>

        <div class="border-t border-gray-100 dark:border-zinc-800 pt-10">
            <DeleteUser />
        </div>
    </div>
</template>
