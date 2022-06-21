<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Helious Jin-Mei',
            'accessToken' => 'eyJhbGciOiJSUzI1NiIsImtpZCI6IkpXVC1TaWduYXR1cmUtS2V5IiwidHlwIjoiSldUIn0.eyJzY3AiOlsiZXNpLWNoYXJhY3RlcnMucmVhZF9jb3Jwb3JhdGlvbl9yb2xlcy52MSIsImVzaS1jb3Jwb3JhdGlvbnMucmVhZF9zdHJ1Y3R1cmVzLnYxIl0sImp0aSI6IjllNTgzY2JjLTU4MDMtNGYzMS1hZjE4LTdlMDcxZDc4ZjM2OSIsImtpZCI6IkpXVC1TaWduYXR1cmUtS2V5Iiwic3ViIjoiQ0hBUkFDVEVSOkVWRTo5NDE1NDI5NiIsImF6cCI6ImZjNWY3NTVkNTdmYjQwNDg5MTA4YWNkZDllNDg4NDgzIiwidGVuYW50IjoidHJhbnF1aWxpdHkiLCJ0aWVyIjoibGl2ZSIsInJlZ2lvbiI6IndvcmxkIiwiYXVkIjoiRVZFIE9ubGluZSIsIm5hbWUiOiJIZWxpb3VzIEppbi1NZWkiLCJvd25lciI6IjF3VHFsMllBNm9ZTmF5cExkbWU0L0IwRjIwZz0iLCJleHAiOjE2NTExODc2MDQsImlhdCI6MTY1MTE4NjQwNCwiaXNzIjoibG9naW4uZXZlb25saW5lLmNvbSJ9.ba5Z2w5ZUeTpsH1DVkdFZy0HtlO5MGjuNBPMSy74UfexAPgnwF6LQjVQP5Ud8FAPef8-dvqB8ZMrggwM_2vNAAEUnUpmjHywwee4kKiHzXmo9065al8wlzYXmqrSJ1z82kf1BMDTLCmXgjgpcUkmEcMFlMRtAckaYotScBwECsTVVfL0p9CSesUyQ10ZJSi2aZU3S7GyhBK2aKYJR8mstPokd10qhpFwwe1169ysIsB4D5JJLqvsHwJ3gWMGXoNvAICf-iVLZZqL-VMCtXaueHVpdKbJyxTRPVbe_WQGYuXZxsv8MQFhFlA3HyzOaUoIW8tIJHZQzshPOKHwlaeLjA',
            'refreshToken' => 'JSh6Kxo79EWFScPktgG0eA==',
            'eve_id' => '94154296',
        ]);
    }
}
