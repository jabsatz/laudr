<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Laud;
use App\Follow;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('UserTableSeeder');

    $this->command->info('User table seeded!');

    $this->call('LaudTableSeeder');

    $this->command->info('Laud table seeded!');
	}

}

class UserTableSeeder extends Seeder {

  /**
   * Run the user table seeds.
   *
   * @return void
   */
  public function run()
  {
    User::create(['username' => 'julianabsatz', 'email' => 'julianabsatz@gmail.com', 'password' => bcrypt('password'), 'profile_picture' => '1.png', 'private' => false]);
    User::create(['username' => 'example', 'email' => 'example@example.com', 'password' => bcrypt('password'), 'profile_picture' => '', 'private' => true]);
    User::create(['username' => 'example2', 'email' => 'example2@example.com', 'password' => bcrypt('password'), 'profile_picture' => '', 'private' => true]);

    Follow::create(['follower_id' => '1', 'user_id' => '1']);
    Follow::create(['follower_id' => '2', 'user_id' => '2']);
    Follow::create(['follower_id' => '3', 'user_id' => '3']);
    Follow::create(['follower_id' => '2', 'user_id' => '1']);
    Follow::create(['follower_id' => '1', 'user_id' => '3']);
  }

}

class LaudTableSeeder extends Seeder {

  /**
   * Run the laud table seeds.
   *
   * @return void
   */
  public function run()
  {
    Laud::create(['title' => 'Testeo', 'sound' => 'test.mp3', 'user_id' => 1]);
  }

}