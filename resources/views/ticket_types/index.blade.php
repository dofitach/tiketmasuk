<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Harga Tiket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Daftar Jenis Tiket dan Harga</h3>

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

                    {{-- Tombol Tambah Jenis Tiket Baru --}}
                    <div class="mb-4 text-right">
                        <a href="{{ route('ticket_types.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Tambah Jenis Tiket Baru') }}
                        </a>
                    </div>

                    @if ($ticketTypes->isEmpty())
                        <p>Belum ada jenis tiket yang terdaftar.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jenis Tiket
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Harga
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Aksi</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($ticketTypes as $ticketType)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $ticketType->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Rp {{ number_format($ticketType->price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('ticket_types.edit', $ticketType->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('ticket_types.destroy', $ticketType->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis tiket ini? Menghapus jenis tiket ini akan memengaruhi data tiket yang sudah ada.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-app-layout>
    ```
* **Simpan file `resources/views/ticket_types/index.blade.php`**.

---

**Langkah Terakhir (Penting Setelah Semua Perubahan Kode):**

1.  **Simpan Semua File:** Pastikan semua perubahan pada `app/Http/Controllers/TicketTypeController.php`, `routes/web.php`, `resources/views/ticket_types/create.blade.php`, dan `resources/views/ticket_types/index.blade.php` sudah tersimpan.
2.  **Bersihkan Cache Laravel (Sangat Penting):**
    * Buka terminal di dalam folder proyekmu (`D:\wamp\www\tiketmasuk\` atau `D:\wamp\www\tiketmasuk-baru\`).
    * Jalankan:
        ```bash
        php artisan optimize:clear
        php artisan route:clear
        php artisan view:clear
        php artisan cache:clear
        composer dump-autoload
        ```
3.  **Restart Server WAMP/Apache:**
    * Buka panel kontrol WAMP-mu dan **Restart All Services**.
4.  **Hard Refresh Browser:**
    * Buka browser dan navigasikan ke halaman pengaturan harga tiket: `http://[virtual_host_mu]/admin/ticket-types` (misal: `http://tiketmasuk.test/admin/ticket-types`).
    * Lakukan **Hard Refresh** (`Ctrl + Shift + R` atau `Cmd + Shift + R`).

Sekarang, di halaman pengaturan harga tiket, kamu akan melihat tombol "Tambah Jenis Tiket Baru". Kamu bisa mengkliknya untuk menambahkan jenis tiket baru dan harganya ke database. Beritahu aku jika ada masalah ya, Nak!