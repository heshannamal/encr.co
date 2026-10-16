<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use domainencore\Facades\ProjectFacade\ProjectFacade;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('add_project_id_in_comments', function(){
    $this->info('starting...');
    $items = ProjectFacade::getAllComments();
    $totalCount = count($items);

    $progressBar = $this->output->createProgressBar($totalCount);
    $progressBar->start();

    foreach ($items as $item) {
        if($item->is_sub_discussion == 1){
            $discussion = $item->subDiscussionInfo()->withTrashed()->first();
        } else {
            $discussion = $item->discussionInfo()->withTrashed()->first();
        }
        $item->project_id = $discussion->project_id;
        $item->save();

        $progressBar->advance();
    }

    $progressBar->finish();
    $this->info("\All project IDs set successfully!");
})->purpose('Set all project IDs in the table');
