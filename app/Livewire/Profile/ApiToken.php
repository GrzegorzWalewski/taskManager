<?php

namespace App\Livewire\Profile;

use Livewire\Component;

class ApiToken extends Component
{
    public $token = '';

    public $allTokens = [];

    public function render()
    {
        $this->allTokens = auth()->user()->tokens;

        return view('livewire.profile.api-token',
    );
    }

    public function generateApiToken()
    {
        if ($this->allTokens->count() >= 10) {
            $this->dispatch('api-error');
            return;
        }

        $token = auth()->user()->createToken('API Token')->plainTextToken;
        $tokenPart = explode("|", $token);
        $this->token = end($tokenPart);
    }

    public function deleteApiToken($tokenId)
    {
        $this->allTokens->find($tokenId)->delete();
    }
}
