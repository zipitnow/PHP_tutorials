<?php


use App\Models\Job;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
      return view('home');
});

// Displays all jobs
Route::get('/jobs', function () {
    $jobs =Job::with('employer')->latest()->simplePaginate(3);

    return view('jobs/index',[
        'jobs' => $jobs
    ]);
});

// Create Jobs
Route::get('/jobs/create', function(){
 return view('jobs.create');
});

// Displays a single job
Route::get('/jobs/{id}', function ($id) {
    $jobs = Job::find($id);

    return view('jobs.show',['job' => $jobs]);
});

// Stores are new obJ
Route::post('/jobs', function () {
//validation
request()->validate([
     'title' => ['required','min:3'],
     'salary' => ['required']
]);

Job::create([
    'title' => request('title'),
    'salary' => request('salary'),
    'employer_id' => 1
]);

return redirect('/jobs');
});

//Edit a Job
Route::get('/jobs/{id}/edit', function ($id) {
    $jobs = Job::find($id);
    return view('jobs.edit',['job' => $jobs]);
});


// Update a Job
Route::patch('/jobs/{id}', function ($id) {

    //Validate
    request()->validate([
        'title' => ['required','min:3'],
        'salary' => ['required']
   ]);
    //Authorize
    //update the job
    $job = Job::findOrFail($id); //and persist by adding OrFail
    //This
         // $job->title = request('title');
        // $job->salary = request('salary');
        // $job->save();
    //OR This method to update
    $job->update([
        'title' => request('title'),
        'salary' => request('salary'),
    ]);

    //redirect to the job page
    return redirect('/jobs/'.$job->id);
});

// Delete a Job
Route::delete('/jobs/{id}', function ($id) {
     //authorize

     // delete the job
     Job::findOrFail($id)->delete();

     //redirect
     return redirect('/jobs');
});

Route::get('/contact', function () {
    return view('contact');
});