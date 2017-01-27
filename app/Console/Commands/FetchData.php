<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DiDom\Document;
use DB;

class FetchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bach:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lay danh sach sinh vien';

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
        $this->line('Lay danh sach mon hoc');
        DB::table('subjects')->truncate();
        $table = (new Document('http://ktdbcl.epu.edu.vn/examre/ket-qua-hoc-tap.htm?code=1381310007', true))
            ->find('#_ctl7_viewResult > div > div > table')[0];
        $data = collect($table->find('tr'))->map(function ($row) {
            if (!$row->has('td a')) return false;
            $tmp = $row('td a')[0];
            preg_match('@/(\\d+)/@', $tmp->href, $matches);
            return [ 'name' => trim($tmp->text()), 'id' => intval($matches[1]) ];
        })->filter(function($sub) {
            return $sub !== false && $sub['id'] >= 11602;
        })->toArray();
        DB::table('subjects')->insert($data);
        $this->info('Lay thanh cong ' . (DB::table('subjects')->count()) . ' mon hoc');

    }
}
