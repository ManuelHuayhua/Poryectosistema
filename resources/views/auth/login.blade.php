<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financiera Pro - Sistema de Préstamos</title>
    <link rel="icon" href="https://static.vecteezy.com/system/resources/previews/006/695/460/non_2x/money-dollar-bill-cartoon-illustration-free-vector.jpg" type="image/png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --light: #f8fafc;
            --white: #ffffff;
            --glass: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Fondo animado optimizado */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
            animation: backgroundShift 15s ease-in-out infinite;
            pointer-events: none;
            z-index: 1;
        }
        
        @keyframes backgroundShift {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        .container-fluid {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            transform: translateY(0);
            opacity: 1;
            animation: slideIn 0.6s ease-out;
        }
        
     /*   @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateY(20px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }*/
        
        .left-section {
            padding: 3rem 2.5rem;
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.9) 100%);
            position: relative;
        }
        
        .left-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
        }
        
        .right-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .right-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Logo mejorado */
        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo-circle {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: var(--shadow);
            position: relative;
            transition: transform 0.3s ease;
        }
        
        .logo-circle:hover {
            transform: scale(1.05);
        }
        
        .logo-circle::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            background: linear-gradient(135deg, var(--warning), var(--success));
            border-radius: 50%;
            z-index: -1;
            opacity: 0.7;
        }
        
        .logo-icon {
            font-size: 2.5rem;
            color: white;
        }
        
        .brand-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }
        
        .brand-subtitle {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .welcome-text {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .welcome-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .welcome-desc {
            color: #64748b;
            font-size: 1rem;
        }
        
        /* Formulario mejorado */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .input-container {
            position: relative;
        }
        
        .form-control {
            background: rgba(248, 250, 252, 0.8);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .form-control:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1.1rem;
            z-index: 5;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            width: 100%;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }
        
        .btn-primary-custom:hover::before {
            left: 100%;
        }
        
        .btn-outline-custom {
            background: transparent;
            border: 2px solid var(--primary);
            border-radius: 12px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            color: var(--primary);
            width: 100%;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-outline-custom:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            text-decoration: none;
        }
        
        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .forgot-link:hover {
            color: var(--primary-dark);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }
        
        .divider-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
        }
        
        .divider-text {
            padding: 0 1rem;
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        /* Panel derecho mejorado */
        .right-content {
            position: relative;
            z-index: 10;
            padding: 3rem 2.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .right-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .right-description {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .feature-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }
        
        .feature-icon {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.3rem;
        }
        
        .feature-text h5 {
            margin-bottom: 0.25rem;
            font-weight: 600;
        }
        
        .feature-text p {
            margin: 0;
            opacity: 0.8;
            font-size: 0.9rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .stat-card {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }
        
        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: 0.8rem;
            opacity: 0.8;
        }
        
        /* Responsive optimizado */
        @media (max-width: 991px) {
            .right-section {
                display: none;
            }
            
            .left-section {
                padding: 2rem 1.5rem;
            }
            
            .welcome-title {
                font-size: 1.8rem;
            }
        }
        
        @media (max-width: 576px) {
            .container-fluid {
                padding: 0.5rem;
            }
            
            .left-section {
                padding: 1.5rem 1rem;
            }
            
            .welcome-title {
                font-size: 1.6rem;
            }
            
            .logo-circle {
                width: 80px;
                height: 80px;
            }
            
            .logo-icon {
                font-size: 2rem;
            }
        }
        
        /* Efectos adicionales */
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(99, 102, 241, 0); }
            100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0); }
        }
        
        .glow {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="login-card">
            <div class="row g-0">
                <!-- Sección Izquierda - Formulario -->
                <div class="col-lg-6">
                    <div class="left-section">
                        <!-- Logo -->
                        <div class="logo-section">
                            <div class="logo-circle pulse">
                                <i class="fas fa-coins logo-icon"></i>
                            </div>
                            <h1 class="brand-title">Financiera Pro</h1>
                            <p class="brand-subtitle">Sistema de Préstamos</p>
                        </div>
                        
                        <!-- Bienvenida -->
                        <div class="welcome-text">
                            <h2 class="welcome-title">¡Bienvenido!</h2>
                            <p class="welcome-desc">Acceda a su cuenta para gestionar sus préstamos</p>
                        </div>
                        @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

                        <!-- Formulario -->
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            
                            <div class="form-group">
                                <label class="form-label">DNI</label>
                                <div class="input-container">
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input type="text" name="dni" class="form-control" placeholder="Ingrese su DNI" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Contraseña</label>
                                <div class="input-container">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                                </div>
                            </div>
                            
                         
                            
                            <button type="submit" class="btn-primary-custom">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Iniciar Sesión
                            </button>
                            
                           
                        </form>
                    </div>
                </div>
                
                <!-- Sección Derecha - Información -->
                <div class="col-lg-6">
                    <div class="right-section">
                        <div class="right-content">
                            <h3 class="right-title">Gestión Financiera del Futuro</h3>
                            <p class="right-description">
                                Revolucione la manera en que maneja sus préstamos con tecnología de vanguardia y seguridad de nivel empresarial.
                            </p>
                            
                            <ul class="feature-list">
                                <li class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h5>Seguridad Máxima</h5>
                                        <p>Protección multicapa y cifrado robusto para resguardar tu información</p>
                                    </div>
                                </li>
                                
                                <li class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h5>Análisis Estratégico</h5>
                                        <p>Herramientas precisas para mejorar sus decisiones financieras</p>
                                    </div>
                                </li>
                                
                                <li class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h5>Acceso Universal</h5>
                                        <p>Disponible 24/7 desde cualquier dispositivo</p>
                                    </div>
                                </li>
                            </ul>
                            
                            <div class="stats-grid">
                                <div class="stat-card">
                                    <div class="stat-number">99.9%</div>
                                    <div class="stat-label">Disponibilidad</div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-number">15K+</div>
                                    <div class="stat-label">Usuarios Activos</div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-number">24/7</div>
                                    <div class="stat-label">Soporte Premium</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Optimización de carga y efectos
        document.addEventListener('DOMContentLoaded', function() {
            // Efecto de focus mejorado
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('glow');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('glow');
                });
            });
            
            // Efecto de hover en feature items
            const featureItems = document.querySelectorAll('.feature-item');
            featureItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(10px) scale(1.02)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0) scale(1)';
                });
            });
        });
    </script>
</body>
</html>