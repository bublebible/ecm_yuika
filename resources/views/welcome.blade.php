@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gray-900 pt-16 min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-pink-900 opacity-90 z-0"></div>
    
    <!-- Hero Image Background (Optional, using gradient priority) -->
    <div class="absolute inset-0 z-0">
        {{-- Hero Image can go here if provided, keeping it clean for now --}}
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-white mb-8 drop-shadow-lg">
            Sewa <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-purple-500">Kostum Impianmu</span> <br>
            Wujudkan Fantasimu
        </h1>
        <p class="mt-4 text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
            Platform penyewaan kostum cosplay #1 di Indonesia. Koleksi lengkap dari Anime, Game, hingga Film. Kualitas premium, bersih, dan siap pakai.
        </p>
        <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('user.catalog.index') }}" class="inline-flex items-center justify-center px-10 py-4 border border-transparent text-lg font-bold rounded-full text-white bg-pink-600 hover:bg-pink-700 shadow-lg hover:shadow-pink-500/50 transform hover:-translate-y-1 transition-all duration-300">
                Lihat Katalog
                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
            <a href="#about" class="inline-flex items-center justify-center px-10 py-4 border-2 border-gray-500 text-lg font-bold rounded-full text-gray-300 hover:text-white hover:border-white hover:bg-white/10 transition-all duration-300">
                Tentang Kami
            </a>
        </div>
    </div>
    
    <!-- Floating Shapes (Decoration) -->
    <div class="absolute top-1/4 left-10 w-24 h-24 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute top-1/3 right-10 w-32 h-32 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
</div>

<!-- About Us -->
<div id="about" class="bg-white py-24 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-pink-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative rounded-2xl bg-gray-900 aspect-w-4 aspect-h-3 overflow-hidden shadow-2xl transform transition duration-500 hover:scale-[1.01]">
                      {{-- Image Placeholder --}}
                      <div class="h-full w-full flex items-center justify-center bg-gray-800 text-gray-500">
                          <i class="fas fa-users fa-5x"></i>
                      </div>
                </div>
            </div>
            <div class="mt-12 lg:mt-0">
                <h2 class="text-base text-pink-600 font-semibold tracking-wide uppercase">Tentang Kami</h2>
                <h3 class="mt-2 text-4xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                    Lebih dari Sekadar Kostum
                </h3>
                <p class="mt-6 text-xl text-gray-500 leading-relaxed">
                    ECM Rent Coss hadir untuk memenuhi kebutuhan para cosplayer di Indonesia. Kami tidak hanya menyewakan baju, tapi memberikan **pengalaman**. Setiap detail kostum dirawat dengan hati-hati untuk memastikan Anda tampil sempurna.
                </p>
                <div class="mt-8 grid grid-cols-2 gap-4">
                    <div class="border-l-4 border-pink-500 pl-4">
                        <span class="block text-2xl font-bold text-gray-900">500+</span>
                        <span class="block text-gray-500">Koleksi Kostum</span>
                    </div>
                    <div class="border-l-4 border-purple-500 pl-4">
                        <span class="block text-2xl font-bold text-gray-900">10k+</span>
                        <span class="block text-gray-500">Penyewa Puas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features (Cards with Lift Effect) -->
<div class="bg-gray-50 py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <h2 class="text-base text-purple-600 font-semibold tracking-wide uppercase">Kenapa Kami?</h2>
            <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Standar Baru Rental Kostum
            </p>
        </div>
        <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-3">
             <!-- Feature 1 -->
            <div class="bg-white rounded-2xl shadow-sm p-8 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 border border-gray-100">
                <div class="w-14 h-14 bg-pink-100 text-pink-600 rounded-xl flex items-center justify-center text-2xl mb-6">
                    ✨
                </div>
                <h3 class="text-xl font-bold text-gray-900">Kualitas Premium</h3>
                <p class="mt-4 text-gray-500 leading-relaxed">
                    Bahan kostum nyaman dipakai (cotton, satin, leather), detail akurat sesuai karakter aslinya.
                </p>
            </div>

             <!-- Feature 2 -->
             <div class="bg-white rounded-2xl shadow-sm p-8 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 border border-gray-100">
                <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center text-2xl mb-6">
                    💰
                </div>
                <h3 class="text-xl font-bold text-gray-900">Harga Jujur</h3>
                <p class="mt-4 text-gray-500 leading-relaxed">
                     Harga sewa transparan tanpa biaya tersembunyi. Dapatkan diskon untuk sewa jangka panjang.
                </p>
            </div>

             <!-- Feature 3 -->
             <div class="bg-white rounded-2xl shadow-sm p-8 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 border border-gray-100">
                <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-2xl mb-6">
                    🧼
                </div>
                <h3 class="text-xl font-bold text-gray-900">Hygiene First</h3>
                <p class="mt-4 text-gray-500 leading-relaxed">
                    Setiap kostum melalui proses dry cleaning professional + desinfektan UV sebelum dikirim.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Promo Banner (Modern Gradient) -->
