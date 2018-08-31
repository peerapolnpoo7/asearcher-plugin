<?php namespace Asearcher\CandidateCustommer;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
           'Asearcher\CandidateCustommer\Components\Candidates' => 'candidates',
           'Asearcher\CandidateCustommer\Components\SmartcvForm' => 'smartcvform',
           'Asearcher\CandidateCustommer\Components\AddressForm' => 'addressform',
           'Asearcher\CandidateCustommer\Components\ProfileSession' => 'profilesession',
           'Asearcher\CandidateCustommer\Components\Statusfamilyform' => 'statusfamilyform',
           'Asearcher\CandidateCustommer\Components\Education' => 'education',
           'Asearcher\CandidateCustommer\Components\PersonalForm' => 'personalform'
           'Asearcher\CandidateCustommer\Components\Skill' => 'skill'

        ];
    }

    public function registerSettings()
    {

    }

    public function registerNavigation()
    {
        return [
            'candidatecustommer' => [
                'label' => 'Candidate & Customer',
                'url'   => Backend::url('asearcher/candidatecustommer/candidate'),
                'icon'  => 'icon-archive',
                'order' => 500,
                'sideMenu' => [
                    'cv' => [
                        'label' => 'asearcher.candidatecustommer::lang.backend.candidate',
                        'icon' => 'icon-user',
                        'url' => Backend::url('asearcher/candidatecustommer/candidate'),
                    ],
                    'customer' => [
                		'label' => 'asearcher.candidatecustommer::lang.backend.customer',
                		'icon' => 'icon-folder',
                		'url' => Backend::url('asearcher/candidatecustommer/customer'),
            		]

                ]
            ]
        ];
    }
}
