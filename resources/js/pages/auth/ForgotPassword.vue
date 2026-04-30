<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { email } from '@/routes/password';

defineOptions({
    layout: {
        title: 'Mot de passe oublié',
        description: 'Pas de panique ! Entrez votre email pour recevoir un lien de réinitialisation.',
    },
});

defineProps<{
    status?: string;
}>();
</script>

<template>
    <Head title="Mot de passe oublié" />

    <div
        v-if="status"
        class="mb-4 text-center text-sm font-medium text-green-600"
    >
        {{ status }}
    </div>

    <div class="space-y-6">
        <Form v-bind="email.form()" v-slot="{ errors, processing }">
            <div class="grid gap-2">
                <Label for="email" class="font-bold text-gray-700 dark:text-gray-300">Adresse Email</Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    autocomplete="off"
                    autofocus
                    placeholder="votre@email.com"
                    class="rounded-xl border-gray-200 dark:border-gray-800 focus:ring-[#cc0000] focus:border-[#cc0000]"
                />
                <InputError :message="errors.email" />
            </div>

            <div class="my-6 flex items-center justify-start">
                <Button
                    class="w-full py-6 bg-[#cc0000] hover:bg-red-700 text-white font-bold text-lg rounded-xl transition-all duration-300 shadow-lg shadow-red-900/20 active:scale-[0.98]"
                    :disabled="processing"
                    data-test="email-password-reset-link-button"
                >
                    <Spinner v-if="processing" class="mr-2" />
                    Envoyer le lien
                </Button>
            </div>
        </Form>

        <div class="space-x-1 text-center text-sm text-gray-500 dark:text-gray-400 font-medium">
            <span>Ou, retourner à la</span>
            <TextLink :href="login()" class="font-bold text-[#cc0000] hover:text-red-700">connexion</TextLink>
        </div>
    </div>
</template>
