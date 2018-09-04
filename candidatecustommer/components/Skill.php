<?php namespace Asearcher\Candidatecustommer\Components;

use Cms\Classes\ComponentBase;

class Skill extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Skill Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

     public function onRun(){
        $this->addJs('assets/js/cv-skill.js');
        $this->addCss('assets/css/cv-skill.css');
    }
}
