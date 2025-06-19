<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    /**
     * Tampilkan formulir untuk membuat tiket baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Ambil semua jenis tiket dari database
        $ticketTypes = TicketType::all();
        return view('tickets.create', compact('ticketTypes'));
    }

    /**
     * Simpan tiket baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'visitor_name' => 'required|string|max:255',
            'visitor_email' => 'nullable|email|max:255',
            'quantities.*' => 'nullable|integer|min:0', // Menggunakan array untuk quantities
        ]);

        $ticketsCreated = [];
        $totalTicketsPurchased = 0;

        // Ambil semua jenis tiket beserta harganya dari database
        $ticketTypes = TicketType::all()->keyBy('name'); // Menggunakan nama sebagai kunci

        // Array untuk menyimpan data tiket yang akan dibuat
        $ticketsData = [];

        foreach ($request->quantities as $ticketTypeName => $quantity) {
            $quantity = (int) $quantity; // Pastikan kuantitas adalah integer

            if ($quantity > 0) {
                // Pastikan jenis tiket ada di database
                if ($ticketTypes->has($ticketTypeName)) {
                    $ticketType = $ticketTypes->get($ticketTypeName);
                    $price = $ticketType->price;

                    for ($i = 0; $i < $quantity; $i++) {
                        $ticketsData[] = [
                            'user_id' => auth()->id(),
                            'visitor_name' => $request->visitor_name,
                            'visitor_email' => $request->visitor_email,
                            'ticket_type' => $ticketTypeName,
                            'price' => $price,
                            'quantity' => 1,
                            'qr_code_hash' => Str::uuid(),
                            'status' => 'purchased',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    $totalTicketsPurchased += $quantity;
                } else {
                    \Log::warning("Jenis tiket tidak valid ditemukan: {$ticketTypeName}");
                }
            }
        }

        if (empty($ticketsData)) {
            return back()->with('error', 'Anda harus memilih setidaknya satu tiket.');
        }

        Ticket::insert($ticketsData);

        return redirect()->route('tickets.index')
                         ->with('success', $totalTicketsPurchased . ' tiket berhasil dibuat untuk ' . $request->visitor_name . '!');
    }

    /**
     * Tampilkan detail tiket dan QR Code.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\View\View
     */
    public function show(Ticket $ticket)
    {
        if (auth()->id() !== $ticket->user_id) {
            abort(403, 'Akses Dilarang.');
        }

        $qrCodeSvg = QrCode::size(200)->generate($ticket->qr_code_hash);

        return view('tickets.show', compact('ticket', 'qrCodeSvg'));
    }

    /**
     * Tampilkan daftar tiket yang dibeli oleh pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function index() // <--- PASTIKAN METODE INI ADA DAN KODE DI DALAMNYA BENAR
    {
        $tickets = auth()->user()->tickets()->latest()->get();
        return view('tickets.index', compact('tickets'));
    }
}