<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

const showingNavigationDropdown = ref(false);
const isScrolled = ref(false);

// Scroll zu einem Abschnitt (nur wenn aktuelle Seite die Startseite ist)
const scrollToSection = (sectionId) => {
    const el = document.getElementById(sectionId);
    if (el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    showingNavigationDropdown.value = false;
};

// Intelligente Navigation: Wenn nicht auf der Startseite -> per Inertia zur Startseite navigieren und danach scrollen
const goTo = (sectionId) => {
    const pathIsHome = window.location.pathname === '/';
    // Hero ist ganz oben – Sonderfall: wir lassen den Hash weg, damit kein störender Offset entsteht
    const hash = sectionId && sectionId !== 'hero' ? `#${sectionId}` : '';

    if (pathIsHome) {
        // Bereits auf der Startseite -> direkt scrollen
        scrollToSection(sectionId);
    } else {
        // Via Inertia zur Startseite und danach smooth scrollen
        router.visit('/' + hash, {
            replace: false,
            preserveState: false,
            onSuccess: () => {
                // Kleines Delay, bis DOM der Startseite gemountet ist
                setTimeout(() => scrollToSection(sectionId), 60);
            },
        });
    }
};

// Handle scroll effect for navbar
const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <nav 
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 ease-in-out"
        :class="isScrolled 
            ? 'bg-white/95 backdrop-blur-lg shadow-lg border-b border-gray-200/50' 
            : 'bg-white/80 backdrop-blur-sm border-b border-gray-100/30'"
    >
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link href="/" class="flex items-center space-x-3 group">
                            <div class="relative flex-shrink-0">
                                <img src="/uploads/logo.png" alt="GreenGains Logo" class="h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105" @error="($e)=>{ $e.target.replaceWith(Object.assign(document.createElement('div'),{innerText:'Logo',className:'h-12 w-12 flex items-center justify-center bg-gg-green/10 text-gg-green rounded-lg text-xs font-semibold'})); }" />
                                <div class="absolute inset-0 bg-gg-green/10 opacity-0 group-hover:opacity-100 rounded-lg transition-opacity duration-300"></div>
                            </div>
                            <div class="flex flex-col">
                                <h1 class="text-lg font-bold text-gg-dark leading-tight md:text-xl">GreenGains</h1>
                                <p class="text-[10px] text-gg-green -mt-0.5 tracking-wide hidden sm:block">Pflanzlich. Stark.</p>
                            </div>
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-1 lg:ml-12 lg:flex">
                        <button @click="goTo('hero')" class="nav-btn">Start</button>
                        <button @click="goTo('problem')" class="nav-btn">Problem</button>
                        <button @click="goTo('inhalte')" class="nav-btn">Inhalte</button>
                        <button @click="goTo('warum')" class="nav-btn">Warum</button>
                        <button @click="goTo('stimmen')" class="nav-btn">Stimmen</button>
                        <button @click="goTo('angebot')" class="nav-btn">Angebot</button>
                        <button @click="goTo('faq')" class="nav-btn-emph">Jetzt starten</button>
                    </div>
                </div>

                <!-- Right side actions (nur wenn eingeloggt) -->
                <div class="hidden lg:flex lg:items-center" v-if="$page.props.auth.user">
                    <div class="relative">
                        <Dropdown align="right" width="56">
                            <template #trigger>
                                <button
                                    type="button"
                                    class="flex items-center space-x-3 px-4 py-2 text-sm font-medium text-gg-dark bg-white/80 border border-gg-green/30 rounded-full hover:bg-white hover:border-gg-green focus:outline-none focus:ring-2 focus:ring-gg-green focus:ring-offset-2 transition-all duration-300 group"
                                >
                                    <div class="w-8 h-8 bg-gradient-to-r from-gg-green to-gg-dark rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-semibold">
                                            {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                        </span>
                                    </div>
                                    <span class="hidden md:block">
                                        {{ $page.props.auth.user.name }}
                                    </span>
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </template>
                            <template #content>
                                <div class="py-2">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-900">{{ $page.props.auth.user.name }}</p>
                                        <p class="text-xs text-gray-500">{{ $page.props.auth.user.email }}</p>
                                    </div>
                                    <DropdownLink :href="route('profile.edit')" class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Profil</span>
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button" class="flex items-center space-x-2 text-red-600 hover:text-red-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>Abmelden</span>
                                    </DropdownLink>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center lg:hidden">
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="inline-flex items-center justify-center p-2 rounded-full text-gg-dark/60 hover:text-gg-green hover:bg-gg-green/10 focus:outline-none focus:bg-gg-green/10 focus:text-gg-green transition-all duration-300"
                    >
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div
            :class="{ 
                'translate-y-0 opacity-100': showingNavigationDropdown, 
                '-translate-y-4 opacity-0 pointer-events-none': !showingNavigationDropdown 
            }"
            class="lg:hidden absolute top-full left-0 right-0 bg-white/95 backdrop-blur-lg border-b border-gray-200/50 shadow-lg transition-all duration-300 ease-in-out"
        >
            <div class="px-4 py-6 grid gap-2">
                <button @click="goTo('hero')" class="w-full text-left px-4 py-3 text-base font-medium rounded-lg text-gg-dark/80 hover:text-gg-dark hover:bg-gg-green/10 transition">Start</button>
                <button @click="goTo('problem')" class="w-full text-left px-4 py-3 text-base font-medium rounded-lg text-gg-dark/80 hover:text-gg-dark hover:bg-gg-green/10 transition">Problem</button>
                <button @click="goTo('inhalte')" class="w-full text-left px-4 py-3 text-base font-medium rounded-lg text-gg-dark/80 hover:text-gg-dark hover:bg-gg-green/10 transition">Inhalte</button>
                <button @click="goTo('warum')" class="w-full text-left px-4 py-3 text-base font-medium rounded-lg text-gg-dark/80 hover:text-gg-dark hover:bg-gg-green/10 transition">Warum</button>
                <button @click="goTo('stimmen')" class="w-full text-left px-4 py-3 text-base font-medium rounded-lg text-gg-dark/80 hover:text-gg-dark hover:bg-gg-green/10 transition">Stimmen</button>
                <button @click="goTo('angebot')" class="w-full text-left px-4 py-3 text-base font-medium rounded-lg text-gg-dark/80 hover:text-gg-dark hover:bg-gg-green/10 transition">Angebot</button>
                <button @click="goTo('faq')" class="w-full text-left px-4 py-3 text-base font-medium rounded-lg text-gg-dark/80 hover:text-gg-dark hover:bg-gg-green/10 transition">FAQ</button>
                <button @click="goTo('angebot')" class="mt-2 w-full text-center px-4 py-3 text-sm font-semibold rounded-full text-white bg-gg-green hover:bg-gg-dark transition shadow shadow-gg-green/30">Jetzt starten</button>
            </div>
            <div v-if="$page.props.auth.user" class="px-4 py-4 border-t border-gray-200/50">
                <div class="flex items-center space-x-3 px-4 py-3 bg-gray-50 rounded-lg mb-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-gg-green to-gg-dark rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold">
                            {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $page.props.auth.user.name }}</p>
                        <p class="text-xs text-gray-500">{{ $page.props.auth.user.email }}</p>
                    </div>
                </div>
                <div class="space-y-1">
                    <ResponsiveNavLink :href="route('profile.edit')" class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profil</span>
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('logout')" method="post" as="button" class="flex items-center space-x-2 text-red-600 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Abmelden</span>
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.nav-btn {
    @apply relative px-4 py-2 text-sm font-semibold text-gg-dark/80 rounded-full transition-all duration-300 ease-in-out hover:text-gg-dark hover:bg-gg-green/10;
}
.nav-btn-emph {
    @apply relative px-6 py-2 text-sm font-semibold text-white bg-gg-green rounded-full transition-all duration-300 ease-in-out hover:bg-gg-dark hover:shadow-lg hover:shadow-gg-green/30 transform hover:scale-105;
}
</style>