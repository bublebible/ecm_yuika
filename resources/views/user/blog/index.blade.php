<x-app-layout>
    <div class="min-h-screen bg-white font-sans text-gray-900 overflow-x-hidden">

        <!-- Header Section (FOR YOUR PAGE) -->
        <div class="max-w-7xl mx-auto pt-16 px-6 text-center">
            <h2 class="text-4xl font-black text-pink-600 tracking-widest uppercase mb-4">FOR YOUR PAGE</h2>
            <!-- Garis Divider Merah -->
            <div class="flex justify-center mb-16">
                <div class="w-96 h-1.5 bg-red-500 rounded-full"></div>
            </div>
        </div>

        <!-- Blog/Tips Grid Section -->
        <div class="max-w-7xl mx-auto pb-24 px-6 sm:px-8 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                @forelse($posts as $post)
                    <div class="bg-white overflow-hidden group">
                        <!-- Image Container with Rounded Corners (Persis Gambar) -->
                        <div class="relative aspect-square mb-6">
                            @if($post->image)
                                <img src="{{ asset('storage/conditions/sukunacat.jpg') }}" 
                                     class="w-full h-full object-cover rounded-[2.5rem] shadow-sm group-hover:shadow-lg transition-all duration-300" 
                                     alt="{{ $post->title }}">
                            @else
                                <div class="w-full h-full bg-gray-200 rounded-[2.5rem] flex items-center justify-center text-gray-400">
                                    <img src="{{ asset('storage/conditions/sukunacat.jpg') }}" 
                                     class="w-full h-full object-cover rounded-[2.5rem] shadow-sm group-hover:shadow-lg transition-all duration-300" 
                                     alt="{{ $post->title }}">
                                </div>
                            @endif
                        </div>

                        <!-- Content Section -->
                        <div class="space-y-3">
                            <!-- Title (Uppercase Pink) -->
                            <h3 class="font-black text-2xl text-pink-600 leading-tight uppercase tracking-tight">
                                <a href="{{ route('user.blog.show', $post->slug) }}" class="hover:opacity-80">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            
                            <!-- Date (Gray) -->
                            <div class="text-lg text-gray-500 font-medium italic">
                                {{ $post->created_at->format('j F Y') }}
                            </div>

                            <!-- Excerpt -->
                            <p class="text-gray-600 text-lg leading-relaxed line-clamp-2">
                                {{ Str::limit(strip_tags($post->content), 80) }}
                            </p>

                            <!-- Read More Link (Blue/Indigo Bold) -->
                            <div class="pt-2">
                                <a href="{{ route('user.blog.show', $post->slug) }}" class="text-blue-800 font-black text-lg hover:underline flex items-center gap-2">
                                    Baca selengkapnya <span class="text-xl">→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-pink-50 rounded-[3rem] border-2 border-dashed border-pink-200">
                        <p class="text-pink-400 text-xl font-bold italic tracking-wide">Belum ada artikel tips & trick untuk saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Footer Media Sosial (Persis Gambar) -->
        <footer class="bg-pink-300 px-6 py-8 border-t border-pink-200 mt-auto flex justify-center gap-24 font-bold text-white uppercase tracking-widest">
            <div class="flex items-center gap-3">
                <i class="fab fa-instagram text-3xl"></i> @YUIKA.RENTCOS
            </div>
            <div class="flex items-center gap-3">
                <i class="fab fa-tiktok text-3xl"></i> YUMICOS
            </div>
        </footer>

    </div>
</x-app-layout>

<style>
    /* Menyesuaikan font agar lebih mirip dengan desain yang tebal */
    body {
        font-family: 'Inter', 'Arial Black', sans-serif;
    }
</style>