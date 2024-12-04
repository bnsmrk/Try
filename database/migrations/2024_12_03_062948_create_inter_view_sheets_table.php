<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inter_view_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('doc_type')->nullable();
            //1st tab
            $table->string('region')->nullable();
            $table->string('referredBy')->nullable();
            $table->string('district_office')->nullable();
            $table->boolean('merit')->default(false);
            $table->boolean('rep')->default(false);
            $table->string('date')->nullable();
            $table->string('assignTo')->nullable();
            $table->string('control_no')->nullable();
            $table->boolean('isServiceCheck')->default(false);
            $table->string('isServiceInput')->nullable();
            $table->string('mananayam')->nullable();
            $table->boolean('isOthersCheck')->default(false);
            $table->string('isOthersInput')->nullable();
            // 2nd tab
            $table->boolean('legalDoc')->default(false);
            $table->boolean('adminOath')->default(false);
            $table->boolean('courtRep')->default(false);
            $table->boolean('inquest')->default(false);
            $table->boolean('mediation')->default(false);
            $table->boolean('isOthers2Check')->default(false);
            $table->string('isOthers2Input')->nullable();
            //3rd tab
            $table->string('name')->nullable();
            $table->string('age')->nullable();
            $table->string('sex')->nullable();
            $table->string('civilStatus')->nullable();
            $table->string('religion')->nullable();
            $table->string('degree')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('language')->nullable();
            $table->string('regions')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('barangay')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('asawa')->nullable();
            $table->string('income')->nullable();
            $table->string('asawaAddress')->nullable();
            $table->boolean('nakakulong')->default(false);
            $table->string('contactNumberAsawa')->nullable();
            $table->string('dateofKulong')->nullable();
            $table->string('dPlace')->nullable();
            //4th tab
            //window 1
            $table->string('representativeName')->nullable();
            $table->string('representativeAge')->nullable();
            $table->string('representativeSex')->nullable();
            $table->string('representativeCivilStatus')->nullable();
            $table->string('representativeTirahan')->nullable();
            $table->string('representativeContactNumber')->nullable();
            $table->string('representativeRelationship')->nullable();
            $table->string('representativeEmail')->nullable();
            //window 2
            $table->string('type_of_case')->nullable();
            // window 3
            $table->boolean('child_in_conflict')->default(false);
            $table->boolean('senior_citizen')->default(false);
            $table->boolean('woman')->default(false);
            $table->boolean('victim_of_VAWC')->default(false);
            $table->boolean('drug_refugee')->default(false);
            $table->boolean('law_enforcer')->default(false);
            $table->boolean('drug_related_duty')->default(false);
            $table->boolean('tenant_of_agrarian_case')->default(false);
            $table->boolean('ofw_land_based')->default(false);
            $table->boolean('arrested_for_terrorism')->default(false);
            $table->boolean('ofw_sea_based')->default(false);
            $table->boolean('victim_of_torture')->default(false);
            $table->boolean('former_rebel')->default(false);
            $table->boolean('victim_of_trafficking')->default(false);
            $table->boolean('foreign_national')->default(false);
            $table->boolean('indigenous_people')->default(false);
            $table->string('foreign_national_input')->nullable();
            $table->string('indigenous_people_input')->nullable();
            $table->boolean('urban_poor')->default(false);
            $table->boolean('pwd_type')->default(false);
            $table->string('urban_poor_input')->nullable();
            $table->string('pwd_type_input')->nullable();
            $table->boolean('rural_poor')->default(false);
            $table->boolean('petitioner_drugs')->default(false);
            $table->string('rural_poor_input')->nullable();
            $table->string('petitioner_drugs_input')->nullable();
            //aol
            $table->string('id_type')->nullable();
            $table->string('aol_type')->nullable();
            $table->string('id_number')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inter_view_sheets');
    }
};
