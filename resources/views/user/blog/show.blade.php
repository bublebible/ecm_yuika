<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('user.blog.index') }}" class="text-indigo-600 hover:underline">Tips & Tricks</a> / {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($post->image)
                    <img src="{{ Storage::url($post->image) }}" class="w-full max-h-96 object-cover" alt="{{ $post->title }}">
                @endif
                
                <div class="p-8">
                    <h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>
                    <div class="text-gray-500 text-sm mb-6">Diposting pada: {{ $post->created_at->format('d F Y') }}</div>
                    
                    <div class="prose max-w-none text-gray-800 leading-relaxed">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <div class="mt-8 pt-8 border-t">
                        <a href="{{ route('user.blog.index') }}" class="text-gray-600 hover:text-gray-900">&larr; Kembali ke Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
