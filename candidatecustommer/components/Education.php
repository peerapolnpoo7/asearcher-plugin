<?php namespace Asearcher\Candidatecustommer\Components;

use Cms\Classes\ComponentBase;
use Session;
use Auth;
use Input;
use Request;
use Validator;
use Redirect;
use Response;
use Db;

use ValidationException;
use Flash;

use Asearcher\CandidateCustommer\Models\EducationLevel;
use Asearcher\CandidateCustommer\Models\Geography;
use Asearcher\CandidateCustommer\Models\TypeOfInstitute;
use Asearcher\CandidateCustommer\Models\InstituteDetail;
use Asearcher\CandidateCustommer\Models\DegreeCertificate;
use Asearcher\CandidateCustommer\Models\Educations;
use Asearcher\CandidateCustommer\Models\FacultyDetail;
use Asearcher\CandidateCustommer\Models\Department;
use Asearcher\CandidateCustommer\Models\MajorSubject;
use Asearcher\CandidateCustommer\Models\EducationStatus;
use Asearcher\CandidateCustommer\Models\Candidate;



class Education extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'education Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
      $this->addJs('assets/js/cv-education.js');
      $this->addCss('assets/css/cv-education.css');
      $this->education_levels=$this->loadEducationLevel();
      $this->geographys=$this->loadGeography();
      $this->type_of_institues=$this->loadTypeOfInstitute();
      $this->institute_alls=$this->loadIntituteDetail();
      $this->degree_certifidates=$this->loadDegreeCertificate();
      $this->educations=$this->loadEducation();
      $this->educationstatus=$this->loadEducationStatus();
      $this->updegree=$this->loadUpDegree();
      $this->underdegree=$this->loadUndergradDegree();
    }

    public function onSave(){

    }


    public function onAddEducation(){

      $rules = array(
          'idEducation_Level' => array('required'),
      );

      $messages = [
          'idEducation_Level.required' => 'กรุณาเลือก "ระดับการศึกษา"',
      ];

            if(post('idEducation_Level')  != '' && post('idEducation_Level')  != 1){
              $rules_more= array(
                'idGeography' => array('required'),
                'type_of_institue' => array('required'),
                'idInstitute_Detail' => array('required'),
              );
              $messages_more = [
                'idGeography.required' => 'กรุณาเลือก "ที่ตั้งสถาบัน"',
                'type_of_institue.required' => 'กรุณาเลือก "ประเภทสถาบัน"',
                'idInstitute_Detail.required' => 'กรุณาเลือก "ชื่อสถาบัน"',
              ];

              $rules = array_merge($rules,$rules_more);
              $messages = array_merge($messages,$messages_more);
            }


            $rules_more = array(
                'idEducation_Status' => array('required'),
                'start_Year' => array('required'),
                'idDegree_and_Certificate' => array('required'),
                'GPA_Education' => array('required','regex:/^[0]|[0-3]\.(\d{2})|[4].[0]{2}$/'),
            );

            $messages_more = [
                'idEducation_Status.required' => 'กรุณาเลือก "สถานะการศึกษา"',
                'start_Year.required' => 'กรุณากรอก "ปีที่เริ่มการศึกษา"',
                'idDegree_and_Certificate.required' => 'กรุณาเลือก "วุฒิการศึกษา"',
                'GPA_Education.required' => 'กรุณากรอก "เกรดเฉลี่ย"',
                'GPA_Education.regex' => 'รูปแบบของ "GPA" ไม่ถูกต้อง',
            ];

          $rules = array_merge($rules,$rules_more);
          $messages = array_merge($messages,$messages_more);

          $validator = Validator::make(Input::all(), $rules, $messages);

          if ($validator->fails()) {
              throw new ValidationException($validator);
          }

        $get = Candidate::WHERE('idUser',Auth::getUser()->id)->first();
        $education = new Educations();
        $education->idCandidate = $get->idCandidate;
        $education->idUser = Auth::getUser()->id;
        $education->idEducation_Level = post('idEducation_Level');
        if(post('idEducation_Level')!=1 ){
            // $education->idGeography = post('idGeography');
            // $education->type_of_institue = post('type_of_institue');
            $education->idInstitute_Detail = post('idInstitute_Detail');
            $education->idFaculty_Detail = post('idFaculty_Detail');
            $education->idDepartment = post('idDepartment')!='' ? post('idDepartment'):NULL;
            $education->idMajor_Subject = post('idMajor_Subject')!='' ? post('idMajor_Subject'):NULL;
            $education->idEducation_Status = post('idEducation_Status');
            $education->Year_of_Admission = post('start_Year');
            $education->Year_of_Graduation = post('end_Year') !='' ? post('end_Year'):0;
        }else{
            // $education->idGeography = NULL;
            // $education->type_of_institue = NULL;
            $education->idInstitute_Detail = NULL;
            $education->idFaculty_Detail = NULL;
            $education->idDepartment = NULL;
            $education->idMajor_Subject = NULL;
            $education->idEducation_Status = post('idEducation_Status');
            $education->Year_of_Admission = post('start_Year');
            $education->Year_of_Graduation = post('end_Year') !='' ? post('end_Year'):0;
        }
        $education->idDegree_and_Certificate = post('idDegree_and_Certificate');
        $education->GPA = post('GPA_Education');
        $education->save();

        Flash::success('บันทึกข้อมูลเรียบร้อยแล้ว');
        return Redirect::to('/cv-education');

    }

    public function loadEducationLevel()
    {
        return EducationLevel::all();
    }

    public function loadGeography()
    {
        return Geography::all();
    }

    public function loadTypeOfInstitute()
    {
        return TypeOfInstitute::all();
    }

    public function loadIntituteDetail()
    {
        return InstituteDetail::all();
    }

    public function loadDegreeCertificate()
    {
        return DegreeCertificate::all();
    }

    public function loadEducationStatus()
    {
        return EducationStatus::all();
    }

    public function onGetDegreeAndCertificate()
    {
        return DegreeCertificate::select('idDegree_and_Certificate AS id','Name_TH')->where('idEducation_Level',post('value'))->get();
    }

    public function loadEducation()
    {
        $get=Educations::where('idUser',Auth::getUser()->id);
        if($get->count() > 0 and $get->first()->idEducation_Level!=1){
            $get->join('institute_detail','education.idInstitute_Detail','=','institute_detail.idInstitute_Detail')
            ->join('geography','institute_detail.idGeography','=','geography.idGeography');
        }
        return $get->get();
    }

    public function loadUpDegree()
    {
        $get = Educations::select('education.*','institute_detail.Name_TH AS nameinstitute','geography.Name_TH AS namegeography','degree_and_certificate.Abbreviation_TH AS namedegree','department.Name_TH AS namedepartment','faculty_detail.Name_TH AS namefaculty')
        ->leftJoin('institute_detail','education.idInstitute_Detail','=','institute_detail.idInstitute_Detail')
        ->leftJoin('degree_and_certificate','education.idDegree_and_Certificate','=','degree_and_certificate.idDegree_and_Certificate')
        ->leftJoin('geography','institute_detail.idGeography','=','geography.idGeography')
        ->leftJoin('department','education.idDepartment','=','department.idDepartment')
        ->leftJoin('faculty_detail','education.idFaculty_Detail','=','faculty_detail.idFaculty_Detail')
        ->where('idUser',Auth::getUser()->id)->whereNotIn('education.idEducation_Level',[1])->get();
        // dd($get);
        return $get;
    }

    public function loadUndergradDegree()
    {
        $get = Educations::select('education.*','institute_detail.Name_TH AS nameinstitute','geography.Name_TH AS namegeography','degree_and_certificate.Abbreviation_TH AS namedegree','department.Name_TH AS namedepartment','education_level.Name_TH AS nameeducation_level')
        ->leftJoin('institute_detail','education.idInstitute_Detail','=','institute_detail.idInstitute_Detail')
        ->leftJoin('degree_and_certificate','education.idDegree_and_Certificate','=','degree_and_certificate.idDegree_and_Certificate')
        ->leftJoin('geography','institute_detail.idGeography','=','geography.idGeography')
        ->leftJoin('department','education.idDepartment','=','department.idDepartment')
        ->leftJoin('education_level','education.idEducation_Level','=','education_level.idEducation_Level')
        ->where('idUser',Auth::getUser()->id)->whereIn('education.idEducation_Level',[1])->get();
        // dd($get);
        return $get;
    }

    public function onGetEducationLevel()
    {
      return  EducationLevel::all();
    }

    public function onGetInstituteDetail()
    {
        $query=InstituteDetail::select('idInstitute_Detail AS id','Name_TH')->where('idGeography',post('idGeography'));
        if(post('type_of_institue')!=0){
            $query->where('idType_of_Institute',post('type_of_institue'));
        }
        return $query->get();
    }


    public function onGetFaculty()
    {

        return FacultyDetail::select('idFaculty_Detail AS id','Name_TH')->where('idInstitute_Detail',post('value'))->get();
    }

    public function onGetTypeOfInstitue()
    {
        return InstituteDetail::select('idType_of_Institute')->where('idInstitute_Detail',post('value'))->first();
    }

    public function onGetDepartment()
    {
        return Department::select('idDepartment as id','Name_TH')->where('idFaculty_Detail',post('value'))->get();
    }

    public function onGetMajor()
    {
        return MajorSubject::select('idMajor_Subject as id','Name_TH')->where('idDepartment',post('value'))->get();
    }

    public function onSetting_Edu()
    {
        $get = Educations::where('idUser',Auth::getUser()->id)->get();

          foreach ($get as $edu_Set) {
            if ($edu_Set->idEducation == post('idEdu')) {
              $edu_Set->Setting_Edu_CV = 1;
              $edu_Set->save();
            }else {
              $edu_Set->Setting_Edu_CV = 0;
              $edu_Set->save();
            }
          }
            $gg = Educations::where('idUser',Auth::getUser()->id)->where('Setting_Edu_CV',1)->get();
            return $gg;
    }

    public function onEducation()
    {
        $get = Educations::where('idUser',Auth::getUser()->id)->get();
        return $get;
    }


    public $education_levels;
    public $geographys;
    public $type_of_institues;
    public $institute_alls;
    public $degree_certifidates;
    public $educations;
    public $educationstatus;
    public $updegree;
    public $underdegree;
}
