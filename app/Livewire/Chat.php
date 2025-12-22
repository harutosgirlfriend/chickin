<?php

namespace App\Livewire;

use App\Models\ChatModel;
use App\Models\Users;
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chat extends Component
{
      use WithFileUploads;
    public $newMessage;

    public $user;

    public $messages;

    public $selectedUser;

    public $loginId;

    public $photo;

    public function render()
    {
        return view('livewire.chat');
    }

    public function mount()
    {
        if (auth()->user()->role === 'admin') {
            $this->user = Users::where('id', '!=', Auth::id())->get();
            $this->selectedUser = $this->user->first();
        } else {
            $this->selectedUser = Users::find(4); // admin
        }

        $this->loginId = Auth::id();
        $this->loadMessages();
        $this->markAsRead($this->selectedUser->id ?? 4);
    }

    public function loadMessages()
    {
        $penerimaId = auth()->user()->role === 'admin'
            ? $this->selectedUser?->id
            : 4;

        $this->messages = ChatModel::query()
            ->where(function ($q) use ($penerimaId) {
                $q->where('id_pengirim', Auth::id())
                    ->where('id_penerima', $penerimaId);
            })
            ->orWhere(function ($q) use ($penerimaId) {
                $q->where('id_pengirim', $penerimaId)
                    ->where('id_penerima', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Tandai semua pesan dari lawan yang belum dibaca
        $this->markAsRead($penerimaId);
    }


public function submit()
{
    if (!$this->newMessage && !$this->photo) return;

    $penerimaId = auth()->user()->role === 'admin'
        ? $this->selectedUser?->id
        : 4;

    $gambarPath = null;

    if ($this->photo) {
        $gambarPath = $this->photo->store('chat', 'public');
    }

    $message = ChatModel::create([
        'id_pengirim' => Auth::id(),
        'id_penerima' => $penerimaId,
        'pesan' => $this->newMessage,
        'gambar' => $gambarPath,
        'dibaca' => false
    ]);

    $this->messages->push($message);
    $this->reset(['newMessage', 'photo']);
    $this->loadMessages();
}

    public function getListeners()
    {
        return [
            "echo.private:chat.{$this->loginId},App\\Events\\MessageSent" => 'newChatMessageNotification',
        ];
    }

    public function newChatMessageNotification($message)
    {
        $selectedUserId = $this->selectedUser->id ?? 4;

        if ($message['id_pengirim'] == $selectedUserId) {
            $messageObj = ChatModel::find($message['id']);
            $this->messages->push($messageObj);
        }
    }

    public function selectUser($id)
    {
        if (auth()->user()->role !== 'admin') {
            return;
        }

        $this->selectedUser = $this->user->firstWhere('id', $id);
        $this->loadMessages();
        $this->markAsRead($id);
    }

    public function markAsRead($pengirimId)
    {
        ChatModel::where('id_pengirim', $pengirimId)
            ->where('id_penerima', Auth::id())
            ->where('dibaca', false)
            ->update(['dibaca' => true]);
    }

    /**
     * Ambil daftar user untuk chat list, urut berdasarkan chat terbaru
     * dan sertakan jumlah pesan belum dibaca.
     */
    public function getChatUsers()
    {
        if (auth()->user()->role === 'admin') {
            $users = $this->user;
        } else {
            $users = Users::where('id', 4)->get();
        }

        $users = $users->map(function ($pengirim) {
            $lastMessage = ChatModel::where(function ($q) use ($pengirim) {
                $q->where('id_pengirim', $pengirim->id)
                    ->where('id_penerima', auth()->id());
            })
                ->orWhere(function ($q) use ($pengirim) {
                    $q->where('id_pengirim', auth()->id())
                        ->where('id_penerima', $pengirim->id);
                })
                ->orderBy('created_at', 'desc')
                ->first();

            $pengirim->lastMessage = $lastMessage?->created_at;
            $pengirim->unreadCount = ChatModel::where('id_pengirim', $pengirim->id)
                ->where('id_penerima', auth()->id())
                ->where('dibaca', false)
                ->count();

            return $pengirim;
        });

        return $users->sortByDesc(fn ($u) => $u->lastMessage ?? now()->subYears(10));
    }

    public function openChat($pengirimId)
    {
        $this->selectUser($pengirimId);
    }
}
