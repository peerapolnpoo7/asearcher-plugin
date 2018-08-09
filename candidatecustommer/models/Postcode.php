<?php namespace Asearcher\Candidatecustommer\Models;

use Model;

/**
 * Postcode Model
 */
class Postcode extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'postcode';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    protected $primaryKey = 'Subdistricts_code';

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [
        
    ];
    public $hasMany = [
        'subdistrict' => 'Asearcher\Candidatecustommer\Models\Subdistrict'
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
