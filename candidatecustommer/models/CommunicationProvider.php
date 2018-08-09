<?php namespace Asearcher\Candidatecustommer\Models;

use Model;

/**
 * CommunicationProvider Model
 */
class CommunicationProvider extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'communication_provider';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
