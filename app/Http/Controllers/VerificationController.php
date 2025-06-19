<?php

namespace App\Http\Controllers; // FIXED: Changed -> to \

use App\Models\Ticket;           // FIXED: Changed -> to \
use Illuminate\Http\Request;      // FIXED: Changed -> to \

class VerificationController extends Controller
{
    /**
     * Tampilkan halaman verifikasi tiket untuk staf.
     *
     * @return \Illuminate\View\View // FIXED: Changed -> to \
     */
    public function index()
    {
        return view('verification.index');
    }

    /**
     * Proses verifikasi tiket berdasarkan hash QR Code.
     *
     * @param  \Illuminate\Http\Request  $request // FIXED: Changed -> to \
     * @return \Illuminate\Http\RedirectResponse // FIXED: Changed -> to \
     */
    public function verify(Request $request)
    {
        $request->validate([
            'qr_code_hash' => 'required|string',
        ]);

        $ticket = Ticket::where('qr_code_hash', $request->qr_code_hash)->first();

        if (!$ticket) {
            return back()->with('error', 'Tiket tidak ditemukan. Pastikan hash QR Code benar.');
        }

        if ($ticket->status === 'used') {
            return redirect()->route('ticket.verify.form')->with('warning', 'Tiket ini sudah digunakan pada ' . $ticket->updated_at->format('d M Y H:i:s') . '.');
        }

        $ticket->status = 'used';
        $ticket->save();

        return redirect()->route('ticket.verify.form')->with('success', 'Verifikasi tiket berhasil! Tiket atas nama ' . $ticket->visitor_name . ' (' . $ticket->ticket_type . ' - ' . $ticket->quantity . ' buah) telah berhasil digunakan.');
    }
}