<div class="relative py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-pink-600 to-purple-700 overflow-hidden">
    <div class="absolute inset-0">
         <div class="absolute inset-0 bg-pink-600 mix-blend-multiply opacity-20"></div>
         <div class="absolute -top-24 -left-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl opacity-20 animate-blob"></div>
    </div>
    <div class="relative max-w-7xl mx-auto text-center">
        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
            <span class="block">Siap untuk Cosplay Pertamamu?</span>
            <span class="block text-pink-200 mt-2">Dapatkan potongan 10% khusus pengguna baru.</span>
        </h2>
        <div class="mt-8 flex justify-center">
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-full text-pink-700 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10 shadow-lg hover:shadow-xl transition-all duration-300">
                Daftar & Klaim Diskon
            </a>
        </div>
    </div>
</div>

<!-- Testimonials (Modern Grid) -->
<div class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-16">Community Love 💖</h2>
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
             <!-- Testimonial 1 -->
            <div class="bg-gray-50 rounded-2xl p-8 relative">
                 <div class="absolute -top-5 left-8 w-10 h-10 bg-pink-500 text-white flex items-center justify-center rounded-full text-xl shadow-md">❝</div>
                 <p class="text-gray-600 italic mt-4 mb-6">
                     "Gila sih, kostum Raiden Shogun nya detail banget! Bahannya juga gak bikin gerah pas event seharian. Admin fast respon parah!"
                 </p>
                 <div class="flex items-center">
                     <div class="h-10 w-10 bg-gray-300 rounded-full"></div>
                     <div class="ml-3">
                         <div class="text-sm font-bold text-gray-900">Andi Saputra</div>
                         <div class="text-sm text-gray-500">Cosplayer, Jakarta</div>
                     </div>
                 </div>
            </div>
             <!-- Testimonial 2 -->
             <div class="bg-gray-50 rounded-2xl p-8 relative">
                <div class="absolute -top-5 left-8 w-10 h-10 bg-purple-500 text-white flex items-center justify-center rounded-full text-xl shadow-md">❝</div>
                <p class="text-gray-600 italic mt-4 mb-6">
                    "Packing aman banget, pake box tebel. Kostum wangi laundry. Fix bakal langganan terus disini buat next event."
                </p>
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-gray-300 rounded-full"></div>
                    <div class="ml-3">
                        <div class="text-sm font-bold text-gray-900">Budi Santoso</div>
                        <div class="text-sm text-gray-500">Member, Bandung</div>
                    </div>
                </div>
           </div>
            <!-- Testimonial 3 -->
            <div class="bg-gray-50 rounded-2xl p-8 relative">
                <div class="absolute -top-5 left-8 w-10 h-10 bg-blue-500 text-white flex items-center justify-center rounded-full text-xl shadow-md">❝</div>
                <p class="text-gray-600 italic mt-4 mb-6">
                    "Sewa H-1 event dan masih kebagian! Penyelamat banget ECM Rent Coss. Koleksi Chainsaw Man nya lengkap abis."
                </p>
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-gray-300 rounded-full"></div>
                    <div class="ml-3">
                        <div class="text-sm font-bold text-gray-900">Citra Kirana</div>
                        <div class="text-sm text-gray-500">Student, Surabaya</div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>
@endsection
