<script setup>
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="bg-gg-dark text-white relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none opacity-10 bg-[radial-gradient(circle_at_30%_30%,#00A86B,transparent_60%)]"></div>
        <div class="relative max-w-7xl mx-auto py-14 px-6 lg:px-10">
            <div class="grid md:grid-cols-4 gap-10">
                <!-- Brand -->
                <div class="space-y-5 md:col-span-2">
                    <div class="flex items-center space-x-3">
                        <ApplicationLogo class="h-10 w-auto fill-current text-gg-green" />
                        <span class="text-2xl font-bold tracking-tight">GreenGains</span>
                    </div>
                    <p class="text-sm text-white/70 leading-relaxed max-w-md">Pflanzlicher Muskelaufbau mit System. Trainingsplan, High-Protein-Rezepte & Wissen – alles in einem E-Book.</p>
                    <div class="flex items-center gap-3 text-[11px] uppercase tracking-wider font-medium text-white/50">
                        <span class="px-2 py-1 rounded bg-gg-green/10 text-gg-green">Vegan</span>
                        <span class="px-2 py-1 rounded bg-white/10">30 Tage</span>
                        <span class="px-2 py-1 rounded bg-white/10">PDF</span>
                    </div>
                </div>
                <!-- Links -->
                <div class="space-y-4">
                    <h4 class="text-xs font-semibold tracking-wider text-white/60">SEKTIONEN</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#hero" class="footer-link">Start</a></li>
                        <li><a href="#problem" class="footer-link">Problem</a></li>
                        <li><a href="#inhalte" class="footer-link">Inhalte</a></li>
                        <li><a href="#angebot" class="footer-link">Angebot</a></li>
                        <li><a href="#faq" class="footer-link">FAQ</a></li>
                    </ul>
                </div>
                <!-- Rechtliches -->
                <div class="space-y-4">
                    <h4 class="text-xs font-semibold tracking-wider text-white/60">RECHTLICH</h4>
                    <ul class="space-y-2 text-sm">
                        <li><Link href="/impressum" class="footer-link">Impressum</Link></li>
                        <li><Link href="/datenschutz" class="footer-link">Datenschutz</Link></li>
                        <li><Link href="/agb" class="footer-link">AGB</Link></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 flex flex-col md:flex-row md:items-center md:justify-between gap-6 border-t border-white/10 pt-6">
                <p class="text-xs text-white/60">© {{ currentYear }} GreenGains – powered by ThalerDigital</p>
                <div class="flex flex-wrap gap-4 text-[11px] text-white/50">
                    <span>Sichere Zahlung (Digistore24)</span>
                    <span>Support: <a href="mailto:greengains@outlook.de" class="underline hover:text-white">greengains@outlook.de</a></span>
                </div>
            </div>
        </div>
    </footer>
</template>

<style scoped>
.footer-link { @apply text-white/70 hover:text-white transition-colors duration-200; }
</style>
