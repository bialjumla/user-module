<?php

namespace Modules\User\Http\Livewire\Announcement;

use App\Traits\ModalHelper;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Notification\Enums\NotificationTemplateKeysEnums;
use Modules\User\Notifications\AnnouncementNotification;
use Modules\User\Services\AnnouncementService;

class UserAnnouncement extends Component
{
    use WithFileUploads , ModalHelper;

    public  $user;
    public  $details;
    public  $file;
    private $announcementService;

    public function __construct()
    {
        $this->announcementService = new AnnouncementService();
    }

    public function render()
    {
        return view('user::livewire.announcement.user-announcement');
    }

    protected $rules = [
        'details' => 'required',
    ];

    public function addAnnouncement()
    {

        $this->validate($this->rules);

        $this->announcementService->setUserID     (Auth::user()->id)
                                   ->setOpponentID($this->user->id)
                                   ->setDetails   ($this->details)
                                   ->setFile      ($this->file)
                                   ->createAnnouncement();
        $this->resetInputFields();
        $notification = new AnnouncementNotification();
        $notification
        ->setTemplate(NotificationTemplateKeysEnums::CREATE_ANNOUNCEMENT)
        ->setUser($this->user)
        ->setOpponent(Auth::user())
        ->handle();

        $this->modalClose('.add-announcement-popup', 'success', "Your Announcemen Created Successfully", "Announcemen Create");
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->details = '';
        $this->file    = '';
    }
}
