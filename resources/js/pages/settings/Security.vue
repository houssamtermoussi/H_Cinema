<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { ShieldCheck } from 'lucide-vue-next';
import { onUnmounted, ref } from 'vue';
import SecurityController from '@/actions/App/Http/Controllers/Settings/SecurityController';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TwoFactorRecoveryCodes from '@/components/TwoFactorRecoveryCodes.vue';
import TwoFactorSetupModal from '@/components/TwoFactorSetupModal.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth';
import { edit } from '@/routes/security';
import { disable, enable } from '@/routes/two-factor';

type Props = {
    canManageTwoFactor?: boolean;
    requiresConfirmation?: boolean;
    twoFactorEnabled?: boolean;
};

withDefaults(defineProps<Props>(), {
    canManageTwoFactor: false,
    requiresConfirmation: false,
    twoFactorEnabled: false,
});

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Paramètres de sécurité',
                href: edit(),
            },
        ],
    },
});

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth();
const showSetupModal = ref<boolean>(false);

onUnmounted(() => clearTwoFactorAuthData());
</script>

<template>
    <Head title="Paramètres de sécurité" />

    <div class="space-y-12">
        <!-- Password Section -->
        <section class="space-y-8">
            <div>
                <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Mettre à jour le mot de passe</h2>
                <p class="text-sm text-gray-500 dark:text-zinc-500 font-medium mt-1">Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester en sécurité.</p>
            </div>

            <Form
                v-bind="SecurityController.update.form()"
                :options="{
                    preserveScroll: true,
                }"
                reset-on-success
                :reset-on-error="[
                    'password',
                    'password_confirmation',
                    'current_password',
                ]"
                class="space-y-6 max-w-xl"
                v-slot="{ errors, processing }"
            >
                <div class="grid gap-3">
                    <Label for="current_password" class="font-bold text-gray-700 dark:text-zinc-300">Mot de passe actuel</Label>
                    <PasswordInput
                        id="current_password"
                        name="current_password"
                        class="bg-gray-50 dark:bg-zinc-950 border-gray-200 dark:border-zinc-800 rounded-xl focus:ring-[#cc0000] focus:border-[#cc0000]"
                        autocomplete="current-password"
                        placeholder="Mot de passe actuel"
                    />
                    <InputError :message="errors.current_password" />
                </div>

                <div class="grid gap-3">
                    <Label for="password" class="font-bold text-gray-700 dark:text-zinc-300">Nouveau mot de passe</Label>
                    <PasswordInput
                        id="password"
                        name="password"
                        class="bg-gray-50 dark:bg-zinc-950 border-gray-200 dark:border-zinc-800 rounded-xl focus:ring-[#cc0000] focus:border-[#cc0000]"
                        autocomplete="new-password"
                        placeholder="Nouveau mot de passe"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-3">
                    <Label for="password_confirmation" class="font-bold text-gray-700 dark:text-zinc-300">Confirmer le mot de passe</Label>
                    <PasswordInput
                        id="password_confirmation"
                        name="password_confirmation"
                        class="bg-gray-50 dark:bg-zinc-950 border-gray-200 dark:border-zinc-800 rounded-xl focus:ring-[#cc0000] focus:border-[#cc0000]"
                        autocomplete="new-password"
                        placeholder="Confirmer le nouveau mot de passe"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <div class="pt-2">
                    <Button
                        :disabled="processing"
                        class="bg-[#cc0000] hover:bg-[#b30000] text-white font-black uppercase tracking-widest px-8 py-6 rounded-2xl transition-all duration-300 shadow-lg shadow-red-600/20 active:scale-95 disabled:opacity-50"
                    >
                        {{ processing ? 'Mise à jour...' : 'Enregistrer le mot de passe' }}
                    </Button>
                </div>
            </Form>
        </section>

        <!-- 2FA Section -->
        <section v-if="canManageTwoFactor" class="space-y-8 pt-12 border-t border-gray-100 dark:border-zinc-800">
            <div>
                <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Authentification à deux facteurs</h2>
                <p class="text-sm text-gray-500 dark:text-zinc-500 font-medium mt-1">Gérez vos paramètres d'authentification à deux facteurs.</p>
            </div>

            <div
                v-if="!twoFactorEnabled"
                class="flex flex-col items-start justify-start space-y-6 max-w-xl"
            >
                <p class="text-sm text-gray-600 dark:text-zinc-400 leading-relaxed">
                    Lorsque l'authentification à deux facteurs est activée, un code sécurisé vous sera demandé lors de la connexion. Ce code peut être récupéré via une application TOTP sur votre téléphone.
                </p>

                <div>
                    <Button v-if="hasSetupData" @click="showSetupModal = true" class="bg-[#cc0000] hover:bg-[#b30000] text-white font-black uppercase tracking-widest px-8 py-6 rounded-2xl transition-all duration-300 shadow-lg shadow-red-600/20 active:scale-95">
                        <ShieldCheck class="w-5 h-5 mr-2" />Continuer la configuration
                    </Button>
                    <Form
                        v-else
                        v-bind="enable.form()"
                        @success="showSetupModal = true"
                        #default="{ processing }"
                    >
                        <Button type="submit" :disabled="processing" class="bg-[#cc0000] hover:bg-[#b30000] text-white font-black uppercase tracking-widest px-8 py-6 rounded-2xl transition-all duration-300 shadow-lg shadow-red-600/20 active:scale-95">
                            Activer la 2FA
                        </Button>
                    </Form>
                </div>
            </div>

            <div v-else class="flex flex-col items-start justify-start space-y-6 max-w-xl">
                <p class="text-sm text-gray-600 dark:text-zinc-400 leading-relaxed font-bold text-green-600 dark:text-green-500 flex items-center gap-2">
                    <ShieldCheck class="w-5 h-5" />
                    L'authentification à deux facteurs est activée.
                </p>

                <div class="relative inline">
                    <Form v-bind="disable.form()" #default="{ processing }">
                        <Button
                            variant="destructive"
                            type="submit"
                            :disabled="processing"
                            class="font-black uppercase tracking-widest px-8 py-6 rounded-2xl shadow-lg transition-all active:scale-95"
                        >
                            Désactiver la 2FA
                        </Button>
                    </Form>
                </div>

                <div class="w-full bg-gray-50 dark:bg-zinc-950 p-6 rounded-3xl border border-gray-100 dark:border-zinc-800">
                    <TwoFactorRecoveryCodes />
                </div>
            </div>

            <TwoFactorSetupModal
                v-model:isOpen="showSetupModal"
                :requiresConfirmation="requiresConfirmation"
                :twoFactorEnabled="twoFactorEnabled"
            />
        </section>
    </div>
</template>
