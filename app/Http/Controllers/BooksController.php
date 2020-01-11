<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{

    public function store(Request $request){

    	$book = Book::create($this->validateRequest());
    }

    public function update(Book $book){

    	$book->update($this->validateRequest());
    }

    public function validateRequest(){
    	return request()->validate([
    		'title' => 'required',
    		'author' => 'required'
    	]);
    }
}
