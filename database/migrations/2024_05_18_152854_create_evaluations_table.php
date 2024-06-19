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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_id')->constrained();

            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->float('waist')->nullable();
            $table->float('hip')->nullable();
            $table->float('chest')->nullable();
            $table->float('arm')->nullable();
            $table->float('forearm')->nullable();
            $table->float('thigh')->nullable();
            $table->float('calf')->nullable();
            $table->float('abdominal_fat')->nullable();
            $table->float('visceral_fat')->nullable();
            $table->float('muscle_mass')->nullable();
            $table->float('fat_mass')->nullable();
            $table->float('hydration')->nullable();
            $table->float('bone_mass')->nullable();
            $table->float('bmr')->nullable();
            $table->float('metabolic_age')->nullable();
            $table->float('physical_evaluation')->nullable();
            $table->float('fat_percentage')->nullable();
            $table->float('imc')->nullable();
            $table->float('ideal_weight')->nullable();
            $table->float('ideal_fat_percentage')->nullable();
            $table->float('ideal_muscle_mass')->nullable();

            $table->text('observations');
            $table->dateTime('date');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
