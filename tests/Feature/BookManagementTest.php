<?php

namespace Tests\Feature;

use App\Author;
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
            'author_id' => 'Masud Rana'
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
            'author_id' => 'Masud Rana'
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
            'author_id' => null
        ]);

        $response->assertSessionHasErrors('author_id');
    }

    /** @test */
    public function a_book_can_be_updated_to_to_library()
    {   
        $this->withoutExceptionHandling();

        $oldPost = $this->post('/books',[
            'title' => 'My cool book title',
            'author_id' => 'Masud Rana'  // here author id 1
        ]);

        $book = Book::first();

        $response = $this->patch('/books/'.$book->id,[
            'title' => 'New title',
            'author_id' => 'New Author' // here author id 2 for new generate via model helper
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);
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

    /** @test */
    public function a_new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'Cool Title',
            'author_id' => 1,
        ]);
        $book = Book::first();
        $author = Author::first();
        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    private function data()
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Masud Rana',
        ];
    }
}
