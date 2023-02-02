<?php

namespace App\Console\Commands;

use App\Models\post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class addCodePostCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addCode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Agrega codigo unico a todas las publicaciones.';

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
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        try{
            $users=post::get();
            $this->info( 'Actualizando registros de post:'.count($users));
            $i = 1;
            foreach ($users as $user) {
                $user->code =(string) Str::uuid();
                $user->save();
                $this->info( 'UPLOAD post '.count($users).'/'.$i++);
            }
            DB::commit();
            $this->info( '---Actualizacion completa ---');
        }catch(\Exception $e){
            DB::rollBack();
            $this->info($e);
        }
        return 0;
    }
}
