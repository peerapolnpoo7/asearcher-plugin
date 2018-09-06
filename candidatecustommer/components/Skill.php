<?php namespace Asearcher\Candidatecustommer\Components;
use Auth;
use Cms\Classes\ComponentBase;
use Asearcher\CandidateCustommer\Models\SkillList;
use Asearcher\CandidateCustommer\Models\RequirementOfWork;

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
        $this->skillLists=$this->loadSkillList();
    }

    public function loadSkillList()
    {
        $getRequireOfWork = RequirementOfWork::where('idUser',Auth::getUser()->id)->first();
        if($getRequireOfWork){
            $get=SkillList::where('idJob_Category','like','%#'.$getRequireOfWork->idJob_Category.'#%')->skip(0)->take(15)->get()->toArray();
            return $get;
        }
    }
    public $skillLists;
}
