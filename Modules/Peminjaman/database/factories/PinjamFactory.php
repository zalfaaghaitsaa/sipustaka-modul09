<?php

namespace Modules\Peminjaman\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Peminjaman\Models\Pinjam;

class PinjamFactory extends Factory
{
    protected $model = Pinjam::class;

    public function definition(): array
    {
        $pinjam = fake()->dateTimeBetween('-30 days', 'now');

        return [
            'nama_peminjam' => fake()->name(),
            'judul_buku' => fake()->sentence(3),
            'tanggal_pinjam' => $pinjam->format('Y-m-d'),
            'tanggal_kembali' => (clone $pinjam)->modify('+7 days')->format('Y-m-d'),
            'status' => fake()->randomElement(['Dipinjam', 'Dikembalikan']),
        ];
    }
}