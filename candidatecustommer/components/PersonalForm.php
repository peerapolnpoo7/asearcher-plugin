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
use ApplicationException;
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
use Asearcher\CandidateCustommer\Models\StatusCandidate;
use Asearcher\CandidateCustommer\Models\BodyInformation;
use Asearcher\CandidateCustommer\Models\Presentation;

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
        $this->status_candidate=$this->loadStatusCandidate();
        $this->body_informations=$this->loadBodyInformation();
        $this->presentations = $this->loadPresentation(); 
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

    public function chkCID($ID_Card_Number)
    {
        $pid=str_replace('-', '', $ID_Card_Number);
        if(strlen($pid) != 13) return false;
          for($i=0, $sum=0; $i<12;$i++)
            $sum += (int)($pid{$i})*(13-$i);
            if((11-($sum%11))%10 == (int)($pid{12}))
            return true;
            return false;
    }

     public function onSave(){
        $rules = array(
            'idGender' => array('required'),
            'idPrefix' => array('required'),
            'FirstName_TH' => array('required','min:2','max:64','regex:/^[ก-์]+$/u'),
            'LastName_TH' => array('required','min:2','max:64','regex:/^[\ก-์\s]+$/u'),
            'Date_of_Birth' => array('required'),
            'ID_Card_Number' => array('required'),
            'Nationality' => array('required'),
            'Email' => array('required','email','between:6,255'),
            'Line_ID' => array('max:20'),
            'TelephoneNumber' => array('required','min:9','max:10','regex:/\d{10}|\d{9}$/'),
            'idCommunication_Provider' => array('required'),
        );

        if(Input::get('idCommunication_Provider')=="5"){
            $rules_more= array( 
                'Communication_Provider' => array('required'),
            );
            $rules = array_merge($rules,$rules_more);
        }

         $rules_more= array( 
                'Weight' => array('regex:/\d{2}|\d{3}|\s/'),
                'Height' => array('regex:/\d{2}|\d{3}|\s/'),
                'idJob_Seeking_Status' => array('required'),
            );
            $rules = array_merge($rules,$rules_more);

        $messages = [
            'idGender.required' => 'กรุณาเลือก "เพศ"',
            'idPrefix.required' => 'กรุณาเลือก "คำนำหน้าชื่อ"',
            'FirstName_TH.required' => 'กรุณากรอก "ชื่อ"',
            'FirstName_TH.min' => 'กรุณากรอก "ชื่อ" 2 ตัวอักษรขึ้นไป',
            'FirstName_TH.max' => 'กรุณากรอก "ชื่อ" น้อยกว่า 64 ตัวอักษร',
            'FirstName_TH.regex' => 'กรุณากรอก "ชื่อ" เป็นตัวอักษรไทยเท่านั้น',
            'LastName_TH.required' => 'กรุณากรอก "นามสกุล"',
            'FirstName_TH.max' => 'กรุณากรอก "นามสกุล" น้อยกว่า 64 ตัวอักษร',
            'LastName_TH.regex' => 'กรุณากรอก "นามสกุล" เป็นตัวอักษรไทยเท่านั้น',
            'Date_of_Birth.required' => 'กรุณาเลือก "วันเกิด"',
            'ID_Card_Number.required' => 'กรุณากรอก "รหัสบัตรประชาชน"',
            'Nationality.required' => 'กรุณาเลือก "สัญชาติ"',
            'Email.required' => 'กรุณากรอก "อีเมล์"',
            'Email.email' => 'รูปแบบ "อีเมล์" ไม่ถูกต้อง',
            'Email.between' => '"อีเมล์" ต้องมีความยาวระหว่าง 6-255 อักษร',
            'Line_ID.max' => '"ไลน์ไอดี" ต้องไม่เกิน 20 ตัวอักษร',
            'TelephoneNumber.required' => 'กรุณากรอก "เบอร์โทรศัพท์"',
            'TelephoneNumber.min' => 'เบอร์โทรศัพท์ต้องมากกว่าหรือเท่ากับ 9 ตัวเลข',
            'TelephoneNumber.max' => 'เบอร์โทรศัพท์ต้องไม่เกิน 10 ตัวเลข',
            'TelephoneNumber.regex' => '"เบอร์โทรศัพท์" ต้องเป็นตัวเลขเท่านั้น',
            'idCommunication_Provider.required' => 'กรุณาเลือก "เครื่อข่ายโทรศัพท์มือถือที่ใช้"',
            'Communication_Provider.required' => 'กรุณาระบุ "เครือข่าย อื่นๆ"',
            'Weight.regex' => 'ตัวเลข "น้ำหนัก" ไม่ถูกต้อง',
            'Height.regex' => 'ตัวเลข "ส่วนสูง" ไม่ถูกต้อง',
            'idJob_Seeking_Status.required' => 'กรุณาเลือก "สถานะการค้นหางาน"'
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        if($this->chkCID(post('ID_Card_Number'))==false){
            throw new ApplicationException('รูปแบบ "บัตรประชาชน" ไม่ถูกต้อง');
        }
        $users=Users::find(Auth::getUser()->id);
        $users->name = Input::get('FirstName_TH');
        $users->surname = Input::get('LastName_TH');
        $users->save();

        if(Input::get('idCommunication_Provider')=="5"){
            $communicattions = new CommunicationProvider();
            $communicattions->Name = Input::get('Communication_Provider');
            $communicattions->Status = '2';
            $communicattions->Verify = '0';
            $communicattions->save();
            $idCommunication_Provider=$communicattions->id;
        }else{
            $idCommunication_Provider = Input::get('idCommunication_Provider');
        }

        $candidate = Candidate::find(Auth::getUser()->id);
        $candidate->idGender = Input::get('idGender');
        $candidate->idPrefix = Input::get('idPrefix');
        $candidate->FirstName_TH = Input::get('FirstName_TH');
        $candidate->LastName_TH = Input::get('LastName_TH');
        $candidate->Date_of_Birth = $this->convertDateToDB(Input::get('Date_of_Birth'));
        $candidate->ID_Card_Number = str_replace('-', '', Input::get('ID_Card_Number'));
        $candidate->idCountry_Calling_Code = Input::get('idCountry_Calling_Code');
        $candidate->TelephoneNumber = Input::get('TelephoneNumber');
        $candidate->idCommunication_Provider = $idCommunication_Provider;
        $candidate->Line_ID = Input::get('Line_ID');
        $candidate->Nationality = Input::get('Nationality');
        $candidate->save();

        $chkImgCV=PhotoProfileCV::where('idUser',$candidate->idCandidate);
        if($chkImgCV->count() > 0)
        {
            $imgcv = PhotoProfileCV::find($chkImgCV->first()->idPhoto_Profile_CV);
        }else{
            $imgcv = new PhotoProfileCV();
        }
        $imgcv->idCandidate=$candidate->idCandidate;
        $imgcv->idUser = Auth::getUser()->id;
        $imgcv->Photo = Input::get('Photos');
        $imgcv->path = Input::get('path');
        $imgcv->thumb = Input::get('thumb');
        $imgcv->save();

        $chk=StatusCandidate::where('idUser',Auth::getUser()->id);
        if($chk->count() > 0){
            $status_candidate = StatusCandidate::find($chk->first()->idStatus_Candidate);
        }else{
            $status_candidate = new StatusCandidate();
            $status_candidate->idUser = Auth::getUser()->id;
            $status_candidate->idCandidate = $candidate->idCandidate;
            $status_candidate->idMilitary = NULL;
             $status_candidate->idMarital_Status = NULL;
        }
        $status_candidate->idRace = Input::get('idRace')?Input::get('idRace'):NULL;
        $status_candidate->idReligion = Input::get('idReligion')?Input::get('idReligion'):NULL;
        $status_candidate->save();

        $chk=BodyInformation::where('idUser',Auth::getUser()->id);
        if($chk->count() > 0){
            $body_information = BodyInformation::find($chk->first()->idBody_Information);
        }else{
            $body_information = new BodyInformation();
            $body_information->idUser = Auth::getUser()->id;
            $body_information->idCandidate = $candidate->idCandidate;
        }

        $body_information->Height = Input::get('Height')?Input::get('Height'):NULL;
        $body_information->Weight = Input::get('Weight')?Input::get('Weight'):NULL;
        $body_information->idBlood_Group = Input::get('idBlood_Group')?Input::get('idBlood_Group'):NULL;
        $body_information->save();

        $chk = Presentation::where('idUser',Auth::getUser()->id);
        if($chk->count() > 0){
            $presentations = Presentation::find($chk->first()->idPresentation);
        }else{
            $presentations = new Presentation();
            $presentations->idUser = Auth::getUser()->id;
            $presentations->idCandidate = $candidate->idCandidate;
        }
        $presentations->Text =  Input::get('Text');
        $presentations->Video_Link =  Input::get('Video_Link');
        $presentations->save();
        
        Flash::success('บันทึกข้อมูลเรียบร้อยแล้ว');
        return Redirect::to('/cv-personal');
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

    public function loadRequirementOfWork()
    {
        $get=RequirementOfWork::join('job_title','requirement_of_work.idJob_Title','=','job_title.idJob_Title')
        ->where('idUser',Auth::getUser()->id)->first();
        return $get;
    }

    public function convertDateToDB($date)
    {
        $dateExp=explode("/",$date);
        return $dateExp['2'].'-'.$dateExp['1'].'-'.$dateExp['0'];
    }

    public function convertDateToForm($date)
    {
        if($date==""){
            return "";
        }
        $dateExp=explode("-",$date);
        return $dateExp['2'].'/'.$dateExp['1'].'/'.$dateExp['0'];
    }

    function FnID($var)
    {
        $srt[0] = substr($var, 0, 1);
        $srt[1] = substr($var, 1, 4);
        $srt[2] = substr($var, 5, 5);
        $srt[3] = substr($var, 10, 2);
        $srt[4] = substr($var, 12, 1);
        return $srt[0]."-".$srt[1]."-".$srt[2]."-".$srt[3]."-".$srt[4];
    }

    public function loadCandidate()
    { 
        $get=Candidate::where('idUser',Auth::getUser()->id)->first();
        if($get){
            $get->Date_of_Birth=$this->convertDateToForm($get->Date_of_Birth);
            $get->ID_Card_Number = $this->FnID($get->ID_Card_Number);
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

    public function loadStatusCandidate()
    {
        $get = StatusCandidate::where('idUser',Auth::getUser()->id)->first();
        return $get;
    }

    public function loadBodyInformation()
    {
        $get = BodyInformation::where('idUser',Auth::getUser()->id)->first();
        return $get;
    }

    public function loadPresentation()
    {
        $get = Presentation::where('idUser',Auth::getUser()->id)->first();
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
    public $candidates;
    public $status_candidate;
    public $body_informations;
    public $presentations;
}
