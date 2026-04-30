<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

defineOptions({
    layout: {
        title: 'Connexion',
        description: 'Heureux de vous revoir ! Connectez-vous pour gérer vos réservations.',
    },
});

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();
</script>

<template>
    <Head title="Connexion" />

    <div
        v-if="status"
        class="mb-4 text-center text-sm font-medium text-green-600"
    >
        {{ status }}
    </div>

    <Form
        v-bind="store.form()"
        :reset-on-success="['password']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-6"
    >
        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="email" class="font-bold text-gray-700 dark:text-gray-300">Adresse Email</Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    placeholder="votre@email.com"
                    class="rounded-xl border-gray-200 dark:border-gray-800 focus:ring-[#cc0000] focus:border-[#cc0000]"
                />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <div class="flex items-center justify-between">
                    <Label for="password" class="font-bold text-gray-700 dark:text-gray-300">Mot de passe</Label>
                    <TextLink
                        v-if="canResetPassword"
                        :href="request()"
                        class="text-xs font-bold text-[#cc0000] hover:text-red-700"
                        :tabindex="5"
                    >
                        Mot de passe oublié ?
                    </TextLink>
                </div>
                <PasswordInput
                    id="password"
                    name="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="rounded-xl border-gray-200 dark:border-gray-800 focus:ring-[#cc0000] focus:border-[#cc0000]"
                />
                <InputError :message="errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <Label for="remember" class="flex items-center space-x-3 cursor-pointer">
                    <Checkbox id="remember" name="remember" :tabindex="3" class="border-gray-300 text-[#cc0000] focus:ring-[#cc0000]" />
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Se souvenir de moi</span>
                </Label>
            </div>

            <Button
                type="submit"
                class="mt-4 w-full py-6 bg-[#cc0000] hover:bg-red-700 text-white font-bold text-lg rounded-xl transition-all duration-300 shadow-lg shadow-red-900/20 active:scale-[0.98]"
                :tabindex="4"
                :disabled="processing"
                data-test="login-button"
            >
                <Spinner v-if="processing" class="mr-2" />
                Se connecter
            </Button>
        </div>

        <div
            class="text-center text-sm text-gray-500 dark:text-gray-400 font-medium"
            v-if="canRegister"
        >
            Pas encore de compte ?
            <TextLink :href="register()" :tabindex="5" class="font-bold text-[#cc0000] hover:text-red-700 ml-1">S'inscrire</TextLink>
        </div>
    </Form>
</template>
