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
use Asearcher\CandidateCustommer\Models\RequirementOfWork;
use Asearcher\CandidateCustommer\Models\Candidate;
use Asearcher\CandidateCustommer\Models\CommunicationProvider;

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
        $this->addCss('assets/css/cv-personal.css');
        $this->imgcvs=$this->loadImageCV();
        $this->prefixs=$this->loadPrefix();
        $this->genders=$this->loadGender();
        $this->religions=$this->loadReligion();
        $this->races=$this->loadRace();
        $this->countrycallingcodes=$this->loadCountryCallingCode();
        $this->blood_groups=$this->loadBloodGroup();
        $this->job_seeker_statuses=$this->loadJobSeekingStatus();
        $this->requirement_of_works=$this->loadRequirementOfWork();
        $this->communication_providers=$this->loadCommunicationProvider();
        $this->candidates=$this->loadCandidate();
    }

    public function onUpload()
    {
        $image = Input::all();
        $rules = [
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:1500',
        ];
        $messages = [
            'photo.mimes' => 'นามสกุลรูปภาพต้องเป็น jpg, jpeg, png เท่านั้น',
            'photo.max' => 'นามสกุลรูปภาพต้องเป็น 1.5MB เท่านั้น',
        ];
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $file = (new File())->fromPost($image['photo']);
        $file->thumb=$file->getThumb(140, 140, ['mode' => 'crop']);
         return array($file);
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

    public function loadRequirementOfWork()
    {
        $get=RequirementOfWork::join('job_title','requirement_of_work.idJob_Title','=','job_title.idJob_Title')
        ->where('idUser',Auth::getUser()->id)->first();
        return $get;
    }

    public function convertDateToForm($date)
    {
        if($date==""){
            return "";
        }
        $dateExp=explode("-",$date);
        return $dateExp['2'].'/'.$dateExp['1'].'/'.$dateExp['0'];
    }

    public function loadCandidate()
    { 
        $get=Candidate::where('idUser',Auth::getUser()->id)->first();
        if($get){
            $get->Date_of_Birth=$this->convertDateToForm($get->Date_of_Birth);
        }
        return $get;
    }

    public function loadCommunicationProvider()
    {
        $get=CommunicationProvider::where('Verify',1);
        $chkCommu=Candidate::where('idUser',Auth::getUser()->id);
        if($chkCommu->count() > 0){
            $get->orWhere('idCommunication_Provider',$chkCommu->first()->idCommunication_Provider);
        }
        $get->orderBy('Status','ASC');
        return $get->get();
    }

    public function chkChooseJobSeek($idJob_Seeking_Status)
    {
        $get=RequirementOfWork::where('idUser',Auth::getUser()->id)->where('idJob_Seeking_Status',$idJob_Seeking_Status);
        if($get->count() > 0){
            return 'selected';
        }else{
            return '';
        }
    }

    public function loadJobSeekingStatus()
    {
        $get = JobSeekingStatus::get()->toArray();
        if($get){
            foreach ($get as $key => $value) {
                $get[$key]['isSelect'] = $this->chkChooseJobSeek($value['idJob_Seeking_Status']);
            }
        }
        return $get;
    }

    public function onGetPrefix()
    {
        return Prefix::select('idPrefix AS id','Name_TH')->whereIn('idGender',[post('value'),'99'])->where('Type','C')->get();
    }


    public $imgcvs;
    public $prefixs;
    public $genders;
    public $religions;
    public $races;
    public $countrycallingcodes;
    public $blood_groups;
    public $job_seeker_statuses;
    public $requirement_of_works;
    public $communication_providers;
    public $job_seeker_statuses;
    public $candidates;
}
