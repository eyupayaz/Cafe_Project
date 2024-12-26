<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kafe Menü Sistemi')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        main {
            flex: 1; /* Sayfa içeriğini footer'dan ayırır ve kalan alanı doldurur */
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="container-fluid px-4 py-2">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Sol Taraf - Kafe Menü Sistemi Başlık ve Menü Butonları -->
                <div class="d-flex align-items-center">
                    <h1 class="h4 mb-0 me-4"><a href = "/">kafem.com</a></h1>
                    <ul class="d-flex mb-0">
                        <li class="nav-item me-3">
                            <a href="/" class="nav-link text-blue-500">Ana Sayfa</a>
                        </li>
                        <li class="nav-item me-3">
                            <a href="/hakkımızda" class="nav-link text-blue-500">Hakkında</a>
                        </li>
                        <li class="nav-item me-3">
                            <a href="/iletisim" class="nav-link text-blue-500">İletişim</a>
                        </li>
                    </ul>
                </div>

                <!-- Sağ Taraf - Giriş Butonu -->
                <div>
                    <a href="/giris" class="btn btn-primary">Giriş</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4">
        <p>&copy; 2024 Eterna Teknoloji. Tüm Hakları Saklıdır.</p>
    </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
