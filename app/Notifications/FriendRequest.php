<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FriendRequest extends Notification
{
    use Queueable;

    protected $friend;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $friend)
    {
        $this->friend = $friend;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            ->subject("My Bookcase Friend Request Accepted")
            ->line("{$this->friend->name} has accepted you friend request")
            ->action('View Friends', url('/#/friends'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user' => $this->friend,
            'action' => 'Accepted your a friend request'
        ];
    }
}
