<?php namespace Asearcher\Candidatecustommer\Components;

use Session;
use Auth;
use Input;

use Cms\Classes\ComponentBase;

use Asearcher\CandidateCustommer\Models\Military;
use Asearcher\CandidateCustommer\Models\MaritalStatus;
use Asearcher\CandidateCustommer\Models\Occupation;
use Asearcher\CandidateCustommer\Models\MaritalRegiterStatus;
use Asearcher\CandidateCustommer\Models\CountryCallingCode;
use Asearcher\CandidateCustommer\Models\Candidate;
use Asearcher\CandidateCustommer\Models\Families;
use Asearcher\CandidateCustommer\Models\RelationshipType;
use Asearcher\CandidateCustommer\Models\Prefix;

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
      $this->maritalregiterstatus=$this->loadMaritalregiterstatus();
      $this->countrycallingcodes=$this->loadCountryCallingCode();
      $this->candidates=$this->loadCandidate();
      $this->familiess=$this->loadFamilies();
      $this->relationshiptypes=$this->loadRelationshipType();
      $this->prefixs=$this->loadPrefix();
    }

    public function onSave(){
      // $candidate = Candidate::find(Session::get('idCandidate'));
      // // $chkEdu=Education::where('idCandidate',Session::get('idCandidate'));
      // $idCandidate = Session::get('idCandidate');
      // $message = "wrong answer";

      $families = new Families();
      //สถานะทางทหาร
      $families->idtypeMilitary = Input::get('typeMilitary');
      //สถานภาพสมรส
      $families->idtypeMarital = Input::get('typeMarital');

      //คู่สมรส
      $families->idtypeMarital_regiter_status = Input::get('typeMarital_regiter_status');
      $families->idPrefix_Spouse = Input::get('idPrefix_Spouse');
      $families->FirstName_TH_Spouse = Input::get('FirstName_TH_Spouse');
      $families->LastName_TH_Spouse = Input::get('LastName_TH_Spouse');
      $families->NickName_TH_Spouse = Input::get('NickName_TH_Spouse');
      $families->idOccupation_Spouse = Input::get('idOccupation_Spouse');
      $families->Date_of_Birth_Spouse = Input::get('Date_of_Birth_Spouse');
      $families->idCountry_Calling_Code_Spouse = Input::get('idCountry_Calling_Code_Spouse');
      $families->TelephoneNumber_Spouse = Input::get('TelephoneNumber_Spouse');
      $families->Amount_of_Children = Input::get('Amount_of_Children');

     //บุตร
       print_r(post());

       if($families->Amount_of_Children !="" || $families->Amount_of_Children !="0"){
         // $idPrefix_Children = Input::get('idPrefix_Children');
         // $FirstName_TH_Children = Input::get('FirstName_TH_Children');
         // $LastName_TH_Children = Input::get('LastName_TH_Children');
         // $AgeChildren = Input::get('AgeChildren');

         // $array1 = array("idPrefix_Children" => $idPrefix_Children);
         // $array2 = array("FirstName_TH_Children" => $FirstName_TH_Children);
         // $array3 = array("LastName_TH_Children" => $LastName_TH_Children);
         // $array4 = array("AgeChildren" => $AgeChildren);

         // $Children = array_merge($array1,$array2,$array3,$array4);

         for ($i=0; $i < $families->Amount_of_Children ; $i++) {
           $families_children = new Families();
           $families_children->idCandidate = Session::get('idCandidate');
           $families_children->idUser = Auth::getUser()->id;
           $families_children->idPrefix_Children = post('idPrefix_Children')[$i];
           $families_children->FirstName_TH_Children = post('FirstName_TH_Children')[$i];
           $families_children->LastName_TH_Children = post('LastName_TH_Children')[$i];
           $families_children->AgeChildren = post('AgeChildren')[$i];
           $families_children->idRelationship_type = '5';
           // echo $families_children->idCandidate;
           // echo $families_children->idUser;
           // echo $families_children->idPrefix_Children;
           // echo $families_children->FirstName_TH_Children;
           // echo $families_children->LastName_TH_Children;
           // echo $families_children->AgeChildren;
           // echo $families_children->idRelationship_type;
           // echo "-----";
         }
        }

     //บิดา

     $families_father = new Families();
     $families_father->idCandidate = Session::get('idCandidate');
     $families_father->idUser = Auth::getUser()->id;
     $families_father->idPrefix = post('TitleNameFather');
     $families_father->FirstName_TH = post('FirstName_TH_Father');
     $families_father->LastName_TH = post('LastName_TH_Father');
     //ชื่อเล่น
     $families_father->idLife_Status = post('Status_Father');
     //วันเกิด
     // $families_father->idRelationship_type = post('Age_Father');
     $families_father->idOccupation = post('idOccupation_Father');
     $families_father->idCountry_Calling_Codes = post('idCountry_Calling_Code_Father');
     $families_father->TelephoneNumber = post('TelephoneNumber_Father');
     // TitleNameFather
     // FirstName_TH_Father
     // LastName_TH_Father
     // Status_Father
     // Age_Father
     // idOccupation_Father
     // idCountry_Calling_Code_Father
     // TelephoneNumber_Father

     // //มารดา

     // $families_Mother = new Families();
     // $families_Mother->idCandidate = Session::get('idCandidate');
     // $families_Mother->idUser = Auth::getUser()->id;
     // $families_Mother->idPrefix = post('TitleNameMother');
     // $families_Mother->FirstName_TH = post('FirstName_TH_Mother');
     // $families_Mother->LastName_TH = post('LastName_TH_Mother');
     // //ชื่อเล่น
     // $families_Mother->idLife_Status = post('Status_Mother');
     // //วันเกิด
     // // $families_Mother->idRelationship_type = post('Age_Mother');
     // $families_Mother->idOccupation = post('idOccupation_Mother');
     // $families_Mother->idCountry_Calling_Codes = post('idCountry_Calling_Code_Mother');
     // $families_Mother->TelephoneNumber = post('TelephoneNumber_Mother');

     // TitleNameMother
     // FirstName_TH_Mother
     // LastName_TH_Mother
     // Status_Mother
     // Age_Mother
     // idOccupation_Mother
     // idCountry_Calling_Code_Mother
     // TelephoneNumber_Mother


     //พี่น้อง

     $families->NumBrethren = Input::get('NumBrethren');

     if($families->$families->NumBrethren !="" || $families->NumBrethren !="0"){
       for ($i=0; $i < $families->NumBrethren ; $i++) {
         $families_brethren = new Families();
         $families_brethren->idCandidate = Session::get('idCandidate');
         $families_brethren->idUser = Auth::getUser()->id;
         $families_brethren->idPrefix_Children = post('TitleNameBrethren')[$i];
         $families_brethren->FirstName_TH_Children = post('FirstName_TH_Brethren')[$i];
         $families_brethren->LastName_TH_Children = post('LastName_TH_Brethren')[$i];
         $families_brethren->Gender_Brethren = post('Gender_Brethren')[$i];
         $families_brethren->Status_Brethren = post('Status_Brethren')[$i];
         $families_brethren->Age_Brethren = post('Age_Brethren')[$i];
         $families_brethren->idOccupation_Brethren = post('idOccupation_Brethren')[$i];

         // $families_brethren->idRelationship_type = '5';
       }
      }

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
        $get=Candidate::where('idUser',Auth::getUser()->id)->first();
        // if($get){
        //     $get->Date_of_Birth=$this->convertDateToForm($get->Date_of_Birth);
        // }
        //dd(Auth::getUser()->id);
        return $get;
    }

    public function loadFamilies()
    {
        return Families::all();
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

    public $militarys;
    public $maritalstatuss;
    public $occupations;
    public $maritalregiterstatus;
    public $countrycallingcodes;
    public $familiess;
    public $relationshiptypes;
    public $prefixs;
}
