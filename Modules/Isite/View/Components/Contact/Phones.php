<?php

namespace Modules\Isite\View\Components\Contact;

use Illuminate\View\Component;

class Phones extends Component
{
    public $phones;

    public $phonesReplaced;

    public $icon;

    public $showIcon;

    public $classes;

    public $withHyphen;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon = 'fa fa-phone', $showIcon = true, $phones = null, $classes = null,
                              $withHyphen = true)
    {
        $this->icon = $icon;
        $this->classes = $classes ?? '';
        $this->withHyphen = $withHyphen;
        if (! empty($phones)) {
            $this->phones = ! is_array($phones) ? [$phones] : $phones;
        } else {
            $this->phones = json_decode(setting('isite::phones', null, '[]'));
        }

        $this->showIcon = $showIcon;
        foreach ($this->phones as $key => $phone) {
            $this->phonesReplaced[] = preg_replace('/[^0-9]/', '', $phone);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('isite::frontend.components.contact.contactphones');
    }
}
