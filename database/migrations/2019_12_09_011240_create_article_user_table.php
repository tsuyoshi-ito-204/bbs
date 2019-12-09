<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_user', function(Blueprint $table)
		{
			$table->bigInteger('user_id')->unsigned()->index('article_user_user_id_foreign');
			$table->bigInteger('article_id')->unsigned();
			$table->primary(['article_id','user_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('article_user');
	}

}
