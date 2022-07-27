<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table
                ->timestamp('deleted_at')
                ->nullable()
                ->index();

            $table
                ->boolean('published')
                ->default(true)
                ->index();
        });

        Schema::create('users_revisions', function (Blueprint $table) {
            $this->createRevisionsTable($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            $table->dropColumn('published');
        });

        Schema::dropIfExists('users_revisions');
    }

    public function createRevisionsTable(Blueprint $table): void
    {
        $tableNameSingular = 'site_user';

        $table->{twillIncrementsMethod()}('id');

        $table->{twillIntegerMethod()}("{$tableNameSingular}_id")->unsigned();

        $table
            ->{twillIntegerMethod()}('user_id')
            ->unsigned()
            ->nullable();

        $table->timestamps();

        $table->json('payload');

        $table
            ->foreign('site_user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

        $table
            ->foreign('user_id')
            ->references('id')
            ->on(config('twill.users_table', 'twill_users'))
            ->onDelete('set null');
    }
};
