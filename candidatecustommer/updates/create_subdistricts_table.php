<?php namespace Asearcher\CandidateCustommer\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSubdistrictsTable extends Migration
{
    public function up()
    {
        Schema::create('asearcher_candidatecustommer_subdistricts', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asearcher_candidatecustommer_subdistricts');
    }
}
