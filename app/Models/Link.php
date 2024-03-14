<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_url', 'shortened_url', 'clicks',
    ];


    public function formatShortened(): string
    {
        return url($this->shortened_url);
    }

    public function formatFull(): string
    {
        return str_starts_with($this->full_url, 'http') ? $this->full_url : 'https://'.$this->full_url;
    }

    public static function shorten(string $url): string
    {
        return substr(sha1($url), 0, 6);
    }
}
