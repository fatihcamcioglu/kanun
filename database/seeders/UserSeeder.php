<?php

namespace Database\Seeders;

use App\Models\LegalCategory;
use App\Models\LawyerProfile;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 1 ADMIN
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@kanun-i.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
            'phone' => '+905551234567',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create 2 LAWYER + LawyerProfile
        $lawyer1 = User::create([
            'name' => 'Avukat Ahmet Yılmaz',
            'email' => 'ahmet.yilmaz@kanun-i.com',
            'password' => Hash::make('password'),
            'role' => 'LAWYER',
            'phone' => '+905551234568',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        LawyerProfile::create([
            'user_id' => $lawyer1->id,
            'specializations' => ['Ceza Hukuku', 'İş Hukuku'],
            'bio' => '15 yıllık deneyime sahip, ceza ve iş hukuku alanlarında uzman avukat.',
            'bar_number' => 'BAR1234',
            'is_active' => true,
        ]);

        $lawyer2 = User::create([
            'name' => 'Avukat Ayşe Demir',
            'email' => 'ayse.demir@kanun-i.com',
            'password' => Hash::make('password'),
            'role' => 'LAWYER',
            'phone' => '+905551234569',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        LawyerProfile::create([
            'user_id' => $lawyer2->id,
            'specializations' => ['Aile Hukuku', 'Gayrimenkul Hukuku'],
            'bio' => 'Aile ve gayrimenkul hukuku konularında uzman, 10 yıllık tecrübe.',
            'bar_number' => 'BAR5678',
            'is_active' => true,
        ]);

        // Create 3 CUSTOMER
        User::create([
            'name' => 'Müşteri Mehmet Kaya',
            'email' => 'mehmet.kaya@example.com',
            'password' => Hash::make('password'),
            'role' => 'CUSTOMER',
            'phone' => '+905551234570',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Müşteri Fatma Şahin',
            'email' => 'fatma.sahin@example.com',
            'password' => Hash::make('password'),
            'role' => 'CUSTOMER',
            'phone' => '+905551234571',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Müşteri Ali Çelik',
            'email' => 'ali.celik@example.com',
            'password' => Hash::make('password'),
            'role' => 'CUSTOMER',
            'phone' => '+905551234572',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create 5 LegalCategory
        $categories = [
            [
                'name' => 'Ceza Hukuku',
                'slug' => Str::slug('Ceza Hukuku'),
                'description' => 'Ceza hukuku ile ilgili tüm konular',
                'is_active' => true,
            ],
            [
                'name' => 'İş Hukuku',
                'slug' => Str::slug('İş Hukuku'),
                'description' => 'İş hukuku ve çalışma hayatı ile ilgili konular',
                'is_active' => true,
            ],
            [
                'name' => 'Aile Hukuku',
                'slug' => Str::slug('Aile Hukuku'),
                'description' => 'Boşanma, velayet, nafaka gibi aile hukuku konuları',
                'is_active' => true,
            ],
            [
                'name' => 'Gayrimenkul Hukuku',
                'slug' => Str::slug('Gayrimenkul Hukuku'),
                'description' => 'Tapu, kira, satış gibi gayrimenkul işlemleri',
                'is_active' => true,
            ],
            [
                'name' => 'Ticaret Hukuku',
                'slug' => Str::slug('Ticaret Hukuku'),
                'description' => 'Şirket kuruluşu, ticari işlemler ve sözleşmeler',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            LegalCategory::create($category);
        }

        // Create 3 Package
        $packages = [
            [
                'name' => 'Temel Paket',
                'slug' => Str::slug('Temel Paket'),
                'question_quota' => 5,
                'voice_quota' => 0,
                'validity_days' => 30,
                'price' => 299.00,
                'currency' => 'TRY',
                'is_active' => true,
            ],
            [
                'name' => 'Standart Paket',
                'slug' => Str::slug('Standart Paket'),
                'question_quota' => 15,
                'voice_quota' => 3,
                'validity_days' => 60,
                'price' => 599.00,
                'currency' => 'TRY',
                'is_active' => true,
            ],
            [
                'name' => 'Premium Paket',
                'slug' => Str::slug('Premium Paket'),
                'question_quota' => 50,
                'voice_quota' => 10,
                'validity_days' => 90,
                'price' => 1299.00,
                'currency' => 'TRY',
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}
