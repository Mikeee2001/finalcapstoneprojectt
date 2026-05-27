<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Animal Clinic System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700"
        rel="stylesheet" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
        }

        .fade-up {
            opacity: 0;
            transform: translateY(60px);
            transition: all 1s ease;
        }

        .fade-up.show {
            opacity: 1;
            transform: translateY(0);
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
        }

        .hero-bg {
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.25), transparent 35%),
                radial-gradient(circle at bottom right, rgba(168, 85, 247, 0.25), transparent 35%);
        }
    </style>
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full z-50 glass border-b border-gray-200">

        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <div>
                <a href="{{ route('welcome') }}" class="flex items-center gap-2">
                    <h1 class="text-2xl font-bold text-blue-700">
                    VetCare System
                </h1>
                </a>
            </div>

            <div class="hidden md:flex items-center gap-8 text-sm font-medium">

                <a href="#features" class="hover:text-blue-600 transition">
                    Features
                </a>

                <a href="#workflow" class="hover:text-blue-600 transition">
                    Workflow
                </a>

                <a href="#gallery" class="hover:text-blue-600 transition">
                    Gallery
                </a>

                <a href="#about" class="hover:text-blue-600 transition">
                    About
                </a>

                <a href="{{ route('login') }}"
                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg transition">
                    Login
                </a>

            </div>

        </div>

    </nav>


    <!-- Hero Section -->
    <section class="hero-bg min-h-screen flex items-center relative overflow-hidden">

        <div class="absolute inset-0 bg-black/10"></div>

        <div class="absolute w-[500px] h-[500px] bg-blue-300 rounded-full blur-3xl opacity-20 -top-32 -left-32"></div>

        <div class="absolute w-[400px] h-[400px] bg-purple-300 rounded-full blur-3xl opacity-20 bottom-0 right-0"></div>

        <div class="max-w-7xl mx-auto px-6 py-24 relative z-10">

            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <!-- Left -->
                <div class="fade-up">

                    <span class="inline-block px-5 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold mb-6">
                        Veterinary Clinic Management System
                    </span>

                    <h1 class="text-5xl lg:text-7xl font-bold leading-tight mb-6">
                        Smart Animal Clinic Management
                    </h1>

                    <p class="text-lg text-gray-600 leading-relaxed mb-8 max-w-xl">
                        Streamline appointments, consultations, prescriptions,
                        inventory, billing, vaccinations, and laboratory tests
                        in one modern veterinary platform.
                    </p>

                    <div class="flex flex-wrap gap-4">

                        <a href="{{ route('login') }}"
                            class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl shadow-xl transition duration-300 hover:scale-105">
                            Get Started
                        </a>

                        <a href="#features"
                            class="px-8 py-4 border border-gray-300 hover:border-blue-500 rounded-2xl transition duration-300 hover:scale-105">
                            Explore Features
                        </a>

                    </div>

                </div>

                <!-- Right -->
                <div class="fade-up">

                    <div class="relative">

                        <img
                            src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?q=80&w=1200&auto=format&fit=crop"
                            alt="Veterinary Clinic"
                            class="rounded-[32px] shadow-2xl w-full h-[550px] object-cover">

                        <div class="absolute bottom-6 left-6 right-6 glass rounded-3xl p-6 shadow-xl">

                            <div class="grid grid-cols-2 gap-5">

                                <div class="bg-blue-50 rounded-3xl p-5">
                                    <h3 class="font-bold text-blue-700 text-lg mb-2">
                                        Appointments
                                    </h3>

                                    <p class="text-sm text-gray-600">
                                        Easy booking and scheduling.
                                    </p>
                                </div>

                                <div class="bg-green-50 rounded-3xl p-5">
                                    <h3 class="font-bold text-green-700 text-lg mb-2">
                                        Consultations
                                    </h3>

                                    <p class="text-sm text-gray-600">
                                        Diagnose and treat pets efficiently.
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- Features -->
    <section id="features" class="py-28">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-16 fade-up">

                <h2 class="text-5xl font-bold mb-5">
                    Powerful Features
                </h2>

                <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                    Everything you need to manage your veterinary clinic efficiently.
                </p>

            </div>

            @php
                $features = [
                    [
                        'Pet & Owner Management',
                        'Manage pets, breeds, species, and owner information securely.',
                        'https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=1200&auto=format&fit=crop'
                    ],
                    [
                        'Appointment Scheduling',
                        'Track appointments and veterinarian availability.',
                        'https://images.unsplash.com/photo-1583512603805-3cc6b41f3edb?q=80&w=1200&auto=format&fit=crop'
                    ],
                    [
                        'Medical Consultation',
                        'Store diagnosis, findings, symptoms, and treatments.',
                        'https://images.unsplash.com/photo-1548199973-03cce0bbc87b?q=80&w=1200&auto=format&fit=crop'
                    ]
                ];
            @endphp

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                @foreach($features as $feature)

                    <div class="fade-up bg-white border border-gray-100 rounded-[30px] overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 hover:-translate-y-2">

                        <img
                            src="{{ $feature[2] }}"
                            class="w-full h-56 object-cover"
                            alt="Feature Image">

                        <div class="p-8">

                            <h3 class="text-2xl font-bold mb-4">
                                {{ $feature[0] }}
                            </h3>

                            <p class="text-gray-600 leading-relaxed">
                                {{ $feature[1] }}
                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </section>


    <!-- Workflow -->
    <section id="workflow" class="bg-gray-950 text-white py-28 relative overflow-hidden">

        <div class="absolute w-[400px] h-[400px] bg-blue-500 opacity-20 blur-3xl rounded-full top-0 left-0"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">

            <div class="text-center mb-20 fade-up">

                <h2 class="text-5xl font-bold mb-5">
                    Clinic Workflow
                </h2>

                <p class="text-gray-300 text-lg">
                    Complete veterinary process from appointment to payment.
                </p>

            </div>

            @php
                $steps = [
                    'Book Appointment',
                    'Vet Consultation',
                    'Prescription & Lab Tests',
                    'Invoice Generation',
                    'Payment Processing'
                ];
            @endphp

            <div class="grid md:grid-cols-5 gap-6">

                @foreach($steps as $index => $step)

                    <div class="fade-up bg-white/10 border border-white/10 backdrop-blur-xl rounded-3xl p-8 text-center hover:bg-white/20 transition">

                        <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-blue-600 flex items-center justify-center text-2xl font-bold shadow-lg">
                            {{ $index + 1 }}
                        </div>

                        <h3 class="font-semibold text-lg">
                            {{ $step }}
                        </h3>

                    </div>

                @endforeach

            </div>

        </div>

    </section>


    <!-- Gallery -->
    <section id="gallery" class="py-28 bg-gray-100">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-16 fade-up">

                <h2 class="text-5xl font-bold mb-5">
                    Our Clinic Gallery
                </h2>

                <p class="text-gray-600 text-lg">
                    Caring for pets with compassion and technology.
                </p>

            </div>

            <div class="grid md:grid-cols-3 gap-8">

                <img
                    src="https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=1200&auto=format&fit=crop"
                    class="rounded-[30px] shadow-xl h-80 w-full object-cover hover:scale-105 transition duration-500">

                <img
                    src="https://images.unsplash.com/photo-1583512603805-3cc6b41f3edb?q=80&w=1200&auto=format&fit=crop"
                    class="rounded-[30px] shadow-xl h-80 w-full object-cover hover:scale-105 transition duration-500">

                <img
                    src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?q=80&w=1200&auto=format&fit=crop"
                    class="rounded-[30px] shadow-xl h-80 w-full object-cover hover:scale-105 transition duration-500">

            </div>

        </div>

    </section>


    <!-- About -->
    <section id="about" class="py-28">

        <div class="max-w-6xl mx-auto px-6">

            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <div class="fade-up">

                    <h2 class="text-5xl font-bold mb-6">
                        Modern Veterinary Management
                    </h2>

                    <p class="text-lg text-gray-600 leading-relaxed mb-6">
                        Built to simplify veterinary clinic operations using a centralized management system.
                    </p>

                    <p class="text-lg text-gray-600 leading-relaxed">
                        Track consultations, prescriptions, inventory, invoices, and payments while improving patient care.
                    </p>

                </div>

                <div class="fade-up">

                    <img
                        src="https://images.unsplash.com/photo-1628009368231-7bb7cfcb0def?q=80&w=1200&auto=format&fit=crop"
                        class="rounded-[40px] shadow-2xl w-full h-[500px] object-cover">

                </div>

            </div>

        </div>

    </section>


    <!-- Footer -->
    <footer class="bg-black text-gray-400 py-12">

        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">

            <div>
                <h3 class="text-2xl font-bold text-white">
                    VetCare System
                </h3>

                <p class="mt-2 text-sm">
                    Veterinary Clinic Management Platform
                </p>
            </div>

            <div class="flex gap-8 text-sm">

                <a href="#features" class="hover:text-white transition">
                    Features
                </a>

                <a href="#workflow" class="hover:text-white transition">
                    Workflow
                </a>

                <a href="#gallery" class="hover:text-white transition">
                    Gallery
                </a>

            </div>

        </div>

    </footer>


    <!-- Scroll Animation -->
    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.fade-up').forEach((el) => {
            observer.observe(el);
        });
    </script>

</body>

</html>
