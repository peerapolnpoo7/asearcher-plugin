<?php namespace Asearcher\Candidatecustommer\Components;

use Cms\Classes\ComponentBase;
use Input;
use Request;
use Validator;
use Redirect;
use Auth;
use Db;
use Session;
use ValidationException;
use Flash;
use System\Models\File as File;
use Asearcher\CandidateCustommer\Models\Users;
use Asearcher\CandidateCustommer\Models\Prefix;
use Asearcher\CandidateCustommer\Models\Gender;
use Asearcher\CandidateCustommer\Models\PhotoProfileCV;
use Asearcher\CandidateCustommer\Models\CountryCallingCode;
use Asearcher\CandidateCustommer\Models\Religion;
use Asearcher\CandidateCustommer\Models\Race;
use Asearcher\CandidateCustommer\Models\BloodGroup;
use Asearcher\CandidateCustommer\Models\JobSeekingStatus;

class PersonalForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'PersonalForm Component',
            'description' => 'Personal Information Form'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $this->addJs('assets/js/cv-personal.js');
        $this->imgcvs=$this->loadImageCV();
        $this->prefixs=$this->loadPrefix();
        $this->genders=$this->loadGender();
        $this->religions=$this->loadReligion();
        $this->races=$this->loadRace();
        $this->countrycallingcodes=$this->loadCountryCallingCode();
        $this->blood_groups=$this->loadBloodGroup();
        $this->job_seeker_statuses=$this->loadJobSeekingStatus();
    }

    public function loadImageCV()
    {
        return PhotoProfileCV::where('idCandidate',Session::get('idCandidate'))->first();
    }

    public function loadPrefix()
    {
        return Prefix::all();
    }

    public function loadGender()
    {
        return Gender::where('idGender','!=','99')->get();
    }

    public function loadReligion()
    {
        return Religion::all();
    }

    public function loadRace()
    {
        return Race::all();
    }

    public function loadCountryCallingCode()
    {
        return CountryCallingCode::all();
    }

    public function loadBloodGroup()
    {
        return BloodGroup::all();
    }

    public function loadJobSeekingStatus()
    {
        return JobSeekingStatus::all();
    }


    public $imgcvs;
    public $prefixs;
    public $genders;
    public $religions;
    public $races;
    public $countrycallingcodes;
    public $blood_groups;
    public $job_seeker_statuses;
}
