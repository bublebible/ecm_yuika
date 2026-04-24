<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tips & Tricks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($posts as $post)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                        @if($post->image)
                            <img src="{{ Storage::url($post->image) }}" class="w-full h-48 object-cover" alt="{{ $post->title }}">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                                No Image
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="font-bold text-xl mb-2">
                                <a href="{{ route('user.blog.show', $post->slug) }}" class="hover:text-indigo-600">{{ $post->title }}</a>
                            </h3>
                            <div class="text-sm text-gray-500 mb-4">{{ $post->created_at->format('d M Y') }}</div>
                            <p class="text-gray-700 mb-4">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                            <a href="{{ route('user.blog.show', $post->slug) }}" class="text-indigo-600 font-semibold hover:underline">Baca Selengkapnya &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-10 bg-white rounded-lg">
                        <p class="text-gray-500">Belum ada artikel tips & trick.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
