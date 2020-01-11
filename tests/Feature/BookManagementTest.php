<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class BookManagementTest extends TestCase
{   
   
    // use WithoutMiddleware;
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    
    /** @test */
    public function a_book_can_be_added_to_to_library()
    {   
        // $this->withoutExceptionHandling();

        $response = $this->post('/books',[
            'title' => 'My cool book title',
            'author' => 'Masud Rana'
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_title_is_required()
    {   
        //We need exceptionHandling
        //  $this->withoutExceptionHandling();

        $response = $this->post('/books',[
            'title' => null,
            'author' => 'Masud Rana'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required()
    {   
        //We need exceptionHandling
        //  $this->withoutExceptionHandling();

        $response = $this->post('/books',[
            'title' => 'My cool book title',
            'author' => null
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated_to_to_library()
    {   
        // $this->withoutExceptionHandling();

        $oldPost = $this->post('/books',[
            'title' => 'My cool book title',
            'author' => 'Masud Rana'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/'.$book->id,[
            'title' => 'New title',
            'author' => 'New Author'
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
        $response->assertRedirect($book->fresh()->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        // $this->withoutExceptionHandling();
        
        $this->post('/books', $this->data());
        
        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response = $this->delete('/books/'.$book->id);

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    private function data()
    {
        return [
            'title' => 'Cool Book Title',
            'author' => 'Masud Rana',
        ];
    }
}
