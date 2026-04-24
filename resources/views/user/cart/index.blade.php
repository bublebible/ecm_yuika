<x-app-layout>
    <div class="pb-24 pt-4 sm:pt-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Shopping Cart</h2>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

             @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            @if($cart && count($cart) > 0)
                <div class="space-y-4"> 
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $details)
                    @php $subtotal = $details['price'] * $details['quantity'] * $details['duration']; $total += $subtotal; @endphp
                    <div class="bg-white p-4 rounded-xl shadow-sm flex gap-4 relative">
                        <!-- Remove Button -->
                         <form action="{{ route('user.cart.remove') }}" method="POST" class="absolute top-2 right-2">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $id }}">
                            <button type="submit" class="text-gray-400 hover:text-red-500"><i class="fas fa-times"></i></button>
                        </form>

                        <div class="h-20 w-20 bg-gray-200 rounded-lg overflow-hidden">
                             @if($details['image'])
                                <img src="{{ Storage::url($details['image']) }}" class="object-cover w-full h-full">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400"><i class="fas fa-image"></i></div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900">{{ $details['name'] }}</h4>
                            <p class="text-sm text-gray-500">Duration: 
                                <span class="font-semibold text-gray-700">{{ $details['duration'] }} Days</span>
                            </p>
                            <div class="mt-2 flex justify-between items-center">
                                 <span class="font-bold text-pink-600">Rp {{ number_format($details['price'], 0, ',', '.') }} / day</span>
                                 <div class="flex items-center gap-3">
                                     <span class="text-xs text-gray-500">Qty: {{ $details['quantity'] }}</span>
                                 </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Summary -->
                <div class="mt-8 bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-4 border-b pb-4">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-bold">Rp 0</span>
                    </div>
                    <div class="flex justify-between mb-6">
                        <span class="text-lg font-bold">Total</span>
                        <span class="text-lg font-bold text-pink-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <form action="{{ route('user.cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-4 bg-pink-600 text-white font-bold rounded-xl shadow hover:bg-pink-700 transition">
                            Checkout Now
                        </button>
                    </form>
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="h-24 w-24 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4 text-pink-500">
                        <i class="fas fa-shopping-basket fa-3x"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Your cart is empty</h3>
                    <p class="text-gray-500 mt-2 mb-6">Looks like you haven't added any costumes yet.</p>
                    <a href="{{ route('user.catalog.index') }}" class="inline-block px-6 py-3 bg-pink-600 text-white font-medium rounded-full shadow hover:bg-pink-700 transition">
                        Start Browsing
                    </a>
                </div>
            @endif
             
        </div>
    </div>
</x-app-layout>
