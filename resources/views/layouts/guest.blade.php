<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TaskFlow') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Vite Assets for HMR / Live Reload -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fc;
            min-height: 100vh;
        }
        .auth-card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
            max-width: 450px;
            width: 100%;
        }
        .auth-logo {
            font-size: 2.2rem;
            font-weight: 800;
            color: #0d6efd;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .auth-logo i {
            margin-right: 12px;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5">

    <div class="d-flex flex-column align-items-center w-100 px-3">
        <!-- Logo -->
        <a href="/" class="auth-logo">
            <i class="fa-solid fa-list-check"></i>
            <span>TaskFlow</span>
        </a>

        <!-- Content Card -->
        <div class="card auth-card">
            <div class="card-body p-4 p-sm-5">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
