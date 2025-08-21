<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users      = User::all();
        $categories = Category::all();

        if ($users->isEmpty() || $categories->isEmpty()) {
            $this->command->error('Please run CategorySeeder and UserSeeder first!');
            return;
        }

        foreach ($users as $user) {
            $this->createExpensesForUser($user, $categories);
        }

        $this->command->info('Created expenses for all users covering the last 3 months');
    }

    /**
     * Summary of createExpensesForUser
     * @param \App\Models\User $user
     * @param mixed $categories
     * @return void
     */
    private function createExpensesForUser(User $user, $categories): void
    {
        $expenseCount = rand(25, 35);
        for ($i = 0; $i < $expenseCount; $i++) {
            $category = $categories->random();
            $date = Carbon::now()->subDays(rand(0, 90)); 
            Expense::create([
                'user_id'       => $user->id,
                'category_id'   => $category->id,
                'title'         => $this->getExpenseTitleByCategory($category->name),
                'amount'        => $this->getAmountByCategory($category->name),
                'date'          => $date,
            ]);
        }
    }

    /**
     * Summary of getExpenseTitleByCategory
     * @param string $categoryName
     * @return string
     */
    private function getExpenseTitleByCategory(string $categoryName): string
    {
        $titles = [
            'Food' => [
                'Grocery shopping at Shwapno',
                'Lunch at office cafeteria',
                'Dinner at restaurant',
                'Coffee and snacks',
                'Breakfast at hotel',
                'Food delivery from Foodpanda',
                'Ice cream and desserts',
                'Street food',
                'Fruits and vegetables',
                'Tea and biscuits',
            ],
            'Transport' => [
                'Bus fare to office',
                'Rickshaw fare',
                'CNG auto fare',
                'Uber ride',
                'Fuel for motorcycle',
                'Parking fee',
                'Train ticket',
                'Bus ticket for travel',
                'Taxi fare',
                'Metro rail fare',
            ],
            'Shopping' => [
                'Clothing from Aarong',
                'Electronics from Ryans',
                'Books and stationery',
                'Shoes and accessories',
                'Mobile accessories',
                'Home appliances',
                'Gifts for family',
                'Online shopping delivery',
                'Pharmacy medicines',
                'Cosmetics and personal care',
            ],
            'Others' => [
                'Mobile bill payment',
                'Internet bill',
                'Electricity bill',
                'Medical checkup',
                'Movie tickets',
                'Gym membership',
                'Barber shop',
                'House rent',
                'Utility bills',
                'Bank charges',
            ],
        ];

        $categoryTitles = Arr::get($titles, $categoryName, "Others");
        return $categoryTitles[array_rand($categoryTitles)];
    }

    private function getAmountByCategory(string $categoryName): float
    {
        $ranges = [
            'Food'      => [50, 800],      
            'Transport' => [20, 500], 
            'Shopping'  => [100, 2000], 
            'Others'    => [100, 1500],  
        ];

        $range = $ranges[$categoryName] ?? $ranges['Others'];
        return rand(Arr::get($range, 0, 0), Arr::get($range, 1, 100));
    }
}