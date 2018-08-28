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
            'Nationality.required' => 'กรุณาเลือก "สัญชาติ"',
            'Type_Candidate.required' => 'กรุณาเลือก "จบใหม่/ฝึกงาน หรือ มีประสบการณ์"',
            'idEducation_Level.required' => 'กรุณาเลือก "ระดับการศึกษา"',
            'idGeography.required' => 'กรุณาเลือก "ที่ตั้งสถาบัน"',
            'type_of_institue.required' => 'กรุณาเลือก "ประเภทสถาบัน"',
            'idInstitute_Detail.required' => 'กรุณากรอก "ชื่อสถาบัน"',
            'idFaculty_Detail.required' => 'กรุณาเลือก "คณะ"',
            'idDepartment.required' => 'กรุณาเลือก "ภาควิชา"',
            'idDegree_and_Certificate.required' => 'กรุณาเลือก "วุฒิการศึกษา"',
            'GPA.required' => 'กรุณากรอก "GPA"',
            'GPA.between' => 'กรุณากรอก "GPA" ไม่เกิน 4.00',
            'GPA.regex' => 'รปูแบบของ "GPA" ไม่ถูกต้อง',
            'LastSeniority.required' => 'กรุณาเลือก "ระดับการทำงาน"',
            'LastJob_Title.required' => 'กรุณาเลือก "ชื่อตำแหน่งาน"',
            'idExperience_Work_Status.required' => 'กรุณาเลือก "สถานะการทำงาน"',
            'Date_Start.required' => 'กรุณาเลือก "วันที่เริ่ม"',
            'Date_End.required' => 'กรุณาเลือก "วันที่สิ้นสุด"',
            'job_CategoryNew.required' => 'กรุณาเลือก "หมวดหมู่งาน" ที่คาดหวัง',
            'Seniority.required' => 'กรุณาเลือก "ระดับการทำงาน" ที่คาดหวัง',
            'Job_TitleRequire.required' => 'กรุณาเลือก "ชื่อตำแหน่งาน" ที่คาดหวัง',
            'Job_TitleRequireOther.required' => 'กรุณาระบุ "ตำแหน่งงานที่คุณคาดหวัง" ',
            'idSkill_List.required' => 'กรุณาเลือก "ทักษะที่ถนัดที่สุด"',
            'Skill_ListOther.required' => 'กรุณาระบุ "ทักษะที่คุณถนัดที่สุด"',
            'LangidCountry_Calling_Code.required' => 'กรุณาเลือก "ภาษาที่ถนัดที่สุด"',
            'Expected_Salary.required' => 'กรุณาเลือก "เงินเดือนที่ต้องการ"',
            'idType_of_Employment.required' => 'กรุณาเลือก "ประเภทการจ้างงาน"',
            'idAvailability_of_Work.required' => 'กรุณาเลือก "ความพร้อมในการเริ่มงาน"',
            'idJob_Seeking_Status.required' => 'กรุณาเลือก "สถานะการค้นหางาน"',
            'idSources_Type.required'=> 'กรุณาบอก "คุณรู้จัก aSearcher ได้อย่างไร"',
            'OtherType.required' => 'กรุณาระบุ "คุณรู้จัก aSearcher ได้อย่างไร"',
        ];
        
        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
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
    public $candidates;
}
