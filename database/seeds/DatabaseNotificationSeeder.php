<?php

use Illuminate\Database\Seeder;
use Illuminate\Notifications\DatabaseNotification;

class DatabaseNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DatabaseNotification::class)->create();
    }
}
