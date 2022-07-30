<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class StressApi extends Command
{
    protected $signature = 'stress:api';

    public function handle()
    {
        while(true) {
            Http::post('http://127.0.0.1:8000/api/test', [
                "sourceForm" => "external",
                "firstName" => "Custom Student",
                "surname" => "Form Data",
                "email" => "rockydodssaX121S12re3@asdaafgmsfail.com",
                "phone1" => "+917045591602",
                "photo" => "1135587726.png",
                "gender" => "M",
                "nationality" => "Indian",
                "dob" => "1999-02-16",
                "student_id" => null,
                "source" => "Parent Referral",
                "address" => [
                    "street" => "Samarpan, New Maneklal",
                    "city" => "Mumbai",
                    "state" => "Maharashtra",
                    "zip" => "400077",
                    "country" => "IN"
                ],
                "school" => "SVDD",
                "schoolYear" => "bhsdsdsdsdsdsd rffgdg 4233333333333333333333333333333333333333333",
                "curriculum" => "168",
                "parentFirstName" => "Heroku",
                "parentSurname" => "heroku",
                "relation" => "Father",
                "parentEmail" => "parentheroku@gmail.com",
                "parentPhone1" => "+919120399725",
                "isEmergency" => 1,
                "send_invoices" => true,
                "field1" => "demotext",
                "field2" => "demotext2",
                "signature" => "",
                "interests" => "I like football and cricket"
            ]);
        }
    }
}
