<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XMLBook extends Model
{
    use HasFactory;
    protected $table = 'current_xml_books';
    protected $fillable = [
        'book_barcode_no',
        'book_name',
        'book_author_name',
        'book_publisher_name',
        'book_price',
        'book_stock',
        'book_image',
        'book_description',
        'xml_fetch_group',
        'book_is_updated'
    ];
}
