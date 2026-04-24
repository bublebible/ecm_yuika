<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Penyewaan #') . $rental->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold">Status: {{ ucfirst($rental->status) }}</h3>
                        <p>Total Harga: Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($rental->status == 'pending')
                        <div class="border-t pt-4">
                            <h4 class="font-bold mb-2">Upload Identitas (KTP/KTM)</h4>
                            <form action="{{ route('user.rentals.update', $rental) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="file" name="identity_card" class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100" required>
                                <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Upload</button>
                            </form>
                        </div>
                    @endif

                    @if($rental->status == 'active')
                        <div class="border-t pt-4">
                            <h4 class="font-bold mb-2">Kembalikan Kostum / Upload Bukti Retur</h4>
                            <form action="{{ route('user.rentals.update', $rental) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="file" name="return_proof" class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100" required>
                                <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Konfirmasi Pengembalian</button>
                            </form>
                        </div>
                    @endif

                    <div class="mt-8">
                        <h4 class="font-bold">Dokumen Terupload</h4>
                        <ul class="list-disc ml-5">
                            @foreach($rental->documents as $doc)
                                <li>
                                    {{ ucfirst(str_replace('_', ' ', $doc->type)) }} - 
                                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                                    ({{ $doc->status }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
