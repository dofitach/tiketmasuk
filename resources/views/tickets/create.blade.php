<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Tiket Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Formulir Pembelian Tiket</h3>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Ada masalah dengan input Anda.</span>
                            <ul class="mt-3 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tickets.store') }}">
                        @csrf

                        <!-- Nama Pengunjung -->
                        <div class="mb-4">
                            <label for="visitor_name" class="block text-sm font-medium text-gray-700">Nama Pengunjung</label>
                            <input type="text" name="visitor_name" id="visitor_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('visitor_name') }}" required>
                        </div>

                        <!-- Email Pengunjung (Opsional) -->
                        <div class="mb-4">
                            <label for="visitor_email" class="block text-sm font-medium text-gray-700">Email Pengunjung (Opsional)</label>
                            <input type="email" name="visitor_email" id="visitor_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('visitor_email') }}">
                        </div>

                        {{-- Bagian untuk Jumlah Tiket per Jenis --}}
                        <div class="space-y-4 mb-6">
                             <h4 class="text-md font-semibold text-gray-800">Jumlah Tiket per Jenis:</h4>

                                @foreach ($ticketTypes as $ticketType)
                                <div class="flex items-center justify-between border p-3 rounded-md bg-gray-50">
                                    <label for="quantity_{{ Str::slug($ticketType->name) }}" class="text-sm font-medium text-gray-700 flex-grow">{{ $ticketType->name }} (Rp {{ number_format($ticketType->price, 0, ',', '.') }}/tiket)</label>
                                    <input type="number"
                                        name="quantities[{{ $ticketType->name }}]" {{-- Menggunakan array 'quantities' --}}
                                        id="quantity_{{ Str::slug($ticketType->name) }}"
                                        class="quantity-input w-24 text-right rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        value="{{ old('quantities.' . $ticketType->name, 0) }}" {{-- Membaca nilai old() dari array --}}
                                        min="0"
                                        data-price="{{ $ticketType->price }}"> {{-- Simpan harga di data attribute --}}
                                </div>
                                @endforeach
                        </div>
                        <!-- Total Harga -->
                        <div class="mb-6 border-t pt-4 mt-4">
                            <p class="text-lg font-bold text-gray-800 flex justify-between">
                                <span>Total Harga:</span>
                                <span id="total_overall_price">Rp 0</span>
                            </p>
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ __('Beli Tiket') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script JavaScript untuk perhitungan total harga --}}
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil semua input kuantitas dengan kelas 'quantity-input'
        const quantityInputs = document.querySelectorAll('.quantity-input');
        const totalOverallPriceSpan = document.getElementById('total_overall_price');

        // Fungsi untuk menghitung dan memperbarui total harga
        function calculateTotalPrice() {
            let total = 0;
            quantityInputs.forEach(input => {
                const quantity = parseInt(input.value) || 0;
                const price = parseFloat(input.dataset.price); // <--- Ambil harga dari data-price attribute
                total += (quantity * price);
            });

            totalOverallPriceSpan.textContent = 'Rp ' + total.toLocaleString('id-ID'); // Format mata uang Indonesia
        }

        // Tambahkan event listener untuk setiap input jumlah agar perhitungan diperbarui saat nilai berubah
        quantityInputs.forEach(input => {
            input.addEventListener('input', calculateTotalPrice);
        });

        // Panggil fungsi perhitungan saat halaman dimuat pertama kali
        calculateTotalPrice();
    });
</script>
    @endpush
</x-app-layout>