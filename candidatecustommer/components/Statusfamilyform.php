<?php namespace Asearcher\Candidatecustommer\Components;

use Cms\Classes\ComponentBase;

use Asearcher\CandidateCustommer\Models\Military;
use Asearcher\CandidateCustommer\Models\MaritalStatus;
use Asearcher\CandidateCustommer\Models\Occupation;

class Statusfamilyform extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'statusfamilyform Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
      $this->addJs('assets/js/cv-family.js');
      $this->addCss('assets/css/cv-family.css');
      $this->militarys=$this->loadmilitary();
      $this->maritalstatuss=$this->loadMarital_status();
      $this->occupations=$this->loadOccupation();
    }

    public function loadmilitary()
    {
       return Military::where('idMilitary','!=','99')->get();
       // $get = Military::where('idMilitary','!=','99')->get();
       // $get = Military::find(1);
       // dd($get);
    }

    public function loadMarital_status()
    {
       return MaritalStatus::all();
    }

    public function loadOccupation()
    {
       return Occupation::all();
    }

    public $militarys;
    public $maritalstatuss;
    public $occupations;
}
