<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario - Sidebar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://static.vecteezy.com/system/resources/previews/006/695/460/non_2x/money-dollar-bill-cartoon-illustration-free-vector.jpg" type="image/png">
    <!-- Bootstrap y FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
     

        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-bg: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            --sidebar-width: 280px;
        }

        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            z-index: 1040;
            transition: all 0.3s ease;
            color: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            transition: transform 0.3s ease;
        }

        .user-avatar:hover {
            transform: scale(1.05);
        }

        .user-avatar i {
            font-size: 1.5rem;
            color: white;
        }

        .user-name {
            color: white;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .user-welcome {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
            height: calc(100vh - 140px);
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 2px;
        }

        .nav-item {
            margin: 0.25rem 0.75rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--primary-gradient);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .nav-link:hover::before, .nav-link.active::before {
            transform: scaleY(1);
        }

        .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        .nav-link span {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 1rem;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1050;
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0,0,0,0.2);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1039;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .sidebar-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        /* MODAL MEJORADO */
        .custom-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(3px);
        }

        .custom-modal.show {
            opacity: 1;
            visibility: visible;
        }

        .custom-modal-content {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            transform: scale(0.7) translateY(-50px);
            transition: transform 0.3s ease;
            position: relative;
        }

        .custom-modal.show .custom-modal-content {
            transform: scale(1) translateY(0);
        }

        .custom-modal-header {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
            padding: 1.5rem 2rem;
            border-radius: 15px 15px 0 0;
            position: relative;
            overflow: hidden;
        }

        .custom-modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .custom-modal-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .custom-modal-title i {
            margin-right: 0.75rem;
            font-size: 1.75rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .custom-modal-close {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .custom-modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .custom-modal-body {
            padding: 2rem;
            line-height: 1.6;
        }

        .notification-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 4px solid;
            position: relative;
            overflow: hidden;
        }

        .notification-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.05;
            background: linear-gradient(45deg, transparent 30%, currentColor 30%, currentColor 70%, transparent 70%);
             pointer-events: none; /* 👈 Esto permite hacer clic a través del fondo decorativo */
        }

        .notification-section.pending {
            background: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }

        .notification-section.danger {
            background: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }

        .notification-section.success {
            background: #d1edff;
            border-color: #0dcaf0;
            color: #055160;
        }

        .notification-section.info {
            background: #cff4fc;
            border-color: #0dcaf0;
            color: #055160;
        }

        .notification-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .notification-title i {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }

        .notification-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .notification-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item-content {
            flex: 1;
        }

        .notification-item-action {
            margin-left: 1rem;
        }

        .custom-modal-footer {
            padding: 1.5rem 2rem;
            background: #f8f9fa;
            border-radius: 0 0 15px 15px;
            text-align: center;
        }

        .btn-custom {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-small {
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
            border-radius: 15px;
        }

        /* ESTILOS MEJORADOS PARA LA TABLA DE PRÉSTAMOS */
        .prestamos-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-top: 2rem;
        }

        .prestamos-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .prestamos-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .prestamos-title i {
            margin-right: 0.75rem;
            font-size: 1.75rem;
        }

        .prestamos-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .toggle-switch {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .toggle-switch:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .toggle-switch input[type="checkbox"] {
            margin: 0;
        }

        .toggle-switch label {
            margin: 0;
            color: white;
            font-weight: 500;
            cursor: pointer;
        }

        /* NUEVOS ESTILOS PARA BÚSQUEDA */
        .search-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e9ecef;
        }

        .search-inputs {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 200px;
        }

        .search-group label {
            font-weight: 600;
            color: #495057;
            white-space: nowrap;
            margin: 0;
        }

        .search-group input {
            flex: 1;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            transition: all 0.3s ease;
        }

        .search-group input:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
            outline: none;
        }

        .clear-search {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .clear-search:hover {
            background: #c82333;
            transform: translateY(-1px);
        }

        .user-section {
            margin-bottom: 2rem;
            border: 2px solid #8e44ad;  /*PUNTO2 */
            border-radius: 12px;
            overflow: hidden;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .user-header {
            background: linear-gradient(135deg, #6f42c1, #8e44ad);
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .user-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="60" r="1" fill="rgba(255,255,255,0.05)"/></svg>');
            opacity: 0.3;
        }

        .user-info {
            display: flex;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .user-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .user-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .user-details h5 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .user-details small {
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .loan-group {
            margin-bottom: 1.5rem;
            border-left: 4px solid #007bff;
            background: #f8f9ff;
            border-radius: 0 8px 8px 0;
        }

        .loan-group-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            border-radius: 0 4px 0 0;
        }

        .loan-group-header i {
            margin-right: 0.5rem;
        }

        .loan-number-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.9rem;
            margin-left: auto;
        }

        /* ESTILO PARA ÚLTIMO GRUPO DE ITEMS */
        .last-item-group {
            background: linear-gradient(135deg, #fff8e1, #ffecb3) !important;
            border-left: 4px solid #ff9800 !important;
            box-shadow: 0 2px 8px rgba(255, 152, 0, 0.2) !important;
        }

        .last-item-group .prestamos-table tbody tr {
            background: rgba(255, 193, 7, 0.1);
        }

        .last-item-group .prestamos-table tbody tr:hover {
            background: rgba(255, 193, 7, 0.2) !important;
        }

        .table-container {
            overflow-x: auto;
        }

        .prestamos-table {
            width: 100%;
            margin: 0;
            background: white;
        }

        .prestamos-table th {
            background: #f8f9fa;
            border: none;
            padding: 1rem 0.75rem;
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #dee2e6;
        }

        .prestamos-table td {
            padding: 1rem 0.75rem;
            border: none;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
        }

        .prestamos-table tbody tr {
            transition: all 0.3s ease;
        }

        .prestamos-table tbody tr:hover {
            background: #f8f9ff;
            transform: translateX(2px);
        }

        .prestamos-table tbody tr.table-secondary {
            background: #f8f9fa !important;
            opacity: 0.7;
        }

        .prestamos-table tbody tr.table-secondary:hover {
            background: #e9ecef !important;
        }

        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-aprobado {
            background: #d4edda;
            color: #155724;
        }

        .status-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .status-vencido {
            background: #f8d7da;
            color: #721c24;
        }

        .amount-cell {
            font-weight: 600;
            color: #28a745;
        }

        .date-cell {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .action-buttons .btn {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 500;
        }

        .difference-form {
            max-width: 200px;
        }

        .difference-form .input-group {
            margin-bottom: 0.5rem;
        }

        .difference-form .form-control {
            font-size: 0.85rem;
        }

        .difference-form .btn {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }

        .checkbox-cell {
            text-align: center;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h5 {
            margin-bottom: 0.5rem;
            color: #495057;
        }


          /* funciona para que el menu se despligue en movile */
               .sidebar {
    overflow-y: auto;            /* permite el scroll vertical */
    -webkit-overflow-scrolling: touch; /* scroll suave en iOS */
}

/* Opción 2: fija el header y desplaza solo los enlaces */
.sidebar-nav {
    max-height: calc(100vh - 200px); /* ajusta 160 px al alto real del header */
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
}



        /* Responsive Design */
        @media (max-width: 1200px) {
            :root {
                --sidebar-width: 260px;
            }
            
            .sidebar-header {
                padding: 1.25rem 0.75rem;
            }
            
            .nav-link {
                padding: 0.65rem 0.85rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 992px) {
            :root {
                --sidebar-width: 240px;
            }
            
            .user-avatar {
                width: 50px;
                height: 50px;
            }
            
            .user-avatar i {
                font-size: 1.25rem;
            }
            
            .user-name {
                font-size: 0.9rem;
            }
            
            .user-welcome {
                font-size: 0.75rem;
            }

            .prestamos-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .prestamos-controls {
                justify-content: center;
            }

            .search-inputs {
                flex-direction: column;
                align-items: stretch;
            }

            .search-group {
                min-width: auto;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 100%;
                max-width: 320px;
                z-index: 1041;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 4rem 1rem 1rem;
                z-index: auto;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .sidebar-overlay {
                display: block;
            }

            .nav-link {
                padding: 1rem;
                font-size: 1rem;
            }

            .nav-link i {
                margin-right: 1rem;
                font-size: 1.1rem;
            }

            .sidebar-header {
                padding: 2rem 1rem;
            }

            .user-avatar {
                width: 70px;
                height: 70px;
            }

            .user-avatar i {
                font-size: 1.75rem;
            }

            .user-name {
                font-size: 1.1rem;
            }

            .user-welcome {
                font-size: 0.9rem;
            }

            .custom-modal-content {
                width: 95%;
                margin: 1rem;
            }

            .custom-modal-body {
                padding: 1.5rem;
            }

            .custom-modal-header {
                padding: 1.25rem 1.5rem;
            }

            .notification-section {
                padding: 1rem;
                margin-bottom: 1.5rem;
            }

            .accordion-button {
                padding: 0.75rem;
                font-size: 0.9rem;
            }

            .accordion-body {
                padding: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .btn {
                font-size: 0.875rem;
            }

            .table-responsive {
                font-size: 0.85rem;
            }

            .accordion-item {
                touch-action: manipulation;
            }

            .accordion-button {
                touch-action: manipulation;
            }

            .prestamos-header {
                padding: 1.25rem 1.5rem;
            }

            .prestamos-title {
                font-size: 1.25rem;
            }

            .user-header {
                padding: 0.75rem 1rem;
            }

            .user-icon {
                width: 40px;
                height: 40px;
                margin-right: 0.75rem;
            }

            .user-icon i {
                font-size: 1.25rem;
            }

            .user-details h5 {
                font-size: 1.1rem;
            }

            .prestamos-table th,
            .prestamos-table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.85rem;
            }

            .action-buttons .btn {
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 4rem 0.5rem 1rem;
            }

            .container-fluid {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }

            .sidebar {
                max-width: 280px;
            }

            .mobile-menu-toggle {
                top: 0.75rem;
                left: 0.75rem;
                padding: 0.6rem;
            }

            .prestamos-container {
                border-radius: 10px;
            }

            .prestamos-header {
                padding: 1rem;
            }

            .user-header {
                padding: 0.75rem;
            }

            .loan-group-header {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                max-width: 100%;
            }

            .nav-link span {
                font-size: 0.95rem;
            }

            .prestamos-table {
                font-size: 0.8rem;
            }

            .prestamos-table th,
            .prestamos-table td {
                padding: 0.5rem 0.25rem;
            }
        }

        /* Animaciones mejoradas */
        .sidebar {
            will-change: transform;
        }

        .nav-link {
            will-change: transform, background-color;
        }

        /* Mejoras para accesibilidad */
        @media (prefers-reduced-motion: reduce) {
            .sidebar,
            .nav-link,
            .mobile-menu-toggle,
            .sidebar-overlay,
            .custom-modal,
            .custom-modal-content,
            .prestamos-table tbody tr {
                transition: none;
            }
            
            .custom-modal-title i {
                animation: none;
            }
        }

        /* Estados de focus mejorados */
        .nav-link:focus,
        .mobile-menu-toggle:focus {
            outline: 2px solid #fff;
            outline-offset: 2px;
        }

        /* Clase para prevenir scroll cuando sidebar está abierto */
        body.sidebar-open {
            overflow: hidden;
        }

        /* Prevenir backdrop de Bootstrap */
        .modal-backdrop {
            display: none !important;
        }

        /* Asegurar que no haya conflictos con modales de Bootstrap */
        body.modal-open {
            overflow: auto !important;
            padding-right: 0 !important;
        }
    </style>
</head>
<body>

<!-- Overlay para móviles -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Botón para móviles -->
<button class="mobile-menu-toggle" onclick="toggleSidebar()" aria-label="Abrir menú">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="user-name">{{ Auth::user()->name }}</div>
        <div class="user-welcome">¡Bienvenido de nuevo!</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-item">
            <a href="{{ route('indexAdmin') }}" class="nav-link active">
                <i class="fas fa-home"></i><span>Inicio</span>
            </a>
        </div>
         <div class="nav-item">
            <a href="{{ route('admin.graficos') }}" class="nav-link">
                <i class="fas fa-chart-bar"></i><span>Gráficos</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.createuser') }}" class="nav-link">
                <i class="fas fa-users-cog"></i><span>Usuario y Roles</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.prestamos.pendientes') }}" class="nav-link">
                <i class="fas fa-file-download"></i><span>Descargar Contrato</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.configuraciones') }}" class="nav-link">
                <i class="fas fa-cogs"></i><span>Configurar</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.prestamos.crear') }}" class="nav-link">
                <i class="fas fa-file-signature"></i><span>Generar Préstamo</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.reporte.prestamos') }}" class="nav-link">
                <i class="fas fa-chart-line"></i><span>Generar Reportes</span>
            </a>
        </div>
       
 <div class="nav-item">
            <a href="{{ route('reporte.general') }}" class="nav-link">
                <i class="fas fa-chart-line"></i><span>Reporte General</span>
        </a>
        </div>
        
        <div class="nav-item mt-auto">
            <a href="{{ route('logout') }}" class="nav-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Cerrar sesión</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </nav>
</div>

<!-- Contenido principal -->
<div class="main-content">
  <div class="container-fluid px-3 px-md-4 py-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center mb-3">
                    <i class="fas fa-user-circle text-primary me-2 fs-4"></i>
                    <h2 class="mb-0 text-dark">Bienvenido, {{ Auth::user()->name }}</h2>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->has('caja'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first('caja') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>
        </div>
        
     <!-- PERIODO ACTUAL MAS MONTO -->
<div class="row">
    {{-- Tarjeta del Periodo de Caja Activo --}}
    @if($periodoActual)
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card shadow-sm mb-4 h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-cash-register me-2 text-primary"></i>
                        Periodo de Caja Activo
                    </h5>

                    <div class="mb-3 flex-grow-1">
                        <p class="mb-2 text-muted">
                            <i class="fas fa-calendar-alt me-2"></i>
                            <small class="d-block d-sm-inline">
                                {{ $periodoActual->periodo_inicio->format('d/m/Y') }}
                                <span class="d-none d-sm-inline">&mdash;</span>
                                <span class="d-block d-sm-inline mt-1 mt-sm-0">
                                    {{ $periodoActual->periodo_fin->format('d/m/Y') }}
                                </span>
                            </small>
                        </p>
                    </div>

                    <div class="mt-auto">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="flex-grow-1">
                                <p class="mb-0 fs-5 fw-bold">
                                    <i class="fas fa-wallet me-2 text-success"></i>
                                    <span id="saldoTexto" style="display: none;">
                                        S/ {{ number_format($periodoActual->saldo_actual, 2) }}
                                    </span>
                                    <span id="saldoOculto">
                                        S/ ••••••
                                    </span>
                                </p>
                            </div>
                            <button type="button" 
                                    id="toggleSaldo" 
                                    class="btn btn-link btn-sm p-1 ms-2 text-secondary"
                                    title="Mostrar/Ocultar saldo">
                                <i id="iconoOjo" class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta del Último Aporte --}}
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card shadow-sm mb-4 h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-hand-holding-usd me-2 text-info"></i>
                        Último Aporte Ingresado
                    </h5>

                   <div class="flex-grow-1">
    @if(!is_null($ultimoAporteMonto))
        <p class="fs-5 fw-bold text-success mb-1">
            S/ {{ number_format($ultimoAporteMonto, 2) }}
        </p>
    @else
        <p class="text-muted mb-1">
            Aún no hay movimientos en "APORTES”.
        </p>
    @endif

    <div class="d-flex justify-content-between align-items-center mt-2">
    <small class="text-muted">Datos actualizados</small>

    <a href="{{ route('aportes.index') }}" class="btn btn-sm btn-outline-primary mb-0">
        <i class="fas fa-eye me-1"></i> Ver Aportes
    </a>
</div>
</div>
                </div>
            </div>
        </div>
    @else
        {{-- Si no hay periodo activo --}}
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="alert alert-warning mb-4 d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <span>No hay un periodo de caja abierto en este momento.</span>
            </div>
        </div>
    @endif
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleSaldo');
    const saldoTexto = document.getElementById('saldoTexto');
    const saldoOculto = document.getElementById('saldoOculto');
    const iconoOjo = document.getElementById('iconoOjo');
    
    let saldoVisible = false;
    
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            saldoVisible = !saldoVisible;
            
            if (saldoVisible) {
                saldoTexto.style.display = 'inline';
                saldoOculto.style.display = 'none';
                iconoOjo.className = 'fas fa-eye';
                toggleBtn.title = 'Ocultar saldo';
            } else {
                saldoTexto.style.display = 'none';
                saldoOculto.style.display = 'inline';
                iconoOjo.className = 'fas fa-eye-slash';
                toggleBtn.title = 'Mostrar saldo';
            }
        });
    }
});
</script>
  <br>
<!-- Title Section -->
<div class="row mb-3">
  <div class="col-12">
    <div class="d-flex align-items-center justify-content-between flex-wrap">
      <div class="d-flex align-items-center">
        <i class="fas fa-clock text-warning me-2 fs-5"></i>
        <h4 class="mb-0 text-secondary">Solicitudes de Préstamos Pendientes</h4>
        @if(!$prestamosPendientes->isEmpty())
          <span class="badge bg-warning text-dark ms-2">{{ $prestamosPendientes->count() }}</span>
        @endif
      </div>
      <button class="btn btn-outline-primary btn-sm mt-2 mt-md-0 ms-md-3" onclick="location.reload()">
        <i class="fas fa-sync-alt me-1"></i> Actualizar
      </button>
    </div>
  </div>
</div>

<!-- Content Section -->
<div class="row">
  <div class="col-12">
    @if($prestamosPendientes->isEmpty())
      <div class="text-center py-5">
        <i class="fas fa-inbox text-muted" style="font-size: 4rem;"></i>
        <div class="alert alert-info border-0 mt-3 mx-auto" style="max-width: 400px;">
          <h5 class="alert-heading">
            <i class="fas fa-info-circle me-2"></i>Sin préstamos pendientes
          </h5>
          <p class="mb-0">No hay solicitudes de préstamos esperando aprobación en este momento.</p>
        </div>
      </div>
    @else
      <div class="accordion" id="accordionPrestamos">
        @foreach($prestamosPendientes as $index => $prestamo)
          <div class="accordion-item border-0 shadow-sm mb-3 rounded">
            <h2 class="accordion-header" id="heading{{ $prestamo->id }}">
              <button class="accordion-button collapsed bg-light rounded-top" type="button"
                       data-bs-toggle="collapse" data-bs-target="#collapse{{ $prestamo->id }}"
                       aria-expanded="false" aria-controls="collapse{{ $prestamo->id }}">
                <div class="w-100">
                  <div class="row align-items-center">
                    <div class="col-md-6 col-12 mb-2 mb-md-0">
                      <div class="d-flex align-items-center">
                        <span class="badge bg-primary me-2">#{{ $prestamo->numero_prestamo }}</span>
                        <strong class="text-truncate">{{ $prestamo->user->name }}</strong>
                      </div>
                    </div>
                    <div class="col-md-3 col-6">
                      <div class="text-success fw-bold">
                        <i class="fas fa-dollar-sign me-1"></i>
                        S/. {{ number_format($prestamo->monto, 2) }}
                      </div>
                    </div>
                    <div class="col-md-3 col-6 text-end text-md-start">
                      <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        {{ $prestamo->created_at->format('d/m/Y') }}
                      </small>
                    </div>
                  </div>
                </div>
              </button>
            </h2>
            
            <div id="collapse{{ $prestamo->id }}" class="accordion-collapse collapse"
                 aria-labelledby="heading{{ $prestamo->id }}" data-bs-parent="#accordionPrestamos">
              <div class="accordion-body p-4">
                
                <!-- Información del préstamo -->
                <div class="row mb-4">
                  <div class="col-12">
                    <h6 class="text-primary border-bottom pb-2 mb-3">
                      <i class="fas fa-info-circle me-2"></i>Detalles del Préstamo
                    </h6>
                    <div class="row">
                      <div class="col-md-4 col-6 mb-2">
                        <small class="text-muted d-block">Cliente</small>
                        <strong>{{ $prestamo->user->name }}</strong>
                      </div>
                      <div class="col-md-4 col-6 mb-2">
                        <small class="text-muted d-block">Monto Solicitado</small>
                        <strong class="text-success">S/. {{ number_format($prestamo->monto, 2) }}</strong>
                      </div>
                      <div class="col-md-4 col-12 mb-2">
                        <small class="text-muted d-block">Fecha de Solicitud</small>
                        <strong>{{ $prestamo->created_at->format('d/m/Y H:i') }}</strong>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Formularios en cards separadas -->
                <div class="row">
                  <!-- Formulario de Aprobación -->
                  <div class="col-lg-8 col-12 mb-3">
                    <div class="card border-success">
                      <div class="card-header bg-success bg-opacity-10 border-success">
                        <h6 class="card-title mb-0 text-success">
                          <i class="fas fa-check-circle me-2"></i>Aprobar Préstamo
                        </h6>
                      </div>
                      <div class="card-body">
                        <form action="{{ route('prestamo.aprobar', $prestamo->id) }}" method="POST" id="form_{{ $prestamo->id }}">
                          @csrf
                          @method('PUT')
                          <!-- Fechas -->
                          <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                              <label for="fecha_inicio_{{ $prestamo->id }}" class="form-label fw-semibold">
                                <i class="fas fa-play-circle text-success me-1"></i>Fecha de inicio
                              </label>
                              <input type="date" name="fecha_inicio" id="fecha_inicio_{{ $prestamo->id }}"
                                      class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                              <label for="fecha_fin_{{ $prestamo->id }}" class="form-label fw-semibold">
                                <i class="fas fa-stop-circle text-danger me-1"></i>Fecha de fin
                              </label>
                              <input type="date" name="fecha_fin" id="fecha_fin_{{ $prestamo->id }}"
                                      class="form-control" required>
                            </div>
                          </div>
                          <!-- Interés y Penalidad -->
                          <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                              <label for="interes_{{ $prestamo->id }}" class="form-label fw-semibold">
                                <i class="fas fa-percentage text-info me-1"></i>Interés
                              </label>
                              <select name="interes" id="interes_{{ $prestamo->id }}" class="form-select" required>
                                @foreach ($configuraciones as $config)
                                  <option value="{{ $config->interes }}">{{ $config->interes }}%</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-6 mb-3">
                              <label for="penalidad_{{ $prestamo->id }}" class="form-label fw-semibold">
                                <i class="fas fa-exclamation-triangle text-warning me-1"></i>Penalidad
                              </label>
                              <select name="penalidad" id="penalidad_{{ $prestamo->id }}" class="form-select" required>
                                @foreach ($configuraciones as $config)
                                  <option value="{{ $config->penalidad }}">{{ $config->penalidad }}%</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <!-- Checkbox Junta -->
                          <div class="mb-3">
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" name="es_junta"
                                      id="es_junta_{{ $prestamo->id }}" value="1"
                                     onchange="toggleJuntaSelect({{ $prestamo->id }})">
                              <label class="form-check-label fw-semibold" for="es_junta_{{ $prestamo->id }}">
                                <i class="fas fa-users text-primary me-1"></i>¿Es junta?
                              </label>
                            </div>
                          </div>
                          <!-- Tipo de origen (oculto inicialmente) -->
                          <div id="tipo_origen_container_{{ $prestamo->id }}" class="mb-3" style="display: none;">
                            <label for="tipo_origen_{{ $prestamo->id }}" class="form-label fw-semibold">
                              <i class="fas fa-tag text-secondary me-1"></i>Tipo de origen
                            </label>
                            <select name="tipo_origen" id="tipo_origen_{{ $prestamo->id }}" class="form-select">
                              @foreach($configuraciones as $config)
                                @if($config->tipo_origen)
                                  <option value="{{ $config->tipo_origen }}">{{ $config->tipo_origen }}</option>
                                @endif
                              @endforeach
                            </select>
                          </div>
                          
                          <!-- Botones de acción -->
                          <div class="d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-success"
        onclick="return confirm('¿Está seguro que desea aprobar este préstamo?')">
  <i class="fas fa-check-circle me-2"></i>Aprobar Préstamo
</button>
                            <button type="button" class="btn btn-outline-info" onclick="generarContrato({{ $prestamo->id }})">
                              <i class="fas fa-file-contract me-2"></i>Descargar Contrato
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!-- Formulario de Rechazo -->
                  <div class="col-lg-4 col-12 mb-3">
                    <div class="card border-danger h-100">
                      <div class="card-header bg-danger bg-opacity-10 border-danger">
                        <h6 class="card-title mb-0 text-danger">
                          <i class="fas fa-times-circle me-2"></i>Rechazar Préstamo
                        </h6>
                      </div>
                      <div class="card-body d-flex flex-column justify-content-center text-center">
                        <div class="mb-3">
                          <i class="fas fa-ban text-danger" style="font-size: 2rem;"></i>
                          <p class="text-muted mt-2 mb-3">
                            Esta acción no se puede deshacer. El préstamo será rechazado permanentemente.
                          </p>
                        </div>
                        <form action="{{ route('prestamo.rechazar', $prestamo->id) }}" method="POST">
                          @csrf
                          <button type="submit" class="btn btn-danger w-100"
                                   onclick="return confirm('¿Está seguro que desea rechazar este préstamo?')">
                            <i class="fas fa-times-circle me-2"></i>Rechazar Préstamo
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>

<!-- SCRIPT MEJORADO -->
<script>
  function toggleJuntaSelect(id) {
    const checkbox = document.getElementById(`es_junta_${id}`);
    const container = document.getElementById(`tipo_origen_container_${id}`);
    
    if (checkbox && container) {
      if (checkbox.checked) {
        container.style.display = 'block';
        container.classList.add('fade-in');
      } else {
        container.style.display = 'none';
        container.classList.remove('fade-in');
      }
    }
  }

  // Función para convertir número a texto
  function numeroATexto(numero) {
    const unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
    const decenas = ['', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
    const centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];
    const especiales = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
    
    if (numero === 0) return 'cero';
    if (numero === 100) return 'cien';
    if (numero === 1000) return 'mil';
    
    let resultado = '';
    
    // Miles
    if (numero >= 1000) {
      const miles = Math.floor(numero / 1000);
      if (miles === 1) {
        resultado += 'mil ';
      } else {
        resultado += numeroATexto(miles) + ' mil ';
      }
      numero %= 1000;
    }
    
    // Centenas
    if (numero >= 100) {
      const cent = Math.floor(numero / 100);
      resultado += centenas[cent] + ' ';
      numero %= 100;
    }
    
    // Decenas y unidades
    if (numero >= 20) {
      const dec = Math.floor(numero / 10);
      const uni = numero % 10;
      resultado += decenas[dec];
      if (uni > 0) {
        resultado += ' y ' + unidades[uni];
      }
    } else if (numero >= 10) {
      resultado += especiales[numero - 10];
    } else if (numero > 0) {
      resultado += unidades[numero];
    }
    
    return resultado.trim();
  }

  // Función para generar el contrato
  function generarContrato(prestamoId) {
    // Obtener datos del formulario
    const fechaInicio = document.getElementById(`fecha_inicio_${prestamoId}`).value;
    const fechaFin = document.getElementById(`fecha_fin_${prestamoId}`).value;
    const interes = document.getElementById(`interes_${prestamoId}`).value;
    const penalidad = document.getElementById(`penalidad_${prestamoId}`).value;
    
    // Validar que todos los campos estén llenos
    if (!fechaInicio || !fechaFin || !interes || !penalidad) {
      alert('Por favor, complete todos los campos antes de generar el contrato.');
      return;
    }

    // Obtener datos del préstamo (estos deberían venir del backend)
    const prestamo = @json($prestamosPendientes->keyBy('id'));
    const prestamoData = prestamo[prestamoId];
    
    if (!prestamoData) {
      alert('Error: No se encontraron los datos del préstamo.');
      return;
    }

    // Calcular valores
    const monto = parseFloat(prestamoData.monto);
    const tasaInteres = parseFloat(interes) / 100;
    const montoInteres = monto * tasaInteres;
    const montoTotal = monto + montoInteres;
    
    // Convertir monto a texto
    const montoTexto = numeroATexto(Math.floor(monto));
    
    // Formatear fechas
   function formatearFecha(fechaString) {
  const meses = [
    'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
    'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
  ];
  
  const [año, mes, dia] = fechaString.split('-');
  const mesNombre = meses[parseInt(mes) - 1];
  return `${parseInt(dia)} de ${mesNombre} de ${año}`;
}

// Usar la función personalizada
const fechaInicioFormateada = formatearFecha(fechaInicio);
const fechaFinFormateada = formatearFecha(fechaFin);
    
    const fechaHoy = new Date().toLocaleDateString('es-PE', {
      day: 'numeric',
      month: 'long',
      year: 'numeric'
    });

    // Calcular duración en días
   const [añoInicio, mesInicio, diaInicio] = fechaInicio.split('-').map(Number);
const [añoFin, mesFin, diaFin] = fechaFin.split('-').map(Number);
const inicio = new Date(añoInicio, mesInicio - 1, diaInicio);
const fin = new Date(añoFin, mesFin - 1, diaFin);
    const duracionDias = Math.ceil((fin - inicio) / (1000 * 60 * 60 * 24));
    const duracionSemanas = Math.ceil(duracionDias / 7);

    // Generar HTML del contrato
    const contratoHTML = `
      <!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contrato de Préstamo</title>
  <style>
    @media print {
      body { margin: 0; padding: 20px; font-family: Arial, sans-serif; }
      .no-print { display: none !important; }
    }
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      color: #333;
    }
    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #333;
      padding-bottom: 20px;
    }
    .title {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
      text-transform: uppercase;
    }
    .date {
      text-align: right;
      margin-bottom: 20px;
      font-weight: bold;
    }
    .section {
      margin-bottom: 20px;
    }
    .section-title {
      font-weight: bold;
      text-decoration: underline;
      margin-bottom: 10px;
      font-size: 16px;
    }
    .partes-box {
      display: flex;
      justify-content: space-between;
      gap: 30px;
      margin-bottom: 20px;
    }
    .parte {
      width: 50%;
    }
    .parte-title {
      font-weight: bold;
      margin-bottom: 5px;
      text-decoration: underline;
    }
    .clause {
      margin-bottom: 15px;
      text-align: justify;
    }
    .clause-number {
      font-weight: bold;
    }
    .signatures {
      margin-top: 50px;
      display: flex;
      justify-content: space-between;
    }
    .signature-box {
      text-align: center;
      width: 45%;
    }
    .signature-line {
      border-top: 1px solid #333;
      margin-top: 60px;
      padding-top: 5px;
    }
    .important-note {
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 5px;
      padding: 15px;
      margin: 20px 0;
      font-weight: bold;
    }
    .amount {
      font-weight: bold;
      color: #2c5aa0;
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="title">Contrato de Préstamo</div>
  </div>

  <div class="date">
    Fecha: ${fechaHoy}
  </div>

  <div class="section">
    <div class="section-title">LAS PARTES:</div>
    <div class="partes-box">
      <div class="parte">
        <div class="parte-title">PRESTAMISTA</div>
        <p>Banquito</p>
      </div>
      <div class="parte">
        <div class="parte-title">PRESTATARIO</div>
        <p>${prestamoData.user.name} ${prestamoData.user.apellido_paterno || ''} ${prestamoData.user.apellido_materno || ''}</p>
        <p>DNI: ${prestamoData.user.dni || 'No especificado'}</p>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="section-title">CLÁUSULAS:</div>

    <div class="clause">
      <span class="clause-number">1. MONTO:</span> 
      El Prestamista otorga al Prestatario la suma de <span class="amount">S/ ${monto.toFixed(2)} (${montoTexto} soles)</span> (en adelante, el "Principal").
    </div>

    <div class="clause">
      <span class="clause-number">2. PLAZO:</span> 
      Duración: ${duracionSemanas} ${duracionSemanas === 1 ? 'semana' : 'semanas'} (${duracionDias} días naturales), desde ${fechaInicioFormateada} hasta ${fechaFinFormateada}.
    </div>

    <div class="clause">
      <span class="clause-number">3. INTERÉS:</span> 
      Tasa fija del ${interes}% sobre el Principal. Interés total: <span class="amount">S/ ${montoInteres.toFixed(2)}</span> (Principal × ${tasaInteres}).
    </div>

    <div class="clause">
      <span class="clause-number">4. PAGO TOTAL AL VENCIMIENTO:</span><br>
      - Principal: <span class="amount">S/ ${monto.toFixed(2)}</span><br>
      - Interés: <span class="amount">S/ ${montoInteres.toFixed(2)}</span><br>
      - <strong>Total: <span class="amount">S/ ${montoTotal.toFixed(2)}</span></strong>
    </div>

    <div class="clause">
      <span class="clause-number">5. FECHA LÍMITE:</span> 
      Pago máximo hasta: <strong>${fechaFinFormateada}</strong> (inclusive).
    </div>
  </div>

  <div class="important-note">
    <strong>NOTA IMPORTANTE:</strong> En caso de mora, se aplicará una penalidad del ${penalidad}% que se calcula exclusivamente sobre el interés. El vencimiento es de ${duracionDias} días naturales a partir de la fecha de firma del presente contrato.
  </div>

  <div class="signatures">
    <div class="signature-box">
      <div class="signature-line">
        <strong>PRESTAMISTA</strong><br>
        Banquito
      </div>
    </div>
    <div class="signature-box">
      <div class="signature-line">
        <strong>PRESTATARIO</strong><br>
        ${prestamoData.user.name} ${prestamoData.user.apellido_paterno || ''} ${prestamoData.user.apellido_materno || ''}
      </div>
    </div>
  </div>
</body>
</html>
    `;

    // Crear nueva ventana e imprimir
    const ventanaImpresion = window.open('', '_blank');
    ventanaImpresion.document.write(contratoHTML);
    ventanaImpresion.document.close();
    
    // Esperar a que se cargue y luego imprimir
    ventanaImpresion.onload = function() {
      setTimeout(() => {
        ventanaImpresion.print();
      }, 500);
    };
  }

  // Mejorar la experiencia de fechas
  document.addEventListener('DOMContentLoaded', function() {
    // Establecer fecha mínima como hoy
    const today = new Date().toISOString().split('T')[0];
    const fechaInicioInputs = document.querySelectorAll('input[name="fecha_inicio"]');
    const fechaFinInputs = document.querySelectorAll('input[name="fecha_fin"]');
    
    fechaInicioInputs.forEach(input => {
      //input.min = today;
      input.addEventListener('change', function() {
        const prestamoId = this.id.split('_').pop();
        const fechaFinInput = document.getElementById(`fecha_fin_${prestamoId}`);
        fechaFinInput.min = this.value;
      });
    });
    
    fechaFinInputs.forEach(input => {
      //input.min = today;
    });
  });
</script>

<style>
  .fade-in {
    animation: fadeIn 0.3s ease-in;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  .accordion-button:not(.collapsed) {
    background-color: #e7f3ff !important;
    border-color: #0d6efd !important;
  }
  
  .form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
  }
  
  .card {
    transition: all 0.3s ease;
  }
  
  .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
  }
  
  @media (max-width: 768px) {
    .container-fluid {
      padding-left: 15px !important;
      padding-right: 15px !important;
    }
    
    .accordion-button {
      padding: 1rem 0.75rem;
    }
    
    .accordion-body {
      padding: 1.5rem !important;
    }
  }
</style>
 {{--termino la seccion de prestamos pendientes --}}

  {{-- MODAL PERSONALIZADO MEJORADO --}}
 @if($hayNuevosPrestamos || $hayPrestamosPorVencer || $usuariosConCumpleanos->isNotEmpty() ||
    $hayQuierenPagar || 
    $hayPrestamosVencidos // ← agrega esto si implementaste la sección de vencidos
    )
<!-- Modal personalizado mejorado -->
<div class="custom-modal" id="notificacionesModal">
  <div class="custom-modal-content">
    <div class="custom-modal-header">
      <h5 class="custom-modal-title">
        <i class="fas fa-bell"></i>
        Centro de Notificaciones
      </h5>
      <button type="button" class="custom-modal-close" onclick="closeCustomModal()">
        <i class="fas fa-times"></i>
      </button>
    </div>
    
    <div class="custom-modal-body">
      @if($hayNuevosPrestamos)
        <div class="notification-section pending">
          <div class="notification-title">
            <i class="fas fa-clock"></i>
            Préstamos Pendientes de Aprobación
          </div>
          <p>
            Tienes <strong>{{ $prestamosPendientes->count() }}</strong> 
            solicitud{{ $prestamosPendientes->count() > 1 ? 'es' : '' }} de préstamo 
            pendiente{{ $prestamosPendientes->count() > 1 ? 's' : '' }} por revisar.
          </p>
          <div class="alert alert-warning border-0 mt-2">
            <i class="fas fa-info-circle me-2"></i>
            Revisa la sección <strong>"Solicitudes de Préstamos Pendientes"</strong> para aprobar o rechazar.
          </div>
        </div>
      @endif

      @if($hayPrestamosPorVencer)
        <div class="notification-section danger">
          <div class="notification-title">
            <i class="fas fa-exclamation-triangle"></i>
            Préstamos Próximos a Vencer
          </div>
          <p>
            <strong>{{ $prestamosPorVencer->count() }}</strong> préstamo{{ $prestamosPorVencer->count() > 1 ? 's' : '' }} 
            vence{{ $prestamosPorVencer->count() > 1 ? 'n' : '' }} en los próximos 5 días:
          </p>
          <ul class="notification-list">
            @foreach($prestamosPorVencer as $prestamo)
              <li class="notification-item">
                <div class="notification-item-content">
                  <strong>Préstamo N° {{ $prestamo->numero_prestamo }}</strong><br>
                  <small>{{ $prestamo->user->name }} - Vence el {{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}</small>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      @endif


@if($hayPrestamosVencidos)
  <div class="notification-section danger">
    <div class="notification-title">
      <i class="fas fa-skull-crossbones"></i>
      Préstamos Vencidos
    </div>
    <p>
      Tienes <strong>{{ $prestamosVencidos->count() }}</strong> préstamo{{ $prestamosVencidos->count() > 1 ? 's' : '' }} vencido{{ $prestamosVencidos->count() > 1 ? 's' : '' }}:
    </p>
    <ul class="notification-list">
      @foreach($prestamosVencidos as $prestamo)
        <li class="notification-item">
          <div class="notification-item-content">
            <strong>Préstamo N° {{ $prestamo->numero_prestamo }}</strong><br>
            <small>{{ $prestamo->user->name }} - Venció el {{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}</small>
          </div>
        </li>
      @endforeach
    </ul>
  </div>
@endif



      @if($usuariosConCumpleanos->isNotEmpty())
        <div class="notification-section success">
          <div class="notification-title">
            <i class="fas fa-birthday-cake"></i>
            Próximos Cumpleaños 🎉
          </div>
          <ul class="notification-list">
            @foreach($usuariosConCumpleanos as $user)
              <li class="notification-item">
                <div class="notification-item-content">
                  <strong>{{ $user->nombre }}</strong><br>
                  <small>
                    Cumple <strong>{{ $user->edad }}</strong> año{{ $user->edad > 1 ? 's' : '' }}
                    @if($user->es_hoy)
                      <span class="badge bg-danger">¡Hoy! 🎂</span>
                    @else
                      <span class="badge bg-info">En {{ $user->dias_faltantes }} día{{ $user->dias_faltantes > 1 ? 's' : '' }}</span>
                    @endif
                  </small>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      @endif

      @if($hayQuierenPagar)
        <div class="notification-section info">
          <div class="notification-title">
            <i class="fas fa-money-bill-wave"></i>
            Solicitudes de Pago
          </div>
          <p>Usuarios que desean realizar un pago:</p>
          <ul class="notification-list">
            @foreach($prestamosNotificados as $prestamo)
              <li class="notification-item">
                <div class="notification-item-content">
                  <strong>{{ $prestamo->user->name }} {{ $prestamo->user->apellido_paterno ?? '' }}</strong><br>
                  <small>Préstamo N° {{ $prestamo->numero_prestamo }} - S/. {{ number_format($prestamo->monto, 2) }}</small>
                </div>
                <div class="notification-item-action">
                  <form action="{{ route('admin.marcar_leido', $prestamo->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-small">
                      <i class="fas fa-check me-1"></i>Leído
                    </button>
                  </form>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>
    
    <div class="custom-modal-footer">
      <button type="button" class="btn-custom" onclick="closeCustomModal()">
        <i class="fas fa-check me-2"></i>Entendido
      </button>
    </div>
  </div>
</div>

<script>
    // Funciones del modal personalizado
    function showCustomModal() {
        const modal = document.getElementById('notificacionesModal');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeCustomModal() {
        const modal = document.getElementById('notificacionesModal');
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }

    // Mostrar modal al cargar la página
    document.addEventListener('DOMContentLoaded', function () {
        // Pequeño delay para mejor experiencia visual
        setTimeout(showCustomModal, 500);
    });

    // Cerrar modal con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCustomModal();
        }
    });

    // Cerrar modal al hacer clic fuera del contenido
    document.getElementById('notificacionesModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCustomModal();
        }
    });
