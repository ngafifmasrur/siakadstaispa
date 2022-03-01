<?php

namespace Modules\Account\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ForgotPasswordNotification extends Notification
{
    use Queueable;

    public $link;

    /**
     * Create a new notification instance.
     */
    public function __construct($link)
    {
        $this->link = $link;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Atur ulang sandi')
                    ->greeting('Amankan akun Anda sekarang!')
                    ->line('Jangan khawatir, kami akan membantu Anda untuk mengatur ulang sandi akun Anda.')
                    ->action('Atur ulang sandi', $this->link)
                    ->line('Untuk melakukan pengaturan ulang password, silahkan tekan tombol diatas dan masukkan password baru Anda.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
