<?php

namespace App\Notifications;

use App\Models\ClubApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClubApplicationStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $application;

    /**
     * Create a new notification instance.
     */
    public function __construct(ClubApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $clubName = $this->application->club->name;
        $status = $this->application->status;
        $reason = $this->application->reason;

        $subject = 'Your Application Status for ' . $clubName;
        $greeting = 'Hello ' . $notifiable->name . ',';

        $mailMessage = (new MailMessage)
            ->subject($subject)
            ->greeting($greeting);

        if ($status === 'approved') {
            $mailMessage->line('Congratulations! Your application to join the ' . $clubName . ' has been approved.')
                ->line('You can now access club member features.')
                ->action('Go to Dashboard', route('dashboard'));
        } elseif ($status === 'rejected') {
            $mailMessage->line('We regret to inform you that your application to join the ' . $clubName . ' has been rejected.');
            if ($reason) {
                $mailMessage->line('Reason: ' . $reason);
            }
            $mailMessage->line('Please contact the administrator if you have questions.');
        } else {
            $mailMessage->line('Your application status for the ' . $clubName . ' has been updated to: ' . $status . '.');
        }

        $mailMessage->line('Thank you for your interest!');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'club_name' => $this->application->club->name,
            'status' => $this->application->status,
        ];
    }
}
