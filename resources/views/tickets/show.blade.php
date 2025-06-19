<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Tiket & QR Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Detail Tiket Anda</h3>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="mb-4">
                        <p class="font-medium text-gray-700">Nama Pengunjung:</p>
                        <p class="text-lg">{{ $ticket->visitor_name }}</p>
                    </div>

                    @if($ticket->visitor_email)
                    <div class="mb-4">
                        <p class="font-medium text-gray-700">Email Pengunjung:</p>
                        <p class="text-lg">{{ $ticket->visitor_email }}</p>
                    </div>
                    @endif

                    <div class="mb-4">
                        <p class="font-medium text-gray-700">Jenis Tiket:</p>
                        <p class="text-lg">{{ $ticket->ticket_type }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="font-medium text-gray-700">Jumlah Tiket:</p>
                        <p class="text-lg">{{ $ticket->quantity }}</p> {{-- Ini akan selalu 1 per entri tiket --}}
                    </div>

                    <div class="mb-4">
                        <p class="font-medium text-gray-700">Harga Tiket Individu:</p> {{-- Sesuaikan labelnya --}}
                        <p class="text-lg">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="font-medium text-gray-700">Status:</p>
                        <p class="text-lg">{{ ucfirst($ticket->status) }}</p>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="font-medium text-gray-700 mb-2">QR Code Tiket:</p>
                        <div class="flex justify-center mb-4">
                            {!! $qrCodeSvg !!} {{-- Render QR Code SVG --}}
                        </div>
                        <p class="text-sm text-gray-500 break-words">Hash Tiket: {{ $ticket->qr_code_hash }}</p>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Kembali ke Daftar Tiket') }}
                        </a>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Kembali ke Dashboard') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>