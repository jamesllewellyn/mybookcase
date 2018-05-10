<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InviteInterestedUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Your Invitation to join My Bookcase')
            ->subject("MyBookcase.co Invite")
            ->line("Thank you for registering your interest in My Bookcase")
            ->line("Here's your invite to join")
            ->line("Happy reading")
            ->action('Accept Invitation',
                url("/interested-user?invitation_code=".urlencode(base64_encode('email='.$notifiable->email.'&token='.$notifiable->token)))
            );
    }
}
