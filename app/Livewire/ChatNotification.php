<?php
namespace App\Livewire;

use App\Models\ChatModel;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatNotification extends Component
{
    public $unreadCount = 0;
    public $loginId;
    public $user;
    public $selectedUser;

    public function mount()
    {
        $this->loginId = Auth::id();
        $this->loadUnread();

        if (auth()->user()->role === 'admin') {
            $this->user = Users::where('id', '!=', Auth::id())->get();
            $this->selectedUser = $this->user->first();
        } else {
            $this->selectedUser = Users::find(4); // admin
 
        }
    }


    public function loadUnread()
    {
        $this->unreadCount = ChatModel::where('id_penerima', Auth::id())
            ->where('dibaca', false)
            ->count();
    }

    public function markAsRead($pengirimId)
    {
        ChatModel::where('id_pengirim', $pengirimId)
            ->where('id_penerima', Auth::id())
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        $this->loadUnread(); 
    }

    public function render()
    {
        return view('livewire.chat-notification', [
            'unreadCount' => $this->unreadCount
        ]);
    }
}
