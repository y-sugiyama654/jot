<?php

namespace Tests\Feature;

use App\Contact;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_contact_can_be_added()
    {
        $this->post('/api/contacts', $this->data());

        $contact = Contact::first();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('05/04/1994', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC String', $contact->company);
    }

    /** @test */
    public function fields_are_required()
    {
        collect(['name', 'email', 'birthday', 'company'])
            ->each(function($fields) {
                $response = $this->post('/api/contacts',
                    array_merge($this->data(), [$fields => '']));
                $response->assertSessionHasErrors($fields);
                $this->assertCount(0, Contact::all());
            });
    }

    /** @test */
    public function email_must_be_a_valid_email()
    {
        $response = $this->post('/api/contacts',
            array_merge($this->data(), ['email' => 'NOT AN EMAIL']));
        $response->assertSessionHasErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function birthdays_are_properly_stored()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/contacts',
            array_merge($this->data(), ['birthday' => 'May 04, 1994']));

        $this->assertCount(1, Contact::all());
        $this->assertInstanceOf(Carbon::class, Contact::first()->birthday);
        $this->assertEquals('05-04-1994', Contact::first()->birthday->format('m-d-Y'));
    }

    /** @test */
    public function a_contact_can_be_retrieved() {

        $contact = factory(Contact::class)->create();

        $response = $this->get('api/contacts/' . $contact->id);

        $response->assertJson([
           'name' => $contact->name,
           'email' => $contact->email,
           'birthday' => $contact->birthday,
           'company' => $contact->company,
        ]);

    }

    /** @test */
    public function a_contact_can_be_patched() {

        $this->withoutExceptionHandling();

        $contact = factory(Contact::class)->create();

        $response = $this->patch('api/contacts/' . $contact->id, $this->data());

        $contact = $contact->fresh();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('05/04/1994', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC String', $contact->company);
    }

    /** @test */
    public function a_contact_can_be_deleted() {

        $contact = factory(Contact::class)->create();

        $response = $this->delete('api/contacts/' . $contact->id);

        $this->assertCount(0, Contact::all());
    }

    private function data() {
        return [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'birthday' => '05/04/1994',
            'company' => 'ABC String',
        ];
    }
}
