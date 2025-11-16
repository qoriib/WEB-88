<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminData = SeedData::admin();

        SeederState::$admin = User::updateOrCreate(
            ['email' => $adminData['email']],
            [
                'name' => $adminData['name'],
                'phone' => $adminData['phone'],
                'city' => $adminData['city'],
                'address' => $adminData['address'],
                'password' => Hash::make($adminData['password']),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );

        $this->command?->info('Admin -> ' . $adminData['email'] . ' / ' . $adminData['password']);

        foreach (SeedData::vendors() as $vendor) {
            $userData = $vendor['user'];
            $vendorUser = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'phone' => $userData['phone'],
                    'city' => $userData['city'],
                    'address' => $userData['address'],
                    'password' => Hash::make('Vendor#123'),
                    'role' => 'vendor',
                    'email_verified_at' => now(),
                ],
            );

            SeederState::$vendors[$vendorUser->email] = $vendorUser;
        }

        $this->command?->info('Vendor (default pass: Vendor#123) -> ' . implode(', ', array_keys(SeederState::$vendors)));

        foreach (SeedData::customers() as $customer) {
            $customerUser = User::updateOrCreate(
                ['email' => $customer['email']],
                [
                    'name' => $customer['name'],
                    'phone' => $customer['phone'],
                    'city' => $customer['city'],
                    'address' => $customer['address'],
                    'password' => Hash::make('Customer#123'),
                    'role' => 'customer',
                    'email_verified_at' => now(),
                ],
            );

            SeederState::$customers[$customerUser->email] = $customerUser;
        }

        $this->command?->info('Customer (default pass: Customer#123) -> ' . implode(', ', array_keys(SeederState::$customers)));
    }
}
