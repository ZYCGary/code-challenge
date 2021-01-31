<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        foreach (range(1, 50) as $index) {
            $customer = Customer::factory()->make([
                'country_id' => rand(1, 10),
                'active' => (rand(0, 1) === 1)
            ]);

            $data[] = [
                'name' => $customer->name,
                'mobile' => $customer->mobile,
                'email' => $customer->email,
                'country_id' => $customer->country_id,
                'active' => $customer->active,
            ];
        }

        Customer::insert($data);
    }
}
