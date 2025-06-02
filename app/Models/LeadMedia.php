<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class LeadMedia extends Model
{
    use HasFactory;

    protected $table = 'lead_media';

    protected $fillable = [
        'lead_id',
        'title',
        'original_name',
        'file_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'metadata',
        'uploaded_by',
    ];

    protected $casts = [
        'metadata' => 'array',
        'file_size' => 'integer',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getFileUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public function getFileIconAttribute(): string
    {
        $extension = pathinfo($this->original_name, PATHINFO_EXTENSION);

        $iconMap = [
            'pdf' => 'icon-file-pdf',
            'doc' => 'icon-file-word',
            'docx' => 'icon-file-word',
            'xls' => 'icon-file-excel',
            'xlsx' => 'icon-file-excel',
            'ppt' => 'icon-file-powerpoint',
            'pptx' => 'icon-file-powerpoint',
            'zip' => 'icon-file-archive',
            'rar' => 'icon-file-archive',
            'jpg' => 'icon-file-image',
            'jpeg' => 'icon-file-image',
            'png' => 'icon-file-image',
            'gif' => 'icon-file-image',
            'svg' => 'icon-file-image',
            'mp4' => 'icon-file-video',
            'avi' => 'icon-file-video',
            'mov' => 'icon-file-video',
            'mp3' => 'icon-file-audio',
            'wav' => 'icon-file-audio',
            'txt' => 'icon-file-text',
        ];

        return $iconMap[strtolower($extension)] ?? 'icon-file';
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }
}
