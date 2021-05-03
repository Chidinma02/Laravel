<?php
use App\Models\Post;
use App\Models\User;
use App\Models\country;
use App\Models\Photo;
use App\Models\Tag;
use App\Http\Controllers\users;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use Illuminate\Routing\RouteRegistrar;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/insert',function(){
//     DB::insert('insert into posts(title,body,) 
//     values(?,?) ',['night','morning']);
// });



// eloquent
// Route::get('/read',function(){
//     $result = DB::select('select * from posts where id=?',[1]);
 
//      foreach($result as $post){
//          return $post->title;
//      }
//  });

 Route ::get('/create',function(){

post::create(['title'=>'morning','body'=>'night',]);


  });

  Route::get('/softdelete',function(){
        

    Post::find(2)->delete();

  });

  Route::get('/readsoftdelete',function(){
      
    // $post = Post::find(1);
    // return $post;

    // $post = post::withoutTrashed()->where('id',2)->get();
    // return $post;

    $post = post::onlyTrashed()->where('is_admin',0)->get();
    return $post;
  });

  Route::get('/restore',function(){

    post::withTrashed()->where('is_admin',0)->restore();
  });
 
  Route::get('/forcedelete',function(){
    post::onlyTrashed()->where('is_admin',0)->forceDelete();
  });

  // one to one relationship
  Route::get('/user/{id}/post',function($id){
    return User::find($id)->post;
  });
  // inverse
  Route::get('/post/{id}/user',function ($id){

    return Post::find($id)->user->name;
  });

  // one to many
  Route::get('/posts',function(){

    $user = User::find(1);
    foreach($user->posts as $post){
      echo $post->title."<br>";
    }
  });

  Route::get('/user/{id}/role',function($id){
    $user = User::find($id)->roles()->orderby('id','desc')->get();
    return $user;

    // foreach($user->roles as $role){

    //   return $role->name;
    // }


  });



  // accessing the intermediate table/pivot
  Route::get('user/pivot',function (){
     
    $user = User::find(1);
    foreach($user->roles as $role){
      echo  $role->pivot->created_at;
    }
  });

  Route::get('/user/country',function(){
        
    $country = Country::find(2);

    foreach($country->posts as $post){
      echo $post->title;
    }
  });



  // polymorphic relationship

  Route::get('user/photos',function(){
         $user=User::find(1);

         foreach($user->photos as $photo){
            return $photo;
         }
  });
  Route::get('post/{id}photos',function($id){
    $post=Post::find($id);

    foreach($post->photos as $photo){
       echo $photo->path."<br>";
    }
});

Route::get('photo/{id}/post',function($id){
   $photo = Photo::findOrfail($id);
   return $photo->imageable;
});

// polymorphoc many to many
Route::get('/post/tag',function(){
  $post = post::find(1);

  foreach($post->tags as $tag){
     echo $tag;
  }

  
});


Route::get('/tag/post',function(){
  $tag = Tag::find(2);

  foreach($tag->posts as $post){
    return $post;
  }
});

// crud application



// Route::resource('/posts','App\Http\Controllers\PostsController');
// Route::get('/', 'App\Http\Controllers\RegistrationController@create');
// Route::resource("/posts",[Posts::class,'create']);

// Route::resources([
//   '/posts'=>PostsController::class
// ]);

// Route::get("users",[Users::class,'index']);
// Route::get("posts",[PostsController::class,'create']);
// Route::resource("posts",[PostsController::class,'create']);

// Route::resource('posts', PostsController::class)->only([
//   'create', 
// ]);
Route::resource('posts', PostsController::class);