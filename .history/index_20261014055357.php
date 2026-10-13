<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi REST API - OnlineShop</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        code, pre { font-family: 'Fira Code', monospace; }
        .hidden-endpoint { display: none !important; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 antialiased selection:bg-indigo-500 selection:text-white">

    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Sidebar Navigation -->
        <aside class="w-full md:w-80 bg-slate-950 border-r border-slate-800 p-6 md:fixed md:h-screen overflow-y-auto flex flex-col justify-between z-20">
            <div>
                <!-- Brand Header -->
                <div class="flex items-center space-x-3 mb-6">
                    <div class="bg-gradient-to-tr from-indigo-600 to-violet-500 text-white p-2.5 rounded-2xl font-bold text-xl shadow-lg shadow-indigo-500/30">🛒</div>
                    <div>
                        <h1 class="text-white font-bold text-lg leading-tight tracking-tight">OnlineShop API</h1>
                        <span class="text-xs text-indigo-400 font-medium">Interactive Documentation</span>
                    </div>
                </div>

                <!-- Live Search Box -->
                <div class="relative mb-6">
                    <input type="text" id="searchEndpoint" placeholder="Cari endpoint (mis: login, produk)..." 
                        class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    <span class="absolute right-3 top-3 text-slate-500 text-xs">🔍</span>
                </div>

                <!-- Navigation Links -->
                <div class="space-y-6 text-sm" id="sidebarNav">
                    <!-- Autentikasi -->
                    <div class="nav-category">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">1. Autentikasi</p>
                        <ul class="space-y-1 pl-2 border-l border-slate-800">
                            <li><a href="#login" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Login</a></li>
                            <li><a href="#register" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Register</a></li>
                            <li><a href="#update-profile" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Update Profile</a></li>
                            <li><a href="#change-password" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Ubah Password</a></li>
                            <li><a href="#logout" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Logout</a></li>
                        </ul>
                    </div>

                    <!-- Produk -->
                    <div class="nav-category">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">2. Manajemen Produk</p>
                        <ul class="space-y-1 pl-2 border-l border-slate-800">
                            <li><a href="#get-products" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Lihat Produk</a></li>
                            <li><a href="#get-products-page" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Produk + Pagination</a></li>
                            <li><a href="#get-product-detail" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Detail Produk</a></li>
                            <li><a href="#search-product" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Cari Produk</a></li>
                            <li><a href="#create-product" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Tambah Produk</a></li>
                            <li><a href="#update-product" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Update Produk</a></li>
                            <li><a href="#delete-product" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Hapus Produk</a></li>
                        </ul>
                    </div>

                    <!-- Keranjang -->
                    <div class="nav-category">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">3. Keranjang Belanja</p>
                        <ul class="space-y-1 pl-2 border-l border-slate-800">
                            <li><a href="#cart-add" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Pesan Produk (Add)</a></li>
                            <li><a href="#cart-index" class="nav-link block py-1.5 px-3 rounded-lg hover:bg-slate-900 hover:text-indigo-400 transition">Lihat Keranjang</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Sidebar -->
            <div class="mt-8 pt-4 border-t border-slate-800/80 text-xs text-slate-500">
                <p class="font-medium text-slate-400">PHP Native & MySQL</p>
                <p class="mt-0.5">Envelope Standard JSON</p>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 md:ml-80 p-6 md:p-12 max-w-5xl">
            
            <!-- Hero Header -->
            <div class="bg-gradient-to-r from-slate-800/80 to-slate-900 border border-slate-800 rounded-3xl p-8 mb-10 shadow-xl backdrop-blur-md">
                <div class="inline-flex items-center space-x-2 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold px-3.5 py-1.5 rounded-full mb-4">
                    <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                    <span>Base URL: http://localhost/OnlineShop/</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-3">OnlineShop REST API</h1>
                <p class="text-slate-400 leading-relaxed text-sm md:text-base max-w-2xl">
                    Dokumentasi teknis backend lengkap untuk integrasi aplikasi mobile (Android/Flutter) maupun web. Mendukung autentikasi berbasis Bearer Token, upload berkas gambar absolut, serta standar Envelope JSON Response.
                </p>
            </div>

            <!-- Endpoint Cards Wrapper -->
            <div class="space-y-8" id="endpointContainer">

                <!-- 1. LOGIN -->
                <section id="login" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="login auth post masuk">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">POST</span>
                            <h2 class="text-lg font-bold text-white">Login User</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/auth/login.php</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Digunakan untuk masuk ke sistem dan mendapatkan token akses unik yang diperlukan untuk endpoint terproteksi.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Request Body (form-data)</h4>
                            <div class="border border-slate-800 rounded-xl overflow-hidden bg-slate-900/50">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-900 text-slate-400 border-b border-slate-800">
                                        <tr><th class="p-3 font-medium">Key</th><th class="p-3 font-medium">Type</th><th class="p-3 font-medium">Value</th></tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800/60 text-slate-300">
                                        <tr><td class="p-3 font-mono text-indigo-400">username</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">admin</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">password</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">admin123</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (200 OK)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Login berhasil",
    "data": {
        "id": 1,
        "username": "admin",
        "email": "admin@shop.com",
        "token": "f9db78bb57605d2692e4be..."
    }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 2. REGISTER -->
                <section id="register" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="register auth post daftar akun">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">POST</span>
                            <h2 class="text-lg font-bold text-white">Register Akun Baru</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/auth/register.php</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Mendaftarkan akun baru ke dalam database sistem.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Request Body (form-data)</h4>
                            <div class="border border-slate-800 rounded-xl overflow-hidden bg-slate-900/50">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-900 text-slate-400 border-b border-slate-800">
                                        <tr><th class="p-3 font-medium">Key</th><th class="p-3 font-medium">Type</th><th class="p-3 font-medium">Value</th></tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800/60 text-slate-300">
                                        <tr><td class="p-3 font-mono text-indigo-400">username</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">nandaadisaputra</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">email</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">nanda@gmail.com</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">alamat</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">Kp.Jempono RT 01</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">no_whatsapp</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">082141730797</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">password</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">12345678</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (201 Created)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 201,
    "message": "Registrasi berhasil",
    "data": {
        "id": 2,
        "username": "nandaadisaputra",
        "email": "nanda@gmail.com"
    }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 3. UPDATE PROFILE -->
                <section id="update-profile" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="update profile auth post ubah profil username password">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">POST</span>
                            <h2 class="text-lg font-bold text-white">Update Profile (Username & Password)</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/auth/update-profile.php</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Memperbarui username dan/atau mengganti password akun. Memerlukan header <code class="text-indigo-400 font-semibold">Authorization: Bearer &lt;token&gt;</code>.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Request Body (form-data)</h4>
                            <div class="border border-slate-800 rounded-xl overflow-hidden bg-slate-900/50">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-900 text-slate-400 border-b border-slate-800">
                                        <tr><th class="p-3 font-medium">Key</th><th class="p-3 font-medium">Type</th><th class="p-3 font-medium">Value</th></tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800/60 text-slate-300">
                                        <tr><td class="p-3 font-mono text-indigo-400">username</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">nanda (Baru)</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">old_password</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">123456789 (Opsional)</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">new_password</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">123456 (Opsional)</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (200 OK)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Profil berhasil diperbarui.",
    "data": {
        "id": 2,
        "username": "nanda",
        "email": "nanda@gmail.com"
    }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 4. UBAH PASSWORD -->
                <section id="change-password" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="change password auth post ubah sandi">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">POST</span>
                            <h2 class="text-lg font-bold text-white">Ubah Password Saja</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/auth/change-password.php</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Mengganti password akun secara spesifik dengan verifikasi password lama. Memerlukan header <code class="text-indigo-400 font-semibold">Bearer Token</code>.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Request Body (form-data)</h4>
                            <div class="border border-slate-800 rounded-xl overflow-hidden bg-slate-900/50">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-900 text-slate-400 border-b border-slate-800">
                                        <tr><th class="p-3 font-medium">Key</th><th class="p-3 font-medium">Type</th><th class="p-3 font-medium">Value</th></tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800/60 text-slate-300">
                                        <tr><td class="p-3 font-mono text-indigo-400">old_password</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">12345678</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">new_password</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">123456789</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (200 OK)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Password berhasil diperbarui.",
    "data": {
        "id": 2,
        "username": "nanda",
        "email": "nanda@gmail.com"
    }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 5. LOGOUT -->
                <section id="logout" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="logout auth post keluar sesi">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">POST</span>
                            <h2 class="text-lg font-bold text-white">Logout</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/auth/logout.php</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Mengosongkan token di database untuk mengakhiri sesi aktif user. Memerlukan header <code class="text-indigo-400 font-semibold">Bearer Token</code>.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Keterangan</h4>
                            <p class="text-sm text-slate-300 mb-2">Kirim request dengan Header <code class="text-indigo-400 font-mono">Authorization: Bearer &lt;token&gt;</code>.</p>
                            <p class="text-xs text-slate-500">Body request: Tidak ada (None)</p>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (200 OK)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Logout berhasil. Sesi telah diakhiri.",
    "data": null
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 6. LIHAT PRODUCT -->
                <section id="get-products" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="get products product index lihat produk">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-sky-500/10 border border-sky-500/20 text-sky-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">GET</span>
                            <h2 class="text-lg font-bold text-white">Lihat Semua Produk</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/products/index.php</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Mengambil seluruh daftar produk yang tersimpan di database secara lengkap. Memerlukan header <code class="text-indigo-400 font-semibold">Bearer Token</code>.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Parameter</h4>
                            <p class="text-sm text-slate-300 italic">Tanpa parameter URL (menampilkan semua data).</p>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (200 OK)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Berhasil memuat data produk",
    "data": [
        {
            "id": 1,
            "nama_product": "Cardinal Sneakers Baru",
            "harga": "350000",
            "deskripsi": "Deskripsi sepatu...",
            "gambar": "http://localhost/OnlineShop/uploads/..."
        }
    ]
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 7. LIHAT PRODUCT WITH PAGINATION -->
                <section id="get-products-page" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="get products pagination limit page">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-sky-500/10 border border-sky-500/20 text-sky-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">GET</span>
                            <h2 class="text-lg font-bold text-white">Lihat Produk dengan Pagination</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/products/index.php?page=1&limit=5</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Mengambil daftar produk dengan pembatasan halaman dan jumlah data per halaman.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Query Parameters</h4>
                            <div class="border border-slate-800 rounded-xl overflow-hidden bg-slate-900/50">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-900 text-slate-400 border-b border-slate-800">
                                        <tr><th class="p-3 font-medium">Key</th><th class="p-3 font-medium">Value</th></tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800/60 text-slate-300">
                                        <tr><td class="p-3 font-mono text-indigo-400">page</td><td class="p-3">1</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">limit</td><td class="p-3">5</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (200 OK)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Berhasil memuat data produk",
    "data": {
        "current_page": 1,
        "limit": 5,
        "total_data": 12,
        "total_pages": 3,
        "products": [ ... ]
    }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 8. DETAIL PRODUCT -->
                <section id="get-product-detail" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="get product detail id">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-sky-500/10 border border-sky-500/20 text-sky-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">GET</span>
                            <h2 class="text-lg font-bold text-white">Lihat Detail Produk</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/products/detail.php?id=1</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Menampilkan informasi lengkap satu produk tertentu berdasarkan parameter ID.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Query Parameters</h4>
                            <p class="text-sm text-slate-300"><code class="text-indigo-400 font-mono">id</code> = 1 (ID Produk)</p>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (200 OK)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Detail produk ditemukan",
    "data": {
        "id": 1,
        "nama_product": "Cardinal Sneakers Baru",
        "harga": "350000",
        "deskripsi": "Deskripsi sepatu...",
        "gambar": "http://localhost/OnlineShop/uploads/..."
    }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 9. SEARCH PRODUCT -->
                <section id="search-product" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="get search product cari">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-sky-500/10 border border-sky-500/20 text-sky-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">GET</span>
                            <h2 class="text-lg font-bold text-white">Cari Produk</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/products/search.php?q=Sepatu</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Mencari produk berdasarkan nama atau deskripsi menggunakan keyword parameter <code class="text-indigo-400">q</code>.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Query Parameters</h4>
                            <p class="text-sm text-slate-300"><code class="text-indigo-400 font-mono">q</code> = Sepatu (Kata kunci)</p>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (200 OK)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Pencarian produk berhasil",
    "data": {
        "keyword": "Sepatu",
        "total_found": 2,
        "products": [ ... ]
    }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 10. TAMBAH PRODUCT -->
                <section id="create-product" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="post create product tambah produk upload gambar">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">POST</span>
                            <h2 class="text-lg font-bold text-white">Tambah Produk Baru</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/products/create.php</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Menambahkan produk baru lengkap dengan unggah file gambar (`multipart/form-data`). Memerlukan <code class="text-indigo-400">Bearer Token</code>.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Request Body (form-data)</h4>
                            <div class="border border-slate-800 rounded-xl overflow-hidden bg-slate-900/50">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-900 text-slate-400 border-b border-slate-800">
                                        <tr><th class="p-3 font-medium">Key</th><th class="p-3 font-medium">Type</th><th class="p-3 font-medium">Value</th></tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800/60 text-slate-300">
                                        <tr><td class="p-3 font-mono text-indigo-400">nama_product</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">Cardinal Sneakers</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">harga</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">350000</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">deskripsi</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">Deskripsi sepatu...</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">gambar</td><td class="p-3 text-slate-500 text-xs">file</td><td class="p-3">sepatu.jpg</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (201 Created)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 201,
    "message": "Produk berhasil ditambahkan.",
    "data": {
        "id": 3,
        "nama_product": "Cardinal Sneakers",
        "harga": "350000",
        "deskripsi": "Deskripsi sepatu...",
        "gambar": "http://localhost/OnlineShop/uploads/..."
    }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 11. UPDATE PRODUCT -->
                <section id="update-product" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="put update product edit ubah produk">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-amber-500/10 border border-amber-500/20 text-amber-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">PUT</span>
                            <h2 class="text-lg font-bold text-white">Update Produk</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/products/update.php</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Memperbarui data produk dengan dukungan method PUT / form-data. Memerlukan <code class="text-indigo-400">Bearer Token</code>.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Request Body (form-data)</h4>
                            <div class="border border-slate-800 rounded-xl overflow-hidden bg-slate-900/50">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-900 text-slate-400 border-b border-slate-800">
                                        <tr><th class="p-3 font-medium">Key</th><th class="p-3 font-medium">Type</th><th class="p-3 font-medium">Value</th></tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800/60 text-slate-300">
                                        <tr><td class="p-3 font-mono text-indigo-400">id</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">3</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">nama_product</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">Sepatu Kuning</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">harga</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">450000</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">deskripsi</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">Sepatu baru</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">gambar</td><td class="p-3 text-slate-500 text-xs">file</td><td class="p-3">(Opsional) Ganti foto</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (200 OK)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Produk berhasil diperbarui.",
    "data": {
        "id": 3,
        "nama_product": "Sepatu Kuning",
        "harga": "450000",
        "deskripsi": "Sepatu baru",
        "gambar": "http://localhost/OnlineShop/uploads/..."
    }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 12. DELETE PRODUCT -->
                <section id="delete-product" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="delete product hapus">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-rose-500/10 border border-rose-500/20 text-rose-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">DELETE</span>
                            <h2 class="text-lg font-bold text-white">Hapus Produk</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/products/delete.php?id=1</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Menghapus data produk beserta berkas gambar fisik dari server. Memerlukan <code class="text-indigo-400">Bearer Token</code>.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Query Parameters</h4>
                            <p class="text-sm text-slate-300"><code class="text-indigo-400 font-mono">id</code> = 1 (ID Produk target)</p>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (200 OK)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Produk berhasil dihapus.",
    "data": {
        "id": 1
    }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 13. PESAN PRODUCT (CART ADD) -->
                <section id="cart-add" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="cart add pesan product keranjang belanja post">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">POST</span>
                            <h2 class="text-lg font-bold text-white">Pesan Produk (Tambah ke Keranjang)</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/cart/add.php</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Memasukkan produk pilihan ke dalam tabel keranjang belanja milik user. Memerlukan <code class="text-indigo-400">Bearer Token</code>.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Request Body (form-data)</h4>
                            <div class="border border-slate-800 rounded-xl overflow-hidden bg-slate-900/50">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-900 text-slate-400 border-b border-slate-800">
                                        <tr><th class="p-3 font-medium">Key</th><th class="p-3 font-medium">Type</th><th class="p-3 font-medium">Value</th></tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800/60 text-slate-300">
                                        <tr><td class="p-3 font-mono text-indigo-400">product_id</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">2</td></tr>
                                        <tr><td class="p-3 font-mono text-indigo-400">quantity</td><td class="p-3 text-slate-500 text-xs">text</td><td class="p-3">2 (Opsional)</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (201 Created)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 201,
    "message": "Produk berhasil ditambahkan ke keranjang.",
    "data": {
        "cart_id": 5,
        "quantity": 2,
        "product_id": 2,
        "nama_product": "Sepatu Kuning",
        "harga": 450000,
        "total_harga": 900000
    }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 14. LIHAT KERANJANG -->
                <section id="cart-index" class="endpoint-card bg-slate-950/60 border border-slate-800 rounded-2xl p-6 shadow-sm hover:border-slate-700 transition" data-keywords="cart index lihat keranjang pesanan recyclerview get">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="bg-sky-500/10 border border-sky-500/20 text-sky-400 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">GET</span>
                            <h2 class="text-lg font-bold text-white">Lihat Daftar Keranjang (RecyclerView Data)</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-mono bg-slate-900 px-3 py-1 rounded-lg border border-slate-800">/cart/index.php</span>
                    </div>
                    <p class="text-sm text-slate-400 mb-6">Menampilkan seluruh item keranjang belanja milik user berdasarkan token akses aktif. Cocok dipetakan ke RecyclerView/ListView. Memerlukan <code class="text-indigo-400">Bearer Token</code>.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Headers</h4>
                            <p class="text-sm text-slate-300">Authorization: Bearer &lt;token&gt;</p>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Response (200 OK)</h4>
                                <button onclick="copyCode(this)" class="text-xs text-indigo-400 hover:text-indigo-300 transition flex items-center space-x-1">📋 <span>Copy JSON</span></button>
                            </div>
                            <pre class="code-block bg-slate-900 border border-slate-800 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Berhasil memuat daftar keranjang belanja.",
    "data": {
        "user_id": 1,
        "total_items": 2,
        "grand_total": 800000,
        "items": [
            {
                "cart_id": 5,
                "product_id": 2,
                "nama_product": "Sepatu Kuning",
                "harga": 450000,
                "quantity": 1,
                "subtotal": 450000,
                "gambar": "http://localhost/OnlineShop/uploads/..."
            }
        ]
    }
}</code></pre>
                        </div>
                    </div>
                </section>

            </div>

            <!-- Footer -->
            <footer class="mt-16 text-center text-xs text-slate-500 border-t border-slate-800/80 pt-6">
                <p>&copy; 2026 OnlineShop Backend API. All rights reserved.</p>
            </footer>

        </main>
    </div>

    <!-- JavaScript untuk Interaktivitas Live Search & Copy Button -->
    <script>
        // Live Search / Filter Endpoint
        const searchInput = document.getElementById('searchEndpoint');
        const endpointCards = document.querySelectorAll('.endpoint-card');

        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            
            endpointCards.forEach(card => {
                const keywords = card.getAttribute('data-keywords') || '';
                const textContent = card.innerText.toLowerCase();
                
                if (keywords.includes(query) || textContent.includes(query)) {
                    card.classList.remove('hidden-endpoint');
                } else {
                    card.classList.add('hidden-endpoint');
                }
            });
        });

        // Function Copy JSON Code Snippet
        function copyCode(button) {
            const preElement = button.parentElement.nextElementSibling;
            const codeText = preElement.querySelector('code').innerText;

            navigator.clipboard.writeText(codeText).then(() => {
                const originalHTML = button.innerHTML;
                button.innerHTML = "✅ <span class='text-emerald-400'>Copied!</span>";
                button.classList.add('font-semibold');

                setTimeout(() => {
                    button.innerHTML = originalHTML;
                    button.classList.remove('font-semibold');
                }, 2000);
            }).catch(err => {
                alert('Gagal menyalin teks.');
            });
        }
    </script>
</body>
</html>