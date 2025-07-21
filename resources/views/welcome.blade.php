<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>FinanciaPro - Tu Futuro Financiero</title>
        <link rel="icon" href="https://static.vecteezy.com/system/resources/previews/006/695/460/non_2x/money-dollar-bill-cartoon-illustration-free-vector.jpg" type="image/png">
    
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        
        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                overflow-x: hidden;
            }
            
            .hero-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
                background-size: 300% 300%;
                animation: gradientShift 12s ease infinite;
                position: relative;
            }
            
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            
            .floating-element {
                animation: float 6s ease-in-out infinite;
                opacity: 0.6;
            }
            
            .floating-element:nth-child(2) { animation-delay: -2s; }
            .floating-element:nth-child(3) { animation-delay: -4s; }
            .floating-element:nth-child(4) { animation-delay: -1s; }
            .floating-element:nth-child(5) { animation-delay: -3s; }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                33% { transform: translateY(-20px) rotate(5deg); }
                66% { transform: translateY(-10px) rotate(-5deg); }
            }
            
            .pulse-glow {
                animation: pulseGlow 3s ease-in-out infinite alternate;
            }
            
            @keyframes pulseGlow {
                from { 
                    box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
                    transform: scale(1);
                }
                to { 
                    box-shadow: 0 0 25px rgba(255, 255, 255, 0.4);
                    transform: scale(1.01);
                }
            }
            
            .btn-glow {
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
            }
            
            .btn-glow::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
                transition: left 0.5s;
            }
            
            .btn-glow:hover::before {
                left: 100%;
            }
            
            .btn-glow:hover {
                transform: translateY(-3px);
                box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            }
            
            .money-icon {
                animation: bounce 2s infinite;
            }
            
            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                40% { transform: translateY(-10px); }
                60% { transform: translateY(-5px); }
            }
            
            .text-glow {
                text-shadow: 0 0 20px rgba(255,255,255,0.5);
            }
            
            .card-hover {
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
            }
            
            .card-hover:hover {
                transform: translateY(-5px) scale(1.02);
                box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            }
            
            .particles {
                position: absolute;
                width: 100%;
                height: 100%;
                overflow: hidden;
            }
            
            .particle {
                position: absolute;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                animation: particleFloat 15s infinite linear;
            }
            
            @keyframes particleFloat {
                0% {
                    transform: translateY(100vh) rotate(0deg);
                    opacity: 0;
                }
                10% {
                    opacity: 1;
                }
                90% {
                    opacity: 1;
                }
                100% {
                    transform: translateY(-100px) rotate(360deg);
                    opacity: 0;
                }
            }
            
            .mobile-menu {
                transform: translateX(100%);
                transition: transform 0.3s ease;
            }
            
            .mobile-menu.active {
                transform: translateX(0);
            }
            
            /* Responsive adjustments */
            @media (max-width: 640px) {
                .floating-element {
                    display: none;
                }
                
                .hero-bg {
                    min-height: 100vh;
                    padding: 1rem;
                }
                
                .text-glow {
                    text-shadow: 0 0 10px rgba(255,255,255,0.3);
                }
            }
            
            @media (max-width: 768px) {
                .pulse-glow {
                    animation: none;
                    box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
                }
            }
            
            .emoji-float {
                animation: emojiFloat 3s ease-in-out infinite;
            }
            
            @keyframes emojiFloat {
                0%, 100% { transform: translateY(0px) rotate(-5deg); }
                50% { transform: translateY(-15px) rotate(5deg); }
            }
        </style>
    </head>
    <body class="antialiased">
        <!-- Particles Background -->
        <div class="particles fixed inset-0 pointer-events-none z-0">
            <div class="particle" style="left: 10%; width: 4px; height: 4px; animation-delay: 0s;"></div>
            <div class="particle" style="left: 20%; width: 6px; height: 6px; animation-delay: 2s;"></div>
            <div class="particle" style="left: 30%; width: 3px; height: 3px; animation-delay: 4s;"></div>
            <div class="particle" style="left: 40%; width: 5px; height: 5px; animation-delay: 6s;"></div>
            <div class="particle" style="left: 50%; width: 4px; height: 4px; animation-delay: 8s;"></div>
            <div class="particle" style="left: 60%; width: 6px; height: 6px; animation-delay: 10s;"></div>
            <div class="particle" style="left: 70%; width: 3px; height: 3px; animation-delay: 12s;"></div>
            <div class="particle" style="left: 80%; width: 5px; height: 5px; animation-delay: 14s;"></div>
            <div class="particle" style="left: 90%; width: 4px; height: 4px; animation-delay: 16s;"></div>
        </div>

        <!-- Floating Background Elements (Hidden on mobile) -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0 hidden sm:block">
            <div class="floating-element absolute top-20 left-10 w-16 h-16 lg:w-20 lg:h-20 bg-white bg-opacity-10 rounded-full"></div>
            <div class="floating-element absolute top-40 right-20 w-12 h-12 lg:w-16 lg:h-16 bg-white bg-opacity-10 rounded-full"></div>
            <div class="floating-element absolute bottom-32 left-1/4 w-8 h-8 lg:w-12 lg:h-12 bg-white bg-opacity-10 rounded-full"></div>
            <div class="floating-element absolute bottom-20 right-1/3 w-20 h-20 lg:w-24 lg:h-24 bg-white bg-opacity-10 rounded-full"></div>
            <div class="floating-element absolute top-1/2 left-1/2 w-6 h-6 lg:w-8 lg:h-8 bg-white bg-opacity-10 rounded-full"></div>
        </div>

        <!-- Main Hero Section -->
        <div class="hero-bg min-h-screen flex items-center justify-center relative z-10 px-4 sm:px-6 lg:px-8">
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden fixed top-4 right-4 z-50 bg-white bg-opacity-20 backdrop-blur-sm text-white p-3 rounded-full border border-white border-opacity-30 transition-all duration-300">
                <svg id="menu-icon" class="w-6 h-6 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg id="close-icon" class="w-6 h-6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="mobile-menu md:hidden fixed top-0 right-0 h-full w-80 bg-black bg-opacity-90 backdrop-blur-lg z-40 p-6">
    <div class="mt-16 space-y-6">
        @if (Route::has('login'))
            @auth
                @php
                    $redirectUrl = auth()->user()->is_admin ? url('/admin') : url('/home');
                @endphp
                <a href="{{ $redirectUrl }}" class="block w-full btn-glow bg-gradient-to-r from-green-400 to-blue-500 text-white px-6 py-4 rounded-full font-bold text-center">
                    <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Mi Cuenta
                </a>
            @else
                <a href="{{ route('register') }}" class="block w-full btn-glow bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 px-6 py-4 rounded-full font-bold text-center mb-4">
                    <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Registrarse
                </a>
                <a href="{{ route('login') }}" class="block w-full btn-glow bg-white bg-opacity-20 backdrop-blur-sm text-white px-6 py-4 rounded-full font-bold text-center border border-white border-opacity-30">
                    <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Iniciar Sesión
                </a>
            @endauth
        @endif
    </div>
