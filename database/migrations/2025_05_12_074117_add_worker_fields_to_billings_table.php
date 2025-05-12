<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->decimal('wages', 10, 2)->nullable()->after('total');
            $table->decimal('food', 10, 2)->nullable()->after('rate');
            $table->decimal('transport', 10, 2)->nullable()->after('food');
            $table->integer('no_of_days')->nullable()->after('transport');
            $table->text('work_dates')->nullable()->after('no_of_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->dropColumn('food');
            $table->dropColumn('transport');
            $table->dropColumn('no_of_days');
            $table->dropColumn('work_dates');
            $table->dropColumn('wages');
        });
    }
};
