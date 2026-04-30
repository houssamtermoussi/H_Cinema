<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store } from '@/routes/register';

defineOptions({
    layout: {
        title: 'Créer un compte',
        description: 'Rejoignez la communauté H-Cinema et commencez à réserver vos places.',
    },
});
</script>

<template>
    <Head title="Inscription" />

    <Form
        v-bind="store.form()"
        :reset-on-success="['password', 'password_confirmation']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-6"
    >
        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="name" class="font-bold text-gray-700 dark:text-gray-300">Nom complet</Label>
                <Input
                    id="name"
                    type="text"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="name"
                    name="name"
                    placeholder="Votre nom"
                    class="rounded-xl border-gray-200 dark:border-gray-800 focus:ring-[#cc0000] focus:border-[#cc0000]"
                />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="email" class="font-bold text-gray-700 dark:text-gray-300">Adresse Email</Label>
                <Input
                    id="email"
                    type="email"
                    required
                    :tabindex="2"
                    autocomplete="email"
                    name="email"
                    placeholder="votre@email.com"
                    class="rounded-xl border-gray-200 dark:border-gray-800 focus:ring-[#cc0000] focus:border-[#cc0000]"
                />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="password" class="font-bold text-gray-700 dark:text-gray-300">Mot de passe</Label>
                <PasswordInput
                    id="password"
                    required
                    :tabindex="3"
                    autocomplete="new-password"
                    name="password"
                    placeholder="••••••••"
                    class="rounded-xl border-gray-200 dark:border-gray-800 focus:ring-[#cc0000] focus:border-[#cc0000]"
                />
                <InputError :message="errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation" class="font-bold text-gray-700 dark:text-gray-300">Confirmer le mot de passe</Label>
                <PasswordInput
                    id="password_confirmation"
                    required
                    :tabindex="4"
                    autocomplete="new-password"
                    name="password_confirmation"
                    placeholder="••••••••"
                    class="rounded-xl border-gray-200 dark:border-gray-800 focus:ring-[#cc0000] focus:border-[#cc0000]"
                />
                <InputError :message="errors.password_confirmation" />
            </div>

            <Button
                type="submit"
                class="mt-2 w-full py-6 bg-[#cc0000] hover:bg-red-700 text-white font-bold text-lg rounded-xl transition-all duration-300 shadow-lg shadow-red-900/20 active:scale-[0.98]"
                tabindex="5"
                :disabled="processing"
                data-test="register-user-button"
            >
                <Spinner v-if="processing" class="mr-2" />
                Créer mon compte
            </Button>
        </div>

        <div class="text-center text-sm text-gray-500 dark:text-gray-400 font-medium">
            Déjà inscrit ?
            <TextLink
                :href="login()"
                class="font-bold text-[#cc0000] hover:text-red-700 ml-1"
                :tabindex="6"
                >Se connecter</TextLink
            >
        </div>
    </Form>
</template>
