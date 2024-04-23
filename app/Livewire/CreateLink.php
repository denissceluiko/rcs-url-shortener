<?php

namespace App\Livewire;

use App\Models\Link;
use App\Rules\MyURL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateLink extends Component
{
    public $link;
    public $short;

    public function rules()
    {
        return [
            'link' => [
                'required',
                new MyURL,
            ],
            'short' => [
                'nullable',
                Rule::notIn(['/', 'create', 'destory']),
                'unique:App\Models\Link,shortened_url',
            ],
        ];
    }

    public function save()
    {
        $this->validate();
        
        $existing = Link::where('full_url', $this->link)->first();

        if (empty($this->short)) {
            // Check if link is natively shortened
            if ($existing && $existing->shortened_url == Link::shorten($this->link)) {
                return redirect()->route('link.index')->with('status', $existing);
            }
        }

        $shortened = $this->short ?? Link::shorten($this->link);

        $link = Link::create([
            'full_url' => $this->link,
            'shortened_url' => $shortened,
            'user_id' => Auth::user()?->id,
        ]);

        $link->makeQR();

        return redirect()->route('link.index')->with('status', $link);
    }

    public function render()
    {
        return view('livewire.create-link');
    }
}
