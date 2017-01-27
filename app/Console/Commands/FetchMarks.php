<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DiDom\Document;
use DB;
use Cache;
use Carbon\Carbon;

class FetchMarks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bach:marks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lay diem cac mon hoc';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            file_get_contents('http://ktdbcl.epu.edu.vn');
        } catch(\Exception $e) {
            $this->error('Something wrong!');
            return;
        }
        DB::table('marks')->truncate();
        DB::table('students')->truncate();
        DB::table('subjects')->get()->each(function ($sub) {
            $this->line('Lay mon ' . $sub->name);
            $url = 'http://ktdbcl.epu.edu.vn/student/viewexamresultclass/' . $sub->id . '/bachnx.htm?recpage=0';
            $doc = new Document($url, true);
            $table = $doc->find('#frmMain > div > div.mainpanelleft > div.boxpanel > div.k-panel-bwrap > div.k-panel-ml > div > div > div.k-panel-body > div > div.kPanel > table')[0];
            $data = array_slice($table->find('tr'), 1);
            $marks = collect($data)->map(function($tr) use ($sub) {
                return [
                    'student_id' => trim($tr->find('td')[1]->text()),
                    'subject_id' => $sub->id,
                    'mark1' => trim($tr->find('td')[3]->text()),
                    'mark2' => trim($tr->find('td')[4]->text()),
                ];
            })->toArray();
            DB::table('marks')->insert($marks);
            $students = collect($data)->map(function($tr) {
                return [
                    'id' => trim($tr->find('td')[1]->text()),
                    'name' => trim($tr->find('td > a')[0]->text()) //preg_replace('@\\s+@', ' ', )
                ];
            });
            $existed = DB::table('students')->whereIn('id', $students->pluck('id'))->pluck('id')->toArray();
            DB::table('students')->insert($students->filter(function ($student) use ($existed) {
                return !in_array($student['id'], $existed);
            })->toArray());
            $this->info('Lay thanh cong ' . count($marks) . ' sinh vien');
        });
        Cache::forever('time', Carbon::now());
    }
}
