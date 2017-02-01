<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClientsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(TermsTableSeeder::class);
        $this->call(QuotationsTableSeeder::class);
        $this->call(SalesOrdersTableSeeder::class);
        $this->call(InvoicesTableSeeder::class);
        $this->call(ReceivedPaymentsTableSeeder::class);
        $this->call(DeliveriesTableSeeder::class);
        $this->call(StatementsTableSeeder::class);
        $this->call(VendorsTableSeeder::class);
        $this->call(PurchaseOrdersTableSeeder::class);
    }
}
