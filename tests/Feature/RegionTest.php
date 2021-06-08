<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

use App\Models\Region;
use App\Models\User;

class RegionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     * @test
     * @group region_tests
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** 
     * @test
     * @group region_tests
     */
    public function a_region_cannot_be_created_if_not_authenticated()
    {
        $response = $this->post( 'admin/settings/regions',$this->dataSet() );

         $response->assertRedirect('/login');
         //$this->assertCount(1,Region::all());
    }

    /** 
     * @test
     * @group region_tests
     */
    public function a_region_cannot_be_create_if_not_superadmin()
    {
        $user = User::factory()->create();
        Role::updateOrCreate(['name' => 'admin']);
        $user->assignRole('admin');
        $response = $this->actingAs($user)->post( 'admin/settings/regions', $this->dataSet() );

        $response->assertStatus(403);
        $this->assertCount(0, Region::all());
    }

    /** 
     * @test
     * @group region_tests
     */
    public function a_region_can_be_create_if_superadmin()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Role::updateOrCreate(['name' => 'super-admin']);
        $user->assignRole('super-admin');
        $response = $this->actingAs($user)->post( 'admin/settings/regions', $this->dataSet() );

        $response->assertRedirect(route('admin.settings.regions.index'));
        $this->assertCount(1, Region::all());
    }


    private function dataSet()
    {
        return [
            'region_number' => 1,
            'name'          => 'This is the title',
        ];
    }
}
