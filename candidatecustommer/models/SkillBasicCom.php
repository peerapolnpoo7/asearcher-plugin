<?php namespace Asearcher\Candidatecustommer\Models;

use Model;

/**
 * SkillBasicCom Model
 */
class SkillBasicCom extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'skill_basic_computer';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
    protected $primaryKey = 'idSkill_Basic_Computer';
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
