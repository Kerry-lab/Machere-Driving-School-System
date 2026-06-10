<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Branch;
use App\Models\LicenseCategory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name'     => 'Head Office Admin',
            'email'    => 'admin@machere.co.ke',
            'password' => Hash::make('admin1234'),
            'role'     => 'admin',
        ]);

        // Create Branches
        $branches = [
            ['branch_name' => 'Kerugoya Branch', 'location' => 'Kerugoya Town', 'phone' => '0712345678'],
            ['branch_name' => 'Kutus Branch', 'location' => 'Kutus Town', 'phone' => '0712345679'],
            ['branch_name' => 'Kagio Branch', 'location' => 'Kagio Town', 'phone' => '0712345680'],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }

        // Create License Categories
        LicenseCategory::create([
            'name'                     => 'Class B',
            'description'              => 'Light motor vehicles',
            'total_fee'                => 15000,
            'required_practical_hours' => 15,
            'required_theory_lessons'  => 5,
        ]);

        LicenseCategory::create([
            'name'                     => 'Class C',
            'description'              => 'Heavy motor vehicles',
            'total_fee'                => 25000,
            'required_practical_hours' => 20,
            'required_theory_lessons'  => 8,
        ]);

        LicenseCategory::create([
            'name'                     => 'Class CE',
            'description'              => 'Articulated trucks',
            'total_fee'                => 35000,
            'required_practical_hours' => 25,
            'required_theory_lessons'  => 10,
        ]);
    }
}