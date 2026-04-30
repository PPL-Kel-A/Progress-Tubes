<?php

namespace Database\Seeders;

use App\Models\CollectionPoint;
use Illuminate\Database\Seeder;

class CollectionPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mock TPS data for Jakarta area with realistic coordinates
        $collectionPoints = [
            [
                'name' => 'TPS Kebon Jeruk',
                'address' => 'Jl. Kebon Jeruk No. 45, Kebon Jeruk, Jakarta Barat',
                'latitude' => -6.1753,
                'longitude' => 106.7674,
                'desa' => 'Kebon Jeruk',
                'kecamatan' => 'Kebon Jeruk',
                'kota' => 'Jakarta Barat',
            ],
            [
                'name' => 'TPS Palmerah',
                'address' => 'Jl. Palmerah No. 23, Palmerah, Jakarta Barat',
                'latitude' => -6.2145,
                'longitude' => 106.7890,
                'desa' => 'Palmerah',
                'kecamatan' => 'Palmerah',
                'kota' => 'Jakarta Barat',
            ],
            [
                'name' => 'TPS Grogol',
                'address' => 'Jl. Grogol Utama No. 12, Grogol, Jakarta Barat',
                'latitude' => -6.2234,
                'longitude' => 106.7634,
                'desa' => 'Grogol',
                'kecamatan' => 'Grogol Petamburan',
                'kota' => 'Jakarta Barat',
            ],
            [
                'name' => 'TPS Penjaringan',
                'address' => 'Jl. Penjaringan Timur No. 58, Penjaringan, Jakarta Utara',
                'latitude' => -6.1230,
                'longitude' => 106.7845,
                'desa' => 'Penjaringan',
                'kecamatan' => 'Penjaringan',
                'kota' => 'Jakarta Utara',
            ],
            [
                'name' => 'TPS Menteng',
                'address' => 'Jl. Menteng Raya No. 77, Menteng, Jakarta Pusat',
                'latitude' => -6.1967,
                'longitude' => 106.8234,
                'desa' => 'Menteng',
                'kecamatan' => 'Menteng',
                'kota' => 'Jakarta Pusat',
            ],
            [
                'name' => 'TPS Jagakarsa',
                'address' => 'Jl. Jagakarsa No. 34, Jagakarsa, Jakarta Selatan',
                'latitude' => -6.3456,
                'longitude' => 106.8123,
                'desa' => 'Jagakarsa',
                'kecamatan' => 'Jagakarsa',
                'kota' => 'Jakarta Selatan',
            ],
            [
                'name' => 'TPS Kramat Jati',
                'address' => 'Jl. Kramat Jati No. 88, Kramat Jati, Jakarta Timur',
                'latitude' => -6.2890,
                'longitude' => 106.8900,
                'desa' => 'Kramat Jati',
                'kecamatan' => 'Kramat Jati',
                'kota' => 'Jakarta Timur',
            ],
        ];

        foreach ($collectionPoints as $point) {
            CollectionPoint::create($point);
        }
    }
}
