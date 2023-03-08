<?php

namespace Xitara\Accordion\Components;

use Cms\Classes\ComponentBase;
use Xitara\Accordion\Models\TextList;

class ListOutput extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'xitara.accordion::component.textlist.name',
            'description' => 'xitara.accordion::component.textlist.description',
        ];
    }

    public function defineProperties()
    {
        return [
            'textlist' => [
                'title' => 'xitara.accordion::component.textlist.textlist',
                'description' => 'xitara.accordion::component.textlist.textlist_description',
                'type' => 'dropdown',
                'required' => true,
            ],
            'start_open' => [
                'title' => 'xitara.accordion::component.textlist.start_open',
                'description' => 'xitara.accordion::component.textlist.start_open_description',
                'type' => 'dropdown',
                'options' => [
                    'closed' => 'xitara.accordion::component.textlist.closed',
                    'open' => 'xitara.accordion::component.textlist.open',
                ],
                'default' => 'closed',
            ],
        ];
    }

    public function onRun()
    {
        $this->addJs('/plugins/xitara/accordion/assets/js/app.js');
        $this->addCss('/plugins/xitara/accordion/assets/css/app.css');

        $this->page['textlist'] = TextList::find($this->property('textlist'));
        $this->page['start_open'] = $this->property('start_open');
    }

    public function getTextlistOptions()
    {
        $textlists = TextList::orderBy('name', 'asc')->lists('name', 'id');
        return $textlists;
    }
}
