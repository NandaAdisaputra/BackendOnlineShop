<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi REST API - OnlineShop</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        code,
        pre {
            font-family: 'Fira Code', monospace;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- Sidebar Navigation -->
        <aside
            class="w-full md:w-72 bg-slate-900 text-slate-300 p-6 md:fixed md:h-screen overflow-y-auto flex flex-col justify-between">
            <div>
                <div class="flex items-center space-x-3 mb-8">
                    <div class="bg-indigo-600 text-white p-2 rounded-xl font-bold text-xl">🛒</div>
                    <div>
                        <h1 class="text-white font-bold text-lg leading-tight">OnlineShop API</h1>
                        <span class="text-xs text-indigo-400 font-medium">v1.0.0 Documentation</span>
                    </div>
                </div>

                <div class="space-y-6 text-sm">
                    <!-- Autentikasi -->
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">1. Autentikasi</p>
                        <ul class="space-y-1 pl-2 border-l border-slate-800">
                            <li><a href="#login"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Login</a>
                            </li>
                            <li><a href="#register"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Register</a>
                            </li>
                            <li><a href="#update-profile"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Update
                                    Profile</a></li>
                            <li><a href="#change-password"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Ubah
                                    Password</a></li>
                            <li><a href="#logout"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Logout</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Produk -->
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">2. Manajemen
                            Produk</p>
                        <ul class="space-y-1 pl-2 border-l border-slate-800">
                            <li><a href="#get-products"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Lihat
                                    Produk</a></li>
                            <li><a href="#get-products-page"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Produk
                                    + Pagination</a></li>
                            <li><a href="#get-product-detail"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Detail
                                    Produk</a></li>
                            <li><a href="#search-product"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Cari
                                    Produk</a></li>
                            <li><a href="#create-product"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Tambah
                                    Produk</a></li>
                            <li><a href="#update-product"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Update
                                    Produk</a></li>
                            <li><a href="#delete-product"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Hapus
                                    Produk</a></li>
                        </ul>
                    </div>

                    <!-- Keranjang -->
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">3. Keranjang
                            Belanja</p>
                        <ul class="space-y-1 pl-2 border-l border-slate-800">
                            <li><a href="#cart-add"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Pesan
                                    Produk (Add)</a></li>
                            <li><a href="#cart-index"
                                    class="block py-1 px-2 rounded hover:bg-slate-800 hover:text-white transition">Lihat
                                    Keranjang</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-4 border-t border-slate-800 text-xs text-slate-500">
                <p>PHP Native & MySQL REST API</p>
                <p class="mt-1">Standard Envelope JSON Response</p>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 md:ml-72 p-6 md:p-12 max-w-5xl">

            <!-- Header Section -->
            <div class="bg-white border border-slate-200 rounded-2xl p-8 mb-10 shadow-sm">
                <div
                    class="inline-block bg-indigo-50 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">
                    Base URL: http://localhost/OnlineShop/</div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight mb-3">Dokumentasi API OnlineShop</h1>
                <p class="text-slate-600 leading-relaxed">
                    Panduan integrasi backend REST API murni menggunakan PHP Native dan MySQL tanpa framework[cite: 3].
                    Seluruh endpoint dilindungi menggunakan header <code
                        class="bg-slate-100 text-indigo-600 px-1.5 py-0.5 rounded text-sm font-semibold">Authorization: Bearer &lt;token&gt;</code>
                    kecuali untuk proses Register dan Login[cite: 3].
                </p>
            </div>

            <!-- Endpoint List -->
            <div class="space-y-12">

                <!-- 1. LOGIN -->
                <section id="login" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-emerald-100 text-emerald-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">POST</span>
                            <h2 class="text-lg font-bold text-slate-900">Login User</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/auth/login.php</span>[cite: 3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Digunakan untuk masuk ke sistem dan mendapatkan token akses
                        unik.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Request Body (form-data)
                            </h4>
                            <table class="w-full text-left text-sm border border-slate-100 rounded-lg overflow-hidden">
                                <thead class="bg-slate-50 text-slate-600 border-b border-slate-100">
                                    <tr>
                                        <th class="p-2.5">Key</th>
                                        <th class="p-2.5">Type</th>
                                        <th class="p-2.5">Value (Contoh)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-600">
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">username</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">admin[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">password</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">admin123[cite: 3]</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (200 OK)
                            </h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
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
                <section id="register" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-emerald-100 text-emerald-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">POST</span>
                            <h2 class="text-lg font-bold text-slate-900">Register Akun Baru</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/auth/register.php</span>[cite: 3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Mendaftarkan akun baru ke dalam database sistem.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Request Body (form-data)
                            </h4>
                            <table class="w-full text-left text-sm border border-slate-100 rounded-lg overflow-hidden">
                                <thead class="bg-slate-50 text-slate-600 border-b border-slate-100">
                                    <tr>
                                        <th class="p-2.5">Key</th>
                                        <th class="p-2.5">Type</th>
                                        <th class="p-2.5">Value (Contoh)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-600">
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">username</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">nandaadisaputra[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">email</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">nandaadisaputra18@gmail.com[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">alamat</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">Kp.Jempono RT 01 RW 01[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">no_whatsapp</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">082141730797[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">password</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">12345678[cite: 3]</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (201
                                Created)</h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 201,
    "message": "Registrasi berhasil",
    "data": { ... }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 3. UPDATE PROFILE -->
                <section id="update-profile" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-emerald-100 text-emerald-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">POST</span>
                            <h2 class="text-lg font-bold text-slate-900">Update Profile (Username & Password)</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/auth/update-profile.php</span>[cite: 3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Memperbarui informasi username dan/atau mengganti password
                        akun[cite: 3]. Memerlukan <code class="text-indigo-600">Bearer Token</code>.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Request Body (form-data)
                            </h4>
                            <table class="w-full text-left text-sm border border-slate-100 rounded-lg overflow-hidden">
                                <thead class="bg-slate-50 text-slate-600 border-b border-slate-100">
                                    <tr>
                                        <th class="p-2.5">Key</th>
                                        <th class="p-2.5">Type</th>
                                        <th class="p-2.5">Value (Contoh)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-600">
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">username</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">nanda[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">old_password</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">123456789 (Opsional)[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">new_password</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">123456 (Opsional)[cite: 3]</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (200 OK)
                            </h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Profil berhasil diperbarui.",
    "data": { ... }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 4. UBAH PASSWORD -->
                <section id="change-password" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-emerald-100 text-emerald-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">POST</span>
                            <h2 class="text-lg font-bold text-slate-900">Ubah Password Saja</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/auth/change-password.php</span>[cite: 3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Mengganti password akun dengan verifikasi password lama[cite:
                        3]. Memerlukan <code class="text-indigo-600">Bearer Token</code>.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Request Body (form-data)
                            </h4>
                            <table class="w-full text-left text-sm border border-slate-100 rounded-lg overflow-hidden">
                                <thead class="bg-slate-50 text-slate-600 border-b border-slate-100">
                                    <tr>
                                        <th class="p-2.5">Key</th>
                                        <th class="p-2.5">Type</th>
                                        <th class="p-2.5">Value (Contoh)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-600">
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">old_password</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">12345678[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">new_password</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">123456789[cite: 3]</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (200 OK)
                            </h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Password berhasil diperbarui.",
    "data": { ... }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 5. LOGOUT -->
                <section id="logout" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-emerald-100 text-emerald-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">POST</span>
                            <h2 class="text-lg font-bold text-slate-900">Logout</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/auth/logout.php</span>[cite: 3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Mengosongkan token di database untuk mengakhiri sesi login
                        pengguna[cite: 3].</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Headers</h4>
                            <p class="text-sm text-slate-600 mb-2">Authorization: Bearer &lt;token&gt;[cite: 3]</p>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Request Body</h4>
                            <p class="text-sm text-slate-600 italic">Tidak ada (None)</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (200 OK)
                            </h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Logout berhasil. Sesi telah diakhiri.",
    "data": null
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 6. LIHAT PRODUCT -->
                <section id="get-products" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-sky-100 text-sky-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">GET</span>
                            <h2 class="text-lg font-bold text-slate-900">Lihat Semua Produk</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/products/index.php</span>[cite: 3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Mengambil seluruh daftar produk yang tersedia di
                        database[cite: 3]. Memerlukan <code class="text-indigo-600">Bearer Token</code>.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Parameters</h4>
                            <p class="text-sm text-slate-600 italic">Tanpa parameter URL (menampilkan semua data).</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (200 OK)
                            </h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Berhasil memuat data produk",
    "data": [ ... ]
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 7. LIHAT PRODUCT WITH PAGINATION -->
                <section id="get-products-page" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-sky-100 text-sky-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">GET</span>
                            <h2 class="text-lg font-bold text-slate-900">Lihat Produk dengan Pagination</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/products/index.php?page=1&limit=5</span>[cite:
                        3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Mengambil daftar produk dengan pembatasan halaman dan jumlah
                        data per halaman[cite: 3].</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Query Parameters</h4>
                            <table class="w-full text-left text-sm border border-slate-100 rounded-lg overflow-hidden">
                                <thead class="bg-slate-50 text-slate-600 border-b border-slate-100">
                                    <tr>
                                        <th class="p-2.5">Key</th>
                                        <th class="p-2.5">Value (Contoh)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-600">
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">page</td>
                                        <td class="p-2.5">1[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">limit</td>
                                        <td class="p-2.5">5[cite: 3]</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (200 OK)
                            </h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
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
                <section id="get-product-detail" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-sky-100 text-sky-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">GET</span>
                            <h2 class="text-lg font-bold text-slate-900">Lihat Detail Produk</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/products/detail.php?id=1</span>[cite: 3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Menampilkan informasi lengkap satu produk berdasarkan
                        ID[cite: 3].</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Query Parameters</h4>
                            <p class="text-sm text-slate-600 mb-2"><code class="text-indigo-600 font-mono">id</code> = 1
                                (ID Produk)[cite: 3]</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (200 OK)
                            </h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Detail produk ditemukan",
    "data": {
        "id": 1,
        "nama_product": "Cardinal Sneakers Baru",
        "harga": 350000,
        "deskripsi": "Deskripsi sepatu...",
        "gambar": "http://localhost/OnlineShop/uploads/..."
    }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 9. SEARCH PRODUCT -->
                <section id="search-product" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-sky-100 text-sky-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">GET</span>
                            <h2 class="text-lg font-bold text-slate-900">Cari Produk</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/products/search.php?q=Sepatu</span>[cite: 3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Mencari produk berdasarkan nama atau deskripsi menggunakan
                        keyword[cite: 3].</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Query Parameters</h4>
                            <p class="text-sm text-slate-600 mb-2"><code class="text-indigo-600 font-mono">q</code> =
                                Sepatu (Kata kunci pencarian)[cite: 3]</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (200 OK)
                            </h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
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
                <section id="create-product" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-emerald-100 text-emerald-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">POST</span>
                            <h2 class="text-lg font-bold text-slate-900">Tambah Produk Baru</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/products/create.php</span>[cite: 3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Menambahkan produk baru lengkap dengan unggah file
                        gambar[cite: 3].</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Request Body (form-data)
                            </h4>
                            <table class="w-full text-left text-sm border border-slate-100 rounded-lg overflow-hidden">
                                <thead class="bg-slate-50 text-slate-600 border-b border-slate-100">
                                    <tr>
                                        <th class="p-2.5">Key</th>
                                        <th class="p-2.5">Type</th>
                                        <th class="p-2.5">Value (Contoh)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-600">
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">nama_product</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">Cardinal Sneakers Baru[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">harga</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">350000[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">deskripsi</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">Deskripsi sepatu baru...[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">gambar</td>
                                        <td class="p-2.5">file</td>
                                        <td class="p-2.5">sepatu cardinal.jpg[cite: 3]</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (201
                                Created)</h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 201,
    "message": "Produk berhasil ditambahkan.",
    "data": { ... }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 11. UPDATE PRODUCT -->
                <section id="update-product" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-amber-100 text-amber-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">PUT</span>
                            <h2 class="text-lg font-bold text-slate-900">Update Produk</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/products/update.php</span>[cite: 3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Memperbarui data produk (mendukung pengiriman form-data
                        dengan method PUT)[cite: 3].</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Request Body (form-data /
                                PUT)</h4>
                            <table class="w-full text-left text-sm border border-slate-100 rounded-lg overflow-hidden">
                                <thead class="bg-slate-50 text-slate-600 border-b border-slate-100">
                                    <tr>
                                        <th class="p-2.5">Key</th>
                                        <th class="p-2.5">Type</th>
                                        <th class="p-2.5">Value (Contoh)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-600">
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">id</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">3[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">nama_product</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">Sepatu Kuning[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">harga</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">50000[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">deskripsi</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">Sepatu baru[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">gambar</td>
                                        <td class="p-2.5">file/text</td>
                                        <td class="p-2.5">(Opsional) Ganti foto[cite: 3]</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (200 OK)
                            </h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Produk berhasil diperbarui.",
    "data": { ... }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 12. DELETE PRODUCT -->
                <section id="delete-product" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-rose-100 text-rose-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">DELETE</span>
                            <h2 class="text-lg font-bold text-slate-900">Hapus Produk</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/products/delete.php?id=1</span>[cite: 3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Menghapus data produk beserta file gambar fisiknya dari
                        server[cite: 3].</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Query Parameters</h4>
                            <p class="text-sm text-slate-600 mb-2"><code class="text-indigo-600 font-mono">id</code> = 1
                                (ID Produk yang dihapus)[cite: 3]</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (200 OK)
                            </h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Produk berhasil dihapus.",
    "data": { "id": 1 }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 13. PESAN PRODUCT (CART ADD) -->
                <section id="cart-add" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-emerald-100 text-emerald-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">POST</span>
                            <h2 class="text-lg font-bold text-slate-900">Pesan Produk (Tambah ke Keranjang)</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/cart/add.php</span>[cite: 3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Memasukkan produk pilihan ke dalam tabel keranjang belanja
                        user[cite: 3].</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Request Body (form-data)
                            </h4>
                            <table class="w-full text-left text-sm border border-slate-100 rounded-lg overflow-hidden">
                                <thead class="bg-slate-50 text-slate-600 border-b border-slate-100">
                                    <tr>
                                        <th class="p-2.5">Key</th>
                                        <th class="p-2.5">Type</th>
                                        <th class="p-2.5">Value (Contoh)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-600">
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">product_id</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">2[cite: 3]</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2.5 font-mono text-indigo-600">quantity</td>
                                        <td class="p-2.5">text</td>
                                        <td class="p-2.5">2[cite: 3]</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (201
                                Created)</h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 201,
    "message": "Produk berhasil ditambahkan ke keranjang.",
    "data": { ... }
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 14. LIHAT KERANJANG -->
                <section id="cart-index" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div class="flex items-center space-x-3">
                            <span
                                class="bg-sky-100 text-sky-800 font-bold px-3 py-1 rounded-lg text-xs uppercase">GET</span>
                            <h2 class="text-lg font-bold text-slate-900">Lihat Daftar Keranjang (RecyclerView Data)</h2>
                        </div>
                        <span class="text-xs text-slate-500 font-mono">/cart/index.php</span>[cite: 3]
                    </div>
                    <p class="text-sm text-slate-600 mb-4">Menampilkan daftar item pesanan di keranjang belanja milik
                        user yang sedang aktif berdasarkan token[cite: 3].</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Headers</h4>
                            <p class="text-sm text-slate-600 mb-2">Authorization: Bearer &lt;token&gt;[cite: 3]</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold uppercase text-slate-400 mb-2">Response Example (200 OK)
                            </h4>
                            <pre class="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto"><code>{
    "status": true,
    "code": 200,
    "message": "Berhasil memuat daftar keranjang belanja.",
    "data": {
        "user_id": 1,
        "total_items": 2,
        "grand_total": 800000,
        "items": [ ... ]
    }
}</code></pre>
                        </div>
                    </div>
                </section>

            </div>

            <!-- Footer -->
            <footer class="mt-16 text-center text-xs text-slate-400 border-t border-slate-200 pt-6">
                <p>&copy; 2026 OnlineShop Backend API. All rights reserved.</p>
            </footer>

        </main>
    </div>

</body>

</html>