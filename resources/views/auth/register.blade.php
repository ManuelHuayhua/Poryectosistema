<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financiera Pro - Crear Cuenta</title>
    
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
        
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            max-width: 1100px;
            width: 100%;
            transform: translateY(0);
            opacity: 1;
            animation: slideIn 0.6s ease-out;
        }
        
      /*  @keyframes slideIn {
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
            padding: 2.5rem 2rem;
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.9) 100%);
            position: relative;
            max-height: 100vh;
            overflow-y: auto;
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
        
        /* Logo */
        .logo-section {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .logo-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
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
            font-size: 2rem;
            color: white;
        }
        
        .brand-title {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.25rem;
        }
        
        .brand-subtitle {
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .welcome-text {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .welcome-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .welcome-desc {
            color: #64748b;
            font-size: 0.9rem;
        }
        
        /* Alertas de error */
        .alert-custom {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: var(--danger);
        }
        
        .alert-custom ul {
            margin: 0;
            padding-left: 1.2rem;
        }
        
        .alert-custom li {
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }
        
        .alert-icon {
            color: var(--danger);
            margin-right: 0.5rem;
        }
        
        /* Formulario */
        .form-group {
            margin-bottom: 1.25rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .input-container {
            position: relative;
        }
        
        .form-control {
            background: rgba(248, 250, 252, 0.8);
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.8rem 0.8rem 0.8rem 2.5rem;
            font-size: 0.95rem;
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
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1rem;
            z-index: 5;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border: none;
            border-radius: 10px;
            padding: 0.9rem 2rem;
            font-weight: 600;
            font-size: 0.95rem;
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
            border-radius: 10px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            color: var(--primary);
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
        
        .divider {
            display: flex;
            align-items: center;
            margin: 1.25rem 0;
        }
        
        .divider-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
        }
        
        .divider-text {
            padding: 0 1rem;
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        /* Panel derecho */
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
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .right-description {
            font-size: 1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .benefit-list {
            list-style: none;
            padding: 0;
        }
        
        .benefit-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.25rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.8rem;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .benefit-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }
        
        .benefit-icon {
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.8rem;
            font-size: 1.1rem;
        }
        
        .benefit-text h6 {
            margin-bottom: 0.15rem;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .benefit-text p {
            margin: 0;
            opacity: 0.8;
            font-size: 0.8rem;
        }
        
        .trust-indicators {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .trust-card {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }
        
        .trust-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .trust-text {
            font-size: 0.8rem;
            opacity: 0.9;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .right-section {
                display: none;
            }
            
            .left-section {
                padding: 2rem 1.5rem;
            }
            
            .welcome-title {
                font-size: 1.6rem;
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
                font-size: 1.4rem;
            }
            
            .logo-circle {
                width: 70px;
                height: 70px;
            }
            
            .logo-icon {
                font-size: 1.8rem;
            }
        }
        
        /* Validación visual */
        .form-control.is-valid {
            border-color: var(--success);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2310b981' d='m2.3 6.73.94-.94 2.94 2.94L8.5 6.4l.94.94L6.5 10.27z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
        }
        
        .form-control.is-invalid {
            border-color: var(--danger);
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(99, 102, 241, 0); }
            100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0); }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="register-card">
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
                            <h2 class="welcome-title">Crear Cuenta</h2>
                            <p class="welcome-desc">Únase a miles de usuarios que confían en nosotros</p>
                        </div>
                        
                        <!-- Alertas de Error -->
                        @if ($errors->any())
                            <div class="alert-custom">
                                <i class="fas fa-exclamation-triangle alert-icon"></i>
                                <strong>Por favor corrija los siguientes errores:</strong>
                                <ul class="mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Formulario -->
                        <form action="{{ route('register') }}" method="post">
                            @csrf
                            
                            <!-- Nombre -->
                            <div class="form-group">
                                <label class="form-label">Nombre Completo</label>
                                <div class="input-container">
                                    <i class="fas fa-user input-icon"></i>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Ingrese su nombre completo" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            
                            <!-- Correo -->
                            <div class="form-group">
                                <label class="form-label">Correo Electrónico</label>
                                <div class="input-container">
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="ejemplo@correo.com" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            
                            <!-- Contraseña -->
                            <div class="form-group">
                                <label class="form-label">Contraseña</label>
                                <div class="input-container">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Mínimo 8 caracteres" required>
                                </div>
                            </div>
                            
                            <!-- Confirmar Contraseña -->
                            <div class="form-group">
                                <label class="form-label">Confirmar Contraseña</label>
                                <div class="input-container">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Repita su contraseña" required>
                                </div>
                            </div>
                            
                            <!-- Botón de registro -->
                            <button type="submit" class="btn-primary-custom">
                                <i class="fas fa-user-plus me-2"></i>
                                Crear Cuenta
                            </button>
                            
                            <!-- Divider -->
                            <div class="divider">
                                <div class="divider-line"></div>
                                <span class="divider-text">¿Ya tiene cuenta?</span>
                                <div class="divider-line"></div>
                            </div>
                            
                            <!-- Enlace a login -->
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="btn-outline-custom">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Iniciar Sesión
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Sección Derecha - Beneficios -->
                <div class="col-lg-6">
                    <div class="right-section">
                        <div class="right-content">
                            <h3 class="right-title">Únase a la Revolución Financiera</h3>
                            <p class="right-description">
                                Descubra por qué miles de usuarios eligen Financiera Pro para gestionar sus préstamos de manera inteligente y segura.
                            </p>
                            
                            <ul class="benefit-list">
                                <li class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fas fa-rocket"></i>
                                    </div>
                                    <div class="benefit-text">
                                        <h6>Aprobación Rápida</h6>
                                        <p>Procesos automatizados en menos de 24 horas</p>
                                    </div>
                                </li>
                                
                                <li class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fas fa-percentage"></i>
                                    </div>
                                    <div class="benefit-text">
                                        <h6>Tasas Competitivas</h6>
                                        <p>Las mejores tasas del mercado garantizadas</p>
                                    </div>
                                </li>
                                
                                <li class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fas fa-headset"></i>
                                    </div>
                                    <div class="benefit-text">
                                        <h6>Soporte Premium</h6>
                                        <p>Atención personalizada 24/7 por expertos</p>
                                    </div>
                                </li>
                                
                                <li class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="fas fa-gift"></i>
                                    </div>
                                    <div class="benefit-text">
                                        <h6>Sin Comisiones Ocultas</h6>
                                        <p>Transparencia total en todos nuestros servicios</p>
                                    </div>
                                </li>
                            </ul>
                            
                            <div class="trust-indicators">
                                <div class="trust-card">
                                    <div class="trust-icon">
                                        <i class="fas fa-award"></i>
                                    </div>
                                    <div class="trust-text">Certificado ISO 27001</div>
                                </div>
                                <div class="trust-card">
                                    <div class="trust-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="trust-text">+15,000 Usuarios</div>
                                </div>
                                <div class="trust-card">
                                    <div class="trust-icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="trust-text">4.9/5 Calificación</div>
                                </div>
                                <div class="trust-card">
                                    <div class="trust-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div class="trust-text">100% Seguro</div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Validación en tiempo real
            const inputs = document.querySelectorAll('.form-control');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                    validateField(this);
                });
                
                input.addEventListener('input', function() {
                    if (this.value.length > 0) {
                        validateField(this);
                    }
                });
            });
            
            // Validación de confirmación de contraseña
            confirmPasswordInput.addEventListener('input', function() {
                if (passwordInput.value !== this.value) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (this.value.length > 0) {
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                }
            });
            
            function validateField(field) {
                const value = field.value.trim();
                
                switch(field.type) {
                    case 'email':
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (emailRegex.test(value)) {
                            field.classList.add('is-valid');
                            field.classList.remove('is-invalid');
                        } else if (value.length > 0) {
                            field.classList.add('is-invalid');
                            field.classList.remove('is-valid');
                        }
                        break;
                        
                    case 'password':
                        if (value.length >= 8) {
                            field.classList.add('is-valid');
                            field.classList.remove('is-invalid');
                        } else if (value.length > 0) {
                            field.classList.add('is-invalid');
                            field.classList.remove('is-valid');
                        }
                        break;
                        
                    case 'text':
                        if (value.length >= 2) {
                            field.classList.add('is-valid');
                            field.classList.remove('is-invalid');
                        } else if (value.length > 0) {
                            field.classList.add('is-invalid');
                            field.classList.remove('is-valid');
                        }
                        break;
                }
            }
            
            // Efecto en benefit items
            const benefitItems = document.querySelectorAll('.benefit-item');
            benefitItems.forEach(item => {
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