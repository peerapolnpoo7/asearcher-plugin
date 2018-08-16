<?php namespace Asearcher\Candidatecustommer\Components;

use Cms\Classes\ComponentBase;
use Session;
use Auth;
use Input;
use Request;
use Validator;
use Redirect;

use Db;

use ValidationException;
use Flash;
use System\Models\File as File;
use Asearcher\CandidateCustommer\Models\Users;
use Asearcher\CandidateCustommer\Models\Prefix;
use Asearcher\CandidateCustommer\Models\Gender;
use Asearcher\CandidateCustommer\Models\CountryCallingCode;
use Asearcher\CandidateCustommer\Models\Religion;
use Asearcher\CandidateCustommer\Models\Candidate;
use Asearcher\CandidateCustommer\Models\SkillLanguage;
use Asearcher\CandidateCustommer\Models\SkillList;
use Asearcher\CandidateCustommer\Models\SkillSpecific;
use Asearcher\CandidateCustommer\Models\CommunicationProvider;
use Asearcher\CandidateCustommer\Models\Geography;
use Asearcher\CandidateCustommer\Models\TypeOfInstitute;
use Asearcher\CandidateCustommer\Models\InstituteDetail;
use Asearcher\CandidateCustommer\Models\EducationLevel;
use Asearcher\CandidateCustommer\Models\DegreeCertificate;
use Asearcher\CandidateCustommer\Models\JobCategory;
use Asearcher\CandidateCustommer\Models\JobTitle;
use Asearcher\CandidateCustommer\Models\Seniority;
use Asearcher\CandidateCustommer\Models\ExperienceWorkStatus;
use Asearcher\CandidateCustommer\Models\FacultyDetail;
use Asearcher\CandidateCustommer\Models\Department;
use Asearcher\CandidateCustommer\Models\MajorSubject;
use Asearcher\CandidateCustommer\Models\SalaryRange;
use Asearcher\CandidateCustommer\Models\AvailabilityOfWork;
use Asearcher\CandidateCustommer\Models\JobSeekingStatus;
use Asearcher\CandidateCustommer\Models\Province;
use Asearcher\CandidateCustommer\Models\District;
use Asearcher\CandidateCustommer\Models\Subdistrict;
use Asearcher\CandidateCustommer\Models\WelfareType;
use Asearcher\CandidateCustommer\Models\SourceType;
use Asearcher\CandidateCustommer\Models\TypeOfEmployment;
use Asearcher\CandidateCustommer\Models\TransportationDetail;
use Asearcher\CandidateCustommer\Models\ExpectedDetail;
use Asearcher\CandidateCustommer\Models\Education;
use Asearcher\CandidateCustommer\Models\Experience;
use Asearcher\CandidateCustommer\Models\SkillBasicCom;
use Asearcher\CandidateCustommer\Models\RequirementOfWork;
use Asearcher\CandidateCustommer\Models\TransportationOfWork;
use Asearcher\CandidateCustommer\Models\WelfareOfWork;
use Asearcher\CandidateCustommer\Models\ExpectationOfWork;
use Asearcher\CandidateCustommer\Models\PhotoProfileCV;

class SmartcvForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'SmartcvForm Component',
            'description' => 'SmartCV Form'
        ];
    }

    public function defineProperties(){
        return [];
    }

    public function onRun(){
       
        $this->addJs('assets/js/cv-smart.js');
        $this->addCss('assets/css/cv-address.css');
        $this->candidates=$this->loadCandidate();
        $this->imgcvs=$this->loadImageCV();
        $this->prefixs=$this->loadPrefix();
        $this->genders=$this->loadGender();
        $this->religions=$this->loadReligion();
        $this->countrycallingcodes=$this->loadCountryCallingCode();
        $this->skilllists=$this->loadSkillList();
        $this->communication_providers=$this->loadCommunicationProvider();
        $this->geographys=$this->loadGeography();
        $this->type_of_institues=$this->loadTypeOfInstitute();
        $this->education_levels=$this->loadEducationLevel();
        $this->institute_alls=$this->loadIntituteDetail();
        $this->degree_certifidates=$this->loadDegreeCertificate();
        $this->job_categorys=$this->loadJobCategory();
        $this->senioritys=$this->loadSeniority();
        $this->experience_work_statuss = $this->loadExperienceWorkStatus();
        $this->salary_ranges=$this->loadSalaryRange();
        $this->availability_of_works=$this->loadAvailabilityOfWork();
        $this->job_seeker_statuses=$this->loadJobSeekingStatus();
        $this->provinces=$this->loadProvinces();
        $this->welfare_types=$this->loadWelfareType();
        $this->source_types=$this->loadSourceType();
        $this->type_of_employments=$this->loadTypeOfEmployment();
        $this->transportation_mrts=$this->loadTransportationMRT();
        $this->transportation_btss=$this->loadTransportationBTS();
        $this->transportation_brts=$this->loadTransportationBRT();
        $this->transportation_buss=$this->loadTransportationBUS();
        $this->transportation_ferrys=$this->loadTransportationFerry();
        $this->transportation_airlinks=$this->loadTransportationAirLink();
        $this->expected_details=$this->loadExpectedDetail();
        $this->languages=$this->loadLanguate();
        $this->job_titles = $this->loadJobTitle();
        $this->educations=$this->loadEducation();
        $this->experiences=$this->loadExperience();
        $this->skilllangs=$this->loadSkillLanguage();
        $this->skilllangs=$this->loadSkillLanguage();
        $this->skill_basic_coms=$this->loadSkillBasicCom();
        $this->requirement_of_works=$this->loadRequirementOfWork();
        $this->transportation_of_works_btss=$this->loadTransportationOfWork('BTS');
        $this->transportation_of_works_mrts=$this->loadTransportationOfWork('MRT');
        $this->transportation_of_works_brts=$this->loadTransportationOfWork('BRT');
        $this->transportation_of_works_airports=$this->loadTransportationOfWork('Airport');
        $this->transportation_of_works_ferrys=$this->loadTransportationOfWork('Ferry');
        $this->transportation_of_works_trains=$this->loadTransportationOfWork('SRT');
        $this->transportation_of_works_personals=$this->loadTransportationOfWork('Personal');
        $this->transportation_of_works_buss=$this->loadTransportationOfWork('Bus');
        $this->skillspecifics=$this->loadSkillSpecific();
        $this->chkIsCandidateData();
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
        $rules_more=array(
            'Type_Candidate' => array('required'),
            'idEducation_Level' => array('required'),
        );
        $rules = array_merge($rules,$rules_more);
        if(Input::get('idEducation_Level')!='1'){
            $rules_more=array(
                'idGeography' => array('required'),
                'type_of_institue' => array('required'),
                'idInstitute_Detail' => array('required'),
                'idFaculty_Detail' => array(''),
                'idDepartment' => array(''),
                'idMajor_Subject' => array('')
            );
            $rules = array_merge($rules,$rules_more);
        }
        $rules_more=array(
            'idDegree_and_Certificate' => array('required'),
            'GPA' => array('required','regex:/^[0]|[0-3]\.(\d{2})|[4].[0]{2}$/'),
        );
        $rules = array_merge($rules,$rules_more);
        if(Input::get('Type_Candidate')=='2'){
            $rules_more = array(
                'LastSeniority' => array('required'),
                'LastJob_Title' => array('required'),
                'Company_Name' => array(''),
                'idExperience_Work_Status' => array('required'),
                'Date_Start' => array('required'),
            );
            $rules = array_merge($rules,$rules_more);
            if(Input::get('idExperience_Work_Status')=='2'){
                $rules_more= array( 
                    'Date_End' => array('required'),
                );
                $rules = array_merge($rules,$rules_more);
            }
            
        }
        $rules_more=array(
            'job_CategoryNew' => array('required'),
            'Seniority' => array('required'),
            'Job_TitleRequire' => array('required'),
        );
        $rules = array_merge($rules,$rules_more);
        if(Input::get('chkValidateSkill')=="yes"){
            $rules_more= array( 
                'idSkill_List' => array('required'),
            );
            $rules = array_merge($rules,$rules_more);

        }
        $rules_more=array(
            'LangidCountry_Calling_Code' => array('required'),
            'Expected_Salary' => array('required'),
            'idType_of_Employment' => array('required'),
            'idAvailability_of_Work' => array('required'),
            'idSources_Type' => array('required'),
            'idJob_Seeking_Status' => array('required'),
        );
        $rules = array_merge($rules,$rules_more);
        if(Input::get('idSources_Type')=="99"){
            $rules_more= array( 
                    'OtherType' => array('required'),
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
            'idSkill_List.required' => 'กรุณาเลือก "ทักษะที่ถนัดที่สุด"',
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

        if(Input::get('chkValidateSkill')=="yes"){
            $idSkillList = Input::get('idSkill_List');
        }else{
            $idSkillList = 0;
        }

        $users=Users::find(Input::get('idUser'));
        $users->name = Input::get('FirstName_TH');
        $users->surname = Input::get('LastName_TH');
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

        if(Input::get('idSources_Type')=="99"){
            $source_types = new SourceType();
            $source_types->Name_TH = Input::get('OtherType');
            $source_types->Verify = 0;
            $source_types->Status = 2;
            $source_types->save();
            $idSources_Type = $source_types->id;
        }else{
            $idSources_Type = Input::get('idSources_Type');
        }

        $candidate = Candidate::find(Session::get('idCandidate'));
        $candidate->idUser = Input::get('idUser');
        $candidate->idGender = Input::get('idGender');
        $candidate->idPrefix = Input::get('idPrefix');
        $candidate->FirstName_TH = Input::get('FirstName_TH');
        $candidate->LastName_TH = Input::get('LastName_TH');
        $candidate->Date_of_Birth = $this->convertDateToDB(Input::get('Date_of_Birth'));
        $candidate->idCountry_Calling_Code = Input::get('idCountry_Calling_Code');
        $candidate->TelephoneNumber = Input::get('TelephoneNumber');
        $candidate->idCommunication_Provider = $idCommunication_Provider;
        $candidate->Email = Input::get('Email');
        $candidate->Line_ID = Input::get('Line_ID');
        $candidate->Type_Candidate = Input::get('Type_Candidate');
        $candidate->Nationality = Input::get('Nationality');
        $candidate->idSources_Type = $idSources_Type;
        $candidate->CV_Publish = 1;
        $candidate->CV_Active = 0;
        $candidate->save();

        $chkImgCV=PhotoProfileCV::where('idCandidate',Session::get('idCandidate'));
        if($chkImgCV->count() > 0)
        {
            $imgcv = PhotoProfileCV::find($chkImgCV->first()->idPhoto_Profile_CV);
        }else{
            $imgcv = new PhotoProfileCV();
        }
        $imgcv->idCandidate=Session::get('idCandidate');
        $imgcv->idUser = Input::get('idUser');
        $imgcv->Photo = Input::get('Photos');
        $imgcv->path = Input::get('path');
        $imgcv->thumb = Input::get('thumb');
        $imgcv->save();

        $chkEdu=Education::where('idCandidate',Session::get('idCandidate'));
        if($chkEdu->count() > 0){
            $education = Education::find($chkEdu->first()->idEducation);
        }else{
            $education = new Education();
        }
        $education->idCandidate = Session::get('idCandidate');
        $education->idUser = Input::get('idUser');
        $education->idEducation_Level = Input::get('idEducation_Level');
        if(Input::get('idEducation_Level')!=1){
            $education->idInstitute_Detail = Input::get('idInstitute_Detail');
            $education->idEducation_Status = Input::get('idEducation_Status');
            $education->idFaculty_Detail = Input::get('idFaculty_Detail');
            $education->idDepartment = Input::get('idDepartment');
            $education->idMajor_Subject = Input::get('idMajor_Subject');
            $education->Year_of_Admission = '0000-00-00';
            $education->Year_of_Graduation = '0000-00-00';
        }else{
            $education->idInstitute_Detail = NULL;
            $education->idEducation_Status = NULL;
            $education->idFaculty_Detail = NULL;
            $education->idDepartment = NULL;
            $education->idMajor_Subject = NULL;
            $education->Year_of_Admission = NULL;
            $education->Year_of_Graduation = NULL;
        }
        $education->idDegree_and_Certificate = Input::get('idDegree_and_Certificate');
        $education->GPA = Input::get('GPA');
        $education->save();

        if(Input::get('Type_Candidate')=='2'){
            $chkExp=Experience::where('idCandidate',Session::get('idCandidate'));
            if($chkExp->count() > 0){
                $experience = Experience::find($chkExp->first()->idExperience);
            }else{
                $experience = new Experience();
            }
            
            $experience->idCandidate = Session::get('idCandidate');
            $experience->idUser = Input::get('idUser');
            $experience->idExperience_Type = '2';
            $experience->idProvinces= 0;
            $experience->idSeniority = Input::get('LastSeniority');
            $experience->Job_Title = Input::get('LastJob_Title');
            $experience->idType_of_Employment = 0;
            $experience->idExperience_Work_Status = Input::get('idExperience_Work_Status');
            $experience->Company_Name_TH = Input::get('Company_Name_TH');
            $experience->Date_Start = $this->convertDateToDB(Input::get('Date_Start'));
            if(Input::get('idExperience_Work_Status')=='2'){
                $experience->Date_End = $this->convertDateToDB(Input::get('Date_End'));
            }else{
                $experience->Date_End = '0000-00-00';
            }
            $experience->Salary = 0;
            $experience->save();
        }
        $chkSkillLang=SkillLanguage::where('idCandidate',Session::get('idCandidate'));
        if($chkSkillLang->count() > 0){
            $skilllang = SkillLanguage::find($chkSkillLang->first()->idSkill_Language);
        }else{
            $skilllang = new SkillLanguage();
        }
        $skilllang->idCandidate = Session::get('idCandidate');
        $skilllang->idUser = Auth::getUser()->id;
        $skilllang->idCountry_Calling_Code = Input::get('LangidCountry_Calling_Code');
        $skilllang->Listening_Level = Input::get('ionrangeListenLevel')+1;
        $skilllang->Speaking_Level = Input::get('ionrangeSpeakingLevel')+1;
        $skilllang->Reading_Level = Input::get('ionrangeReadingLevel')+1;
        $skilllang->Writing_Level = Input::get('ionrangeWritingLevel')+1;
        $skilllang->save();

        $chkSkillSpecific=SkillSpecific::where('idCandidate',Session::get('idCandidate'));
        if($chkSkillSpecific->count() > 0){
            $skillspecific = SkillSpecific::find($chkSkillSpecific->first()->idSkill_Specific);
        }else{
            $skillspecific = new SkillSpecific();
        }
        $skillspecific->idCandidate = Session::get('idCandidate');
        $skillspecific->idUser = Auth::getUser()->id;
        //$skillspecific->idSkill_List = Input::get('idSkill_List');
        $skillspecific->idSkill_List = $idSkillList;
        $skillspecific->idSkill_Level_Detail = Input::get('ionrangeSkillListLevel')+1;
        $skillspecific->save();

        $chkSkillCom=SkillBasicCom::where('idCandidate',Session::get('idCandidate'));
        if($chkSkillCom->count() > 0){
            $skill_basic_com = SkillBasicCom::find($chkSkillCom->first()->idSkill_Basic_Computer);
        }else{
            $skill_basic_com = new SkillBasicCom();
        }
        $skill_basic_com->idCandidate = Session::get('idCandidate');
        $skill_basic_com->idUser = Auth::getUser()->id;
        $skill_basic_com->Word_Level = Input::get('Word_Level')+1;
        $skill_basic_com->Excel_Level = Input::get('Excel_Level')+1;
        $skill_basic_com->Powerpoint_Level = Input::get('Powerpoint_Level')+1;
        $skill_basic_com->Typing_Thai_Level = Input::get('Typing_Thai_Level')+1;
        $skill_basic_com->Typing_English_Level = Input::get('Typing_English_Level')+1;
        $skill_basic_com->save();

        $chkReOfWork=RequirementOfWork::where('idCandidate',Session::get('idCandidate'));
        if($chkReOfWork->count() > 0){
            $requirement_of_works = RequirementOfWork::find($chkReOfWork->first()->idRequirement_of_Work);
        }else{
            $requirement_of_works = new RequirementOfWork();
        }
        $requirement_of_works->idCandidate = Session::get('idCandidate');
        $requirement_of_works->idUser = Auth::getUser()->id;
        $requirement_of_works->idJob_Category = Input::get('job_CategoryNew');
        if(Input::get('Type_Candidate')=='2'){
            $requirement_of_works->idSeniority = Input::get('Seniority');
        }else{
            $requirement_of_works->idSeniority ='1';
        }
        $requirement_of_works->idJob_Title = Input::get('Job_TitleRequire');
        $requirement_of_works->Expected_Salary = Input::get('Expected_Salary');
        $requirement_of_works->idType_of_Employment = Input::get('idType_of_Employment');
        $requirement_of_works->idAvailability_of_Work = Input::get('idAvailability_of_Work');
        $requirement_of_works->Location_of_Work_Country = Input::get('Location_of_Work_Country');
        $requirement_of_works->Location_of_Work_Provinces = Input::get('Location_of_Work_Provinces');
        $requirement_of_works->Location_of_Work_Districts = Input::get('Location_of_Work_Districts');
        $requirement_of_works->Location_of_Work_Subdistricts = Input::get('Location_of_Work_SubDistricts');
        $requirement_of_works->idJob_Seeking_Status = Input::get('idJob_Seeking_Status');
        $requirement_of_works->save();

        if(post('idTransportation_Detail')){
            TransportationOfWork::where('idCandidate',Session::get('idCandidate'))->delete();
            foreach (post('idTransportation_Detail') as $idTransportation_Detail) {
                if($idTransportation_Detail!=""){
                    $transportation_of_work = new TransportationOfWork();
                    $transportation_of_work->idCandidate = Session::get('idCandidate');
                    $transportation_of_work->idUser = Auth::getUser()->id;
                    $transportation_of_work->idTransportation_Detail = $idTransportation_Detail;
                    $transportation_of_work->save();
                }
            }
        }

        if(post('Expected_Details')){
            ExpectationOfWork::where('idCandidate',Session::get('idCandidate'))->delete();
            foreach (post('Expected_Details') as $Expected_Detail) {
                $expectation_of_work = new ExpectationOfWork();
                $expectation_of_work->idCandidate = Session::get('idCandidate');
                $expectation_of_work->idUser = Auth::getUser()->id;
                $expectation_of_work->idExpected_Detail = $Expected_Detail;
                $expectation_of_work->save();
            }
        }

        WelfareOfWork::where('idCandidate',Session::get('idCandidate'))->delete();
        if(post('Welfares')){
            foreach (post('Welfares') as $Welfare) {
                $welfare_of_work = new WelfareOfWork();
                $welfare_of_work->idCandidate = Session::get('idCandidate');
                $welfare_of_work->idUser = Auth::getUser()->id;
                $welfare_of_work->idWelfare_Type = $Welfare;
                $welfare_of_work->save();
            }
        }
        Flash::success('บันทึกข้อมูลเรียบร้อยแล้ว');
        return Redirect::to('/cv-smart');
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

    public function chkIsCandidateData(){
        $chk=Candidate::where('idUser',Auth::getUser()->id);
        if($chk->count()==0){
            $candidate= new Candidate();
            $candidate->idUser=Auth::getUser()->id;
            $candidate->FirstName_TH=Auth::getUser()->name;
            $candidate->LastName_TH=Auth::getUser()->surname;
            $candidate->Email=Auth::getUser()->email;
            $candidate->save();
            Session::put('idCandidate', $candidate->id);
        }else{
            Session::put('idCandidate', $chk->first()->idCandidate);
        }
    }

    public function loadImageCV()
    {
        return PhotoProfileCV::where('idUser',Auth::getUser()->id)->first();
    }

    public function loadPrefix()
    {
        $chkGender=Candidate::where('idGender','!=','')->where('idUser',Auth::getUser()->id);
        if($chkGender->count()==0){
            return Prefix::where('Type','C')->get();
        }else{
            return Prefix::whereIN('idGender',[$chkGender->first()->idGender,99])->where('Type','C')->get();
        }
        //return Prefix::whereNotIn('idPrefix',['7','8'])->get();
    }

    public function loadGender()
    {
        return Gender::where('idGender','!=','99')->get();
    }

    public function loadReligion()
    {
        return Religion::all();
    }

    public function loadCountryCallingCode()
    {
        return CountryCallingCode::all();
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

    public function loadJobTitle()
    {
        return JobTitle::all();
    }

    public function loadGeography()
    {
        return Geography::all();
    }

    public function loadTypeOfInstitute()
    {
        return TypeOfInstitute::all();
    }

    public function loadEducationLevel()
    {
        return EducationLevel::all();
    }

    public function loadIntituteDetail()
    {
        return InstituteDetail::all();
    }

    public function loadDegreeCertificate()
    {
        return DegreeCertificate::all();
    }

    public function loadJobCategory()
    {
        return JobCategory::all();
    }

    public function loadSeniority()
    {
        $get=Seniority::whereNotIn('idSeniority',[1,9]);
        return $get->get();
    }

    public function loadSkillList(){
        return SkillList::all();
    }

    public function loadExperienceWorkStatus()
    {
        return ExperienceWorkStatus::all();
    }

    public function loadSalaryRange()
    {
        return SalaryRange::all();
    }

    public function loadAvailabilityOfWork()
    {
        return AvailabilityOfWork::all();
    }

    public function loadJobSeekingStatus()
    {
        return JobSeekingStatus::all();
    }

    public function loadProvinces()
    {
        return Province::all();
    }

    public function chkWelfareSelected($idWelfare_Type)
    {
        $chk=WelfareOfWork::where('idUser',Auth::getUser()->id);
        if($chk->count() == 0){
            $chkCandidate=Candidate::where('TelephoneNumber',NULL)->where('idUser',Auth::getUser()->id);
            if($chkCandidate->count() == 0){
                switch ($idWelfare_Type) {
                    case '5':
                    case '28':
                    case '29':
                    case '35':
                    case '44':
                    case '45':
                        return "selected";
                    break;
                }
            }
        }else{
            $chk->where('idWelfare_Type',$idWelfare_Type);
            if($chk->count() > 0){
                return "selected";
            }    
        }
        
    }

    public function loadWelfareType()
    {
        $get=WelfareType::get()->toArray();
        if($get){
            foreach ($get as $key => $value) {
                $get[$key]['selected']=$this->chkWelfareSelected($value['idWelfare_Type']);
            }
        }
        return $get;
    }

    public function loadSourceType()
    {
        //return SourceType::all();
        $get=SourceType::where('Verify',1);
        $chkSourceType=Candidate::where('idUser',Auth::getUser()->id);
        if($chkSourceType->count() > 0){
            $get->orWhere('idSources_Type',$chkSourceType->first()->idSources_Type);
        }
        $get->orderBy('Status','ASC');
        return $get->get();
    }

    public function loadTypeOfEmployment()
    {
        return TypeOfEmployment::all();
    }

    public function loadTransportationMRT()
    {
        /*return TransportationDetail::whereIn('Name_EN',[3,4,5,6,7,8])->get();*/
        $get=TransportationDetail::where('Name_EN', 'like', '%MRT%')
        ->groupBy('Name_EN')->get()->toArray();
        if($get){
            foreach ($get as $key => $value) {
                $get[$key]['Station']=TransportationDetail::select('idTransportation_Detail','Station_TH')->where('Name_EN',$value['Name_EN'])->get()->toArray();
            }
        }
        return $get;
    }

    public function loadTransportationBTS()
    {
        //return TransportationDetail::whereIn('idTransportation_Detail',[1,2])->get();
        $get=TransportationDetail::where('Name_EN', 'like', '%BTS%')
        ->groupBy('Name_EN')->get()->toArray();
        if($get){
            foreach ($get as $key => $value) {
                $get[$key]['Station']=TransportationDetail::select('idTransportation_Detail','Station_TH')->where('Name_EN',$value['Name_EN'])->get()->toArray();
            }
        }
        return $get;
    }

    public function loadTransportationBRT()
    {
        $get=TransportationDetail::where('Name_EN', 'like', '%BRT%')
        ->groupBy('Name_EN')->get()->toArray();
        if($get){
            foreach ($get as $key => $value) {
                $get[$key]['Station']=TransportationDetail::select('idTransportation_Detail','Station_TH')->where('Name_EN',$value['Name_EN'])->get()->toArray();
            }
        }
        return $get;
    }

    public function loadTransportationBUS()
    {
        $get=TransportationDetail::where('Name_EN', 'like', '%Bus%')
        ->groupBy('Name_EN')->get()->toArray();
        if($get){
            foreach ($get as $key => $value) {
                $get[$key]['Station']=TransportationDetail::select('idTransportation_Detail','Station_TH')->where('Name_EN',$value['Name_EN'])->get()->toArray();
            }
        }
        return $get;
    }

    public function loadTransportationFerry()
    {
        $get=TransportationDetail::where('Name_EN', 'like', '%Ferry%')
        ->groupBy('Name_EN')->get()->toArray();
        if($get){
            foreach ($get as $key => $value) {
                $get[$key]['Station']=TransportationDetail::select('idTransportation_Detail','Station_TH')->where('Name_EN',$value['Name_EN'])->get()->toArray();
            }
        }
        return $get;
    }

    public function loadTransportationAirLink()
    {
        $get=TransportationDetail::where('Name_EN', 'like', '%Airport%')
        ->groupBy('Name_EN')->get()->toArray();
        if($get){
            foreach ($get as $key => $value) {
                $get[$key]['Station']=TransportationDetail::select('idTransportation_Detail','Station_TH')->where('Name_EN',$value['Name_EN'])->get()->toArray();
            }
        }
        return $get;
    }

    public function chkExpectedSelected($idExpected_Detail)
    {

        $chk=Db::table('expectation_of_work')->where('idCandidate',Session::get('idCandidate'));
        if($chk->count() == 0){
            return "selected";
        }
        $chk->where('idExpected_Detail',$idExpected_Detail);
        if($chk->count() > 0){
            return "selected";
        }
        return "";
    }

    public function loadExpectedDetail()
    {
        //return ExpectedDetail::all();
        $get=ExpectedDetail::get()->toArray();
        if($get){
            foreach ($get as $key => $value) {
                $get[$key]['selected']=$this->chkExpectedSelected($value['idExpected_Detail']);
            }
        }
        return $get;
    }

    public function loadLanguate()
    {
        return CountryCallingCode::where('Language_TH','!=','')->get();
    }

    public function onGetPrefix()
    {
        return Prefix::select('idPrefix AS id','Name_TH')->whereIn('idGender',[post('value'),'99'])->get();
    }

    public function onGetInstituteDetail()
    {
        $query=InstituteDetail::select('idInstitute_Detail AS id','Name_TH')->where('idGeography',post('idGeography'));
        if(post('type_of_institue')!=0){
            $query->where('idType_of_Institute',post('type_of_institue'));
        }
        return $query->get();
    }

    public function onGetJobTitle()
    {
        return JobTitle::select('idJob_Title AS id','Name_TH')->where('idJob_Category',post('value'))->get();
    }

    public function onGetEducationLevel()
    {
        if(post('value')==""){
            return false;
        }
        $get=InstituteDetail::select('Min_Level','Max_Level')->where('idInstitute_Detail',post('value'))->first();
        return EducationLevel::select('idEducation_Level AS id','Name_TH')->where('Level','>=',$get->Min_Level)->where('Level','<=',$get->Max_Level)->get();
    }

    public function onGetDegreeAndCertificate()
    {
        return DegreeCertificate::select('idDegree_and_Certificate AS id','Name_TH')->where('idEducation_Level',post('value'))->get();
    }

    public function onGetFaculty()
    {
        return FacultyDetail::select('idFaculty_Detail AS id','Name_TH')->where('idInstitute_Detail',post('value'))->get();
    }

    public function onGetDepartment()
    {
        return Department::select('idDepartment as id','Name_TH')->where('idFaculty_Detail',post('value'))->get();
    }

    public function onGetMajor()
    {
        return MajorSubject::select('idMajor_Subject as id','Name_TH')->where('idDepartment',post('value'))->get();
    }

    public function onGetDistrict()
    {
        return District::select('idDistricts as id' , 'Name_TH')->where('idProvinces',post('value'))->get();
    }

    public function onGetSubDistrict()
    {
        return Subdistrict::select('idSubdistricts as id' , 'Name_TH')->where('idDistricts',post('value'))->get();
    }

    public function onGetSeniority()
    {   
        $get=Seniority::select('idSeniority AS id','Name_TH')->orderBy('Level','ASC');
        if(post('value')=='1'){
            $get->whereIn('idSeniority',[1,9]);
        }else{
            $get->whereNotIn('idSeniority',[1,9]);
        }
        return $get->get();
    }

    public function onGetSkillList()
    {
        return SkillList::select('idSkill_List AS id','Name_TH')->where('idJob_Title',post('value'))->get();
    }

    public function loadCandidate()
    {
        $get=Candidate::where('idUser',Auth::getUser()->id)->first();
        if($get){
            $get->Date_of_Birth=$this->convertDateToForm($get->Date_of_Birth);
        }
        //dd(Auth::getUser()->id);
        return $get;
    }

    public function loadEducation()
    {
        /*$get=Education::join('institute_detail','education.idInstitute_Detail','=','institute_detail.idInstitute_Detail')
        ->join('geography','institute_detail.idGeography','=','geography.idGeography')
        ->where('idUser',Auth::getUser()->id)->first();*/
        $get=Education::where('idUser',Auth::getUser()->id);
        if($get->count() > 0 and $get->first()->idEducation_Level!=1){
            $get->join('institute_detail','education.idInstitute_Detail','=','institute_detail.idInstitute_Detail')
            ->join('geography','institute_detail.idGeography','=','geography.idGeography');
        }
        return $get->first();
    }

    public function loadExperience()
    {
        $get=Db::table('experience')
        ->join('seniority','experience.idSeniority','=','seniority.idSeniority')
        ->where('idUser',Auth::getUser()->id)->first();
        if($get){
            $get->Date_Start=$this->convertDateToForm($get->Date_Start);
            $get->Date_End=$this->convertDateToForm($get->Date_End);
        }
        return $get;
    }

    public function loadSkillLanguage()
    {
        $get=Db::table('skill_language')
        ->where('idUser',Auth::getUser()->id)->first();
        return $get;
    }

    public function loadSkillBasicCom()
    {
        $get=Db::table('skill_basic_computer')
        ->where('idUser',Auth::getUser()->id)->first();
        return $get;
    }

    public function loadRequirementOfWork()
    {
        $get=RequirementOfWork::join('job_title','requirement_of_work.idJob_Title','=','job_title.idJob_Title')
        ->where('idUser',Auth::getUser()->id)->first();
        return $get;
    }

    public function loadSkillSpecific()
    {
        $get=Db::table('skill_specific')
        ->where('idUser',Auth::getUser()->id)->first();
        return $get;
    }

    public function typeTranpotation($type)
    {
        switch (true) {
            case strpos($type, 'BTS') !== false:
                return 'BTS';
            break;
            case strpos($type, 'MRT') !== false:
                return 'MRT';
            break;
            case strpos($type, 'BRT') !== false:
                return 'BRT';
            break;
            case strpos($type, 'Airport') !== false:
                return 'Airport';
            break;
            case strpos($type, 'Ferry') !== false:
                return 'Ferry';
            break;
            case strpos($type, 'SRT') !== false:
                return 'SRT';
            break;
            case strpos($type, 'Personal') !== false:
                return 'Personal';
            break;
            case strpos($type, 'Bus') !== false:
                return 'Bus';
            break;
        }
    }

    public function loadTransportationOfWork($type)
    {
        $get=TransportationOfWork::join('transportation_detail','transportation_of_work.idTransportation_Detail','=','transportation_detail.idTransportation_Detail')
        ->where('transportation_of_work.idUser',Auth::getUser()->id)
        ->where('transportation_detail.Name_EN','like','%'.$type.'%')
        ->first();
        return $get;
    }

    public $imgcvs;
    public $prefixs;
    public $genders;
    public $religions;
    public $countrycallingcodes;
    public $skilllists;
    public $communication_providers;
    public $geographys;
    public $type_of_institues;
    public $education_levels;
    public $institute_alls;
    public $degree_certifidates;
    public $job_categorys;
    public $senioritys;
    public $experience_work_statuss;
    public $salary_ranges;
    public $availability_of_works;
    public $job_seeker_statuses;
    public $provinces;
    public $welfare_types;
    public $source_types;
    public $type_of_employments;
    public $transportation_mrts;
    public $transportation_btss;
    public $transportation_brts;
    public $transportation_buss;
    public $transportation_ferrys;
    public $transportation_airlinks;
    public $expected_details;
    public $languages;
    public $job_titles;
    public $candidates;
    public $educations;
    public $experiences;
    public $skilllangs;
    public $skill_basic_coms;
    public $requirement_of_works;
    public $skillspecifics;
    public $transportation_of_works_btss;
    public $transportation_of_works_mrts;
    public $transportation_of_works_brts;
    public $transportation_of_works_airports;
    public $transportation_of_works_ferrys;
    public $transportation_of_works_trains;
    public $transportation_of_works_personals;
    public $transportation_of_works_buss;
}