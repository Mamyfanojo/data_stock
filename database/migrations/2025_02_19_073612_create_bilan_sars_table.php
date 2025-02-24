<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bilan_sars', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('nom_du_navire')->nullable();
            $table->string('pavillon')->nullable();
            $table->string('immatriculation_callsign')->nullable();
            $table->string('armateur_proprietaire')->nullable();
            $table->string('type_du_navire')->nullable();
            $table->string('coque')->nullable();
            $table->string('propulsion')->nullable();
            $table->string('moyen_d_alerte')->nullable();
            $table->foreignId('type_d_evenement_id')->nullable()->constrained('type_evenements')->nullOnDelete();
            $table->text('description_de_l_evenement')->nullable();
            $table->foreignId('cause_de_l_evenement_id')->nullable()->constrained('cause_evenements')->nullOnDelete();
            $table->string('lieu_de_l_evenement')->nullable();
            $table->foreignId('region_id')->nullable()->constrained('regions')->nullOnDelete(); // Relation avec regions
            $table->string('type_d_intervention')->nullable();
            $table->text('description_de_l_intervention')->nullable();
            $table->string('source_de_l_information')->nullable();
            $table->integer('pob')->nullable();
            $table->integer('survivants')->nullable();
            $table->integer('blesses')->nullable();
            $table->integer('morts')->nullable();
            $table->integer('disparus')->nullable();
            $table->integer('evasan')->nullable();
            $table->string('bilan_materiel')->nullable();
            $table->timestamps();
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('bilan_sars');
    }
};
