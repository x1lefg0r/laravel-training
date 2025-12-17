<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class DailyStatisticsReport extends Mailable
{
    use Queueable, SerializesModels;

    public int $totalViews;
    public int $todayViews;
    public int $todayComments;
    public int $pendingComments;
    public array $topArticles;

    /**
     * Create a new message instance.
     */
    public function __construct($totalViews, $todayViews, $todayComments, $pendingComments, $topArticles)
    {
        $this->totalViews = $totalViews;
        $this->todayViews = $todayViews;
        $this->todayComments = $todayComments;
        $this->pendingComments = $pendingComments;
        $this->topArticles = $topArticles;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ежедневная статистика сайта - ' . now()->format('d.m.Y'),
            from: new Address(config('mail.from.address'), config('mail.from.name')),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.daily-statistics',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}