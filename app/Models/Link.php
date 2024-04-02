<?php

namespace App\Models;

use Endroid\QrCode\Builder\Builder as QRBuilder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\Result\ResultInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_url', 'shortened_url', 'clicks', 'user_id',
    ];

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['shortened_url'],
        );
    }

    public function formatShortened(): string
    {
        return url($this->shortened_url);
    }

    public function formatFull(): string
    {
        return str_starts_with($this->full_url, 'http') ? $this->full_url : 'https://'.$this->full_url;
    }

    public static function slugOrFail(string $slug): Link
    {
        $link = Link::where('shortened_url', $slug)->first();

        if (is_null($link)) {
            throw (new ModelNotFoundException())->setModel(
                Link::class, $slug
            );
        }

        return $link;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function QRCode(): ResultInterface
    {
        $result = QRBuilder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($this->formatShortened())
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->labelText($this->formatShortened())
            ->labelFont(new NotoSans(20))
            ->labelAlignment(LabelAlignment::Center)
            ->validateResult(false)
            ->build();

        return $result;
    }

    public static function shorten(string $url): string
    {
        return substr(sha1($url), 0, 6);
    }
}
