<?php namespace Asearcher\CandidateCustommer\Components;


use Cms\Classes\ComponentBase;

use Asearcher\CandidateCustommer\Models\Candidate;

class Candidates extends ComponentBase
{

	public function componentDetails(){
		return  [
			'name' => 'Candidate list',
			'description' => 'Candidate Description'
		];
	}

	public function defineProperties(){
		return [
			'results'=>[
				'title' => 'Number of Candidate',
				'description' => 'How may candidate do you want to display?',
				'default' => 0,
				'validationPattern' => '^[0-9]+$',
				'validationMessage' => 'Only numbers allowed'
			],
			'sortOrder'=>[
				'title' => 'Sort Candidate',
				'description' => 'Sort those candidate',
				'type' => 'dropdown',
				'default' => 'name asc',
			]
		];
	}

	public function getSortOrderOptions()
	{
		return [
			'name asc' => 'Name (ascending)',
			'name desc' => 'Name (descending)'
		];
	}

	public function onRun(){
		$this->candidates=$this->loadCandidates();
	}

	protected function loadCandidates(){
		$query=Candidate::all();

		if($this->property('sortOrder') == 'name asc'){
			$query = $query->sortBy('name');
		}

		if($this->property('sortOrder') == 'name desc'){
			$query = $query->sortByDesc('name');
		}

		if($this->property('results') > 0){
			$query = $query->take($this->property('results'));
		}

		return $query;

	}

	public $candidates;

}