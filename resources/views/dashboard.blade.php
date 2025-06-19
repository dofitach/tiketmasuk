<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">{{ __("Anda berhasil login!") }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ route('tickets.create') }}" class="block p-6 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition duration-300 ease-in-out text-center">
                            <h3 class="text-lg font-bold mb-2">Buat Tiket Baru</h3>
                            <p class="text-sm">Mulai proses pembelian tiket untuk pengunjung.</p>
                        </a>
                        <a href="{{ route('tickets.index') }}" class="block p-6 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition duration-300 ease-in-out text-center">
                            <h3 class="text-lg font-bold mb-2">Tiket Saya</h3>
                            <p class="text-sm">Lihat daftar tiket yang sudah Anda beli.</p>
                        </a>
                        <a href="{{ route('ticket.verify.form') }}" class="block p-6 bg-purple-500 text-white rounded-lg shadow hover:bg-purple-600 transition duration-300 ease-in-out text-center">
                            <h3 class="text-lg font-bold mb-2">Verifikasi Tiket</h3>
                            <p class="text-sm">Halaman untuk staf memindai dan memverifikasi tiket.</p>
                        </a>

                        {{-- Tautan ini hanya terlihat oleh admin --}}
                        @if (auth()->user()->hasRole('admin')) {{-- <--- GANTI KONDISI INI --}}
                        <a href="{{ route('ticket_types.index') }}" class="block p-6 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition duration-300 ease-in-out text-center">
                            <h3 class="text-lg font-bold mb-2">Pengaturan Harga Tiket</h3>
                            <p class="text-sm">Atur jenis tiket dan harganya.</p>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>