<?php 

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EnterthecontestTest extends DuskTestCase
{
   public function testBasicExample()
   {
   $this->browse(function ($browser) {
   $browser->visit("http://local.lilyandlime.com:8081/contest")
     ->type("first_name", "arslaan")
     ->type("last_name", "ejaz")
     //->type("email", "aejaz+test02@ztechstudio.com")
     ->type("phone", "8989789879")
     ->type("wedding_day", "03/01/2018")
     ->type("wedding_location", "New York, NY")
     ->press("Submit")
     //->type("pardot_url", "https://go.lilyandlime.com/l/169232/2016-05-27/sfhl")
     //->type("form-name", "contest")
     //->type("csrf_token", "07acb922518cbb178e639fcda8a3327ac665ee00")
     ->assertPathIs('/contest')
     ->assertSee("The form you submitted contained the following errors")
   ;
   });
   }
}
