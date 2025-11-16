<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $filePath;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, string $filePath)
    {
        $this->order = $order;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject('Laporan Order ' . $this->order->order_number)
            ->view('emails.order-report')
            ->attach($this->filePath, [
                'as' => $this->order->order_number . '.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
