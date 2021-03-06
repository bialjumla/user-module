<?php

namespace Modules\User\Http\Livewire\User;

use Livewire\Component;
use Modules\Marketplace\Enum\MarketplaceEnum;

class SuggestedUsers extends Component
{
    public $users;
    public $template;
    public function mount()
    {

        $users = app('services')->getUsersInServices(MarketplaceEnum::SUGGESTED_USERS);
        if(!$users){
            $this->users = [];
            return;
        }
        $this->users = $users->users->random($users->users->count()/2);
    }

    public function render()
    {
        return view('user::livewire.user.suggested-users-'.$this->template);
    }
}
