<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref, onMounted, onUnmounted } from 'vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

const scrollTo = (id) => {
    const el = document.getElementById(id);
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
};

// Externe Kauf-URL (Digistore24)
const purchaseUrl = 'https://www.checkout-ds24.com/product/639553';

// Medien-Dateien aus public/uploads (direkt im Git committed)
const media = {
    cover: '/uploads/cover.jpg',
    athlete: '/uploads/athlete.png',
    logo: '/uploads/logo.png',
    videos: [
        '/uploads/1005(1).mp4',
        '/uploads/1005(2).mp4',
        '/uploads/1005(3).mp4',
    ],
    meals: [
        '/uploads/essen1.png',
        '/uploads/essen2.png',
        '/uploads/essen3.png',
        '/uploads/essen4.png',
    ],
};

// Testimonial / "Werbung" Meta für die Videos (Platzhaltertexte – gerne echte Namen/Zitate nachreichen)
const videoTestimonials = [
    { src: '/storage/uploads/1005(1).mp4', name: 'Max', quote: '"Schon nach 3 Wochen merke ich krassen Unterschied."', tag: 'Fortschritt' },
    { src: '/storage/uploads/1005(2).mp4', name: 'Lea', quote: '"Endlich ein Plan der wirklich vegan funktioniert."', tag: 'Energie' },
    { src: '/storage/uploads/1005(3).mp4', name: 'Jonas', quote: '"Essen schmeckt – und Muskelaufbau läuft."', tag: 'Alltag' },
].filter(v => media.videos.includes(v.src));

// Kundenstimmen (mit optionalen Avataren). Wenn du echte Avatar-Bilder hast: einfach avatar: '/storage/uploads/name.png' setzen.
const testimonials = [
    {
        name: 'Max', age: 27,
        text: 'Nach 3 Wochen sehe ich schon erste Veränderungen – und fühle mich leichter & fitter.',
        avatar: null,
    },
    {
        name: 'Lea', age: 24,
        text: 'Endlich ein veganer Plan, der wirklich funktioniert – danke GreenGains!',
        avatar: null,
    },
    {
        name: 'Sophie', age: 31,
        text: 'Meal Prep + Trainingsplan = ich verschwende keine Zeit mehr und wachse konstant.',
        avatar: null,
    },
    {
        name: 'Daniel', age: 29,
        text: 'Ich dachte vegan = zu wenig Protein. Jetzt bin ich leaner und stärker als vorher.',
        avatar: null,
    },
];

// Simple fade-in on view
const observer = ref(null);
onMounted(() => {
    observer.value = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                // Entfernt das Attribut, damit die CSS-Regel [data-fade] nicht mehr greift
                if (e.target.hasAttribute('data-fade')) e.target.removeAttribute('data-fade');
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -10% 0px' });
    document.querySelectorAll('[data-fade]').forEach(el => {
        observer.value.observe(el);
        // Sofort sichtbar machen, wenn bereits im Viewport (Initial Load Problem Fix)
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.9) {
            el.removeAttribute('data-fade');
        }
    });
    // Fallback Safety Timer (falls Observer blockiert wird)
    setTimeout(() => {
        document.querySelectorAll('[data-fade]').forEach(el => el.removeAttribute('data-fade'));
    }, 1500);
});
onUnmounted(() => observer.value?.disconnect());
</script>

