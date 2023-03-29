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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname')->nullable();
            $table->date('birth_date');
            $table->string('phone');
            $table->foreignId('club_id')->constrained();
            $table->text('address');
            $table->text('city');
            $table->text('state');
            $table->text('zip_code');
            $table->boolean('is_guest');
            $table->enum('blood_type', [
                'A+', 'B+', 'AB+', 'O+', 'A-', 'B-', 'AB-', 'O-'
            ]);
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->text('allergies')->nullable();
            $table->text('food_restrictions')->nullable();
            $table->string('rg');
            $table->string('cpf');
            $table->boolean('agreed');
            $table->enum('user_type', ['user', 'admin'])->default('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nickname');
            $table->dropColumn('birth_date');
            $table->dropColumn('phone');
            $table->dropColumn('club_id');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('zip_code');
            $table->dropColumn('is_guest');
            $table->dropColumn('blood_type');
            $table->dropColumn('emergency_contact_name');
            $table->dropColumn('emergency_contact_phone');
            $table->dropColumn('allergies');
            $table->dropColumn('food_restrictions');
            $table->dropColumn('rg');
            $table->dropColumn('cpf');
            $table->dropColumn('agreed');
            $table->dropColumn('user_type');
        });
    }
};
