<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $identity->name ?? 'Portfolio' }} | Backend Engineer</title>
    <meta name="description" content="{{ Str::limit(strip_tags($identity->bio ?? ''), 160) }}">

    <!-- Typography -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600|plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        navy: '#0f172a',
                        royal: '#2563eb',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; }

        /* Scroll reveal base */
        .reveal { opacity: 0; transform: translateY(40px); transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.active { opacity: 1; transform: translateY(0); }

        /* Kinetic outline text */
        .outline-text {
            -webkit-text-stroke: 2px rgba(15, 23, 42, 0.06);
            color: transparent;
            font-size: 14vw;
            white-space: nowrap;
            user-select: none;
            line-height: 1;
        }

        /* Subtle scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* 3D Tilt Card */
        .tilt-card {
            transform-style: preserve-3d;
            will-change: transform;
            transition: transform 0.15s ease-out;
        }

        /* Floating animation for tech stack */
        @keyframes techFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        /* Subtle icon bounce for tech stack elements */
        @keyframes floatingIcon {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-5px) scale(1.05); }
        }
        .tech-card .w-14 {
            animation: floatingIcon 3s ease-in-out infinite;
        }
        .tech-card:nth-child(odd) .w-14 {
            animation-delay: 0.75s;
        }
        .tech-card:nth-child(3n) .w-14 {
            animation-delay: 1.5s;
        }

        /* Lanyard Entry & Swinging Animation */
        @keyframes lanyardThrow {
            0% { transform: translateY(-150vh) rotate(25deg); opacity: 0; }
            40% { transform: translateY(0%) rotate(-15deg); opacity: 1; }
            60% { transform: translateY(0%) rotate(8deg); }
            80% { transform: translateY(0%) rotate(-4deg); }
            100% { transform: translateY(0%) rotate(0deg); opacity: 1; }
        }
        @keyframes lanyardIdle {
            0%, 100% { transform: rotate(-2deg); }
            50% { transform: rotate(2deg); }
        }
        @keyframes lanyardToss {
            0% { transform: translateY(0) rotate(0deg) rotateY(0deg); }
            15% { transform: translateY(-80px) rotate(15deg) rotateY(180deg) scale(1.05); }
            35% { transform: translateY(-40px) rotate(-10deg) rotateY(360deg); }
            55% { transform: translateY(10px) rotate(8deg) rotateY(360deg); }
            75% { transform: translateY(-5px) rotate(-3deg) rotateY(360deg); }
            100% { transform: translateY(0) rotate(0deg) rotateY(360deg); }
        }
        .animate-lanyard {
            opacity: 0;
            transform-origin: top center;
        }
        .animate-lanyard.active {
            animation: 
              lanyardThrow 2s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards,
              lanyardIdle 6s ease-in-out 2s infinite;
        }
        .animate-lanyard.tossed {
            animation: lanyardToss 1.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards !important;
        }

        /* Access Card Barcode Laser */
        @keyframes laserScan {
            0%, 100% { top: 5%; opacity: 0; }
            10% { opacity: 1; }
            50% { top: 95%; opacity: 1; }
            90% { opacity: 1; }
        }
        .animate-laser-scan {
            animation: laserScan 3s linear infinite;
        }

        /* MacOS Browser Card reveal */
        @keyframes browserReveal {
            0%   { transform: translateY(60px) scale(0.95); opacity: 0; }
            60%  { transform: translateY(-8px) scale(1.01); opacity: 1; }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }
        @keyframes typingCursor {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
        .browser-card-reveal {
            opacity: 0;
            transform: translateY(60px) scale(0.95);
        }
        .browser-card-reveal.active {
            animation: browserReveal 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .typing-cursor {
            animation: typingCursor 1s ease infinite;
        }

        /* Lanyard Badge Toss */
        @keyframes badgeToss {
            0%   { transform: translateY(0) rotate(0deg) scale(1); }
            20%  { transform: translateY(-120px) rotate(20deg) scale(1.06); }
            40%  { transform: translateY(-80px) rotate(-14deg) scale(1.04); }
            60%  { transform: translateY(-20px) rotate(8deg) scale(1.02); }
            80%  { transform: translateY(6px) rotate(-3deg) scale(1.01); }
            100% { transform: translateY(0) rotate(0deg) scale(1); }
        }
        .badge-tossing {
            animation: badgeToss 1s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards !important;
        }

        /* Showcase Folder Card */
        @keyframes folderReveal {
            0%   { transform: translateY(50px) scale(0.93) rotateX(8deg); opacity: 0; }
            60%  { transform: translateY(-6px) scale(1.01) rotateX(-1deg); opacity: 1; }
            100% { transform: translateY(0) scale(1) rotateX(0deg); opacity: 1; }
        }
        @keyframes cardFloat {
            0%, 100% { transform: translateY(0px) rotate(0.5deg); }
            50%       { transform: translateY(-10px) rotate(-0.5deg); }
        }
        @keyframes scanLine {
            0%   { top: 0%; opacity: 0; }
            5%   { opacity: 0.8; }
            50%  { top: 100%; opacity: 0.8; }
            95%  { opacity: 0; }
            100% { top: 100%; opacity: 0; }
        }
        .showcase-card-reveal {
            opacity: 0;
            transform: translateY(50px) scale(0.93);
        }
        .showcase-card-reveal.active {
            animation: folderReveal 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .showcase-card-reveal.active .card-inner {
            animation: cardFloat 6s ease-in-out 1s infinite;
        }
        .scan-line {
            position: absolute; left: 0; width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, rgba(37,99,235,0.8) 30%, rgba(96,165,250,1) 50%, rgba(37,99,235,0.8) 70%, transparent 100%);
            box-shadow: 0 0 12px 4px rgba(37,99,235,0.5);
            animation: scanLine 4s ease-in-out infinite;
            pointer-events: none; z-index: 20;
        }
        @keyframes cardToss {
            0%   { transform: translateY(0) rotate(0deg) scale(1); }
            25%  { transform: translateY(-100px) rotate(12deg) scale(1.04); }
            50%  { transform: translateY(-60px) rotate(-8deg) scale(1.02); }
            75%  { transform: translateY(-15px) rotate(3deg) scale(1.01); }
            100% { transform: translateY(0) rotate(0deg) scale(1); }
        }
        .card-tossing {
            animation: cardToss 1.1s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards !important;
        }

        /* Infinite marquee scroll */
        @keyframes scrollLeft {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        @keyframes scrollRight {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0); }
        }

        /* Custom Cinematic Cursor */
        @media (pointer: fine) {
            body, a, button, input, textarea, [x-data], .tech-card { 
                cursor: none !important; 
            }
            .cursor-dot, .cursor-outline {
                position: fixed;
                top: 0; left: 0;
                transform: translate(-50%, -50%);
                border-radius: 50%;
                z-index: 9999;
                pointer-events: none;
            }
            .cursor-dot {
                width: 6px; height: 6px;
                background-color: #2563eb; /* Royal blue */
                transition: transform 0.1s ease-out;
            }
            .cursor-outline {
                width: 36px; height: 36px;
                border: 2px solid rgba(37, 99, 235, 0.4);
                transition: transform 0.15s ease-out, width 0.2s, height 0.2s, background-color 0.2s, border-color 0.2s;
            }
            .cursor-hover {
                width: 60px; height: 60px;
                background-color: rgba(37, 99, 235, 0.1);
                border-color: rgba(37, 99, 235, 0.6);
            }
        }
        @media (pointer: coarse) {
            .cursor-dot, .cursor-outline { display: none; }
        }
    </style>
</head>
<body class="bg-white text-navy antialiased" x-data="{ scrollY: 0, scrolled: false, progress: 0 }" @scroll.window="scrollY = window.scrollY; scrolled = scrollY > 60; progress = Math.min(100, (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100)">

    {{-- ═══════════════════════════════════════════ --}}
    {{-- EPIC LOADING SCREEN --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div id="epic-loader" class="fixed inset-0 bg-navy z-[9999] flex flex-col items-center justify-center transition-transform duration-1000 ease-[cubic-bezier(0.87,0,0.13,1)]">
        <div class="flex items-center gap-4 mb-8">
            <span class="font-heading font-extrabold text-white text-6xl tracking-tighter uppercase">{{ mb_substr($identity->name ?? 'M', 0, 1) }}<span class="text-royal">.</span></span>
        </div>
        
        <div class="relative w-64 h-[2px] bg-white/10 rounded-full overflow-hidden">
            <div id="loader-progress" class="absolute top-0 left-0 h-full bg-royal w-0" style="transition: width 0.1s ease-out"></div>
        </div>
        
        <div class="mt-5 flex items-end gap-1 text-white font-heading font-bold">
            <span id="loader-percentage" class="text-3xl text-white">0</span><span class="text-royal mb-1">%</span>
        </div>
        
        <div class="absolute bottom-12 text-white/30 text-[10px] tracking-[0.3em] font-mono animate-pulse">
            INITIALIZING SYSTEM
        </div>
    </div>
    {{-- ═══════════════════════════════════════════ --}}
    {{-- SCROLL PROGRESS BAR --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="fixed top-0 left-0 w-full h-[3px] z-[60] bg-transparent">
        <div class="h-full bg-gradient-to-r from-royal to-blue-400 transition-none" :style="`width: ${progress}%`"></div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- NAVBAR --}}
    {{-- ═══════════════════════════════════════════ --}}
    <nav class="fixed top-[3px] w-full z-50 transition-all duration-500"
         :class="scrolled ? 'bg-white/90 backdrop-blur-xl shadow-sm' : 'bg-transparent'">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-5 flex justify-between items-center">
            <a href="#" class="font-heading font-extrabold text-3xl tracking-tighter text-navy uppercase">
                {{ mb_substr($identity->name ?? 'M', 0, 1) }}<span class="text-royal">.</span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="#about" class="text-sm font-semibold text-slate-500 hover:text-navy transition">About</a>
                <a href="#education" class="text-sm font-semibold text-slate-500 hover:text-navy transition">Education</a>
                <a href="#work" class="text-sm font-semibold text-slate-500 hover:text-navy transition">Work</a>
                <a href="#certifications" class="text-sm font-semibold text-slate-500 hover:text-navy transition">Certifications</a>
                <a href="#contact" class="text-sm font-semibold text-slate-500 hover:text-navy transition">Contact</a>
            </div>

            <div class="flex items-center gap-3 border border-slate-200 bg-white/60 backdrop-blur-md px-4 py-2 rounded-full">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-royal opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-royal"></span>
                </span>
                <span class="text-[11px] font-bold text-navy tracking-widest uppercase">Available</span>
            </div>
        </div>
    </nav>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- HERO SECTION --}}
    {{-- ═══════════════════════════════════════════ --}}
    <header class="relative min-h-screen flex items-center overflow-x-hidden bg-white pt-24 pb-16">
        {{-- Kinetic BG Text --}}
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none"
             :style="`transform: translateX(${scrollY * -0.08}px)`">
            <span class="outline-text font-heading font-extrabold uppercase">{{ $identity->title ?? 'ENGINEER' }}</span>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

                {{-- Left: Text Content --}}
                <div class="order-2 lg:order-1" x-data="{ shown: false }" x-intersect="shown = true">
                    <p class="text-royal font-bold text-sm tracking-widest uppercase mb-4 reveal" :class="shown && 'active'">
                        {{ $identity->title ?? 'Backend Engineer' }}
                    </p>

                    <h1 class="font-heading font-extrabold text-5xl sm:text-6xl lg:text-7xl text-navy leading-[0.95] tracking-tight uppercase reveal"
                        :class="shown && 'active'" style="transition-delay: 100ms;">
                        {{ $identity->name ?? 'Your Name' }}
                    </h1>

                    {{-- Typewriter Rotating Phrases --}}
                    <div class="mt-6 flex items-center gap-3 h-8 reveal" :class="shown && 'active'" style="transition-delay: 200ms;">
                        <span class="text-slate-400 text-lg font-medium">Hi, I'm a</span>
                        <span id="typewriter-text" class="text-royal font-bold text-lg font-heading"></span>
                        <span class="inline-block w-[2px] h-5 bg-royal typing-cursor"></span>
                    </div>

                    <div class="flex flex-wrap gap-4 mt-10 reveal" :class="shown && 'active'" style="transition-delay: 300ms;">
                        <a href="#work" class="inline-flex items-center gap-2 bg-navy text-white px-7 py-4 rounded-full font-heading font-bold text-sm tracking-wider uppercase hover:bg-royal transition duration-300 shadow-xl hover:shadow-2xl">
                            View Projects
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </a>
                        @if(isset($identity->github_link) && $identity->github_link)
                        <a href="{{ $identity->github_link }}" target="_blank" class="inline-flex items-center gap-2 border-2 border-slate-200 text-navy px-7 py-4 rounded-full font-heading font-bold text-sm tracking-wider uppercase hover:border-navy transition duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                            GitHub
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Right: Premium Dark Lanyard Name Tag --}}
                <div class="order-1 lg:order-2 flex justify-center" x-data="{ shown: false }" x-intersect="shown = true">
                    {{-- Outer wrapper: badge starts at top, strap goes ABOVE via absolute --}}
                    <div class="relative pt-10" :class="shown ? 'opacity-100' : 'opacity-0'" style="transition: opacity 0.4s;">

                        {{-- Lanyard Strap (absolute, hangs UP from the hook) --}}
                        <div class="absolute left-1/2 -translate-x-1/2 w-5 rounded-t-sm"
                             style="bottom: calc(100% - 32px); height: 280px; background: linear-gradient(180deg, #1e3a8a 0%, #2563eb 60%, #1e40af 100%); box-shadow: 0 0 20px rgba(37,99,235,0.5); z-index: 10;"></div>

                        {{-- Metal Hook --}}
                        <div class="relative flex justify-center z-20" style="margin-bottom: -6px;">
                            <div class="w-8 h-8 rounded-full border-4 border-gray-300 bg-gradient-to-b from-gray-100 to-gray-300 shadow-lg"></div>
                        </div>

                        {{-- The Premium ID Badge --}}
                        <div id="lanyard-badge" class="tilt-card relative z-30 cursor-grab active:cursor-grabbing"
                             data-tilt data-tilt-max="10" data-tilt-speed="500" data-tilt-glare data-tilt-max-glare="0.4"
                             style="width: 280px;">
                            <div class="rounded-2xl overflow-hidden border border-white/10 shadow-[0_30px_80px_-10px_rgba(0,0,0,0.7),0_0_40px_rgba(37,99,235,0.2)]"
                                 style="background: linear-gradient(145deg, #0f172a 0%, #1a2440 50%, #0f172a 100%);">

                                {{-- Top punch hole --}}
                                <div class="flex justify-center pt-3 pb-1">
                                    <div class="w-14 h-2 rounded-full bg-white/10 border border-white/5 shadow-inner"></div>
                                </div>

                                {{-- Company Header --}}
                                <div class="px-5 pb-3 flex items-center justify-between">
                                    <div>
                                        <div class="text-[8px] font-bold tracking-[0.25em] text-white/30 uppercase">BINUS University</div>
                                        <div class="text-[9px] font-bold tracking-[0.15em] text-royal uppercase mt-0.5">Tech Division 2028</div>
                                    </div>
                                    <div class="w-7 h-7 rounded-md bg-royal/20 border border-royal/30 flex items-center justify-center">
                                        <span class="text-royal font-heading font-black text-sm">M.</span>
                                    </div>
                                </div>

                                {{-- Photo --}}
                                <div class="mx-4 rounded-xl overflow-hidden relative" style="height: 220px; border: 2px solid rgba(37,99,235,0.3);">
                                    @if(isset($identity->avatar) && $identity->avatar)
                                        <img src="{{ asset('storage/' . $identity->avatar) }}" alt="{{ $identity->name }}" class="w-full h-full object-cover object-top">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-navy to-slate-800 flex items-center justify-center">
                                            <span class="font-heading font-extrabold text-white/20 text-7xl uppercase">{{ mb_substr($identity->name ?? 'P', 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(15,23,42,0.8) 0%, transparent 50%);"></div>
                                    <div class="absolute top-2 right-2 flex gap-1">
                                        <div class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse shadow-[0_0_6px_rgba(34,211,238,0.9)]"></div>
                                        <div class="w-1.5 h-1.5 rounded-full bg-royal animate-pulse shadow-[0_0_6px_rgba(37,99,235,0.9)]" style="animation-delay:0.5s"></div>
                                    </div>
                                </div>

                                {{-- Name & Title --}}
                                <div class="px-5 pt-4 pb-2 text-center">
                                    <div class="text-[10px] font-bold tracking-[0.25em] text-white/30 uppercase mb-1">Authorized Personnel</div>
                                    <div class="font-heading font-black text-base text-white tracking-tight leading-tight">{{ $identity->name ?? 'Muhammad Nur H.' }}</div>
                                    <div class="h-[1px] w-full my-2" style="background: linear-gradient(90deg, transparent, rgba(37,99,235,0.6), transparent);"></div>
                                    <div class="text-[9px] font-bold tracking-[0.2em] text-royal uppercase">{{ $identity->title ?? 'Backend Engineer' }}</div>
                                </div>

                                {{-- Admin Scanner --}}
                                <div class="mx-4 mb-4">
                                    <a href="/admin" class="relative flex items-center justify-center h-12 rounded-lg overflow-hidden group/scan border border-cyan-400/20 hover:border-cyan-400/50 transition-colors" style="background: rgba(15,23,42,0.7);" title="Admin Access">
                                        <div class="flex h-8 w-full px-3 items-center justify-between gap-[2px] opacity-50 group-hover/scan:opacity-80 transition-opacity">
                                            @foreach ([2,1,3,2,1,4,2,1,3,1,2,3,1,4,2,1,3,2,1] as $w)
                                                <div class="h-full bg-cyan-400/60 rounded-[1px]" style="width: {{ $w }}px"></div>
                                            @endforeach
                                        </div>
                                        <div class="absolute left-0 w-full h-[1.5px] animate-laser-scan" style="background: rgba(34,211,238,0.9); box-shadow: 0 0 8px 2px rgba(34,211,238,0.6);"></div>
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover/scan:opacity-100 transition-all duration-200" style="background: rgba(15,23,42,0.85);">
                                            <span class="text-cyan-400 font-bold text-[9px] tracking-[0.3em] uppercase">⚡ Admin Access</span>
                                        </div>
                                    </a>
                                </div>

                            </div>{{-- end card bg --}}
                        </div>{{-- end tilt-card --}}

                    </div>{{-- end outer wrapper --}}
                </div>
    </header>


    {{-- ═══════════════════════════════════════════ --}}
    {{-- ABOUT / BIO SECTION --}}
    {{-- ═══════════════════════════════════════════ --}}
    <section class="py-28 md:py-40 bg-white border-t border-slate-100 relative overflow-hidden" id="about">

        {{-- Kinetic outline background text --}}
        <div class="absolute inset-0 flex items-center justify-start pointer-events-none overflow-hidden" style="padding-left: 5%;">
            <span class="font-heading font-extrabold uppercase tracking-tighter select-none"
                  style="font-size: 18vw; line-height: 1; color: transparent; -webkit-text-stroke: 1.5px rgba(15,23,42,0.04); white-space: nowrap;">
                ABOUT
            </span>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 lg:px-8" x-data="{ shown: false }" x-intersect.margin.-100px="shown = true">
            <div class="flex items-center gap-4 mb-12 reveal" :class="shown && 'active'">
                <div class="w-12 h-[2px] bg-royal"></div>
                <span class="font-heading font-bold text-royal text-sm tracking-widest uppercase">About Me</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">
                {{-- Bio Statement --}}
                <div class="lg:col-span-3 reveal" :class="shown && 'active'" style="transition-delay: 100ms;">
                    <div class="font-heading text-xl md:text-2xl text-navy/80 leading-relaxed font-medium tracking-tight mb-8">
                        @if(isset($identity->bio) && $identity->bio)
                            {!! nl2br(strip_tags($identity->bio)) !!}
                        @else
                            A dedicated Backend Engineer building clean, efficient architectures for the modern web.
                        @endif
                    </div>
                </div>

                {{-- Quick Facts --}}
                <div class="lg:col-span-2 reveal" :class="shown && 'active'" style="transition-delay: 250ms;">
                    <div class="rounded-2xl border border-slate-100 p-6 bg-white shadow-sm">
                        <div class="space-y-5">
                            <div class="border-b border-slate-100 pb-4">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Name</p>
                                <p class="font-heading font-bold text-navy text-lg">{{ $identity->name ?? '-' }}</p>
                            </div>
                            <div class="border-b border-slate-100 pb-4">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Role</p>
                                <p class="font-heading font-bold text-navy text-lg">{{ $identity->title ?? '-' }}</p>
                            </div>
                            @if(isset($identity->email) && $identity->email)
                            <div class="border-b border-slate-100 pb-4">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Email</p>
                                <a href="mailto:{{ $identity->email }}" class="font-heading font-bold text-royal text-lg hover:underline">{{ $identity->email }}</a>
                            </div>
                            @endif
                            <div class="flex gap-3 pt-1">
                                @if(isset($identity->github_link) && $identity->github_link)
                                <a href="{{ $identity->github_link }}" target="_blank" class="w-11 h-11 rounded-full bg-navy flex items-center justify-center hover:bg-royal transition">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                                </a>
                                @endif
                                @if(isset($identity->linkedin_link) && $identity->linkedin_link)
                                <a href="{{ $identity->linkedin_link }}" target="_blank" class="w-11 h-11 rounded-full bg-navy flex items-center justify-center hover:bg-royal transition">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- EDUCATION SECTION --}}
    {{-- ═══════════════════════════════════════════ --}}
    @if(isset($educations) && $educations->count() > 0)
    <section class="py-28 md:py-36 bg-navy relative overflow-hidden" id="education">

        {{-- Decorative background text --}}
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.025]">
            <span class="font-heading font-extrabold text-white text-[20vw] whitespace-nowrap leading-none tracking-tighter uppercase">EDUCATION</span>
        </div>

        {{-- Dot grid --}}
        <div class="absolute inset-0 pointer-events-none" style="background-image: radial-gradient(rgba(37,99,235,0.12) 1px, transparent 1px); background-size: 40px 40px;"></div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="mb-16" x-data="{ shown: false }" x-intersect.margin.-100px="shown = true">
                <div class="flex items-center gap-4 mb-4 reveal" :class="shown && 'active'">
                    <div class="w-12 h-[2px]" style="background: #2563eb;"></div>
                    <span class="font-heading font-bold text-sm tracking-widest uppercase" style="color: #60a5fa;">Riwayat Pendidikan</span>
                </div>
                <h2 class="font-heading font-extrabold text-5xl md:text-6xl text-white uppercase tracking-tighter reveal" :class="shown && 'active'" style="transition-delay: 100ms;">
                    Education
                </h2>
            </div>

            {{-- Timeline --}}
            <div class="relative">

                {{-- Vertical line --}}
                <div class="absolute left-6 top-0 bottom-0 w-[2px] md:left-1/2 md:-translate-x-1/2"
                     style="background: linear-gradient(to bottom, transparent, rgba(37,99,235,0.6) 10%, rgba(37,99,235,0.6) 90%, transparent);"></div>

                <div class="space-y-10">
                    @foreach($educations as $index => $edu)
                    <div class="relative reveal" x-data="{ shown: false }" x-intersect.margin.-60px="shown = true"
                         :class="shown && 'active'" style="transition-delay: {{ $index * 100 }}ms;">

                        {{-- Dot on timeline --}}
                        <div class="absolute left-6 md:left-1/2 top-6 w-4 h-4 rounded-full border-2 border-royal bg-navy -translate-x-1/2 z-10 shadow-[0_0_12px_rgba(37,99,235,0.7)]"
                             style="background: #2563eb;"></div>

                        {{-- Card: alternate left/right on desktop --}}
                        <div class="pl-16 md:pl-0 {{ $index % 2 === 0 ? 'md:pr-[calc(50%+2rem)] md:text-right' : 'md:pl-[calc(50%+2rem)]' }}">
                            <div class="group relative overflow-hidden rounded-2xl p-6 transition-all duration-500 hover:-translate-y-1"
                                 style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(10px);">

                                {{-- Corner accents --}}
                                <div class="absolute top-3 left-3 w-3 h-3 pointer-events-none" style="border-top: 1.5px solid rgba(37,99,235,0.5); border-left: 1.5px solid rgba(37,99,235,0.5); border-radius: 2px 0 0 0;"></div>
                                <div class="absolute top-3 right-3 w-3 h-3 pointer-events-none" style="border-top: 1.5px solid rgba(37,99,235,0.5); border-right: 1.5px solid rgba(37,99,235,0.5); border-radius: 0 2px 0 0;"></div>
                                <div class="absolute bottom-3 left-3 w-3 h-3 pointer-events-none" style="border-bottom: 1.5px solid rgba(37,99,235,0.5); border-left: 1.5px solid rgba(37,99,235,0.5); border-radius: 0 0 0 2px;"></div>
                                <div class="absolute bottom-3 right-3 w-3 h-3 pointer-events-none" style="border-bottom: 1.5px solid rgba(37,99,235,0.5); border-right: 1.5px solid rgba(37,99,235,0.5); border-radius: 0 0 2px 0;"></div>

                                {{-- Hover glow --}}
                                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none rounded-2xl"
                                     style="background: radial-gradient(ellipse at center, rgba(37,99,235,0.08) 0%, transparent 70%);"></div>

                                {{-- Year Badge --}}
                                <div class="inline-flex items-center gap-2 mb-3 px-3 py-1 rounded-full text-[10px] font-bold tracking-[0.25em] uppercase"
                                     style="background: rgba(37,99,235,0.15); border: 1px solid rgba(37,99,235,0.3); color: #60a5fa;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-royal inline-block animate-pulse"></span>
                                    {{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }}
                                    <span class="text-white/30">→</span>
                                    {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('Y') : 'Sekarang' }}
                                </div>

                                {{-- Institution --}}
                                <h3 class="font-heading font-extrabold text-xl text-white uppercase tracking-tight leading-tight mb-1">
                                    {{ $edu->institution }}
                                </h3>

                                {{-- Degree --}}
                                <div class="flex items-center gap-2 {{ $index % 2 === 0 ? 'md:justify-end' : '' }}">
                                    <span class="font-bold text-sm" style="color: #2563eb;">{{ $edu->degree }}</span>
                                    @if($edu->major)
                                        <span class="text-white/20">·</span>
                                        <span class="text-white/50 text-sm">{{ $edu->major }}</span>
                                    @endif
                                </div>

                                {{-- Status badge --}}
                                @if(!$edu->end_date)
                                <div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase"
                                     style="background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.25); color: #34d399;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Sedang Berlangsung
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════════════════════════════════ --}}
    {{-- TECH STACK (Epic Marquee) --}}
    {{-- ═══════════════════════════════════════════ --}}
    <section class="py-28 md:py-40 relative overflow-hidden" id="techstack"
             style="background: linear-gradient(180deg, #020617 0%, #0f172a 50%, #020617 100%);">

        {{-- Animated dot grid background --}}
        <div class="absolute inset-0 pointer-events-none" style="background-image: radial-gradient(rgba(37,99,235,0.15) 1px, transparent 1px); background-size: 40px 40px;"></div>

        {{-- Glowing orbs --}}
        <div class="absolute top-20 left-[20%] w-[500px] h-[500px] rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(37,99,235,0.08) 0%, transparent 70%); animation: techFloat 8s ease-in-out infinite;"></div>
        <div class="absolute bottom-20 right-[15%] w-[400px] h-[400px] rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(99,102,241,0.06) 0%, transparent 70%); animation: techFloat 10s ease-in-out 2s infinite;"></div>

        <div class="relative z-10">
            {{-- Header --}}
            <div class="text-center mb-20 px-6" x-data="{ shown: false }" x-intersect="shown = true">
                <div class="inline-flex items-center gap-2 bg-white/[0.05] border border-white/[0.08] rounded-full px-5 py-2 mb-6 reveal" :class="shown && 'active'">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-white/60 font-heading font-bold text-[11px] tracking-widest uppercase">Tools & Technologies</span>
                </div>
                <h2 class="font-heading font-extrabold text-5xl md:text-7xl lg:text-8xl text-white uppercase tracking-tighter reveal" :class="shown && 'active'" style="transition-delay: 100ms;">
                    Tech <span class="bg-gradient-to-r from-royal to-indigo-400 bg-clip-text text-transparent">Stack</span>
                </h2>
                <p class="text-white/30 font-medium text-lg mt-4 max-w-md mx-auto reveal" :class="shown && 'active'" style="transition-delay: 200ms;">
                    The technologies I use to bring ideas to life
                </p>
            </div>

            {{-- Row 1: Backend & Databases → Scroll Left --}}
            <div class="relative mb-5 group/row">
                {{-- Edge fade --}}
                <div class="absolute left-0 top-0 bottom-0 w-32 z-10 pointer-events-none" style="background: linear-gradient(to right, #020617, transparent);"></div>
                <div class="absolute right-0 top-0 bottom-0 w-32 z-10 pointer-events-none" style="background: linear-gradient(to left, #020617, transparent);"></div>
                <div class="overflow-hidden">
                    <div class="flex gap-4 w-max group-hover/row:[animation-play-state:paused]" style="animation: scrollLeft 40s linear infinite;">
                        {{-- 2x for seamless loop --}}
                        @for($loop_i = 0; $loop_i < 2; $loop_i++)
                        {{-- Laravel --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#FF2D20]/40 hover:bg-[#FF2D20]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(255,45,32,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center animate-icon" style="background:linear-gradient(135deg,#FF2D2020,#FF2D2008); animation-delay: 0s;">
                                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="#FF2D20"><path d="M23.642 5.43a.364.364 0 01.014.1v5.149c0 .135-.073.26-.189.326l-4.323 2.49v4.934a.378.378 0 01-.188.326L9.93 23.949a.316.316 0 01-.066.027c-.008.002-.016.008-.024.01a.348.348 0 01-.192 0c-.011-.002-.02-.008-.03-.012a.282.282 0 01-.064-.027L.533 18.755a.378.378 0 01-.189-.326V2.974c0-.033.005-.066.014-.098.003-.012.01-.02.014-.032a.369.369 0 01.023-.058c.004-.013.015-.022.023-.033l.033-.045c.012-.01.025-.018.037-.027.014-.012.027-.024.041-.034h.001L5.044.05a.375.375 0 01.375 0L9.933 2.697h.002c.015.01.027.021.04.033.013.01.026.018.038.028.013.014.02.03.033.045.008.011.02.021.025.034.01.017.014.037.022.057.005.012.012.021.015.033.008.032.013.065.013.098v9.652l3.76-2.164V5.527c0-.033.004-.066.013-.098.004-.012.01-.021.015-.033a.37.37 0 01.022-.057c.005-.013.016-.023.025-.035.013-.014.02-.03.033-.044.012-.011.025-.019.038-.028.014-.013.027-.024.041-.034h0l4.513-2.647a.375.375 0 01.376 0l4.513 2.647c.016.01.027.021.042.033.012.01.025.018.036.028.014.014.021.03.034.044.008.012.019.022.024.035.01.017.015.037.023.057.004.012.011.021.014.033zm-.74 5.032V6.179l-1.578.908-2.182 1.256v4.283zm-4.514 7.76v-4.287l-2.147 1.225-6.126 3.498v4.325zM1.093 3.624v14.588l8.273 4.761v-4.325l-4.322-2.445-.002-.003-.002-.001c-.014-.01-.025-.021-.04-.033-.012-.01-.025-.02-.035-.03l-.001-.002c-.013-.014-.02-.03-.031-.045-.01-.012-.021-.023-.028-.037v-.002c-.01-.016-.014-.035-.02-.054-.005-.013-.012-.024-.015-.038v-.001c-.005-.02-.007-.041-.008-.062-.002-.013-.006-.026-.006-.04V5.789l-2.18-1.257zM5.232.81L1.47 3.02l3.76 2.164 3.758-2.164zm2.194 13.298l2.182-1.256V3.624l-1.578.91-2.182 1.255v9.228zm11.291-10.1l-3.762 2.166 3.762 2.163 3.76-2.163zm-.376 4.978L16.16 7.73l-1.578-.909v4.283l2.182 1.256 1.577.908zm-8.652 9.036l5.514-3.148 2.756-1.572-3.757-2.163-4.324 2.49-3.94 2.27z"/></svg>
                                </div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">Laravel</span>
                            </div>
                        </div>
                        {{-- PHP --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#777BB4]/40 hover:bg-[#777BB4]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(119,123,180,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#777BB420,#777BB408);">
                                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="#777BB4"><path d="M7.01 10.207h-.944l-.515 2.648h.838c.556 0 .97-.105 1.242-.315.272-.21.455-.559.55-1.049.092-.47.05-.802-.124-.995-.175-.193-.523-.29-1.047-.29zM12 5.688C5.373 5.688 0 8.514 0 12s5.373 6.313 12 6.313S24 15.486 24 12c0-3.486-5.373-6.312-12-6.312zm-3.26 7.451c-.261.25-.575.438-.917.551-.336.108-.765.164-1.286.164H5.357l-.327 1.681H3.652l1.23-6.326h2.65c.797 0 1.378.209 1.744.628.366.418.476 1.002.33 1.752a2.836 2.836 0 01-.349.853c-.145.254-.34.48-.567.697zm4.89 2.396l.528-2.715c.095-.488.033-.84-.188-1.05-.222-.212-.627-.318-1.218-.318h-1.103l-.71 3.646h-1.378l1.23-6.326h1.367l-.327 1.682h1.218c.88 0 1.5.182 1.857.545.36.364.464.944.314 1.74l-.555 2.797zm5.092-2.396c-.262.25-.575.438-.917.551-.336.108-.765.164-1.286.164h-1.18l-.327 1.681h-1.378l1.23-6.326h2.649c.797 0 1.378.209 1.744.628.366.418.477 1.002.33 1.752a2.836 2.836 0 01-.349.853c-.144.254-.339.48-.566.697zm-.503-1.754c.092-.47.049-.802-.124-.995-.175-.193-.524-.29-1.048-.29h-.943l-.516 2.648h.838c.557 0 .971-.105 1.242-.315.272-.21.455-.559.55-1.049z"/></svg>
                                </div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">PHP</span>
                            </div>
                        </div>
                        {{-- Go --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#00ADD8]/40 hover:bg-[#00ADD8]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(0,173,216,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#00ADD820,#00ADD808);">
                                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="#00ADD8"><path d="M1.811 10.231c-.047 0-.058-.023-.035-.059l.246-.315c.023-.035.081-.058.128-.058h4.172c.046 0 .058.035.035.07l-.199.303c-.023.036-.082.07-.117.07zM.047 11.306c-.047 0-.059-.023-.035-.058l.245-.316c.023-.035.082-.058.129-.058h5.328c.047 0 .07.035.058.07l-.093.28c-.012.047-.058.07-.105.07zm2.828 1.075c-.047 0-.059-.035-.035-.07l.163-.292c.023-.035.07-.07.117-.07h2.337c.047 0 .07.035.07.082l-.023.28c0 .047-.047.082-.082.082zm12.129-2.36c-.736.187-1.239.327-1.963.514-.176.046-.187.058-.34-.117-.174-.199-.303-.327-.548-.444-.737-.362-1.45-.257-2.115.175-.789.514-1.195 1.261-1.183 2.152.012.883.652 1.605 1.523 1.72.756.093 1.39-.163 1.916-.72.11-.117.21-.246.339-.397H14.03c-.246 0-.304-.152-.222-.35.152-.362.432-.97.596-1.274a.315.315 0 01.292-.187h4.253c-.023.316-.023.631-.07.947a5.236 5.236 0 01-1.053 2.454c-.96 1.193-2.164 1.985-3.673 2.268-1.227.222-2.384.094-3.437-.607a4.091 4.091 0 01-1.728-2.56c-.246-1.263-.023-2.442.642-3.52.737-1.193 1.81-1.997 3.16-2.384 1.124-.327 2.22-.28 3.253.35.666.409 1.135.96 1.46 1.647.07.117.035.175-.093.21z"/></svg>
                                </div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">Golang</span>
                            </div>
                        </div>
                        {{-- PostgreSQL --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#4169E1]/40 hover:bg-[#4169E1]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(65,105,225,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl" style="background:linear-gradient(135deg,#4169E120,#4169E108);">🐘</div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">PostgreSQL</span>
                            </div>
                        </div>
                        {{-- MySQL --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#00758F]/40 hover:bg-[#00758F]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(0,117,143,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl" style="background:linear-gradient(135deg,#00758F20,#00758F08);">🐬</div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">MySQL</span>
                            </div>
                        </div>
                        {{-- Docker --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#2496ED]/40 hover:bg-[#2496ED]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(36,150,237,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#2496ED20,#2496ED08);">
                                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="#2496ED"><path d="M13.983 11.078h2.119a.186.186 0 00.186-.185V9.006a.186.186 0 00-.186-.186h-2.119a.185.185 0 00-.185.185v1.888c0 .102.083.185.185.185m-2.954-5.43h2.118a.186.186 0 00.186-.186V3.574a.186.186 0 00-.186-.185h-2.118a.185.185 0 00-.185.185v1.888c0 .102.082.185.185.186m0 2.716h2.118a.187.187 0 00.186-.186V6.29a.186.186 0 00-.186-.185h-2.118a.185.185 0 00-.185.185v1.887c0 .102.082.185.185.186m-2.93 0h2.12a.186.186 0 00.184-.186V6.29a.185.185 0 00-.185-.185H8.1a.185.185 0 00-.185.185v1.887c0 .102.083.185.185.186m-2.964 0h2.119a.186.186 0 00.185-.186V6.29a.185.185 0 00-.185-.185H5.136a.186.186 0 00-.186.185v1.887c0 .102.084.185.186.186m5.893 2.715h2.118a.186.186 0 00.186-.185V9.006a.186.186 0 00-.186-.186h-2.118a.185.185 0 00-.185.185v1.888c0 .102.082.185.185.185m-2.93 0h2.12a.185.185 0 00.184-.185V9.006a.185.185 0 00-.184-.186h-2.12a.185.185 0 00-.184.185v1.888c0 .102.083.185.185.185m-2.964 0h2.119a.185.185 0 00.185-.185V9.006a.185.185 0 00-.184-.186h-2.12a.186.186 0 00-.186.186v1.887c0 .102.084.185.186.185m-2.92 0h2.12a.185.185 0 00.184-.185V9.006a.185.185 0 00-.184-.186H2.22a.185.185 0 00-.186.185v1.888c0 .102.084.185.186.185m10.893 2.715h2.118a.186.186 0 00.186-.185v-1.888a.186.186 0 00-.186-.185h-2.118a.186.186 0 00-.186.185v1.888c0 .102.084.185.186.185M23.763 9.89c-.065-.051-.672-.51-1.954-.51-.338.001-.676.03-1.01.087-.248-1.7-1.653-2.53-1.716-2.566l-.344-.199-.226.327c-.284.438-.49.922-.612 1.43-.23.97-.09 1.882.403 2.661-.595.332-1.55.413-1.744.42H.751a.751.751 0 00-.75.748 11.376 11.376 0 00.692 4.062c.545 1.428 1.355 2.48 2.41 3.124 1.18.723 3.1 1.137 5.275 1.137.983.003 1.963-.086 2.93-.266a12.248 12.248 0 003.823-1.389c.98-.567 1.86-1.288 2.61-2.136 1.252-1.418 1.998-2.997 2.553-4.4h.221c1.372 0 2.215-.549 2.68-1.009.309-.293.55-.65.707-1.046l.098-.288z"/></svg>
                                </div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">Docker</span>
                            </div>
                        </div>
                        {{-- Redis --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#DC382D]/40 hover:bg-[#DC382D]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(220,56,45,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#DC382D20,#DC382D08);">
                                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="#DC382D"><path d="M10.5 2.661l.54.997-1.797.644 2.409.166.54.997-1.797.644 2.409.166.002.004 1.469-.535L12 3.88l3.274-1.194-.526-.97-1.621.6 2.173.14.526.97-1.621.6 2.173.14.004.003 1.277-.466-3.28-1.196-3.274-1.194z M12 17.58c4.876 0 8.826-1.373 8.826-3.066 0-.39-.223-.764-.627-1.11-2.66 1.053-5.416 1.59-8.199 1.59-2.783 0-5.54-.537-8.2-1.59-.403.346-.626.72-.626 1.11 0 1.693 3.95 3.066 8.826 3.066z M12 21.58c4.876 0 8.826-1.373 8.826-3.066v-2.863c-2.265 1.234-5.49 1.93-8.826 1.93-3.336 0-6.56-.696-8.826-1.93v2.863c0 1.693 3.95 3.066 8.826 3.066z"/></svg>
                                </div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">Redis</span>
                            </div>
                        </div>
                        {{-- Git --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#F05032]/40 hover:bg-[#F05032]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(240,80,50,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#F0503220,#F0503208);">
                                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="#F05032"><path d="M23.546 10.93L13.067.452c-.604-.603-1.582-.603-2.188 0L8.708 2.627l2.76 2.76c.645-.215 1.379-.07 1.889.441.516.515.658 1.258.438 1.9l2.66 2.66c.645-.222 1.387-.078 1.9.435.721.72.721 1.884 0 2.604-.72.719-1.886.719-2.605 0-.538-.536-.67-1.32-.4-1.978l-2.48-2.48v6.53c.175.087.34.198.477.335.72.72.72 1.884 0 2.604-.72.719-1.885.719-2.604 0-.72-.72-.72-1.885 0-2.604.182-.181.39-.32.619-.42V8.834c-.228-.1-.434-.24-.617-.422a1.838 1.838 0 01-.404-1.96L7.636 3.725.45 10.913c-.604.601-.604 1.582 0 2.186l10.48 10.477c.604.604 1.582.604 2.186 0l10.43-10.43c.605-.603.605-1.582 0-2.186"/></svg>
                                </div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">Git</span>
                            </div>
                        </div>
                        {{-- GitHub --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-white/30 hover:bg-white/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,rgba(255,255,255,0.12),rgba(255,255,255,0.04));">
                                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="white"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                                </div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">GitHub</span>
                            </div>
                        </div>
                        {{-- Linux --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#FCC624]/40 hover:bg-[#FCC624]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(252,198,36,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl" style="background:linear-gradient(135deg,#FCC62420,#FCC62408);">🐧</div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">Linux</span>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Row 2: Frontend & Frameworks → Scroll Right --}}
            <div class="relative mb-5 group/row">
                <div class="absolute left-0 top-0 bottom-0 w-32 z-10 pointer-events-none" style="background: linear-gradient(to right, #020617, transparent);"></div>
                <div class="absolute right-0 top-0 bottom-0 w-32 z-10 pointer-events-none" style="background: linear-gradient(to left, #020617, transparent);"></div>
                <div class="overflow-hidden">
                    <div class="flex gap-4 w-max group-hover/row:[animation-play-state:paused]" style="animation: scrollRight 45s linear infinite;">
                        @for($loop_i = 0; $loop_i < 2; $loop_i++)
                        {{-- JavaScript --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#F7DF1E]/40 hover:bg-[#F7DF1E]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(247,223,30,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center font-extrabold text-2xl text-[#F7DF1E]" style="background:linear-gradient(135deg,#F7DF1E20,#F7DF1E08);">JS</div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">JavaScript</span>
                            </div>
                        </div>
                        {{-- Tailwind --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#06B6D4]/40 hover:bg-[#06B6D4]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(6,182,212,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#06B6D420,#06B6D408);">
                                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="#06B6D4"><path d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.337 13.382 8.976 12 6.001 12z"/></svg>
                                </div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">Tailwind</span>
                            </div>
                        </div>
                        {{-- HTML5 --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#E34F26]/40 hover:bg-[#E34F26]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(227,79,38,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center font-extrabold text-xl text-[#E34F26]" style="background:linear-gradient(135deg,#E34F2620,#E34F2608);">&lt;/&gt;</div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">HTML5</span>
                            </div>
                        </div>
                        {{-- CSS3 --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#1572B6]/40 hover:bg-[#1572B6]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(21,114,182,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center font-extrabold text-xl text-[#1572B6]" style="background:linear-gradient(135deg,#1572B620,#1572B608);">{ }</div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">CSS3</span>
                            </div>
                        </div>
                        {{-- Alpine.js --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#8BC0D0]/40 hover:bg-[#8BC0D0]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(139,192,208,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl" style="background:linear-gradient(135deg,#8BC0D020,#8BC0D008);">🏔️</div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">Alpine.js</span>
                            </div>
                        </div>
                        {{-- Filament --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#FDAE4B]/40 hover:bg-[#FDAE4B]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(253,174,75,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl" style="background:linear-gradient(135deg,#FDAE4B20,#FDAE4B08);">🟠</div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">Filament</span>
                            </div>
                        </div>
                        {{-- Bootstrap --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#7952B3]/40 hover:bg-[#7952B3]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(121,82,179,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center font-extrabold text-2xl text-[#7952B3]" style="background:linear-gradient(135deg,#7952B320,#7952B308);">B</div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">Bootstrap</span>
                            </div>
                        </div>
                        {{-- REST API --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#6366F1]/40 hover:bg-[#6366F1]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(99,102,241,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,#6366F120,#6366F108);">
                                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="#6366F1"><path d="M7 7H5v2h2V7zm4 0H9v2h2V7zm0 4H9v2h2v-2zm4-4h-2v2h2V7zm0 4h-2v2h2v-2zm4-4h-2v2h2V7zM3 3v18h18V3H3zm16 16H5V5h14v14z"/></svg>
                                </div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">REST API</span>
                            </div>
                        </div>
                        {{-- Nginx --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#009639]/40 hover:bg-[#009639]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(0,150,57,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center font-extrabold text-lg text-[#009639]" style="background:linear-gradient(135deg,#00963920,#00963908);">N</div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">Nginx</span>
                            </div>
                        </div>
                        {{-- AWS --}}
                        <div class="tech-card group/card flex-shrink-0 w-40 md:w-44 p-5 rounded-2xl border border-white/[0.06] bg-white/[0.03] backdrop-blur-sm transition-all duration-500 hover:border-[#FF9900]/40 hover:bg-[#FF9900]/[0.06] hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(255,153,0,0.15)] cursor-default">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl" style="background:linear-gradient(135deg,#FF990020,#FF990008);">☁️</div>
                                <span class="text-white/50 font-heading font-bold text-[11px] tracking-widest uppercase group-hover/card:text-white transition-colors">AWS</span>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- PROJECTS SECTION --}}
    {{-- ═══════════════════════════════════════════ --}}
    <section class="py-28 md:py-40 bg-white relative overflow-hidden" id="work">

        {{-- Kinetic outline background text --}}
        <div class="absolute inset-0 flex items-end justify-end pointer-events-none overflow-hidden" style="padding-right: 3%; padding-bottom: 5%;">
            <span class="font-heading font-extrabold uppercase tracking-tighter select-none"
                  style="font-size: 22vw; line-height: 0.85; color: transparent; -webkit-text-stroke: 1.5px rgba(15,23,42,0.04); white-space: nowrap;">
                WORK
            </span>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-end border-b-2 border-navy pb-6 mb-16" x-data="{ shown: false }" x-intersect="shown = true">
                <h2 class="font-heading font-extrabold text-5xl md:text-7xl text-navy uppercase tracking-tighter reveal" :class="shown && 'active'">
                    Selected<br>Work
                </h2>
                <span class="hidden md:block font-bold text-slate-400 tracking-widest uppercase text-sm reveal" :class="shown && 'active'" style="transition-delay: 150ms;">
                    {{ count($projects ?? []) }} Projects
                </span>
            </div>

            <div class="space-y-20">
                @forelse($projects ?? [] as $index => $project)
                <article class="group" x-data="{ shown: false }" x-intersect.margin.-80px="shown = true">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center {{ $index % 2 !== 0 ? 'lg:flex-row-reverse' : '' }}">
                        
                        {{-- Thumbnail: Dark Folder Showcase Card --}}
                        <div class="{{ $index % 2 !== 0 ? 'lg:order-2' : '' }}">
                            <div class="relative rounded-[18px] overflow-hidden reveal cursor-pointer group/proj"
                                 :class="shown && 'active'"
                                 style="background: #09090b; border: 1px solid rgba(255,255,255,0.07); box-shadow: 0 30px 80px -15px rgba(0,0,0,0.25), 0 0 40px rgba(37,99,235,0.08);">

                                <div class="absolute top-3 left-3 w-4 h-4 z-10 pointer-events-none" style="border-top: 1.5px solid rgba(37,99,235,0.6); border-left: 1.5px solid rgba(37,99,235,0.6); border-radius: 2px 0 0 0;"></div>
                                <div class="absolute top-3 right-3 w-4 h-4 z-10 pointer-events-none" style="border-top: 1.5px solid rgba(37,99,235,0.6); border-right: 1.5px solid rgba(37,99,235,0.6); border-radius: 0 2px 0 0;"></div>
                                <div class="absolute bottom-3 left-3 w-4 h-4 z-10 pointer-events-none" style="border-bottom: 1.5px solid rgba(37,99,235,0.6); border-left: 1.5px solid rgba(37,99,235,0.6); border-radius: 0 0 0 2px;"></div>
                                <div class="absolute bottom-3 right-3 w-4 h-4 z-10 pointer-events-none" style="border-bottom: 1.5px solid rgba(37,99,235,0.6); border-right: 1.5px solid rgba(37,99,235,0.6); border-radius: 0 0 2px 0;"></div>
                                <div class="scan-line opacity-0 group-hover/proj:opacity-100 transition-opacity duration-500"></div>

                                <div class="relative aspect-video">
                                    @if(isset($project->thumbnail) && $project->thumbnail)
                                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}"
                                             class="w-full h-full object-cover transition-transform duration-700 group-hover/proj:scale-105">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#0f172a] to-[#1e293b]">
                                            <span class="font-heading font-black text-[#1e3a8a]/60 text-[6rem] leading-none">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(9,9,11,0.7) 0%, transparent 60%);"></div>
                                    <div class="absolute top-4 left-4 flex items-center gap-1.5 z-10">
                                        <div class="w-1.5 h-1.5 rounded-full bg-royal animate-pulse" style="box-shadow: 0 0 6px rgba(37,99,235,0.9);"></div>
                                        <span class="text-[9px] font-bold tracking-[0.25em] text-white/50 uppercase">Project {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>

                                <div class="px-5 py-3 flex items-center justify-between">
                                    <span class="text-white/30 font-mono text-[10px] tracking-widest uppercase">{{ $project->title }}</span>
                                    <div class="flex gap-1.5">
                                        <div class="w-1.5 h-1.5 rounded-full" style="background: #FF5F57;"></div>
                                        <div class="w-1.5 h-1.5 rounded-full" style="background: #FFBD2E;"></div>
                                        <div class="w-1.5 h-1.5 rounded-full" style="background: #28C840;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="{{ $index % 2 !== 0 ? 'lg:order-1' : '' }}">
                            <div class="reveal" :class="shown && 'active'" style="transition-delay: 150ms;">
                                <span class="text-royal font-bold text-xs tracking-widest uppercase block mb-3">Project {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <h3 class="font-heading font-extrabold text-3xl md:text-4xl text-navy uppercase tracking-tight mb-4 group-hover:text-royal transition duration-300">
                                    {{ $project->title }}
                                </h3>

                                @if(isset($project->description) && $project->description)
                                    <div class="text-slate-500 leading-relaxed mb-6 line-clamp-3">
                                        {!! strip_tags($project->description) !!}
                                    </div>
                                @endif

                                @if(isset($project->tech_stack) && $project->tech_stack)
                                <div class="flex flex-wrap gap-2 mb-8">
                                    @foreach(explode(',', $project->tech_stack) as $tech)
                                        <span class="bg-slate-100 text-navy font-bold text-[11px] tracking-widest uppercase px-4 py-1.5 rounded-full border border-slate-200">{{ trim($tech) }}</span>
                                    @endforeach
                                </div>
                                @endif

                                <div class="flex flex-wrap gap-3">
                                    @if(isset($project->github_link) && $project->github_link)
                                    <a href="{{ $project->github_link }}" target="_blank" class="inline-flex items-center gap-2 border-2 border-slate-200 text-navy px-5 py-2.5 rounded-full font-bold text-xs tracking-wider uppercase hover:border-navy hover:bg-navy hover:text-white transition duration-300">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                                        Source Code
                                    </a>
                                    @endif
                                    @if(isset($project->demo_link) && $project->demo_link)
                                    <a href="{{ $project->demo_link }}" target="_blank" class="inline-flex items-center gap-2 bg-royal text-white px-5 py-2.5 rounded-full font-bold text-xs tracking-wider uppercase hover:bg-navy transition duration-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        Live Demo
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                @empty
                <div class="py-24 flex flex-col items-center justify-center text-center">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <p class="font-heading font-extrabold text-2xl text-slate-300 uppercase tracking-widest">No Projects Yet</p>
                    <p class="text-slate-400 mt-2">Projects will appear here once added via the admin panel.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════ --}}
    {{-- CERTIFICATIONS VAULT --}}
    {{-- ═══════════════════════════════════════════ --}}
    <section class="py-28 md:py-40 bg-navy relative overflow-hidden" id="certifications">
        {{-- Decorative BG --}}
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.03]">
            <span class="font-heading font-extrabold text-white text-[25vw] whitespace-nowrap leading-none tracking-tighter">CERTIFIED</span>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16" x-data="{ shown: false }" x-intersect="shown = true">
                <span class="text-royal font-bold text-sm tracking-widest uppercase reveal" :class="shown && 'active'">Verified Credentials</span>
                <h2 class="font-heading font-extrabold text-4xl md:text-6xl text-white uppercase tracking-tighter mt-4 reveal" :class="shown && 'active'" style="transition-delay: 100ms;">
                    Certification Vault
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" x-data="{ shown: false }" x-intersect.margin.-50px="shown = true">
                @forelse($certifications ?? [] as $index => $cert)
                <div class="reveal" :class="shown && 'active'" style="transition-delay: {{ $index * 120 }}ms;"
                     x-data="{
                        mx: 0, my: 0,
                        tilt(e) {
                            if(window.innerWidth < 768) return;
                            const r = $el.getBoundingClientRect();
                            const x = e.clientX - r.left;
                            const y = e.clientY - r.top;
                            this.mx = x; this.my = y;
                            const cx = r.width / 2, cy = r.height / 2;
                            const rx = (y - cy) / cy * -10;
                            const ry = (x - cx) / cx * 10;
                            $refs.card.style.transform = `rotateX(${rx}deg) rotateY(${ry}deg) scale(1.03)`;
                        },
                        reset() {
                            $refs.card.style.transform = 'rotateX(0) rotateY(0) scale(1)';
                        }
                     }"
                     @mousemove="tilt" @mouseleave="reset">
                    
                    {{-- Dark Folder Certification Card --}}
                    <div x-ref="card" class="tilt-card h-full relative overflow-hidden group cursor-pointer flex flex-col rounded-[16px]"
                         style="background: #09090b; border: 1px solid rgba(255,255,255,0.07); box-shadow: 0 20px 60px -15px rgba(0,0,0,0.7), 0 0 30px rgba(37,99,235,0.07);">

                        {{-- Corner accents --}}
                        <div class="absolute top-3 left-3 w-4 h-4 z-10 pointer-events-none" style="border-top: 1.5px solid rgba(37,99,235,0.5); border-left: 1.5px solid rgba(37,99,235,0.5); border-radius: 2px 0 0 0;"></div>
                        <div class="absolute top-3 right-3 w-4 h-4 z-10 pointer-events-none" style="border-top: 1.5px solid rgba(37,99,235,0.5); border-right: 1.5px solid rgba(37,99,235,0.5); border-radius: 0 2px 0 0;"></div>
                        <div class="absolute bottom-3 left-3 w-4 h-4 z-10 pointer-events-none" style="border-bottom: 1.5px solid rgba(37,99,235,0.5); border-left: 1.5px solid rgba(37,99,235,0.5); border-radius: 0 0 0 2px;"></div>
                        <div class="absolute bottom-3 right-3 w-4 h-4 z-10 pointer-events-none" style="border-bottom: 1.5px solid rgba(37,99,235,0.5); border-right: 1.5px solid rgba(37,99,235,0.5); border-radius: 0 0 2px 0;"></div>

                        {{-- Holographic hover glow --}}
                        <div class="absolute inset-0 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-400"
                             :style="`background: radial-gradient(circle 200px at ${mx}px ${my}px, rgba(37,99,235,0.1), transparent 70%);`"></div>

                        {{-- Scan line on hover --}}
                        <div class="scan-line opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="animation-duration: 3s;"></div>

                        <div class="p-7 flex flex-col h-full">
                            {{-- Badge Icon --}}
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5" style="background: rgba(37,99,235,0.15); border: 1px solid rgba(37,99,235,0.25);">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="rgba(96,165,250,1)">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>

                            <p class="font-bold text-[10px] tracking-[0.3em] uppercase mb-2" style="color: rgba(96,165,250,0.9);">
                                {{ $cert->issued_at ? $cert->issued_at->format('M Y') : ($cert->issue_date ? \Carbon\Carbon::parse($cert->issue_date)->format('M Y') : date('Y')) }}
                            </p>

                            <h3 class="font-heading font-extrabold text-lg text-white uppercase tracking-tight leading-tight mb-2 flex-grow">
                                {{ $cert->name }}
                            </h3>

                            <div class="h-[1px] my-3 w-full" style="background: linear-gradient(90deg, rgba(37,99,235,0.4), transparent);"></div>

                            <p class="text-white/30 font-bold text-[11px] tracking-[0.2em] uppercase mb-5">{{ $cert->issuer }}</p>

                            @if(isset($cert->credential_url) && $cert->credential_url)
                            <a href="{{ $cert->credential_url }}" target="_blank"
                               class="inline-flex items-center gap-2 font-bold text-[10px] tracking-[0.25em] uppercase transition-colors group/link mt-auto"
                               style="color: rgba(96,165,250,0.7);">
                                <span class="group-hover/link:text-white transition-colors">Verify Credential</span>
                                <svg class="w-3.5 h-3.5 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 flex flex-col items-center justify-center bg-white/[0.04] border border-white/10 rounded-2xl">
                    <svg class="w-16 h-16 text-slate-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <p class="font-heading font-extrabold text-2xl text-slate-400 uppercase tracking-widest">Vault Empty</p>
                    <p class="text-slate-500 mt-2 text-sm">Add certifications via the admin panel.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>



    {{-- ═══════════════════════════════════════════ --}}
    {{-- FOOTER --}}
    {{-- ═══════════════════════════════════════════ --}}
    <footer style="background: linear-gradient(180deg, #020617 0%, #0a0f1e 100%);">

        {{-- CONTACT FORM SECTION --}}
        <div id="contact" class="relative overflow-hidden border-b border-white/5 py-24 px-6" style="scroll-margin-top: 80px;">
            {{-- Glow orb --}}
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[400px] rounded-full pointer-events-none"
                 style="background: radial-gradient(ellipse, rgba(37,99,235,0.12) 0%, transparent 70%);"></div>

            <div class="relative z-10 max-w-4xl mx-auto">
                {{-- Header --}}
                <div class="text-center mb-14">
                    <p class="text-[11px] font-bold tracking-[0.4em] text-royal uppercase mb-5">— Available for Collaboration —</p>
                    <h2 class="font-heading font-extrabold text-5xl md:text-7xl text-white uppercase tracking-tighter leading-none mb-6">
                        Let's Build<br>
                        <span style="background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 50%, #93c5fd 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Something.</span>
                    </h2>
                    <p class="text-white/30 font-medium text-lg max-w-md mx-auto leading-relaxed">
                        Kirim pesan langsung — akan saya baca dan balas secepatnya.
                    </p>
                </div>

                {{-- Success Flash --}}
                @if(session('contact_success'))
                <div class="mb-8 flex items-center gap-4 px-6 py-4 rounded-2xl border border-green-500/30 bg-green-500/10">
                    <svg class="w-6 h-6 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-green-300 font-medium">{{ session('contact_success') }}</p>
                </div>
                @endif

                {{-- Contact Form --}}
                <form action="{{ route('contact.store') }}" method="POST"
                      class="rounded-3xl border border-white/[0.07] p-8 md:p-12"
                      style="background: rgba(255,255,255,0.03); backdrop-filter: blur(20px);">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-[11px] font-bold tracking-[0.25em] text-white/30 uppercase mb-2">Nama *</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama kamu..."
                                   class="w-full px-5 py-3.5 rounded-xl text-white placeholder-white/20 text-sm font-medium outline-none transition-all duration-300"
                                   style="background: rgba(255,255,255,0.05); border: 1px solid {{ $errors->has('name') ? 'rgba(239,68,68,0.5)' : 'rgba(255,255,255,0.1)' }};"
                                   onfocus="this.style.borderColor='rgba(37,99,235,0.6)'; this.style.boxShadow='0 0 20px rgba(37,99,235,0.15)';"
                                   onblur="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.boxShadow='none';">
                            @error('name')<p class="mt-1.5 text-red-400 text-xs">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold tracking-[0.25em] text-white/30 uppercase mb-2">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                                   class="w-full px-5 py-3.5 rounded-xl text-white placeholder-white/20 text-sm font-medium outline-none transition-all duration-300"
                                   style="background: rgba(255,255,255,0.05); border: 1px solid {{ $errors->has('email') ? 'rgba(239,68,68,0.5)' : 'rgba(255,255,255,0.1)' }};"
                                   onfocus="this.style.borderColor='rgba(37,99,235,0.6)'; this.style.boxShadow='0 0 20px rgba(37,99,235,0.15)';"
                                   onblur="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.boxShadow='none';">
                            @error('email')<p class="mt-1.5 text-red-400 text-xs">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-[11px] font-bold tracking-[0.25em] text-white/30 uppercase mb-2">Subjek</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Diskusi project, kolaborasi, dll..."
                               class="w-full px-5 py-3.5 rounded-xl text-white placeholder-white/20 text-sm font-medium outline-none transition-all duration-300"
                               style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);"
                               onfocus="this.style.borderColor='rgba(37,99,235,0.6)'; this.style.boxShadow='0 0 20px rgba(37,99,235,0.15)';"
                               onblur="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.boxShadow='none';">
                    </div>

                    <div class="mb-8">
                        <label class="block text-[11px] font-bold tracking-[0.25em] text-white/30 uppercase mb-2">Pesan *</label>
                        <textarea name="message" rows="5" placeholder="Ceritakan project atau ide yang ingin kamu diskusikan..."
                                  class="w-full px-5 py-3.5 rounded-xl text-white placeholder-white/20 text-sm font-medium outline-none transition-all duration-300 resize-none"
                                  style="background: rgba(255,255,255,0.05); border: 1px solid {{ $errors->has('message') ? 'rgba(239,68,68,0.5)' : 'rgba(255,255,255,0.1)' }};"
                                  onfocus="this.style.borderColor='rgba(37,99,235,0.6)'; this.style.boxShadow='0 0 20px rgba(37,99,235,0.15)';"
                                  onblur="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.boxShadow='none';">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1.5 text-red-400 text-xs">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="text-white/20 text-xs tracking-widest">* Wajib diisi</p>
                        <button type="submit"
                                class="inline-flex items-center gap-3 bg-royal text-white px-8 py-4 rounded-full font-heading font-bold text-sm tracking-wider uppercase hover:bg-blue-500 transition-all duration-300 shadow-[0_0_30px_rgba(37,99,235,0.4)] hover:shadow-[0_0_50px_rgba(37,99,235,0.6)] hover:scale-105 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MAIN FOOTER CONTENT --}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">

                {{-- Brand --}}
                <div>
                    <a href="#" class="font-heading font-extrabold text-4xl text-white tracking-tighter uppercase block mb-4">
                        {{ mb_substr($identity->name ?? 'M', 0, 1) }}<span class="text-royal">.</span>
                    </a>
                    <p class="text-white/30 text-sm leading-relaxed max-w-xs">
                        {{ $identity->title ?? 'Backend Engineer' }} crafting clean, scalable systems with Laravel & PHP.
                    </p>
                    <div class="flex items-center gap-2 mt-5">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-400"></span>
                        </span>
                        <span class="text-green-400/70 text-[11px] font-bold tracking-widest uppercase">Open to Work</span>
                    </div>
                </div>

                {{-- Quick Nav --}}
                <div>
                    <p class="text-[10px] font-bold tracking-[0.3em] text-white/20 uppercase mb-5">Navigate</p>
                    <nav class="space-y-3">
                        @foreach(['About' => '#about', 'Work' => '#work', 'Certifications' => '#certifications', 'Contact' => '#contact'] as $label => $href)
                        <a href="{{ $href }}" class="flex items-center gap-2 text-white/40 hover:text-white text-sm font-medium tracking-wide transition-colors duration-200 group/nav">
                            <span class="w-4 h-[1px] bg-white/20 group-hover/nav:bg-royal group-hover/nav:w-6 transition-all duration-300"></span>
                            {{ $label }}
                        </a>
                        @endforeach
                    </nav>
                </div>

                {{-- Social + Contact --}}
                <div>
                    <p class="text-[10px] font-bold tracking-[0.3em] text-white/20 uppercase mb-5">Connect</p>
                    <div class="space-y-3">
                        @if(isset($identity->github_link) && $identity->github_link)
                        <a href="{{ $identity->github_link }}" target="_blank" class="flex items-center gap-3 text-white/40 hover:text-white text-sm font-medium tracking-wide transition-colors duration-200 group/soc">
                            <span class="w-8 h-8 rounded-lg border border-white/10 flex items-center justify-center group-hover/soc:border-royal group-hover/soc:bg-royal/10 transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                            </span>
                            GitHub
                        </a>
                        @endif
                        @if(isset($identity->linkedin_link) && $identity->linkedin_link)
                        <a href="{{ $identity->linkedin_link }}" target="_blank" class="flex items-center gap-3 text-white/40 hover:text-white text-sm font-medium tracking-wide transition-colors duration-200 group/soc">
                            <span class="w-8 h-8 rounded-lg border border-white/10 flex items-center justify-center group-hover/soc:border-royal group-hover/soc:bg-royal/10 transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </span>
                            LinkedIn
                        </a>
                        @endif
                        @if(isset($identity->email) && $identity->email)
                        <a href="mailto:{{ $identity->email }}" class="flex items-center gap-3 text-white/40 hover:text-white text-sm font-medium tracking-wide transition-colors duration-200 group/soc">
                            <span class="w-8 h-8 rounded-lg border border-white/10 flex items-center justify-center group-hover/soc:border-royal group-hover/soc:bg-royal/10 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            {{ $identity->email }}
                        </a>
                        @endif
                    </div>
                </div>

            </div>

            {{-- BOTTOM BAR --}}
            <div class="border-t border-white/[0.06] pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-white/20 text-xs font-medium tracking-widest">
                    &copy; {{ date('Y') }} <span class="text-white/40">{{ $identity->name ?? 'Portfolio' }}</span>. Built with Laravel &amp; ❤️
                </p>
                <p class="text-white/10 text-xs font-mono tracking-widest italic hidden md:block">"Clean code always looks like it was written by someone who cares."</p>
                <button onclick="window.scrollTo({top:0,behavior:'smooth'})"
                        class="group flex items-center gap-2 text-white/20 hover:text-white text-xs font-bold tracking-widest uppercase transition-colors">
                    <svg class="w-4 h-4 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                    Back to top
                </button>
            </div>
        </div>

    </footer>


    {{-- ═══════════════════════════════════════════ --}}
    {{-- CUSTOM CURSOR --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="cursor-dot" data-cursor-dot></div>
    <div class="cursor-outline" data-cursor-outline></div>

    <script>
        const cursorDot = document.querySelector("[data-cursor-dot]");
        const cursorOutline = document.querySelector("[data-cursor-outline]");
        
        let cursorX = 0, cursorY = 0;
        let outlineX = 0, outlineY = 0;

        window.addEventListener("mousemove", (e) => {
            cursorX = e.clientX;
            cursorY = e.clientY;
            
            cursorDot.style.transform = `translate(calc(-50% + ${cursorX}px), calc(-50% + ${cursorY}px))`;
        });

        // Smooth follow for the outline using requestAnimationFrame
        function animateCursor() {
            // Easing factor (0 to 1) - lower is smoother, 1 is instantaneous
            const easing = 0.15; 
            outlineX += (cursorX - outlineX) * easing;
            outlineY += (cursorY - outlineY) * easing;
            
            cursorOutline.style.transform = `translate(calc(-50% + ${outlineX}px), calc(-50% + ${outlineY}px))`;
            requestAnimationFrame(animateCursor);
        }
        animateCursor();

        // Hover scale effect
        document.querySelectorAll('a, button, .tech-card, .tilt-card').forEach(el => {
            el.addEventListener('mouseenter', () => cursorOutline.classList.add('cursor-hover'));
            el.addEventListener('mouseleave', () => cursorOutline.classList.remove('cursor-hover'));
        });

        // Magnetic Button Effect
        const magneticBtns = document.querySelectorAll('a.inline-flex.rounded-full');
        magneticBtns.forEach((btn) => {
            // Apply base transition to button for smooth reset
            btn.style.transition = 'transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), background-color 0.3s, color 0.3s';
            
            btn.addEventListener('mousemove', (e) => {
                const position = btn.getBoundingClientRect();
                const x = e.clientX - position.left - position.width / 2;
                const y = e.clientY - position.top - position.height / 2;
                
                // Cancel transition during movement for immediate tracking
                btn.style.transition = 'none';
                btn.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px)`;
            });

            btn.addEventListener('mouseleave', () => {
                btn.style.transition = 'transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275), background-color 0.3s, color 0.3s';
                btn.style.transform = 'translate(0px, 0px)';
            });
        });
    </script>
    
    <!-- Vanilla Tilt for 3D Epic Cards -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>

    {{-- Epic Loading Screen Script --}}
    <script>
        document.body.style.overflow = 'hidden'; // Lock scroll during loading
        let currentPerc = 0;
        const loader = document.getElementById('epic-loader');
        const percentageText = document.getElementById('loader-percentage');
        const progressBar = document.getElementById('loader-progress');
        
        const loaderInterval = setInterval(() => {
            currentPerc += Math.floor(Math.random() * 12) + 4;
            if (currentPerc > 100) currentPerc = 100;
            
            percentageText.innerText = currentPerc;
            progressBar.style.width = currentPerc + '%';
            
            if (currentPerc === 100) {
                clearInterval(loaderInterval);
                setTimeout(() => {
                    loader.style.transform = 'translateY(-100vh)';
                    document.body.style.overflow = ''; // Unlock scroll
                    setTimeout(() => loader.remove(), 1000); // Cleanup DOM
                }, 500); // Small pause at 100%
            }
        }, 60);

        // Typewriter Cycling Effect
        const typewriterEl = document.getElementById('typewriter-text');
        if (typewriterEl) {
            const phrases = [
                'Backend Engineer.',
                'Laravel Developer.',
                'PHP Enthusiast.',
                'API Architect.',
                'Clean Code Advocate.',
                'BINUS Student 2028.',
            ];
            let phraseIdx = 0, charIdx = 0, deleting = false;

            function typeLoop() {
                const current = phrases[phraseIdx];
                if (!deleting) {
                    typewriterEl.textContent = current.substring(0, charIdx + 1);
                    charIdx++;
                    if (charIdx === current.length) {
                        deleting = true;
                        setTimeout(typeLoop, 1800); // Pause before deleting
                        return;
                    }
                } else {
                    typewriterEl.textContent = current.substring(0, charIdx - 1);
                    charIdx--;
                    if (charIdx === 0) {
                        deleting = false;
                        phraseIdx = (phraseIdx + 1) % phrases.length;
                    }
                }
                setTimeout(typeLoop, deleting ? 50 : 90);
            }
            setTimeout(typeLoop, 1200); // Start after page reveal
        }

        // Lanyard Badge Toss on click
        const lanyardBadge = document.getElementById('lanyard-badge');
        if (lanyardBadge) {
            lanyardBadge.addEventListener('click', (e) => {
                if (e.target.closest('a')) return;
                if (lanyardBadge.classList.contains('badge-tossing')) return;
                lanyardBadge.classList.add('badge-tossing');
                setTimeout(() => lanyardBadge.classList.remove('badge-tossing'), 1000);
            });
        }
    </script>
</body>
</html>