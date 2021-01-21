<?php



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'kd_user' => rand(0,99999),
            'nama' => 'anu',
            'username' => 'anu@gmail.com',
            'akses'=>5,
            'status'=>'client',
            'password' => Hash::make('password'),
        ]);
    }
}