<template>
    <MainLayout title="GreenGains – Pflanzlich. Stark." :user="$page.props.auth?.user" :can-login="canLogin" :can-register="canRegister" :show-footer="true">
        <!-- 1. HERO -->
        <section id="hero" class="relative min-h-[85vh] sm:min-h-[90vh] flex items-center bg-gg-bg overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-gg-green/10 via-white to-gg-yellow/10"></div>
            <div class="absolute -top-24 -left-24 w-48 h-48 sm:w-72 sm:h-72 rounded-full bg-gg-green/10 blur-3xl"></div>
            <div class="absolute top-1/2 -right-24 w-56 h-56 sm:w-80 sm:h-80 rounded-full bg-gg-yellow/20 blur-3xl"></div>
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-8 md:gap-12">
                <div class="flex flex-col justify-center pt-20 sm:pt-24 md:pt-0" data-fade>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-gg-dark leading-tight">
                        <span class="block">💪 Pflanzlich. Stark.</span>
                        <span class="block text-gg-green mt-1">GreenGains.</span>
                    </h1>
                    <p class="mt-4 sm:mt-6 text-lg sm:text-xl text-gg-text/80 max-w-xl leading-relaxed">
                        Dein 30-Tage-Plan für veganen Muskelaufbau – mit echten Ergebnissen.
                    </p>
                    <div class="mt-4 flex flex-wrap items-center gap-3 text-xs sm:text-sm text-gg-dark/70">
                        <div class="flex items-center gap-1.5">
                            <span class="text-gg-green">✓</span>
                            <span>Von Experten erstellt</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-gg-green">✓</span>
                            <span>Von Veganern getestet</span>
                        </div>
                    </div>
                                <div class="mt-6 sm:mt-8 flex flex-col gap-3">
                                    <a :href="purchaseUrl" target="_blank" rel="noopener noreferrer" class="group inline-flex items-center justify-center px-6 sm:px-8 py-4 sm:py-5 rounded-full bg-gg-green text-white text-base sm:text-lg font-semibold shadow-lg shadow-gg-green/30 hover:bg-gg-dark transition-all active:scale-95">
                                        👉 Jetzt starten für nur 20,00 €
                                    </a>
                                </div>
                    <div class="mt-6 sm:mt-8 flex flex-wrap items-center gap-3 sm:gap-4 text-xs sm:text-sm font-medium text-gg-dark/80">
                        <div class="flex items-center gap-1.5 sm:gap-2"><span class="text-gg-green text-base sm:text-lg">✔️</span><span class="whitespace-nowrap">Sofort-Download</span></div>
                        <div class="flex items-center gap-1.5 sm:gap-2"><span class="text-gg-green text-base sm:text-lg">✔️</span><span class="whitespace-nowrap">Lebenslanger Zugriff</span></div>
                        <div class="flex items-center gap-1.5 sm:gap-2"><span class="text-gg-green text-base sm:text-lg">✔️</span><span class="whitespace-nowrap">Sichere Zahlung</span></div>
                    </div>
                </div>
                <!-- Visual Bereich mit Cover + Athlet + Video (falls vorhanden) -->
                <div class="relative flex items-center justify-center pb-12 md:pb-0" data-fade>
                    <div class="relative w-full max-w-sm sm:max-w-md px-4 sm:px-0">
                        <!-- E-Book Cover -->
                        <div class="relative rounded-xl sm:rounded-2xl overflow-hidden shadow-2xl border border-gg-green/20 bg-white">
                            <img :src="media.cover" alt="GreenGains E-Book Cover" loading="lazy" class="w-full h-auto object-cover" @error="($e)=>{ $e.target.src='/storage/uploads/cover.jpg'; $e.target.closest('.relative')?.classList.add('ring-2','ring-red-500'); }" />
                            <div class="absolute top-2 left-2 sm:top-3 sm:left-3 px-2 py-1 sm:px-3 sm:py-1 rounded-full text-[9px] sm:text-[10px] font-semibold bg-gg-green text-white tracking-wide shadow">E-BOOK</div>
                        </div>
                        <!-- Athlet Bild überlappend -->
                        <div class="absolute -right-4 sm:-right-10 bottom-0 w-32 sm:w-40 md:w-44 rounded-lg sm:rounded-xl overflow-hidden shadow-xl border border-white/10 bg-white/60 backdrop-blur supports-[backdrop-filter]:bg-white/40">
                            <img :src="media.athlete" alt="Veganer Athlet" loading="lazy" class="w-full h-full object-cover" @error="($e)=>{ $e.target.replaceWith(Object.assign(document.createElement('div'),{innerText:'Bild fehlt',className:'text-[10px] text-center text-red-600 p-2 bg-white'})); }" />
                        </div>
                        <!-- Vertikales Video (optional) -->
                        <div v-if="media.videos[0]" class="absolute -left-4 sm:-left-10 -bottom-6 sm:-bottom-8 w-24 sm:w-32 aspect-[9/16] rounded-lg sm:rounded-xl overflow-hidden shadow-lg border border-gg-green/30 bg-black">
                            <video :src="media.videos[0]" autoplay muted playsinline loop preload="none" class="w-full h-full object-cover"></video>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 animate-bounce text-gg-dark/50 text-sm">Scroll</div>
        </section>

        <!-- MEALS / REZEPTE GALERIE -->
        <section v-if="media.meals && media.meals.length" id="rezepte" class="py-12 sm:py-16 md:py-20 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 md:gap-6 mb-8 md:mb-12" data-fade>
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gg-dark">Ein Blick in die Rezepte</h2>
                        <p class="mt-2 text-sm md:text-base text-gg-text/70 max-w-xl leading-relaxed">Farbig, vollwertig, proteinreich – die Grundlage für nachhaltigen Muskelaufbau ohne Verzicht. Beispiele aus dem E-Book:</p>
                    </div>
                    <a :href="purchaseUrl" target="_blank" rel="noopener" class="inline-flex items-center justify-center px-5 sm:px-6 py-3 rounded-full bg-gg-dark text-white text-sm font-semibold hover:bg-gg-green transition shadow active:scale-95">Rezepte erhalten</a>
                </div>
                <div class="grid gap-4 sm:gap-6 grid-cols-2 lg:grid-cols-4" data-fade>
                    <div v-for="(meal, idx) in media.meals" :key="meal" class="group relative rounded-xl sm:rounded-2xl overflow-hidden border border-gg-green/20 bg-gg-bg shadow-sm hover:shadow-xl transition active:scale-95">
                        <img :src="meal" :alt="'Meal Beispiel ' + (idx+1)" loading="lazy" class="w-full h-48 sm:h-56 md:h-64 object-cover object-center group-hover:scale-[1.03] transition-transform duration-500" @error="($e)=>{ $e.target.classList.add('opacity-30','grayscale'); $e.target.alt='Bild nicht gefunden'; }" />
                        <div class="absolute inset-0 bg-gradient-to-t from-gg-dark/60 via-transparent to-transparent opacity-70"></div>
                        <div class="absolute bottom-2 left-2 sm:bottom-3 sm:left-3 text-[10px] sm:text-xs font-medium px-2 py-1 sm:px-3 sm:py-1 rounded-full bg-white/80 backdrop-blur text-gg-dark shadow">High Protein</div>
                    </div>
                </div>
            </div>
        </section>


        <!-- VIDEO TESTIMONIALS / WERBUNGEN -->
        <section v-if="videoTestimonials.length" id="preview" class="py-12 sm:py-16 md:py-24 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="text-center mb-10 sm:mb-14 max-w-3xl mx-auto" data-fade>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gg-dark">Echte Stimmen – echte Ergebnisse</h2>
                    <p class="mt-3 sm:mt-4 text-gg-text/70 text-sm md:text-base leading-relaxed px-4">Kurze Hochformat-Clips: Teilnehmer erzählen, wie sie mit GreenGains Energie, Muskelaufbau und Struktur gewonnen haben.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8" data-fade>
                    <div v-for="(t, i) in videoTestimonials" :key="t.src" class="group relative rounded-2xl sm:rounded-3xl overflow-hidden border border-gg-green/30 bg-white shadow-sm hover:shadow-xl transition active:scale-95 mx-auto w-full max-w-sm sm:max-w-none">
                        <div class="relative aspect-[9/16] bg-black">
                            <video :src="t.src" autoplay muted playsinline loop preload="none" class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-700"></video>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                            <div class="absolute top-2 left-2 px-2 py-1 rounded-full bg-gg-green/90 text-white text-[9px] sm:text-[10px] font-semibold tracking-wide">{{ t.tag }}</div>
                            <div class="absolute bottom-0 left-0 right-0 p-3 sm:p-4 text-white">
                                <p class="text-[10px] sm:text-xs uppercase tracking-wide mb-1 opacity-80">{{ t.name }} berichtet</p>
                                <p class="text-xs sm:text-sm font-medium leading-snug">{{ t.quote }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-10 sm:mt-12 flex justify-center px-4" data-fade>
                    <a :href="purchaseUrl" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto px-8 sm:px-10 py-4 rounded-full bg-gg-green text-white font-semibold shadow-lg shadow-gg-green/30 hover:bg-gg-dark transition text-center active:scale-95">Jetzt selbst starten</a>
                </div>
            </div>
        </section>

        <!-- 2. PROBLEM & VERSPRECHEN -->
        <section id="problem" class="py-12 sm:py-16 md:py-24 bg-white">
            <div class="max-w-5xl mx-auto px-4 sm:px-6" data-fade>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gg-dark mb-6 sm:mb-8">Warum GreenGains?</h2>
                <p class="text-base sm:text-lg leading-relaxed text-gg-text/90 mb-6">
                    Viele glauben, Muskelaufbau funktioniert nur mit Fleisch, Whey und Kalorienbomben. Doch mit den richtigen pflanzlichen Proteinen und einer klaren Struktur kannst du denselben Erfolg erreichen – nachhaltig, gesund und leistungsstark.
                </p>
                <div class="p-6 sm:p-8 border border-gg-green/30 rounded-2xl bg-gg-green/5 mb-6 sm:mb-8">
                    <p class="text-gg-dark font-semibold text-base sm:text-lg leading-relaxed">
                        GreenGains zeigt dir, wie du mit pflanzlicher Ernährung Muskeln aufbaust, ohne auf Geschmack oder Leistung zu verzichten.
                    </p>
                </div>
                <div class="flex justify-center">
                    <a :href="purchaseUrl" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 rounded-full bg-gg-green text-white text-sm sm:text-base font-semibold hover:bg-gg-dark transition shadow-lg shadow-gg-green/30 active:scale-95">
                        🚀 Jetzt durchstarten
                    </a>
                </div>
            </div>
        </section>

        <!-- 3. DAS BEKOMMST DU -->
        <section id="inhalte" class="py-12 sm:py-16 md:py-24 bg-gg-bg">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gg-dark text-center mb-3 sm:mb-4" data-fade>Das bekommst du im E-Book</h2>
                <p class="text-center text-sm sm:text-base text-gg-text/60 mb-10 sm:mb-14" data-fade>Von Ernährungsexperten entwickelt • Von Athleten getestet</p>
                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8" data-fade>
                    <div class="rounded-xl sm:rounded-2xl bg-white p-6 sm:p-8 shadow-sm border border-gg-green/20 hover:shadow-lg transition group active:scale-95">
                        <div class="w-12 h-12 rounded-full bg-gg-green/10 flex items-center justify-center mb-3 sm:mb-4 font-bold text-gg-green text-xl">1️⃣</div>
                        <h3 class="font-semibold text-lg sm:text-xl text-gg-dark mb-2">30-Tage-Trainingsplan</h3>
                        <p class="text-gg-text/70 text-sm leading-relaxed">Strukturiert für Einsteiger & Fortgeschrittene mit Progression.</p>
                    </div>
                    <div class="rounded-xl sm:rounded-2xl bg-white p-6 sm:p-8 shadow-sm border border-gg-green/20 hover:shadow-lg transition group active:scale-95">
                        <div class="w-12 h-12 rounded-full bg-gg-green/10 flex items-center justify-center mb-3 sm:mb-4 font-bold text-gg-green text-xl">2️⃣</div>
                        <h3 class="font-semibold text-lg sm:text-xl text-gg-dark mb-2">Vegane High-Protein-Rezepte</h3>
                        <p class="text-gg-text/70 text-sm leading-relaxed">Einfach, lecker, günstig – voll mit essentiellen Aminosäuren.</p>
                    </div>
                        <div class="rounded-xl sm:rounded-2xl bg-white p-6 sm:p-8 shadow-sm border border-gg-green/20 hover:shadow-lg transition group active:scale-95 sm:col-span-2 md:col-span-1">
                        <div class="w-12 h-12 rounded-full bg-gg-green/10 flex items-center justify-center mb-3 sm:mb-4 font-bold text-gg-green text-xl">3️⃣</div>
                        <h3 class="font-semibold text-lg sm:text-xl text-gg-dark mb-2">Wissens-Einleitung</h3>
                        <p class="text-gg-text/70 text-sm leading-relaxed">Grundlagen zu Ernährung, Proteinen, Regeneration & Performance.</p>
                    </div>
                </div>
                <p class="mt-8 sm:mt-10 text-center text-gg-text/80 max-w-3xl mx-auto text-sm sm:text-base px-4" data-fade>
                    Alles, was du brauchst, um sichtbar Muskeln aufzubauen – 100 % pflanzlich.
                </p>
                        <div class="mt-6 sm:mt-8 flex justify-center px-4" data-fade>
                            <a :href="purchaseUrl" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto px-6 sm:px-8 py-4 rounded-full bg-gg-dark text-white text-base font-semibold hover:bg-gg-green transition shadow-lg shadow-gg-dark/30 text-center active:scale-95">
                                Jetzt E-Book sichern
                            </a>
                        </div>
            </div>
        </section>

        <!-- 4. WARUM VEGAN FUNKTIONIERT -->
        <section id="warum" class="py-12 sm:py-16 md:py-24 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 grid md:grid-cols-2 gap-8 md:gap-12 items-center">
                <div data-fade>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gg-green/10 text-gg-green text-xs font-semibold mb-4">
                        <span>✓</span>
                        <span>Wissenschaftlich fundiert</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gg-dark mb-4 sm:mb-6">Warum veganer Muskelaufbau funktioniert</h2>
                    <p class="text-sm sm:text-base text-gg-text/80 leading-relaxed mb-4">Pflanzliche Proteine aus Linsen, Tofu, Soja, Erbsen & Hafer liefern alle essentiellen Aminosäuren – bei besserer Regeneration und weniger Entzündung im Körper.</p>
                    <p class="text-sm sm:text-base text-gg-text/80 leading-relaxed mb-6">Mit GreenGains nutzt du wissenschaftlich fundierte Prinzipien, um nachhaltig Muskeln aufzubauen – ohne tierische Produkte.</p>
                    <div class="mt-6 sm:mt-8 grid grid-cols-2 gap-3 sm:gap-4 text-xs sm:text-sm">
                        <div class="p-4 rounded-xl bg-gg-green/5 border border-gg-green/20">Aminosäuren-Profil</div>
                        <div class="p-4 rounded-xl bg-gg-green/5 border border-gg-green/20">Regeneration</div>
                        <div class="p-4 rounded-xl bg-gg-green/5 border border-gg-green/20">Entzündungsarm</div>
                        <div class="p-4 rounded-xl bg-gg-green/5 border border-gg-green/20">Nachhaltig</div>
                    </div>
                    <div class="mt-6 sm:mt-8">
                        <a :href="purchaseUrl" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 rounded-full bg-gg-green text-white text-sm sm:text-base font-semibold hover:bg-gg-dark transition shadow-lg shadow-gg-green/30 active:scale-95">
                            💚 Jetzt GreenGains starten
                        </a>
                    </div>
                </div>
                <div class="relative" data-fade>
                    <div class="aspect-video rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl border border-gg-green/20 bg-white">
                        <img src="/uploads/banner.png" alt="GreenGains Banner" loading="lazy" class="w-full h-full object-cover" @error="($e)=>{ $e.target.closest('div').classList.add('bg-gradient-to-br','from-gg-green/20','via-white','to-gg-yellow/30','flex','items-center','justify-center'); $e.target.replaceWith(Object.assign(document.createElement('div'),{innerHTML:'<div class=\'text-center p-6\'><h3 class=\'text-xl font-semibold text-gg-dark mb-2\'>Proteinquellen</h3><p class=\'text-sm text-gg-text/70 max-w-xs mx-auto\'>Linsen • Tofu • Tempeh • Erbsen • Hafer • Bohnen • Lupine • Nüsse</p></div>'})); }" />
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. KUNDENSTIMMEN -->
                <!-- 5. KUNDENSTIMMEN -->
        <section id="stimmen" class="py-12 sm:py-16 md:py-24 bg-gg-bg">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gg-dark text-center mb-8 sm:mb-12" data-fade>Kundenstimmen</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8" data-fade>
                    <div v-for="t in testimonials" :key="t.name" class="relative p-5 sm:p-7 rounded-xl sm:rounded-2xl bg-white border border-gg-green/20 shadow-sm hover:shadow-lg transition group active:scale-95">
                        <div class="flex items-start justify-between mb-3 sm:mb-4">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full ring-2 ring-gg-green/30 flex items-center justify-center overflow-hidden bg-gradient-to-br from-gg-green/20 to-gg-yellow/20 text-gg-dark text-sm font-semibold flex-shrink-0">
                                    <img v-if="t.avatar" :src="t.avatar" :alt="t.name" class="w-full h-full object-cover" />
                                    <span v-else>{{ t.name.substring(0,1) }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm sm:text-base text-gg-dark leading-tight">{{ t.name }}</p>
                                    <p class="text-[10px] sm:text-[11px] uppercase tracking-wide text-gg-text/60">Alter {{ t.age }}</p>
                                </div>
                            </div>
                            <div class="text-gg-yellow text-sm sm:text-base leading-none flex-shrink-0">★★★★★</div>
                        </div>
                        <p class="text-gg-text/80 italic text-xs sm:text-sm leading-relaxed">„{{ t.text }}"</p>
                        <div class="absolute -top-2 -left-2 sm:-top-3 sm:-left-3 w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-gg-green text-white flex items-center justify-center text-xs font-bold shadow-md">💬</div>
                        <div class="absolute inset-0 rounded-2xl pointer-events-none opacity-0 group-hover:opacity-100 transition bg-gradient-to-br from-gg-green/0 via-gg-green/0 to-gg-yellow/5"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. ANGEBOT & GARANTIE -->
        <section id="angebot" class="py-12 sm:py-16 md:py-28 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6" data-fade>
                <div class="rounded-2xl sm:rounded-3xl border border-gg-green/30 bg-gradient-to-br from-white via-gg-green/5 to-gg-yellow/10 p-6 sm:p-10 text-center shadow-xl shadow-gg-green/10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gg-green/10 text-gg-green text-xs font-semibold mb-4">
                        <span>✓</span>
                        <span>Bereits über 500 zufriedene Kunden</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gg-dark mb-3 sm:mb-4">Einmalig 20,00 € – kein Abo</h2>
                    <p class="text-sm sm:text-base text-gg-text/80 max-w-2xl mx-auto mb-6 leading-relaxed">Du erhältst das komplette E-Book direkt nach Zahlung als Download per E-Mail. Starte noch heute mit deinem veganen Muskelaufbau-Plan.</p>
                                <a :href="purchaseUrl" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-full sm:w-auto px-8 sm:px-10 py-4 sm:py-5 rounded-full bg-gg-green text-white font-semibold hover:bg-gg-dark transition text-base sm:text-lg shadow-lg shadow-gg-green/30 active:scale-95">
                                    💚 Jetzt E-Book kaufen
                                </a>
                    <div class="mt-5 sm:mt-6 flex flex-wrap justify-center gap-3 sm:gap-4 text-xs text-gg-text/60">
                        <span>Sichere Zahlung</span>
                        <span>Digistore24</span>
                        <span>PDF Download</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. FAQ -->
        <section id="faq" class="py-12 sm:py-16 md:py-24 bg-gg-bg">
            <div class="max-w-5xl mx-auto px-4 sm:px-6">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gg-dark text-center mb-8 sm:mb-12" data-fade>FAQ</h2>
                <div class="space-y-4 sm:space-y-6" data-fade>
                    <details class="group rounded-xl sm:rounded-2xl bg-white border border-gg-green/20 p-4 sm:p-6">
                        <summary class="cursor-pointer font-semibold text-sm sm:text-base text-gg-dark flex items-center justify-between gap-4">Für wen ist GreenGains geeignet?<span class="text-gg-green group-open:rotate-180 transition flex-shrink-0">▼</span></summary>
                        <p class="mt-3 sm:mt-4 text-xs sm:text-sm text-gg-text/80 leading-relaxed">Für alle, die Muskeln aufbauen wollen – egal ob vegan oder einfach neugierig.</p>
                    </details>
                    <details class="group rounded-xl sm:rounded-2xl bg-white border border-gg-green/20 p-4 sm:p-6">
                        <summary class="cursor-pointer font-semibold text-sm sm:text-base text-gg-dark flex items-center justify-between gap-4">Brauche ich Vorkenntnisse?<span class="text-gg-green group-open:rotate-180 transition flex-shrink-0">▼</span></summary>
                        <p class="mt-3 sm:mt-4 text-xs sm:text-sm text-gg-text/80 leading-relaxed">Nein, der Plan erklärt alles Schritt für Schritt.</p>
                    </details>
                    <details class="group rounded-xl sm:rounded-2xl bg-white border border-gg-green/20 p-4 sm:p-6">
                        <summary class="cursor-pointer font-semibold text-sm sm:text-base text-gg-dark flex items-center justify-between gap-4">Wie bekomme ich das E-Book?<span class="text-gg-green group-open:rotate-180 transition flex-shrink-0">▼</span></summary>
                        <p class="mt-3 sm:mt-4 text-xs sm:text-sm text-gg-text/80 leading-relaxed">Direkt nach der Zahlung als Download-Link per E-Mail.</p>
                    </details>
                    <details class="group rounded-xl sm:rounded-2xl bg-white border border-gg-green/20 p-4 sm:p-6">
                        <summary class="cursor-pointer font-semibold text-sm sm:text-base text-gg-dark flex items-center justify-between gap-4">Kann ich es auch auf dem Handy lesen?<span class="text-gg-green group-open:rotate-180 transition flex-shrink-0">▼</span></summary>
                        <p class="mt-3 sm:mt-4 text-xs sm:text-sm text-gg-text/80 leading-relaxed">Ja, das PDF ist mobilfreundlich optimiert.</p>
                    </details>
                </div>
            </div>
        </section>

    </MainLayout>
</template>

<style scoped>
html { scroll-behavior: smooth; }
[data-fade] { @apply opacity-0 translate-y-6 transition-all duration-700 ease-out; }
/* Fallback: falls JS nicht ausgeführt wird */
noscript [data-fade], .no-js [data-fade] { opacity: 1 !important; transform: none !important; }
</style>
