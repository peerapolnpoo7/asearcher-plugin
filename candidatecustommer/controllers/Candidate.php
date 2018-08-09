<?php namespace Asearcher\CandidateCustommer\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Candidate extends Controller
{
    public $implement = [    ];
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Asearcher.CandidateCustommer', 'candidatecustommer', 'cv');
    }

     public function index()    // <=== Action method
    {
		
    }		
}