</div>
            <!-- Desktop Auth Links - Top Right -->
          @if (Route::has('login'))
    <div class="hidden md:block absolute top-6 right-6 z-20">
        <div class="flex space-x-4">
            @auth
                @php
                    $redirectUrl = auth()->user()->is_admin ? url('/admin') : url('/home');
                @endphp
                <a href="{{ $redirectUrl }}" class="btn-glow bg-white bg-opacity-20 backdrop-blur-sm text-white px-4 lg:px-6 py-2 lg:py-3 rounded-full font-semibold border border-white border-opacity-30 hover:bg-opacity-30 transition-all duration-300 text-sm lg:text-base">
                    <svg class="inline-block w-4 h-4 lg:w-5 lg:h-5 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Mi Cuenta
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-glow bg-white bg-opacity-20 backdrop-blur-sm text-white px-4 lg:px-6 py-2 lg:py-3 rounded-full font-semibold border border-white border-opacity-30 hover:bg-opacity-30 transition-all duration-300 text-sm lg:text-base">
                    <svg class="inline-block w-4 h-4 lg:w-5 lg:h-5 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Iniciar Sesión
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-glow bg-white text-purple-600 px-4 lg:px-6 py-2 lg:py-3 rounded-full font-bold shadow-lg hover:shadow-xl transition-all duration-300 text-sm lg:text-base">
                        <svg class="inline-block w-4 h-4 lg:w-5 lg:h-5 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Registrarse
                    </a>
                @endif
            @endauth
        </div>
    </div>
