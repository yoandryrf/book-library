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
        $enumsArr = UserRoleEnum::cases();
        $values = array_column($enumsArr, 'value');

        //TODO: Change this by a new table named 'roles'
        Schema::table('users', function (Blueprint $table) use ($values) {
            $table->enum('role', $values)->default(UserRoleEnum::CLIENT->value);
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
