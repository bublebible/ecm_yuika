<x-app-layout>
  <div class="min-h-screen bg-pink-100 font-sans text-gray-900 overflow-x-hidden">
    @include('home.index')
  </div>
</x-app-layout>

<style>
  /* Hide scrollbar for smooth carousel scrolling */
  .no-scrollbar::-webkit-scrollbar {
    display: none;
  }
  .no-scrollbar {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
  }
</style>