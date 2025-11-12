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
            // Drop the old 'name' column and add new fields
            $table->dropColumn('name');
            
            // Add new authentication fields
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->string('phone_number')->nullable()->after('email');
            $table->string('nationality')->nullable()->after('phone_number');
            $table->enum('role', ['guest', 'staff', 'admin'])->default('guest')->after('nationality');
            $table->boolean('newsletter_subscribed')->default(false)->after('role');
            $table->boolean('active')->default(true)->after('newsletter_subscribed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add back the 'name' column
            $table->string('name')->after('id');
            
            // Drop the new fields
            $table->dropColumn([
                'first_name',
                'last_name', 
                'phone_number',
                'nationality',
                'role',
                'newsletter_subscribed',
                'active'
            ]);
        });
    }
};
