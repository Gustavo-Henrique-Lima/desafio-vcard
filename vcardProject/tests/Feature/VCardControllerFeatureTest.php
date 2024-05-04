<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Contact;

class VCardControllerFeatureTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testViewCreateReturnsView()
    {
        $response = $this->get('/contacts');
        $response->assertStatus(200);
        $response->assertViewIs('create');
    }

    public function testViewContactsReturnsViewWithContacts()
    {
        $response = $this->get('/contacts/view');
        $response->assertStatus(200);
        $response->assertViewIs('visualize');
        $response->assertViewHas('contacts');
    }

    public function testStoreContacts()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->createWithContent('contacts.vcf', "BEGIN:VCARD\nVERSION:3.0\nFN:John Doe\nEMAIL:example@example.com\nEND:VCARD");

        $response = $this->post('/contacts/store', [
            'vcard' => $file
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Contatos importados com sucesso!');
        $this->assertDatabaseHas('contacts', [
            'email' => 'example@example.com'
        ]);
    }

    public function testGetAllContacts()
    {
        Contact::create([
            'full_name' => 'John Doe',
            'telephone' => '123456789',
            'email' => 'john@example.com',
            'organization' => 'Example Org',
            'title' => 'Manager',
            'url' => 'http://example.com',
            'address' => '123 Example St',
            'note' => 'No notes'
        ]);

        $response = $this->get('/api/contacts/getall');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'full_name' => 'John Doe',
            'telephone' => '123456789',
            'email' => 'john@example.com'
        ]);
    }
}
