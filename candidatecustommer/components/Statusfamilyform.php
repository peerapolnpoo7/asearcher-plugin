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
use Asearcher\CandidateCustommer\Models\LifeStatus;

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
      $onGender = Candidate::where('idUser',Auth::getUser()->id)->first();
      // dd($onGender->idGender);
      if ($onGender->idGender == 1) {
        $this->spouse = $this->loadfami(4);
      }else {
        $this->spouse = $this->loadfami(3);
      }
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
      $this->lifestatuss=$this->loadLifestatus();
      $this->childrens=$this->onChildren();
      $this->brethrens=$this->onBrethren();
      $this->brethren=$this->loadBrethren();
      $this->children=$this->loadChildren();
      $this->callingcode=$this->onCountryCallingCode();
    }

    public function onSave(){

                      $onGender = Candidate::where('idUser',Auth::getUser()->id)->first();
                      // dd($onGender->idGender);
                      if ($onGender->idGender == "1") {
                        $rules= array('typeMilitary' => array('required'));
                        $messages = ['typeMilitary.required' => 'กรุณาเลือก "สถานะทางทหาร"'];
                      }else {
                        $rules= array();
                        $messages = [];
                      }

              $rules_more = array(

                  'typeMarital' => array('required'),
                  //บิดา
                  // 'TitleNameFather' => array('required'),
                  'FirstName_TH_Father' => array('regex:/^[ก-์]+$/u'),
                  'LastName_TH_Father' => array('regex:/^[\ก-์\s]+$/u'),
                  'Age_Father' => array('regex:/^[1-9][0-9]*$/'),
                  'TelephoneNumber_Father' => array('min:9','max:10','regex:/\d{10}|\d{9}$/'),
                  //มารดา
                  // 'TitleNameMother' => array('required'),
                  'FirstName_TH_Mother' => array('regex:/^[ก-์]+$/u'),
                  'LastName_TH_Mother' => array('regex:/^[\ก-์\s]+$/u'),
                  'Age_Mother' => array('regex:/^[1-9][0-9]*$/'),
                  'TelephoneNumber_Mother' => array('min:9','max:10','regex:/\d{10}|\d{9}$/'),
              );
              $messages_more = [

                  'typeMarital.required' => 'กรุณาเลือก "สถานภาพสมรส"',
                  //บิดา
                  // 'TitleNameFather.required' => 'กรุณาเลือก "คำนำหน้าชื่อบิดา"',
                  'FirstName_TH_Father.regex' => 'กรุณากรอก "ชื่อบิดา" เป็นตัวอักษรไทยเท่านั้น',
                  'LastName_TH_Father.regex' => 'กรุณากรอก "นามสกุลบิดา" เป็นตัวอักษรไทยเท่านั้น',
                  'Age_Father.regex' => '"อายุบิดา" ต้องเป็นตัวเลขเท่านั้น',
                  'TelephoneNumber_Father.min' => 'เบอร์โทรศัพท์ต้องมากกว่าหรือเท่ากับ 9 ตัวเลข',
                  'TelephoneNumber_Father.max' => 'เบอร์โทรศัพท์ต้องไม่เกิน 10 ตัวเลข',
                  'TelephoneNumber_Father.regex' => '"เบอร์โทรศัพท์" ต้องเป็นตัวเลขเท่านั้น',
                  //มารดา
                  // 'TitleNameMother.required' => 'กรุณาเลือก "คำนำหน้าชื่อมารดา"',
                  'FirstName_TH_Mother.regex' => 'กรุณากรอก "ชื่อมารดา" เป็นตัวอักษรไทยเท่านั้น',
                  'LastName_TH_Mother.regex' => 'กรุณากรอก "นามสกุลมารดา" เป็นตัวอักษรไทยเท่านั้น',
                  'Age_Mother.regex' => '"อายุมารดา" ต้องเป็นตัวเลขเท่านั้น',
                  'TelephoneNumber_Mother.min' => 'เบอร์โทรศัพท์ต้องมากกว่าหรือเท่ากับ 9 ตัวเลข',
                  'TelephoneNumber_Mother.max' => 'เบอร์โทรศัพท์ต้องไม่เกิน 10 ตัวเลข',
                  'TelephoneNumber_Mother.regex' => '"เบอร์โทรศัพท์" ต้องเป็นตัวเลขเท่านั้น',
              ];

              $rules = array_merge($rules,$rules_more);
              $messages = array_merge($messages,$messages_more);


              if(Input::get('typeMarital') != 1){
                  $rules_more= array(
                          //คู่สมรส
                          // 'idPrefix_Spouse' => array('required'),
                          'FirstName_TH_Spouse' => array('required','regex:/^[ก-์]+$/u'),
                          'LastName_TH_Spouse' => array('required','regex:/^[\ก-์\s]+$/u'),
                          'NickName_TH_Spouse' => array('required','regex:/^[ก-์]+$/u'),

                          'Amount_of_Children' => array('required'),
                  );
                  $messages_more = [
                          // 'idPrefix_Spouse.required' => 'กรุณาเลือก "คำนำหน้าชื่อ"',
                          'FirstName_TH_Spouse.required' => 'กรุณากรอก "ชื่อ"',
                          'FirstName_TH_Spouse.regex' => 'กรุณากรอก "ชื่อ" เป็นตัวอักษรไทยเท่านั้น',
                          'LastName_TH_Spouse.required' => 'กรุณากรอก "นามสกุล"',
                          'LastName_TH_Spouse.regex' => 'กรุณากรอก "นามสกุล" เป็นตัวอักษรไทยเท่านั้น',
                          'NickName_TH_Spouse.required' => 'กรุณากรอก "ชื่อเล่น"',
                          'NickName_TH_Spouse.regex' => 'กรุณากรอก "ชื่อเล่น" เป็นตัวอักษรไทยเท่านั้น',
                          'Amount_of_Children.required' => 'กรุณากรอก "จำนวนบุตร"',
                  ];

                  $rules = array_merge($rules,$rules_more);
                  $messages = array_merge($messages,$messages_more);

                  if(Input::get('typeMarital') != 4){
                      $rules_more= array(
                        //ถ้าหม่ายไม่ต้องใส่
                        'idOccupation_Spouse' => array('required'),
                        'Age_Spouse' => array('required','regex:/^[1-9][0-9]*$/'),
                        'idCountry_Calling_Code_Spouse' => array('required'),
                        'TelephoneNumber_Spouse' => array('required','min:9','max:10','regex:/\d{10}|\d{9}$/'),
                        //--------
                      );
                      $messages_more = [
                        //ถ้าหม่ายไม่ต้องใส่
                        'idOccupation_Spouse.required' => 'กรุณาเลือก "อาชีพ"',
                        'Age_Spouse.required' => 'กรุณากรอก "อายุ"',
                        'Age_Spouse.regex' => '"อายุ" ต้องเป็นตัวเลขเท่านั้น',
                        'idCountry_Calling_Code_Spouse.required' => 'กรุณาเลือก "หมายเลขโทรศัทพ์ระหว่างประเทศ"',
                        'TelephoneNumber_Spouse.required' => 'กรุณากรอก "เบอร์โทรศัพท์"',
                        'TelephoneNumber_Spouse.min' => 'เบอร์โทรศัพท์ต้องมากกว่าหรือเท่ากับ 9 ตัวเลข',
                        'TelephoneNumber_Spouse.max' => 'เบอร์โทรศัพท์ต้องไม่เกิน 10 ตัวเลข',
                        'TelephoneNumber_Spouse.regex' => '"เบอร์โทรศัพท์" ต้องเป็นตัวเลขเท่านั้น',
                        //--------
                      ];
                      $rules = array_merge($rules,$rules_more);
                      $messages = array_merge($messages,$messages_more);
                  }
              }

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
      if ($onGender->idGender == "1") {
        $statuscandidate->idMilitary = Input::get('typeMilitary');
      }else {
        $statuscandidate->idMilitary = 99 ;
      }

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
        $chkfami_spouse=Families::where('idCandidate',Session::get('idCandidate'))->whereIN('idRelationship_type',['3','4']);
        if($chkfami_spouse->count() > 0){
            $families_spouse = Families::find($chkfami_spouse->first()->idFamilies);
        }else{
            $families_spouse = new Families();
        }
        $families_spouse->idCandidate = Session::get('idCandidate');
        $families_spouse->idUser = Auth::getUser()->id;
        $families_spouse->idPrefix = Input::get('idPrefix_Spouse') !='' ? Input::get('idPrefix_Spouse'):NULL ;
        $families_spouse->FirstName_TH = Input::get('FirstName_TH_Spouse');
        $families_spouse->LastName_TH = Input::get('LastName_TH_Spouse');
        $families_spouse->NickName_TH = Input::get('NickName_TH_Spouse');
        if ($statuscandidate->idMarital_Status == 4) {
        $families_spouse->idOccupation = NULL;
        $families_spouse->Age = NULL;
        $families_spouse->idCountry_Calling_Code = 83;
        $families_spouse->TelephoneNumber = NULL;
        }else {
          $families_spouse->idOccupation = Input::get('idOccupation_Spouse');
          $families_spouse->Age = Input::get('Age_Spouse');
          $families_spouse->idCountry_Calling_Code = Input::get('idCountry_Calling_Code_Spouse');
          $families_spouse->TelephoneNumber = Input::get('TelephoneNumber_Spouse');
        }

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

     //บิดา

     $chkfami_father=Families::where('idCandidate',Session::get('idCandidate'))->where('idRelationship_type','1');
     if($chkfami_father->count() > 0){
         $families_father = Families::find($chkfami_father->first()->idFamilies);
     }else{
         $families_father = new Families();
     }
     $families_father->idCandidate = Session::get('idCandidate');
     $families_father->idUser = Auth::getUser()->id;
     $families_father->idPrefix = Input::get('TitleNameFather')!='' ? Input::get('TitleNameFather'):NULL ;
     $families_father->FirstName_TH = Input::get('FirstName_TH_Father');
     $families_father->LastName_TH = Input::get('LastName_TH_Father');
     $families_father->idLife_Status = Input::get('Status_Father');

     if ($families_father->idLife_Status == 2) {
       $families_father->Age = NULL ;
       $families_father->idOccupation = NULL ;
       $families_father->idCountry_Calling_Code = 83 ;
       $families_father->TelephoneNumber = NULL;
     }else {
       $families_father->Age = Input::get('Age_Father')!='' ? Input::get('Age_Father'):NULL ;
       $families_father->idOccupation = Input::get('idOccupation_Father')!='' ? Input::get('idOccupation_Father'):NULL ;
       $families_father->idCountry_Calling_Code = Input::get('idCountry_Calling_Code_Father');
       $families_father->TelephoneNumber = Input::get('TelephoneNumber_Father');
     }
     $families_father->idRelationship_type = 1;
     $families_father->save();

     //มารดา

     $chkfami_Mother=Families::where('idCandidate',Session::get('idCandidate'))->where('idRelationship_type','2');
     if($chkfami_Mother->count() > 0){
         $families_Mother = Families::find($chkfami_Mother->first()->idFamilies);
     }else{
         $families_Mother = new Families();
     }
     $families_Mother->idCandidate = Session::get('idCandidate');
     $families_Mother->idUser = Auth::getUser()->id;
     $families_Mother->idPrefix = Input::get('TitleNameMother')!='' ? Input::get('TitleNameMother'):NULL ;
     $families_Mother->FirstName_TH = Input::get('FirstName_TH_Mother');
     $families_Mother->LastName_TH = Input::get('LastName_TH_Mother');
     $families_Mother->idLife_Status = Input::get('Status_Mother');
     // $families_Mother->Age = Input::get('Age_Mother')!='' ? Input::get('Age_Mother'):NULL ;
     // $families_Mother->idOccupation = Input::get('idOccupation_Mother')!='' ? Input::get('idOccupation_Mother'):NULL ;
     if (Input::get('Status_Mother') == 2) {
       $families_Mother->Age = NULL ;
       $families_Mother->idOccupation = NULL ;
       $families_Mother->idCountry_Calling_Code = 83 ;
       $families_Mother->TelephoneNumber = NULL;
     }else {
       $families_Mother->Age = Input::get('Age_Mother')!='' ? Input::get('Age_Mother'):NULL ;
       $families_Mother->idOccupation = Input::get('idOccupation_Mother')!='' ? Input::get('idOccupation_Mother'):NULL;
       $families_Mother->idCountry_Calling_Code = Input::get('idCountry_Calling_Code_Mother');
       $families_Mother->TelephoneNumber = Input::get('TelephoneNumber_Mother');
     }
     $families_Mother->idRelationship_type = 2;
     $families_Mother->save();

         Flash::success('บันทึกข้อมูลเรียบร้อยแล้ว');
         return Redirect::to('/cv-family');

     }

     public function onAddBrethren(){

       $rules = array(
           'TitleNameBrethren' => array('required'),
           'NameBrethren' => array('required','regex:/^[ก-์]+$/u'),
           'LastNameBrethren' => array('required','regex:/^[\ก-์\s]+$/u'),
           'BrethrenStatus' => array('required'),

       );
       $messages = [
           'TitleNameBrethren.required' => 'กรุณาเลือก "คำนำหน้าชื่อ"',
           'NameBrethren.required' => 'กรุณากรอก "ชื่อ"',
           'NameBrethren.regex' => 'กรุณากรอก "ชื่อ" เป็นตัวอักษรไทยเท่านั้น',
           'LastNameBrethren.required' => 'กรุณากรอก "นามสกุล"',
           'LastNameBrethren.regex' => 'กรุณากรอก "นามสกุล" เป็นตัวอักษรไทยเท่านั้น',
           'BrethrenStatus.required' => 'กรุณาเลือก "สถานะการมีชีวิต"',

       ];

       if(post('BrethrenStatus')  != 2){
         $rules_more= array(
           'AgeBrethren' => array('required','regex:/^[1-9][0-9]*$/'),
           'OccupationBrethren' => array('required'),
         );
         $messages_more = [
           'AgeBrethren.required' => 'กรุณากรอก "อายุ"',
           'AgeBrethren.regex' => '"อายุ" ต้องเป็นตัวเลขเท่านั้น',
           'OccupationBrethren.required' => 'กรุณาเลือก "อาชีพ"',
         ];

         $rules = array_merge($rules,$rules_more);
         $messages = array_merge($messages,$messages_more);
       }

           $rules = array_merge($rules);
           $messages = array_merge($messages);

           $validator = Validator::make(Input::all(), $rules, $messages);

           if ($validator->fails()) {
               throw new ValidationException($validator);
           }

           $get = Candidate::WHERE('idUser',Auth::getUser()->id)->first();
           // for ($i=0; $i < post('NumBrethren') ; $i++) {
                 $families_brethren = new Families();
                 $families_brethren->idCandidate = $get->idCandidate;
                 $families_brethren->idUser = Auth::getUser()->id;
                 $families_brethren->idPrefix = post('TitleNameBrethren');
                 $families_brethren->FirstName_TH = post('NameBrethren');
                 $families_brethren->LastName_TH = post('LastNameBrethren');
                 $families_brethren->idLife_Status = post('BrethrenStatus');
                 // dd($families_brethren->idLife_Status);

                 if (post('BrethrenStatus') == '2') {
                   $families_brethren->Age = NULL ;
                   $families_brethren->idOccupation = NULL ;
                 }else {
                   $families_brethren->Age = post('AgeBrethren');
                   $families_brethren->idOccupation = post('OccupationBrethren');
                 }

                 if (post('TitleNameBrethren') != '') {
                           $get = Prefix::where('idPrefix',post('TitleNameBrethren'))->first();
                           // dd($get->idGender);
                    if ($get->idGender == 1) {
                     $Re_t = 8 ;
                    }else if ($get->idGender == 2) {
                     $Re_t = 9 ;
                    }
                    $families_brethren->idRelationship_type = $Re_t;
                 }

                 if (post('TitleNameBrethren') != ''&& post('NameBrethren') != ''&& post('LastNameBrethren') != '' && post('BrethrenStatus') != '') {
                   $families_brethren->save();
                 }

     }

     public function onUpdateBrethren(){

       $rules = array(
           'TitleNameBrethren' => array('required'),
           'NameBrethren' => array('required','regex:/^[ก-์]+$/u'),
           'LastNameBrethren' => array('required','regex:/^[\ก-์\s]+$/u'),
           'BrethrenStatus' => array('required'),

       );
       $messages = [
           'TitleNameBrethren.required' => 'กรุณาเลือก "คำนำหน้าชื่อ"',
           'NameBrethren.required' => 'กรุณากรอก "ชื่อ"',
           'NameBrethren.regex' => 'กรุณากรอก "ชื่อ" เป็นตัวอักษรไทยเท่านั้น',
           'LastNameBrethren.required' => 'กรุณากรอก "นามสกุล"',
           'LastNameBrethren.regex' => 'กรุณากรอก "นามสกุล" เป็นตัวอักษรไทยเท่านั้น',
           'BrethrenStatus.required' => 'กรุณาเลือก "สถานะการมีชีวิต"',

       ];

       if(post('BrethrenStatus')  != 2){
         $rules_more= array(
           'AgeBrethren' => array('required','regex:/^[1-9][0-9]*$/'),
           'OccupationBrethren' => array('required'),
         );
         $messages_more = [
           'AgeBrethren.required' => 'กรุณากรอก "อายุ"',
           'AgeBrethren.regex' => '"อายุ" ต้องเป็นตัวเลขเท่านั้น',
           'OccupationBrethren.required' => 'กรุณาเลือก "อาชีพ"',
         ];

         $rules = array_merge($rules,$rules_more);
         $messages = array_merge($messages,$messages_more);
       }

           $rules = array_merge($rules);
           $messages = array_merge($messages);

           $validator = Validator::make(Input::all(), $rules, $messages);

           if ($validator->fails()) {
               throw new ValidationException($validator);
           }

           $get = Candidate::WHERE('idUser',Auth::getUser()->id)->first();
           // for ($i=0; $i < post('NumBrethren') ; $i++) {
                  $families_brethren = Families::where('idCandidate',$get->idCandidate)->where('idFamilies',post('numedit'));

                  $families_brethren->update(['idPrefix' => post('TitleNameBrethren')]);
                  $families_brethren->update(['FirstName_TH' => post('NameBrethren')]);
                  $families_brethren->update(['LastName_TH' => post('LastNameBrethren')]);
                  $families_brethren->update(['idLife_Status' => post('BrethrenStatus')]);

                  if (post('BrethrenStatus') == '2') {
                    $families_brethren->update(['Age' => NULL]);
                    $families_brethren->update(['idOccupation' => NULL]);
                  }else {
                    $families_brethren->update(['Age' => post('AgeBrethren')]);
                    $families_brethren->update(['idOccupation' => post('OccupationBrethren')]);
                  }

                  if (post('TitleNameBrethren') != '') {
                            $get = Prefix::where('idPrefix',post('TitleNameBrethren'))->first();
                            // dd($get->idGender);
                     if ($get->idGender == 1) {
                      $Re_t = 8 ;
                     }else if ($get->idGender == 2) {
                      $Re_t = 9 ;
                     }
                     $families_brethren->update(['idRelationship_type' =>$Re_t]);
                  }
     }

     public function onDelBrethren(){
        $can = Candidate::WHERE('idUser',Auth::getUser()->id)->first();
        return Families::where('idCandidate',$can->idCandidate)->where('idFamilies',post('numedit'))->delete();
     }



     public function onAddChildren(){

       $rules = array(
           'TitleNameChildren' => array('required'),
           'NameChildren' => array('required','regex:/^[ก-์]+$/u'),
           'LastNameChildren' => array('required','regex:/^[\ก-์\s]+$/u'),
           'AgeChildren' => array('required','regex:/^[1-9][0-9]*$/'),
       );
       $messages = [
           'TitleNameChildren.required' => 'กรุณาเลือก "คำนำหน้าชื่อ"',
           'NameChildren.required' => 'กรุณากรอก "ชื่อ"',
           'NameChildren.regex' => 'กรุณากรอก "ชื่อ" เป็นตัวอักษรไทยเท่านั้น',
           'LastNameChildren.required' => 'กรุณากรอก "นามสกุล"',
           'LastNameChildren.regex' => 'กรุณากรอก "นามสกุล" เป็นตัวอักษรไทยเท่านั้น',
           'AgeChildren.required' => 'กรุณากรอก "อายุ"',
           'AgeChildren.regex' => '"อายุ" ต้องเป็นตัวเลขเท่านั้น',
       ];

           $rules = array_merge($rules);
           $messages = array_merge($messages);

           $validator = Validator::make(Input::all(), $rules, $messages);

           if ($validator->fails()) {
               throw new ValidationException($validator);
           }

           $get = Candidate::WHERE('idUser',Auth::getUser()->id)->first();
                 $families_Children = new Families();
                 $families_Children->idCandidate = $get->idCandidate;
                 $families_Children->idUser = Auth::getUser()->id;
                 $families_Children->idPrefix = post('TitleNameChildren');
                 $families_Children->FirstName_TH = post('NameChildren');
                 $families_Children->LastName_TH = post('LastNameChildren');
                 $families_Children->Age = post('AgeChildren');
                 $families_Children->idRelationship_type = 5;
                 if (post('TitleNameChildren') != ''&& post('NameChildren') != ''&& post('LastNameChildren') != '') {
                   $families_Children->save();
                 }

     }

     public function onUpdateChildren(){

       $rules = array(
           'TitleNameChildren' => array('required'),
           'NameChildren' => array('required','regex:/^[ก-์]+$/u'),
           'LastNameChildren' => array('required','regex:/^[\ก-์\s]+$/u'),
           'AgeChildren' => array('required','regex:/^[1-9][0-9]*$/'),
       );
       $messages = [
           'TitleNameChildren.required' => 'กรุณาเลือก "คำนำหน้าชื่อ"',
           'NameChildren.required' => 'กรุณากรอก "ชื่อ"',
           'NameChildren.regex' => 'กรุณากรอก "ชื่อ" เป็นตัวอักษรไทยเท่านั้น',
           'LastNameChildren.required' => 'กรุณากรอก "นามสกุล"',
           'LastNameChildren.regex' => 'กรุณากรอก "นามสกุล" เป็นตัวอักษรไทยเท่านั้น',
           'AgeChildren.required' => 'กรุณากรอก "อายุ"',
           'AgeChildren.regex' => '"อายุ" ต้องเป็นตัวเลขเท่านั้น',
       ];

           $rules = array_merge($rules);
           $messages = array_merge($messages);

           $validator = Validator::make(Input::all(), $rules, $messages);

           if ($validator->fails()) {
               throw new ValidationException($validator);
           }

           $get = Candidate::WHERE('idUser',Auth::getUser()->id)->first();
                  $families_Children = Families::where('idCandidate',$get->idCandidate)->where('idFamilies',post('numedit'));

                  $families_Children->update(['idPrefix' => post('TitleNameChildren')]);
                  $families_Children->update(['FirstName_TH' => post('NameChildren')]);
                  $families_Children->update(['LastName_TH' => post('LastNameChildren')]);
                  $families_Children->update(['Age' => post('AgeChildren')]);


     }

     public function onDelChildren(){
        $can = Candidate::WHERE('idUser',Auth::getUser()->id)->first();
        return Families::where('idCandidate',$can->idCandidate)->where('idFamilies',post('numedit'))->delete();
     }


    public function loadmilitary()
    {
       return Military::where('idMilitary','!=','99')->get();
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

    public function onCountryCallingCode()
    {
        $get = CountryCallingCode::select('Name_EN as name','Flag as iso2','Code AS dialCode','idCountry_Calling_Code as id')->get();
        // dd($get);
        return Response::json($get);
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

    public function loadBrethren()
    {
        $get = Families::select('families.*','life_status.Name_TH AS namelife','occupation.Name_TH AS nameoccupation','prefix.Name_TH AS nameprefix')
        ->leftJoin('life_status','families.idLife_Status','=','life_status.idLife_Status')
        ->leftJoin('occupation','families.idOccupation','=','occupation.idOccupation')
        ->leftJoin('prefix','families.idPrefix','=','prefix.idPrefix')
        ->where('idUser',Auth::getUser()->id)->whereIN('idRelationship_type',['8','9'])->get();
        return $get;
    }

    public function loadChildren()
    {
        $get = Families::select('families.*','life_status.Name_TH AS namelife','occupation.Name_TH AS nameoccupation','prefix.Name_TH AS nameprefix')
        ->leftJoin('life_status','families.idLife_Status','=','life_status.idLife_Status')
        ->leftJoin('occupation','families.idOccupation','=','occupation.idOccupation')
        ->leftJoin('prefix','families.idPrefix','=','prefix.idPrefix')
        ->where('idUser',Auth::getUser()->id)->whereIN('idRelationship_type',['5'])->get();
        return $get;
    }

    public function loadLifestatus()
    {
       return LifeStatus::all();
    }

    public function onChildren()
    {
        $get = Families::select('families.*','life_status.Name_TH AS namelife','occupation.Name_TH AS nameoccupation','prefix.Name_TH AS nameprefix')
        ->leftJoin('life_status','families.idLife_Status','=','life_status.idLife_Status')
        ->leftJoin('occupation','families.idOccupation','=','occupation.idOccupation')
        ->leftJoin('prefix','families.idPrefix','=','prefix.idPrefix')
        ->where('idUser',Auth::getUser()->id)->where('idRelationship_type',5)->get();
        return $get;
    }

    public function onBrethren()
    {
        $get = Families::select('families.*','life_status.Name_TH AS namelife','occupation.Name_TH AS nameoccupation','prefix.Name_TH AS nameprefix')
        ->leftJoin('life_status','families.idLife_Status','=','life_status.idLife_Status')
        ->leftJoin('occupation','families.idOccupation','=','occupation.idOccupation')
        ->leftJoin('prefix','families.idPrefix','=','prefix.idPrefix')
        ->where('idUser',Auth::getUser()->id)->whereIN('idRelationship_type',['8','9'])->get();
        return $get;
    }

    public function onBrethrenedit()
    {
        $can = Candidate::WHERE('idUser',Auth::getUser()->id)->first();
        return Families::where('idCandidate',$can->idCandidate)->where('idFamilies',post('numedit'))->first();
    }

    public function onChildrenedit()
    {
        $can = Candidate::WHERE('idUser',Auth::getUser()->id)->first();
        return Families::where('idCandidate',$can->idCandidate)->where('idFamilies',post('numedit'))->first();
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
    public $lifestatuss;
    public $childrens;
    public $brethrens;
    public $brethren;
    public $children;
}
