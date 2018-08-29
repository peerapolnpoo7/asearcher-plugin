<?php namespace Asearcher\Candidatecustommer\Components;

use Cms\Classes\ComponentBase;
use Session;
use System\Models\File as File;
use Asearcher\CandidateCustommer\Models\Candidate;

class ProfileSession extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'ProfileSession Component',
            'description' => 'Profile Session'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $this->profiles=$this->loadProfiles();
    }

    public function loadProfiles()
    {
        $get=Candidate::select('FirstName_TH','LastName_TH','thumb','job_title.Name_TH as JobTitle','job_seeking_status.idJob_Seeking_Status','job_seeking_status.Name_TH as JobSeekStatus')
        ->join('photo_profile_cv','candidate.idCandidate','=','photo_profile_cv.idCandidate')
        ->join('requirement_of_work','candidate.idCandidate','=','requirement_of_work.idCandidate')
        ->join('job_title','requirement_of_work.idJob_Title','=','job_title.idJob_Title')
        ->join('job_seeking_status','requirement_of_work.idJob_Seeking_Status','=','job_seeking_status.idJob_Seeking_Status')
        ->where('candidate.idCandidate',Session::get('idCandidate'))->first();
        return $get;

    }
    public $profiles;
}
