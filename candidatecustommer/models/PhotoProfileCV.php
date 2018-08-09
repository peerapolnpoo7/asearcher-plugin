<?php namespace Asearcher\Candidatecustommer\Models;

use Model;

/**
 * PhotoProfileCV Model
 */
class PhotoProfileCV extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'photo_profile_cv';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
    protected $primaryKey = 'idPhoto_Profile_CV';
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
