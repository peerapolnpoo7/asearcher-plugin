<?php namespace Asearcher\Candidatecustommer\Components;

use Cms\Classes\ComponentBase;
use Input;
use Validator;
use Redirect;
use Db;
use Session;
use Auth;
use ValidationException;
use Flash;

use Asearcher\CandidateCustommer\Models\Provincessssss; 
use Asearcher\CandidateCustommer\Models\District;
use Asearcher\CandidateCustommer\Models\Subdistrict;
use Asearcher\CandidateCustommer\Models\Postcode;
use Asearcher\CandidateCustommer\Models\Address;

class AddressForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AddressForm Component',
            'description' => 'Address Form'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $this->addCss('assets/css/cv-address.css');
        $this->addJs('assets/js/cv-address.js');
        $this->provinces=$this->loadProvinces();
        $this->address=$this->loadAddress();
    }

    public function onSave()
    {
        $rules = [
            'Address_No_TH'    => 'required',
            'idProvinces'    => 'required',
            'idDistricts'    => 'required',
            'idSubdistricts'    => 'required',
            'idPostcode'    => 'required',
        ];
        $messages = [
            'Address_No_TH.required' => 'กรุณากรอก "บ้านเลขที่" ตามที่อยู่บัตรประชาชน',
            'idProvinces.required' => 'กรุณาเลือก "จังหวัด" ตามที่อยู่บัตรประชาชน',
            'idDistricts.required' => 'กรุณาเลือก "อำเภอ/เขต" ตามที่อยู่บัตรประชาชน',
            'idSubdistricts.required' => 'กรุณาเลือก "ตำบล/แขวง" ตามที่อยู่บัตรประชาชน',
            'idPostcode.required' => 'กรุณากรอก "รหัสไปรษณีย์" ตามที่อยู่บัตรประชาชน',
        ];

        if(Input::get('Address_Present')=='2'){
           $rules_1 = [
            'Address_No_TH_1'    => 'required',
            'idProvinces_1'    => 'required',
            'idDistricts_1'    => 'required',
            'idSubdistrict_1'    => 'required',
            'idPostcode_1'    => 'required',
            ];
            $messages_1 = [
                'Address_No_TH_1.required' => 'กรุณากรอก "บ้านเลขที่" ตามที่อยู่ปัจจุบัน',
                'idProvinces_1.required' => 'กรุณาเลือก "จังหวัด" ตามที่อยู่ปัจจุบัน',
                'idDistricts_1.required' => 'กรุณาเลือก "อำเภอ/เขต" ตามที่อยู่ปัจจุบัน',
                'idSubdistrict_1.required' => 'กรุณาเลือก "ตำบล/แขวง" ตามที่อยู่ปัจจุบัน',
                'idPostcode_1.required' => 'กรุณากรอก "รหัสไปรษณีย์" ตามที่อยู่ปัจจุบัน',
            ]; 
            $rules=array_merge($rules, $rules_1);
            $messages=array_merge($messages, $messages_1);
        }

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        if(Input::get('idAddress')!=""){
            $address = Address::find(Input::get('idAddress'));
        }else{
            $address = new Address();
        }
        $address->idCandidate=Session::get('idCandidate');
        $address->idUser=Auth::getUser()->id;
        $address->Home_Condo=Input::get('Home_Condo');
        $address->Address_No_TH=Input::get('Address_No_TH');
        $address->Soi_TH=Input::get('Soi_TH');
        $address->Moo_TH=Input::get('Moo_TH');
        if($address->Home_Condo=="2"){
            $address->Building_TH=Input::get('Building_TH');
            $address->Room_NO_TH=Input::get('Room_NO_TH');
            $address->Floor_TH=Input::get('Floor_TH');
        }
        $address->Village_TH=Input::get('Village_TH');
        $address->Road_TH=Input::get('Road_TH');
        $address->idPostcode=$this->loadIDPostcode(Input::get('idPostcode'),Input::get('idSubdistricts'));
        $address->idSubdistricts=Input::get('idSubdistricts');
        $address->idDistricts=Input::get('idDistricts');
        $address->idProvinces=Input::get('idProvinces');
        $address->idCountry='83';
        /*$address->Address_No_EN=Input::get('Address_No_EN');
        $address->Soi_EN=Input::get('Soi_EN');
        $address->Moo_EN=Input::get('Moo_EN');
        $address->Room_No_EN=Input::get('Room_No_EN');
        $address->Floor_EN=Input::get('Floor_EN');
        $address->Village_EN=Input::get('Village_EN');
        $address->Road_EN=Input::get('Road_EN');*/
        $address->Address_Present=Input::get('Address_Present');
        if($address->Address_Present==2){
            $address->Home_Condo_1=Input::get('Home_Condo_1');
            $address->Address_No_TH_1=Input::get('Address_No_TH_1');
            $address->Soi_TH_1=Input::get('Soi_TH_1');
            $address->Moo_TH_1=Input::get('Moo_TH_1');
            if($address->Home_Condo_1=="2"){
                $address->Building_TH_1=Input::get('Building_TH_1');
                $address->Room_No_TH_1=Input::get('Room_No_TH_1');
                $address->Floor_TH_1=Input::get('Floor_TH_1');
            }
            $address->Village_TH_1=Input::get('Village_TH_1');
            $address->Road_TH_1=Input::get('Road_TH_1');
            $address->idPostcode_1=$this->loadIDPostcode(Input::get('idPostcode_1'),Input::get('idSubdistrict_1'));
            $address->idSubdistrict_1=Input::get('idSubdistrict_1');
            $address->idDistricts_1=Input::get('idDistricts_1');
            $address->idProvinces_1=Input::get('idProvinces_1');
            $address->idCountry_1='83';
        }else{
            $address->Home_Condo_1=Input::get('Home_Condo');
            $address->Address_No_TH_1=Input::get('Address_No_TH');
            $address->Soi_TH_1=Input::get('Soi_TH_1');
            $address->Moo_TH_1=Input::get('Moo_TH_1');
            if($address->Home_Condo_1=="2"){
                $address->Building_TH_1=Input::get('Building_TH');
                $address->Room_No_TH_1=Input::get('Room_No_TH');
                $address->Floor_TH_1=Input::get('Floor_TH');
            }
            $address->Village_TH_1=Input::get('Village_TH');
            $address->Road_TH_1=Input::get('Road_TH');
            $address->idPostcode_1=$this->loadIDPostcode(Input::get('idPostcode'),Input::get('idSubdistricts'));
            $address->idSubdistrict_1=Input::get('idSubdistricts');
            $address->idDistricts_1=Input::get('idDistricts');
            $address->idProvinces_1=Input::get('idProvinces');
            $address->idCountry_1='83';
        }
        /*$address->Address_No_EN_1=Input::get('Address_No_EN_1');
        $address->Soi_EN_1=Input::get('Soi_EN_1');
        $address->Moo_EN_1=Input::get('Moo_EN_1');
        $address->Building_EN_1=Input::get('Building_EN_1');
        $address->Room_EN_1=Input::get('Room_EN_1');
        $address->Floor_EN_1=Input::get('Floor_EN_1');
        $address->Village_EN_1=Input::get('Village_EN_1');
        $address->Road_EN_1=Input::get('Road_EN_1');*/
        //return $address;exit;
        $address->save();
        Flash::success('บันทึกข้อมูลเรียบร้อยแล้ว');
        return Redirect::to('/cv-address');

    }

    public function onGetDistrict()
    {
        return District::select('idDistricts as id' , 'Name_TH')->where('idProvinces',post('value'))->get();
    }

    public function onGetSubDistrict()
    {
        return Subdistrict::select('idSubdistricts as id' , 'Name_TH')->where('idDistricts',post('value'))->get();
    }

    public function onGetPostcode()
    {
        $getSubDistrictCode=Subdistrict::where('idSubdistricts',post('value'))->first();
        return Postcode::where('Subdistricts_Code',$getSubDistrictCode->Subdistricts_Code)->first();
    }

    public function loadAddress()
    {
        $get = Address::where('idUser',Auth::getUser()->id)->first();
        if($get){
            $get['code']=$this->loadPostcode($get->idPostcode);
            $get['code1']=$this->loadPostcode($get->idPostcode_1);
        }else{
            $get['code']="";
            $get['code1']="";
        }
        return $get;
    }

    public function loadIDPostcode($code,$idSubdistricts)
    {
        $get=Postcode::where('code',$code)->first();
        if($get){
            $idPostcode=$get->idPostcode;
        }else{
            $getSubdistrict=Subdistrict::where('idSubdistricts',$idSubdistricts);
            $postcode= new Postcode();
            $postcode->Code=$code;
            $postcode->Subdistricts_Code=$getSubdistrict->Subdistricts_Code;
        }
        return $get->idPostcode;
    }

    public function loadPostcode($idPostcode)
    {
        $get=Postcode::where('idPostcode',$idPostcode)->first();
        return $get->Code;
    }

    public function loadProvinces()
    {
        return Province::all();
    }

    public $provinces;

    public $address;
}
