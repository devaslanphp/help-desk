<?php

namespace App\Http\Livewire;

use App\Models\Notice;
use Livewire\Component;

class ScrollingBanner extends Component
{
    // public $count = 0;
 
    // public function increment()
    // {
    //     $this->count++;
    // }

    public function render()
    {
        return view('livewire.scrolling-banner', [
            'notices' => Notice::all(),
        ]);
    }

    /*Example of render
    public function render()
    {
        return view(‘livewire.mystore’, [
            ‘part’ => Mypart::where(‘status’, ‘done’)->get(),
            ‘orders’ => Order::where(‘delivered’, false)->get(),
            ‘products’ => SoldProducts::latest()->take(50)->get()
        ]);
    } 
*/

}
