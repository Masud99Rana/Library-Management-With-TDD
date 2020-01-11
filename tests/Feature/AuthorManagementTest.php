<?php

namespace Tests\Feature;

use App\Author;
use App\Book;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{   
   
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    
    /** @test */
    public function a_book_can_be_added_to_to_library()
    {   
        $this->withoutExceptionHandling();
        
        $this->post('/authors', $this->data());
        
        $author = Author::all();
        
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('2014/14/04', $author->first()->dob->format('Y/d/m'));
    }

    /** @test */
    public function a_name_is_required()
    {
       $response = $this->post('/authors', array_merge($this->data(), ['name' => null]));
       $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_dob_is_required()
    {
       $response = $this->post('/authors', array_merge($this->data(), ['dob' => null]));
       $response->assertSessionHasErrors('dob');
    }

    private function data()
    {
        return [
            'name' => 'Author Name',
            'dob' => '4/14/2014',
        ];
    }
}
