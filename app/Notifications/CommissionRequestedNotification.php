<?php

namespace App\Notifications;

use App\Models\Commission;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommissionRequestedNotification extends Notification implements ShouldQueue
{

    use Queueable;

    private Commission $commission;

    public function __construct(Commission $commission)
    {
        $this->afterCommit = true;
        $this->commission = $commission;
    }

    public function via($notifiable): array
    {
//        return ['mail'];
        return ['database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject( $notifiable->name . ' a commission request has been sent to you!')
            ->line($this->commission->commissionedBy->name. ' has sent you a commission request.')
            ->line('They are offering to pay £'. $this->commission->budget / 100)
            ->line('Please click on the button below to see the commission')
            ->action('View Commission Request', route('commissions.show', [
                'commission' => $this->commission->id
            ]))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        $budget = $this->commission->budget / 100;
        return [
            'commission_id' => $this->commission->id,
            'requested_by_id' => $this->commission->requested_by,
            'requested_by_name' => $this->commission->commissionedBy->name,
            'description' => $this->commission->description,
            'budget' => $this->commission->budget,
            'title' => "Commission request - £{$budget}"
        ];
    }
}
