<x-app-layout>
    <div class="min-h-screen bg-pink-100 font-sans text-gray-900 overflow-x-hidden">

        <!-- CONTENT AREA (Persis Gambar) -->
        <div class="max-w-7xl mx-auto py-12 px-6 sm:px-8 lg:px-12">


            <!-- About & Vision Section with Character (Anya Di Tengah, Besar, Setengah Badan) -->
            <!-- MENUHIN BINGKAI: mt dilebihkan untuk ruang kepala mencuat, overflow-visible -->
            <!-- PERUBAHAN: Gedein dikit layout kotaknya dengan h-96 (dari h-80) dan py-20 (dari pt-16 pb-0) -->
            <div class="relative bg-pink-200 mt-40 rounded-3xl py-20 px-12 flex items-center justify-between overflow-visible shadow-xl h-96 mb-20 border-4 border-white">
                
                <!-- About Yuika Rentcos Text (Kiri, relative z-10) -->
                <!-- PERUBAHAN: pr-32 (dari pr-24) untuk memberi jarak lebih ke gambar -->
                <div class="flex-1 text-left relative z-10 pr-32 pb-12">
                    <h2 class="text-5xl font-extrabold text-black leading-tight">About <span class="text-pink-600">Yuika Rentcos</span></h2>
                    <p class="mt-4 text-white text-lg opacity-95">Yuika Rentcos is a premium costume rental service born from the vibrant world of creativity and fandom. Established in 2024, we specialize in providing high-quality cosplay gear for enthusiasts who want to bring their favorite characters to life.</p>
                </div>

                <!-- Foto Karakter (Anya) - SETENGAH BADAN, TENGAH, BESAR, KELUAR ATAS -->
                <!-- PERUBAHAN UTAMA: 
                     - top-[-50%] diangkat lebih tinggi agar pas dengan kotak yang lebih besar dan kepala tetap mencuat.
                     - h-[150%] diperbesar ukurannya sesuai proporsi kotak baru.
                     - object-center memastikan bagian wajah/tubuh atas tetap terlihat di tengah pemotongan.
                -->
                <img src="{{ asset('storage/conditions/aboutanya.png') }}" 
                     alt="about anya" 
                     class="absolute top-[-50%] left-1/2 -translate-x-1/2 h-[150%] w-auto object-cover object-center z-20">

                <!-- Our Vision Text (Kanan, relative z-10) -->
                <!-- PERUBAHAN: pl-32 (dari pl-24) untuk memberi jarak lebih ke gambar -->
                <div class="flex-1 text-right relative z-10 pl-32 pb-12">
                    <h2 class="text-5xl font-extrabold text-black leading-tight pr-6">Our <span class="text-pink-600">Vision</span></h2>
                    <p class="mt-4 text-black text-lg opacity-95">To become a leading hub for the cosplay community where creativity knows no bounds. We aim to empower every individual to step into the spotlight and express themselves with confidence.</p>
                </div>
            </div>

            <!-- Our Story Section (Tetap Sama) -->
            <div class="mb-20">
                <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
                    <div class="text-left pr-6">
                        <h2 class="text-4xl font-extrabold text-pink-600 sm:text-5xl">Our Story</h2>
                        <p class="mt-6 text-xl text-gray-700 leading-relaxed">
                            The story of Yuika Rentcos began when Friena Sellisya Saputri, then a freshman university student, decided to transform her deep-rooted passion for cosplay into a meaningful business. What started as a personal hobby evolved into a mission to make cosplay more accessible, affordable, and professional for everyone. As a student entrepreneur and a cosplayer herself, Friena understands the dedication it takes to portray a character. He founded Yuika Rentcos to bridge the gap between high-end costume quality and the budget-conscious needs of the local community.
                        </p>
                    </div>
                    <!-- Foto Studio/Cosplay (Dipepetkan ke kanan bingkai) -->
                    <div class="mt-12 lg:mt-0 relative overflow-hidden flex items-end h-96">
                         <img src="{{ asset('storage/conditions/AYAKA.jpg') }}" 
                              alt="Our Studio" 
                              class="relative rounded-3xl shadow-xl w-full h-full object-cover z-10 group-hover:scale-105 transition-transform duration-300">
                    </div>
                </div>
            </div>

            <!-- Why Choose Us Section (Tetap Sama) -->
            <div class="py-16 mb-20 bg-pink-50 rounded-3xl shadow-inner px-12">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-extrabold text-black sm:text-5xl sm:tracking-tight lg:text-6xl">Why <span class="text-pink-600">Choose Us?</span></h2>
                </div>
                
                <div class="grid grid-cols-1 gap-12 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Curated Collections -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg group hover:shadow-2xl transition border border-pink-100 overflow-hidden relative">
                        <div class="flex items-center justify-center p-4 bg-pink-500 rounded-md shadow-lg mb-6 w-16 h-16 mx-auto">
                            <i class="fas fa-heart text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-pink-600 tracking-tight text-center mb-4">Curated Collections</h3>
                        <p class="text-lg text-gray-700 text-center leading-relaxed">
                            Every costume is handpicked and maintained with the highest standards of cleanliness and detail.
                        </p>
                    </div>

                    <!-- By Cosplayers, For Cosplayers (Icon User) -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg group hover:shadow-2xl transition border border-pink-100 overflow-hidden relative">
                        <div class="flex items-center justify-center p-4 bg-pink-500 rounded-md shadow-lg mb-6 w-16 h-16 mx-auto">
                            <i class="fas fa-users text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-pink-600 tracking-tight text-center mb-4">By Cosplayers, For Cosplayers</h3>
                        <p class="text-lg text-gray-700 text-center leading-relaxed">
                            Since we are part of the community, we know exactly what you need—from the right wig styling to the essential accessories.
                        </p>
                    </div>

                    <!-- Student-Driven Spirit -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg group hover:shadow-2xl transition border border-pink-100 overflow-hidden relative">
                        <div class="flex items-center justify-center p-4 bg-pink-500 rounded-md shadow-lg mb-6 w-16 h-16 mx-auto">
                            <i class="fas fa-sparkles text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-pink-600 tracking-tight text-center mb-4">Student-Driven Spirit</h3>
                        <p class="text-lg text-gray-700 text-center leading-relaxed">
                            We represent the energy and innovation of the younger generation, constantly updating our catalog with the latest trending characters from anime, manga, and games.
                        </p>
                    </div>
                </div>
            </div>

    <!-- Footer (Tetap Sama) -->
    <footer class="bg-white px-6 py-6 border-t border-pink-200 mt-auto flex justify-center gap-12 text-sm text-pink-600">
      <div class="flex items-center gap-2">
        <i class="fab fa-instagram text-xl"></i> @YUIKA.RENTCOS
      </div>
      <div class="flex items-center gap-2">
        <i class="fab fa-tiktok text-xl"></i> YUMICOS
      </div>
    </footer>

        </div> <!-- End of Content Area -->
    </div> <!-- End of Page Layout Div -->
</x-app-layout>

<style>
    /* Global scrollbar hiding is not included, assuming x-app-layout handles it if needed */
</style>