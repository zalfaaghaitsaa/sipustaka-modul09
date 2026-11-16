<?php

namespace Modules\Peminjaman\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Peminjaman\Database\Factories\PinjamFactory;

class Pinjam extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_peminjam',
        'judul_buku',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'berkas',
        'nama_berkas',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date:Y-m-d',
        'tanggal_kembali' => 'date:Y-m-d',
    ];

    protected $appends = ['berkas_url'];

    protected function berkasUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->berkas ? asset('storage/'.$this->berkas) : null);
    }

    protected static function newFactory(): PinjamFactory
    {
        return PinjamFactory::new();
    }
}