@endif

            <!-- Main Content -->
            <div class="container mx-auto text-center max-w-6xl">
                <!-- Logo/Brand -->
                <div class="mb-6 sm:mb-8">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-black text-white text-glow mb-2 sm:mb-4 leading-tight">
                        Financia<span class="text-yellow-300">Pro</span>
                    </h1>
                    <div class="flex justify-center items-center space-x-2 sm:space-x-4 mb-4 sm:mb-6">
                        <div class="money-icon">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68-.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="h-1 w-8 sm:w-12 lg:w-16 bg-gradient-to-r from-yellow-300 to-white rounded-full"></div>
                        <div class="money-icon" style="animation-delay: -1s;">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Main Message -->
                <div class="max-w-5xl mx-auto mb-8 sm:mb-12">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 sm:mb-6 leading-tight px-2">
                        <span class="emoji-float inline-block">💰</span> 
                        <span class="text-yellow-300">Préstamos Rápidos</span> 
                        <span class="emoji-float inline-block" style="animation-delay: -1s;">💰</span>
                        <br />
                        <span class="text-xl sm:text-2xl md:text-3xl lg:text-4xl">¡Aprobación en 24 Horas!</span>
                    </h2>
                    <p class="text-lg sm:text-xl md:text-2xl text-white text-opacity-90 mb-6 sm:mb-8 font-medium px-2">
                        <span class="emoji-float inline-block">🚀</span> 
                        Desde <span class="text-yellow-300 font-bold">$1,000</span> hasta <span class="text-yellow-300 font-bold">$500,000</span> 
                        <span class="emoji-float inline-block" style="animation-delay: -0.5s;">🚀</span>
                        <br />
                        <span class="text-base sm:text-lg block mt-2">Sin papeleos complicados • Tasas desde 7.8% • 100% Digital</span>
                    </p>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4 lg:space-x-6 mb-12 sm:mb-16 px-4">
                    @if (Route::has('login'))
                        @guest
                            <a href="{{ route('register') }}" class="w-full sm:w-auto btn-glow pulse-glow bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 px-8 sm:px-10 lg:px-12 py-4 sm:py-5 lg:py-6 rounded-full text-lg sm:text-xl font-black shadow-2xl transform hover:scale-105 transition-all duration-300">
                                <svg class="inline-block w-5 h-5 lg:w-6 lg:h-6 mr-2 lg:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                ¡SOLICITAR AHORA!
                            </a>
                            <a href="{{ route('login') }}" class="w-full sm:w-auto btn-glow bg-white bg-opacity-20 backdrop-blur-sm text-white px-6 sm:px-8 lg:px-10 py-4 sm:py-5 lg:py-6 rounded-full text-base sm:text-lg font-bold border-2 border-white border-opacity-50 hover:bg-opacity-30 transition-all duration-300">
                                <svg class="inline-block w-4 h-4 lg:w-5 lg:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Ya tengo cuenta
                            </a>
                        @else
                           <a href="{{ auth()->user()->is_admin ? url('/admin') : url('/home') }}"
   class="w-full sm:w-auto btn-glow pulse-glow bg-gradient-to-r from-green-400 to-blue-500 text-white
          px-8 sm:px-10 lg:px-12 py-4 sm:py-5 lg:py-6 rounded-full text-lg sm:text-xl font-black shadow-2xl
          transform hover:scale-105 transition-all duration-300">
    <svg class="inline-block w-5 h-5 lg:w-6 lg:h-6 mr-2 lg:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
    </svg>
    IR A MI CUENTA
