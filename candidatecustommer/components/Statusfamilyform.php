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

use Asearcher\CandidateCustommer\Models\Military;
use Asearcher\CandidateCustommer\Models\MaritalStatus;
use Asearcher\CandidateCustommer\Models\Occupation;
use Asearcher\CandidateCustommer\Models\MaritalRegiterStatus;
use Asearcher\CandidateCustommer\Models\CountryCallingCode;
use Asearcher\CandidateCustommer\Models\Candidate;
use Asearcher\CandidateCustommer\Models\Families;
use Asearcher\CandidateCustommer\Models\RelationshipType;
use Asearcher\CandidateCustommer\Models\Prefix;
use Asearcher\CandidateCustommer\Models\StatusCandidate;

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

      $this->father = $this->loadfami(1);
      $this->mother = $this->loadfami(2);

      // if (condition) {
      //   $this->spouse = $this->loadfami(4);
      // }else {
      //   $this->spouse = $this->loadfami(3);
      // }


      $this->addJs('assets/js/cv-family.js');
      $this->addCss('assets/css/cv-family.css');
      $this->militarys=$this->loadmilitary();
      $this->maritalstatuss=$this->loadMarital_status();
      $this->occupations=$this->loadOccupation();
      $this->maritalregiterstatus=$this->loadMaritalregiterstatus();
      $this->countrycallingcodes=$this->loadCountryCallingCode();
      $this->candidates=$this->loadCandidate();
      $this->familiess=$this->loadFamilies();
      $this->relationshiptypes=$this->loadRelationshipType();
      $this->prefixs=$this->loadPrefix();
      $this->prefixsfa=$this->loadPrefixFa();
      $this->prefixsmo=$this->loadPrefixMo();
      $this->prefixsspo=$this->loadPrefixSpouse();
      $this->statuscandidates=$this->loadStatusCandidate();
      $this->onstatuscandidates=$this->onStatusCandidate();

    }

    public function onSave(){


              $rules = array(
                  'typeMilitary' => array('required')
              );
              $messages = [
                  'typeMilitary.required' => 'กรุณาเลือก "สถานะทางทหาร"'
              ];


              $validator = Validator::make(Input::all(), $rules, $messages);

              if ($validator->fails()) {
                  throw new ValidationException($validator);
              }

      $chkStatusCan=StatusCandidate::where('idCandidate',Session::get('idCandidate'));
      if($chkStatusCan->count() > 0){
          $statuscandidate = StatusCandidate::find($chkStatusCan->first()->idStatus_Candidate);
      }else{
          $statuscandidate = new StatusCandidate();
      }
      $statuscandidate->idCandidate = Session::get('idCandidate');
      $statuscandidate->idUser = Auth::getUser()->id;
      $statuscandidate->idRace = 0;
      $statuscandidate->idReligion = 0;
      //สถานะทางทหาร
      $statuscandidate->idMilitary = Input::get('typeMilitary');
      //สถานภาพสมรส
      $statuscandidate->idMarital_Status = Input::get('typeMarital');
      //สถานะการจดทะเบียน
      if ($statuscandidate->idMarital_Status != '1') {
        $statuscandidate->idMarital_Register_Status = Input::get('typeMarital_register_status');
      }else {
        $statuscandidate->idMarital_Register_Status = '0';
      }
      $statuscandidate->save();



      if ($statuscandidate->idMarital_Status != 1) {
        //คู่สมรส
        $chkfami_spouse=Families::where('idCandidate',Session::get('idCandidate'));
        if($chkfami_spouse->count() > 0){
            $families_spouse = Families::find($chkfami_spouse->first()->idFamilies);
        }else{
            $families_spouse = new Families();
        }
        $families_spouse->idCandidate = Session::get('idCandidate');
        $families_spouse->idUser = Auth::getUser()->id;
        $families_spouse->idPrefix = Input::get('idPrefix_Spouse');
        $families_spouse->FirstName_TH = Input::get('FirstName_TH_Spouse');
        $families_spouse->LastName_TH = Input::get('LastName_TH_Spouse');
        $families_spouse->NickName_TH = Input::get('NickName_TH_Spouse');
        $families_spouse->idOccupation = Input::get('idOccupation_Spouse');
        $families_spouse->Date_of_Birth = Input::get('Date_of_Birth_Spouse');
        $families_spouse->idCountry_Calling_Code = Input::get('idCountry_Calling_Code_Spouse');
        $families_spouse->TelephoneNumber = Input::get('TelephoneNumber_Spouse');
        $families_spouse->Amount_of_Children = Input::get('Amount_of_Children');

        if ($statuscandidate->idMarital_Status == 2) {
          $families_spouse->idLife_Status = 1;
        }else if($statuscandidate->idMarital_Status == 3 || $statuscandidate->idMarital_Status == 5){
          $families_spouse->idLife_Status = 3;
        }else {
          $families_spouse->idLife_Status = 2;
        }
        $checkGender = Candidate::where('idUser',Auth::getUser()->id)->first();

        if ($checkGender->idGender == 1) {
          $families_spouse->idRelationship_type = 4;
        }else {
          $families_spouse->idRelationship_type = 3;
        }

        $families_spouse->save();

      }

      Flash::success('บันทึกข้อมูลเรียบร้อยแล้ว');
      return Redirect::to('/cv-family');

     // //บุตร
     //
     //
     //   if($families_spouse->Amount_of_Children !="" || $families_spouse->Amount_of_Children !="0"){
     //     // $idPrefix_Children = Input::get('idPrefix_Children');
     //     // $FirstName_TH_Children = Input::get('FirstName_TH_Children');
     //     // $LastName_TH_Children = Input::get('LastName_TH_Children');
     //     // $AgeChildren = Input::get('AgeChildren');
     //
     //     // $array1 = array("idPrefix_Children" => $idPrefix_Children);
     //     // $array2 = array("FirstName_TH_Children" => $FirstName_TH_Children);
     //     // $array3 = array("LastName_TH_Children" => $LastName_TH_Children);
     //     // $array4 = array("AgeChildren" => $AgeChildren);
     //
     //     // $Children = array_merge($array1,$array2,$array3,$array4);
     //
     //     for ($i=0; $i < $families->Amount_of_Children ; $i++) {
     //       $families_children = new Families();
     //       $families_children->idCandidate = Session::get('idCandidate');
     //       $families_children->idUser = Auth::getUser()->id;
     //       $families_children->idPrefix_Children = post('idPrefix_Children')[$i];
     //       $families_children->FirstName_TH_Children = post('FirstName_TH_Children')[$i];
     //       $families_children->LastName_TH_Children = post('LastName_TH_Children')[$i];
     //       $families_children->AgeChildren = post('AgeChildren')[$i];
     //       $families_children->idRelationship_type = '5';
     //       // echo $families_children->idCandidate;
     //       // echo $families_children->idUser;
     //       // echo $families_children->idPrefix_Children;
     //       // echo $families_children->FirstName_TH_Children;
     //       // echo $families_children->LastName_TH_Children;
     //       // echo $families_children->AgeChildren;
     //       // echo $families_children->idRelationship_type;
     //       // echo "-----";
     //     }
     //    }
     //
     // //บิดา
     //
     // $families_father = new Families();
     // $families_father->idCandidate = Session::get('idCandidate');
     // $families_father->idUser = Auth::getUser()->id;
     // $families_father->idPrefix = post('TitleNameFather');
     // $families_father->FirstName_TH = post('FirstName_TH_Father');
     // $families_father->LastName_TH = post('LastName_TH_Father');
     // //ชื่อเล่น
     // $families_father->idLife_Status = post('Status_Father');
     // //วันเกิด
     // // $families_father->idRelationship_type = post('Age_Father');
     // $families_father->idOccupation = post('idOccupation_Father');
     // $families_father->idCountry_Calling_Codes = post('idCountry_Calling_Code_Father');
     // $families_father->TelephoneNumber = post('TelephoneNumber_Father');
     // // TitleNameFather
     // // FirstName_TH_Father
     // // LastName_TH_Father
     // // Status_Father
     // // Age_Father
     // // idOccupation_Father
     // // idCountry_Calling_Code_Father
     // // TelephoneNumber_Father
     //
     // // //มารดา
     //
     // // $families_Mother = new Families();
     // // $families_Mother->idCandidate = Session::get('idCandidate');
     // // $families_Mother->idUser = Auth::getUser()->id;
     // // $families_Mother->idPrefix = post('TitleNameMother');
     // // $families_Mother->FirstName_TH = post('FirstName_TH_Mother');
     // // $families_Mother->LastName_TH = post('LastName_TH_Mother');
     // // //ชื่อเล่น
     // // $families_Mother->idLife_Status = post('Status_Mother');
     // // //วันเกิด
     // // // $families_Mother->idRelationship_type = post('Age_Mother');
     // // $families_Mother->idOccupation = post('idOccupation_Mother');
     // // $families_Mother->idCountry_Calling_Codes = post('idCountry_Calling_Code_Mother');
     // // $families_Mother->TelephoneNumber = post('TelephoneNumber_Mother');
     //
     // // TitleNameMother
     // // FirstName_TH_Mother
     // // LastName_TH_Mother
     // // Status_Mother
     // // Age_Mother
     // // idOccupation_Mother
     // // idCountry_Calling_Code_Mother
     // // TelephoneNumber_Mother
     //
     //
     // //พี่น้อง
     //
     // $families->NumBrethren = Input::get('NumBrethren');
     //
     // if($families->$families->NumBrethren !="" || $families->NumBrethren !="0"){
     //   for ($i=0; $i < $families->NumBrethren ; $i++) {
     //     $families_brethren = new Families();
     //     $families_brethren->idCandidate = Session::get('idCandidate');
     //     $families_brethren->idUser = Auth::getUser()->id;
     //     $families_brethren->idPrefix_Children = post('TitleNameBrethren')[$i];
     //     $families_brethren->FirstName_TH_Children = post('FirstName_TH_Brethren')[$i];
     //     $families_brethren->LastName_TH_Children = post('LastName_TH_Brethren')[$i];
     //     $families_brethren->Gender_Brethren = post('Gender_Brethren')[$i];
     //     $families_brethren->Status_Brethren = post('Status_Brethren')[$i];
     //     $families_brethren->Age_Brethren = post('Age_Brethren')[$i];
     //     $families_brethren->idOccupation_Brethren = post('idOccupation_Brethren')[$i];
     //
     //     // $families_brethren->idRelationship_type = '5';
     //   }
     //  }

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

    public function loadMaritalregiterstatus()
    {
       return MaritalRegiterStatus::where('idMarital_Register_Status','!=','99')->get();
    }

    public function loadCountryCallingCode()
    {
        return CountryCallingCode::all();
    }

    public function loadCandidate()
    {
        $get = Candidate::where('idUser',Auth::getUser()->id)->first();
        // if($get){
        //     $get->Date_of_Birth=$this->convertDateToForm($get->Date_of_Birth);
        // }
        // dd($get);
        return $get;

    }

    public function loadFamilies()
    {
          return Families::where('idUser',Auth::getUser()->id)->first();
         // $get = Families::all();
         // // dd($get);
         // return $get;
    }

    public function loadRelationshipType()
    {
        return RelationshipType::all();
    }

    public function loadPrefix()
    {
        // $chkGender=Candidate::where('idGender','!=','')->where('idCandidate',Session::get('idCandidate'));
        // if($chkGender->count()==0){
        //     return Prefix::all();
        // }else{
            return Prefix::where('idGender','!=',99)->get();
        // }
        // return Prefix::all();
    }

    public function loadPrefixFa()
    {
            $get = Prefix::where('idGender','!=','2')->where('Type','!=','O')->get();
            return $get;
    }

    public function loadPrefixMo()
    {
            $get = Prefix::where('idGender','!=','1')->where('Type','!=','O')->get();
            return $get;
    }

    public function loadPrefixSpouse()
    {
            $get = Prefix::where('Type','!=','O')->get();
            return $get;
    }

    public function loadStatusCandidate()
    {
      $get=StatusCandidate::where('idUser',Auth::getUser()->id)->first();
      //dd($get);
      // if($get){
      //     $get->Date_of_Birth=$this->convertDateToForm($get->Date_of_Birth);
      // }
      // dd(Auth::getUser()->id);
      // dd($get->idMilitary);
      return $get;
        // return StatusCandidate::all();
    }

    public function onStatusCandidate()
    {
        $get = StatusCandidate::select('idMilitary','idMarital_Status','idMarital_Register_Status')->where('idUser',Auth::getUser()->id)->first();
        // dd($get);
        return $get;
    }

    public function onCandidate()
    {
        $get = Candidate::select('idCandidate','idUser','idGender','idPrefix','FirstName_TH','LastName_TH','Date_of_Birth','idCountry_Calling_Code','TelephoneNumber')
        ->where('idUser',Auth::getUser()->id)->first();
        // dd($get);
        return $get;
    }



    public function loadfami($type)
    {
        $get = Families::where('idUser',Auth::getUser()->id)->where('idRelationship_type',$type)->first();
        // dd($get);
        return $get;
    }



    public $militarys;
    public $maritalstatuss;
    public $occupations;
    public $maritalregiterstatus;
    public $countrycallingcodes;
    public $familiess;
    public $relationshiptypes;
    public $prefixs;
    public $prefixsfa;
    public $prefixsmo;
    public $prefixsspo;
    public $statuscandidates;
    public $onstatuscandidates;
    public $candidates;
    public $father;
    public $mother;
    public $spouse;
}
