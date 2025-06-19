<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // FIXED: Changed -> to \
use Illuminate\Database\Eloquent\Model;              // FIXED: Changed -> to \

class Ticket extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'visitor_name',
        'visitor_email',
        'ticket_type',
        'price', // Harga per tiket individu
        'quantity', // Akan menjadi 1 per entri tiket
        'qr_code_hash',
        'status',
    ];

    /**
     * Mendapatkan pengguna yang memiliki tiket ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}