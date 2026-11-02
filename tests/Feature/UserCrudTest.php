<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCrudTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_management_requires_login()
    {
        $response = $this->get('/master/pengguna');
        $response->assertRedirect('/login');
    }

    public function test_user_can_be_created_updated_and_deleted()
    {
        $this->withSession(['login' => true, 'username' => 'admin@example.com']);

        $response = $this->get('/master/pengguna');
        $response->assertStatus(200);

        $storeResponse = $this->postJson('/master/pengguna', [
            'name' => 'John Doe',
            'email' => 'john@jewepe.com',
            'password' => 'secret123'
        ]);

        $storeResponse->assertStatus(200);
        $storeResponse->assertJsonFragment(['success' => 'Pengguna berhasil ditambahkan']);
        
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@jewepe.com'
        ]);

        $user = User::where('email', 'john@jewepe.com')->first();

        $updateResponse = $this->putJson('/master/pengguna/' . $user->id, [
            'name' => 'John Doe Updated',
            'email' => 'john_updated@jewepe.com',
            'password' => ''
        ]);

        $updateResponse->assertStatus(200);
        $updateResponse->assertJsonFragment(['success' => 'Pengguna berhasil diubah']);
        
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'John Doe Updated',
            'email' => 'john_updated@jewepe.com'
        ]);

        $destroyResponse = $this->deleteJson('/master/pengguna/' . $user->id);
        $destroyResponse->assertStatus(200);
        $destroyResponse->assertJsonFragment(['success' => 'Pengguna berhasil dihapus']);
        
        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}