</a>
                        @endguest
                    @endif
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 max-w-5xl mx-auto px-4">
                    <div class="card-hover bg-gradient-to-br from-yellow-500 to-yellow-600 backdrop-blur-sm rounded-xl lg:rounded-2xl p-4 sm:p-5 lg:p-6 border border-yellow-400 border-opacity-30 shadow-lg">
                        <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-white mb-1 sm:mb-2">98%</div>
                        <div class="text-yellow-100 font-semibold text-sm sm:text-base">Aprobación</div>
                    </div>
                    <div class="card-hover bg-gradient-to-br from-green-500 to-green-600 backdrop-blur-sm rounded-xl lg:rounded-2xl p-4 sm:p-5 lg:p-6 border border-green-400 border-opacity-30 shadow-lg">
                        <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-white mb-1 sm:mb-2">24h</div>
                        <div class="text-green-100 font-semibold text-sm sm:text-base">Respuesta</div>
                    </div>
                    <div class="card-hover bg-gradient-to-br from-blue-500 to-blue-600 backdrop-blur-sm rounded-xl lg:rounded-2xl p-4 sm:p-5 lg:p-6 border border-blue-400 border-opacity-30 shadow-lg">
                        <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-white mb-1 sm:mb-2">5K+</div>
                        <div class="text-blue-100 font-semibold text-sm sm:text-base">Clientes</div>
                    </div>
                    <div class="card-hover bg-gradient-to-br from-purple-500 to-purple-600 backdrop-blur-sm rounded-xl lg:rounded-2xl p-4 sm:p-5 lg:p-6 border border-purple-400 border-opacity-30 shadow-lg">
                        <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-white mb-1 sm:mb-2">4.9★</div>
                        <div class="text-purple-100 font-semibold text-sm sm:text-base">Rating</div>
                    </div>
                </div>
            </div>

            <!-- Bottom Wave -->
            <div class="absolute bottom-0 left-0 w-full">
                <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                    <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white" fill-opacity="0.1"/>
                </svg>
            </div>
        </div>

        <!-- JavaScript for Mobile Menu and Interactions -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Mobile menu functionality
                const mobileMenuBtn = document.getElementById('mobile-menu-btn');
                const mobileMenu = document.getElementById('mobile-menu');
                const menuIcon = document.getElementById('menu-icon');
                const closeIcon = document.getElementById('close-icon');
                
                if (mobileMenuBtn && mobileMenu) {
                    mobileMenuBtn.addEventListener('click', function() {
                        if (mobileMenu.classList.contains('active')) {
                            // Cerrar menú
                            mobileMenu.classList.remove('active');
                            menuIcon.style.opacity = '1';
                            closeIcon.style.opacity = '0';
                        } else {
                            // Abrir menú
                            mobileMenu.classList.add('active');
                            menuIcon.style.opacity = '0';
                            closeIcon.style.opacity = '1';
                        }
                    });
                }
                
                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (mobileMenu && !mobileMenu.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                        mobileMenu.classList.remove('active');
                        if (menuIcon && closeIcon) {
                            menuIcon.style.opacity = '1';
                            closeIcon.style.opacity = '0';
                        }
                    }
                });
                
                // Add smooth scrolling for better UX
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });
                
                console.log('FinanciaPro loaded successfully with enhanced responsivity!');
            });
        </script>
    </body>
</html>
