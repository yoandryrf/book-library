<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UserRoleEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //TODO: Change this by a new table named 'roles'
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [UserRoleEnum::WORKER, UserRoleEnum::CLIENT])->default(UserRoleEnum::CLIENT);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
