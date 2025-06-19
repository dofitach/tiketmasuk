<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketTypeController extends Controller
{
    /**
     * Tampilkan daftar jenis tiket.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // HAPUS pengecekan admin di sini, karena sudah dihandle oleh middleware
        $ticketTypes = TicketType::all();
        return view('ticket_types.index', compact('ticketTypes'));
    }

    /**
     * Tampilkan formulir untuk mengedit jenis tiket tertentu.
     *
     * @param  \App\Models\TicketType  $ticketType
     * @return \Illuminate\View\View
     */
    public function edit(TicketType $ticketType)
    {
        // HAPUS pengecekan admin di sini
        return view('ticket_types.edit', compact('ticketType'));
    }

    public function create() // <--- METODE BARU: untuk menampilkan form tambah
    {
        return view('ticket_types.create');
    }

    /**
     * Perbarui harga jenis tiket tertentu di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TicketType  $ticketType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TicketType $ticketType)
    {
        // HAPUS pengecekan admin di sini
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('ticket_types')->ignore($ticketType->id)],
            'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $ticketType->update($request->all());

        return redirect()->route('ticket_types.index')->with('success', 'Harga tiket ' . $ticketType->name . ' berhasil diperbarui!');
    }
    public function store(Request $request) // <--- METODE BARU: untuk menyimpan data
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ticket_types,name', // Nama harus unik
            'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        TicketType::create($request->all());

        return redirect()->route('ticket_types.index')->with('success', 'Jenis tiket ' . $request->name . ' berhasil ditambahkan!');
    }
    /**
     * Hapus jenis tiket tertentu.
     * (Opsional: fitur hapus, hanya untuk contoh)
     *
     * @param  \App\Models\TicketType  $ticketType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TicketType $ticketType)
    {
        // HAPUS pengecekan admin di sini
        $ticketType->delete();

        return redirect()->route('ticket_types.index')->with('success', 'Jenis tiket ' . $ticketType->name . ' berhasil dihapus.');
    }
}