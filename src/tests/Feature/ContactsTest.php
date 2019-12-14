<?php

namespace Tests\Feature;

use App\Contact;
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
        $this->assertEquals('05/04/1994', $contact->birthday);
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

    private function data() {

        return [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'birthday' => '05/04/1994',
            'company' => 'ABC String',
        ];
    }
}
