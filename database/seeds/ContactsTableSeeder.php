<?php

use Illuminate\Database\Seeder;
use App\Contact;
use App\Phone;
use App\Location;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Contact::class, 10)->create()->each(function ($contact) {
            for($i = 0, $n = 2; $i < $n; $i++) $contact->phones()->save(factory(Phone::class)->make());
            $contact->locations()->save(factory(Location::class)->make());
        });
    }
}