</script>
@endif

   {{-- SECCIÓN DE PRÉSTAMOS APROBADOS MEJORADA --}}
{{-- Éxitos --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

{{-- Errores --}}
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

<!-- CONTENEDOR MEJORADO DE PRÉSTAMOS -->
<div class="prestamos-container">
  <div class="prestamos-header">
    <h4 class="prestamos-title">
      <i class="fas fa-calendar-times"></i>
      Préstamos Próximos a Vencer
    </h4>
    <div class="prestamos-controls">
      <div class="toggle-switch">
        <input class="form-check-input" type="checkbox" id="mostrarTodosAprobados" onchange="togglePrestamosAprobados()">
        <label class="form-check-label" for="mostrarTodosAprobados">
          <i class="fas fa-list me-1"></i>Mostrar todos los préstamos
        </label>
      </div>    
    </div>
  </div>

  <!-- NUEVA SECCIÓN DE BÚSQUEDA -->
<div class="container-fluid mb-3">
  <div class="row g-3 align-items-end">
    
    <!-- Buscar por nombre -->
    <div class="col-12 col-md-5">
      <label for="searchName" class="form-label">
        <i class="fas fa-user me-1"></i>Buscar por nombre:
      </label>
      <input
        type="text"
        id="searchName"
        class="form-control"
        placeholder="Ingrese nombre del cliente..."
        onkeyup="filterPrestamos()"
      >
    </div>

    <!-- Buscar por N° préstamo -->
    <div class="col-12 col-md-5">
      <label for="searchLoanNumber" class="form-label">
        <i class="fas fa-hashtag me-1"></i>Buscar por N° préstamo:
      </label>
      <input
        type="text"
        id="searchLoanNumber"
        class="form-control"
        placeholder="Ingrese número de préstamo..."
        onkeyup="filterPrestamos()"
      >
    </div>

    <!-- Botón Limpiar -->
    <div class="col-12 col-md-2 d-grid">
      <button
        type="button"
        class="btn btn-outline-secondary clear-search"
        onclick="clearSearch()"
      >
        <i class="fas fa-times me-1"></i>Limpiar
      </button>
    </div>

  </div>
</div>

  <div class="prestamos-body" id="prestamosContainer">
    <!-- El contenido se genera dinámicamente con JavaScript -->
  </div>
</div>

{{-- Pasamos los datos como JSON desde Laravel --}}
<script>
  {{--  const prestamosFiltrados = @json($prestamosAprobados);  --}}
   const prestamosFiltrados = @json($versionesAnterioresPorVencer);// se agrego esto beta funcionalidad en proceso punto2
    const prestamosTodos = @json($todosPrestamosAprobados); 
    const csrfToken = "{{ csrf_token() }}";
    let prestamosOriginales = [];
    let prestamosActuales = [];
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        togglePrestamosAprobados(); // Mostrar por defecto los filtrados
    });

    function togglePrestamosAprobados() {
        const mostrarTodos = document.getElementById('mostrarTodosAprobados').checked;
        prestamosOriginales = mostrarTodos ? prestamosTodos : prestamosFiltrados;
        prestamosActuales = [...prestamosOriginales];
        renderPrestamos(prestamosActuales);
        clearSearchInputs();
    }

    function filterPrestamos() {
        const searchName = document.getElementById('searchName').value.toLowerCase().trim();
        const searchLoanNumber = document.getElementById('searchLoanNumber').value.toLowerCase().trim();
        
        let filteredPrestamos = [...prestamosOriginales];
        
        if (searchName) {
    filteredPrestamos = filteredPrestamos.filter(p => {
        const nombreCompleto = `${p.user.name || ''} ${p.user.apellido_paterno || ''} ${p.user.apellido_materno || ''}`.toLowerCase();
        return nombreCompleto.includes(searchName);
    });
}
        
        if (searchLoanNumber) {
            filteredPrestamos = filteredPrestamos.filter(p => 
                p.numero_prestamo.toString().includes(searchLoanNumber)
            );
        }
        
        prestamosActuales = filteredPrestamos;
        renderPrestamos(prestamosActuales);
    }

    function clearSearch() {
        clearSearchInputs();
        prestamosActuales = [...prestamosOriginales];
        renderPrestamos(prestamosActuales);
    }

    function clearSearchInputs() {
        document.getElementById('searchName').value = '';
        document.getElementById('searchLoanNumber').value = '';
    }

    function renderPrestamos(lista) {
        const container = document.getElementById('prestamosContainer');
        container.innerHTML = '';

        if (lista.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h5>No se encontraron préstamos</h5>
                    <p>No hay préstamos que coincidan con los criterios de búsqueda.</p>
                </div>
            `;
            return;
        }

        // Agrupar por usuarios
        const usuarios = {};
        lista.forEach(p => {
            if (!usuarios[p.user_id]) usuarios[p.user_id] = { user: p.user, prestamos: [] };
            usuarios[p.user_id].prestamos.push(p);
        });

        // Renderizar cada usuario
        for (const userId in usuarios) {
            const { user, prestamos } = usuarios[userId];
            
            // Crear sección de usuario
            const userSection = document.createElement('div');
            userSection.className = 'user-section';
            
            // Header del usuario
            userSection.innerHTML = `
                <div class="user-header">
                    <div class="user-info">
                        <div class="user-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-details">
                            <h5>${user.name} ${user.apellido_paterno || ''}</h5>
                            <small><i class="fas fa-id-card me-1"></i>Usuario ID: ${user.id}</small>
                        </div>
                    </div>
                </div>
            `;

            // Agrupar préstamos por número
            const grupos = {};
            prestamos.forEach(p => {
                if (!grupos[p.numero_prestamo]) grupos[p.numero_prestamo] = [];
                grupos[p.numero_prestamo].push(p);
            });

            // Crear contenido del usuario
            const userContent = document.createElement('div');
            userContent.style.padding = '1.5rem';

            // Renderizar cada grupo de préstamos
            for (const num in grupos) {
                // Ordenar versiones: última primero
                grupos[num].sort((a, b) => b.item_prestamo - a.item_prestamo);

                // Determinar si es el último grupo de items (item más bajo)
                const minItem = Math.min(...grupos[num].map(p => p.item_prestamo));
                const isLastItemGroup = minItem === 1;

                // Crear grupo de préstamo
                const loanGroup = document.createElement('div');
                loanGroup.className = isLastItemGroup ? 'loan-group last-item-group' : 'loan-group';

                loanGroup.innerHTML = `
                    <div class="loan-group-header">
                        <i class="fas fa-file-contract"></i>
                        Préstamo N° ${num}
                        <span class="loan-number-badge">
                            ${grupos[num].length} versión${grupos[num].length > 1 ? 'es' : ''}
                        </span>
                    </div>
                    <div class="table-container">
                        <table class="prestamos-table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Monto</th>
                                    <th>Interés</th>
                                    <th>Interés a Pagar</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Estado</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                    <th>Diferencia</th>
                                    <th>Cancelar</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${renderLoanRows(grupos[num], userId, num)}
                            </tbody>
                        </table>
                    </div>
                `;

                userContent.appendChild(loanGroup);
            }

            userSection.appendChild(userContent);
            container.appendChild(userSection);
        }
    }

    function renderLoanRows(prestamos, userId, numeroPrestamoGrupo) {
        let rows = '';
        
        prestamos.forEach((p, idx) => {
            const esUltima = (idx === 0);
            const grupoId = `prestamo_${userId}_${numeroPrestamoGrupo}`;
            const isCanceled = p.descripcion === 'cancelado';
            
            rows += `
                <tr ${isCanceled ? 'class="table-secondary"' : ''}>
                    <td>
                        <span class="badge ${esUltima ? 'bg-primary' : 'bg-secondary'}">
                            ${p.item_prestamo}
                        </span>
                    </td>
                    <td class="amount-cell">S/. ${Number(p.monto).toFixed(2)}</td>
                    <td>${p.interes}%</td>
                    <td class="amount-cell">S/. ${Number(p.interes_pagar).toFixed(2)}</td>
                    <td class="date-cell">${formatDate(p.fecha_inicio)}</td>
                    <td class="date-cell">${formatDate(p.fecha_fin)}</td>
                    <td>
                        <span class="status-badge ${getStatusClass(p.estado)}">
                            ${capitalize(p.estado)}
                        </span>
                    </td>
                    <td>${p.descripcion || '-'}</td>
                    <td>${esUltima ? acciones(p.id) : ''}</td>
                    <td>${esUltima ? diferenciaInput(grupoId, p) : checkCancelado(grupoId, p)}</td>
                    <td>${esUltima ? botonCancelar(p.id) : ''}</td>
                </tr>
            `;
        });
        
        return rows;
    }

    function getStatusClass(estado) {
        switch(estado.toLowerCase()) {
            case 'aprobado': return 'status-aprobado';
            case 'pendiente': return 'status-pendiente';
            case 'vencido': return 'status-vencido';
            default: return 'status-aprobado';
        }
    }

    function acciones(id) {
        return `
            <div class="action-buttons">
                <form method="POST" action="/prestamos/${id}/penalidad" onsubmit="return confirm('¿Aplicar penalidad a este préstamo?')">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-exclamation-triangle me-1"></i>Penalidad
                    </button>
                </form>
                <form method="POST" action="/prestamos/${id}/renovar" onsubmit="return confirm('¿Renovar este préstamo?')">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-redo me-1"></i>Renovar
                    </button>
                </form>
            </div>
        `;
    }

    function diferenciaInput(grupoId, p) {
        return `
            <div class="difference-form">
                <form method="POST" action="/prestamos/${p.id}/diferencia" 
                      onsubmit="guardarCancelados('${grupoId}'); return confirm('¿Aplicar esta diferencia?')">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <div class="input-group mb-1">
                        <input type="number" 
                               name="diferencia_monto" 
                               step="0.01" 
                               max="${p.monto}" 
                               oninput="validarMonto(this)" 
                               placeholder="Máx: S/. ${parseFloat(p.monto).toFixed(2)}"
                               class="form-control form-control-sm" required>
                    </div>
                    <input type="hidden" name="grupo" value="${p.numero_prestamo}">
                    <input type="hidden" name="item" value="${p.item_prestamo}">
                    <input type="hidden" name="filas_canceladas" id="cancelados_${grupoId}">
                    <button type="submit" class="btn btn-warning btn-sm w-100">
                        <i class="fas fa-calculator me-1"></i>Aplicar
                    </button>
                </form>
            </div>
        `;
    }

    function checkCancelado(grupoId, p) {
        return `
            <div class="checkbox-cell">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input check-cancelado" 
                           data-grupo="${grupoId}" value="${p.id}" id="check_${p.id}">
                    <label class="form-check-label" for="check_${p.id}">
                        <small>Cancelar</small>
                    </label>
                </div>
            </div>
        `;
    }

    function botonCancelar(id) {
        return `
            <form method="POST" action="/prestamos/${id}/cancelar" 
                  onsubmit="return confirm('¿Estás seguro de cancelar este préstamo completo?')">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="submit" class="btn btn-outline-dark btn-sm">
                    <i class="fas fa-ban me-1"></i>Cancelar
                </button>
            </form>
        `;
    }

    function formatDate(fecha) {
        const date = new Date(fecha);
        return date.toLocaleDateString('es-PE');
    }

    function capitalize(text) {
        return text.charAt(0).toUpperCase() + text.slice(1);
    }

    function guardarCancelados(grupoId) {
        let checkboxes = document.querySelectorAll('.check-cancelado[data-grupo="' + grupoId + '"]');
        let ids = [];

        checkboxes.forEach(cb => {
            if (cb.checked) {
                ids.push(cb.value);
            }
        });

        document.getElementById('cancelados_' + grupoId).value = ids.join(',');
    }
</script>

@if($prestamosSinIniciar->isNotEmpty())
<div class="prestamos-container mt-4">
    <div class="prestamos-header">
        <h4 class="prestamos-title">
            <i class="fas fa-hourglass-start"></i>
            Préstamos Aprobados Sin Iniciar
        </h4>
        <div class="prestamos-controls">
            <span class="badge bg-warning text-dark">
                {{ $prestamosSinIniciar->count() }} préstamo{{ $prestamosSinIniciar->count() > 1 ? 's' : '' }}
            </span>
        </div>
    </div>

    <div class="table-container">
        <table class="prestamos-table">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag me-1"></i>N° Préstamo</th>
                    <th><i class="fas fa-user me-1"></i>Cliente</th>
                    <th><i class="fas fa-calendar-alt me-1"></i>Fecha Inicio</th>
                    <th><i class="fas fa-dollar-sign me-1"></i>Monto (S/.)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prestamosSinIniciar as $prestamo)
                <tr>
                    <td>
                        <span class="badge bg-info">{{ $prestamo->numero_prestamo }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-icon me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                <i class="fas fa-user"></i>
                            </div>
                            {{ $prestamo->user->name }}
                        </div>
                    </td>
                    <td class="date-cell">{{ $prestamo->fecha_inicio->format('d/m/Y') }}</td>
                    <td>
                        <form action="{{ route('admin.prestamos.actualizarMonto', $prestamo->id) }}"
                              method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            @method('PATCH')

                            <div class="input-group" style="max-width: 150px;">
                                <span class="input-group-text">S/.</span>
                                <input type="number" name="monto"
                                       value="{{ $prestamo->monto }}"
                                       class="form-control form-control-sm"
                                       min="0" step="0.01" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save me-1"></i>Guardar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const body = document.body;
        
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
        
        // Prevenir scroll del body cuando el sidebar está abierto en móvil
        if (window.innerWidth <= 768) {
            if (sidebar.classList.contains('show')) {
                body.classList.add('sidebar-open');
            } else {
                body.classList.remove('sidebar-open');
            }
        }
    }

    // Cerrar sidebar al hacer clic en el overlay
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('sidebarOverlay');
        
        overlay.addEventListener('click', function(e) {
            // Solo cerrar si el click es directamente en el overlay
            if (e.target === overlay) {
                toggleSidebar();
            }
        });

        // Cerrar sidebar al hacer clic en un enlace (solo en móvil)
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    toggleSidebar();
                }
            });
        });

        // Manejar cambios de tamaño de ventana
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const body = document.body;
            
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                body.classList.remove('sidebar-open');
            }
        });

        // Prevenir que los clicks en el contenido del sidebar cierren el menú
        const sidebar = document.getElementById('sidebar');
        sidebar.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Limpiar cualquier backdrop de Bootstrap que pueda quedar
        const cleanBootstrapBackdrops = () => {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());
        };

        // Ejecutar limpieza al cargar y cada vez que se redimensiona
        cleanBootstrapBackdrops();
        window.addEventListener('resize', cleanBootstrapBackdrops);
    });
</script>

<script>
    function validarMonto(input) {
        const max = parseFloat(input.max);
        const val = parseFloat(input.value);

        if (val > max) {
            alert('No puedes ingresar una diferencia mayor al monto disponible (S/. ' + max.toFixed(2) + ')');
            input.value = '';
        }
    }
</script>

</body>
</html>
