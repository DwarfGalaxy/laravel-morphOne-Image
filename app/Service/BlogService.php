<?php
namespace App\Service;

use App\Models\Blog;

class BlogService{
    private $imageservice;
    public function __construct() {
        $this->imageservice = new ImageService();
    }
    // =======POST==============
    public function addService($request){
       // adding data to db
       $blog = Blog::create($request);
       // if image exist
       if (isset($request['image'])) {
           $this->imageservice->saveImage($blog, $request['image'], 'blog');
       }
    }

    // =============GET(all)==============
    public function fetchBlogs(){
        $blogs = Blog::with('image')->get();
        return $blogs;
    }

    // ========DELETE====================
    public function delete($blog){
        if (!empty($blog['image'])) {
            $this->imageservice->deleteImage($blog['image']);
        }
        $blog->delete();
    }

    // ========GET(single blog)============
    public function view($blog)
    {
        $blog = Blog::with('image')->first();
        return $blog;
    }

     // ================UPDATE=======================
    public function updateService($request, $blog)
    {
        if (!empty($request['image'])) {
            $this->imageservice->updateImage($blog, $request['image'], 'blog', true);
        }
        $blog->update([
            'title' => $request['title'],
            'slug' => $request['slug'],
            'description' => $request['description']
        ]);
    }

}