<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Project;
use App\Http\Resources\ProjectResource;

class WebsiteController extends Controller
{
    //
    public function home()
    {
        return $this->renderWithSeo('Website/Home', [], );
    }

    public function services()
    {
        return $this->renderWithSeo('Website/Services', [], [
            'title' => "Our Services | Furniture, HR & Construction Labor Supply in Kigali - " . config('app.name'),
            'description' => 'Explore our core services: custom furniture design, skilled construction labor supply, and corporate HR solutions tailored for Rwandan businesses.',
            'keywords' => "Furniture manufacturing Rwanda, Construction labor supply Kigali, HR services for companies Rwanda,Kigali skilled workers, Interior design services Rwanda",
            'canonical' => route('services'),
        ]);
    }

    public function projects()
    {
        $collection = Project::with(['category'])
            ->where('is_published', true)
            ->orderBy('order')
            ->latest()
            ->get();
        $projects = ProjectResource::collection($collection);
        return $this->renderWithSeo('Website/Projects', ['projects' => $projects], [
            'title' => "Our Projects | Residential, Commercial, Cultural, Urban Planning - " . config('app.name'),
            'description' => 'Explore our diverse portfolio of architectural projects spanning residential, commercial, cultural, and urban design spaces.',
            'keywords' => "Residential projects, Commercial projects, Cultural projects, Urban planning projects",
            'canonical' => route('projects'),
        ]);
    }
    // project details
    public function projectDetails($slug)
    {
        $project = Project::with(['category'])
            ->where('slug', $slug)
            ->first();
        $project = ProjectResource::make($project);

        $prevProject = Project::where('is_published', true)
            ->where('is_featured', true)
            ->where('order', '<', $project->order)
            ->orderBy('order', 'desc')
            ->first();
        $nextProject = Project::where('is_published', true)
            ->where('is_featured', true)
            ->where('order', '>', $project->order)
            ->orderBy('order', 'asc')
            ->first();

        // related projects
        $relatedProjects = Project::where('is_published', true)
            ->where('category_id', $project->category_id)
            ->where('id', '!=', $project->id)
            ->orderBy('order')
            ->limit(3)
            ->get();
        $relatedProjects = ProjectResource::collection($relatedProjects);

        return $this->renderWithSeo('Website/ProjectDetails', ['project' => $project, 'prevProject' => $prevProject, 'nextProject' => $nextProject, 'relatedProjects' => $relatedProjects], [
            'title' => "Project Details | " . $project->title . " - " . config('app.name'),
            'description' => "Explore the details of our " . $project->title . " project, including its features, design, and construction process.",
            'keywords' => "Project details, " . $project->title . " project, " . $project->title . " features, " . $project->title . " construction",
            'canonical' => route('project.details', $slug),
        ]);
    }

    public function about()
    {
        return $this->renderWithSeo('Website/About', [], [
            'title' => "About " . config('app.name') . " | Empowering Rwanda's Workforce Through Technical Innovation",
            'description' => 'Learn the story of how 23 IPRC Kigali graduates launched a company to revolutionize Rwanda\'s furniture, construction, and HR industries through practical skills and innovation.',
            'keywords' => "About Resilience Professionals, IPRC Kigali graduates, Rwanda technical innovation, Youth-led companies Rwanda, Engineering startups Rwanda ",
            'canonical' => route('about'),
        ]);
    }

    public function contact()
    {
        return $this->renderWithSeo('Website/Contact', [], [
            'title' => "Contact Us | Visit Our Showroom or Workshop in Kigali - " . config('app.name'),
            'description' => 'Get in touch with Resilience Professionals. Visit our showroom in Kicukiro or workshop in Gisozi, Kigali. Call us at +250 788 945 304 or email info@resilience.rw',
            'keywords' => "Contact Resilience Professionals,Furniture showroom Kigali,Interior workshop Rwanda,Construction company contact Kigali",
            'canonical' => route('contact'),
        ]);
    }

    public function blog()
    {
        $blogs = Blog::where('is_published', true)
            ->orderBy('order')
            ->latest()
            ->select('id', 'slug', 'title', 'excerpt', 'featured_image', 'author', 'published_at')
            ->get();
        return $this->renderWithSeo('Website/Blog', ['blogs' => $blogs], [
            'title' => "Blog | UDC Africa",
            'description' => "Explore our thoughts on architecture, design trends, sustainability, and behind-the-scenes insights into our projects.",
            'keywords' => "Architecture blog, Design trends, Sustainability, Project insights",
            'canonical' => route('blog'),
        ]);
    }

    public function blogDetails($slug)
    {
        $blog = Blog::with(['category'])
        ->where('slug', $slug)
        ->firstOrFail();


        // Previous and next blogs by order
        $prevBlog = Blog::where('is_published', true)
        ->where('order', '<', $blog->order)
        ->orderBy('order', 'desc')
        ->first();
        $nextBlog = Blog::where('is_published', true)
        ->where('order', '>', $blog->order)
        ->orderBy('order', 'asc')
        ->first();

        // Related blogs: same category, not current
        $relatedBlogs = Blog::where('is_published', true)
            ->where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->orderBy('order')
            ->limit(5)
            ->get();

        return $this->renderWithSeo('Website/BlogDetails', [
            'blog' => $blog,
            'prevBlog' => $prevBlog,
            'nextBlog' => $nextBlog,
            'relatedBlogs' => $relatedBlogs,
        ], [
            'title' => "Blog Details | " . $blog->title . " - " . config('app.name'),
            'description' => $blog->excerpt ?? '',
            'keywords' => "Blog details, " . $blog->title . ", " . ($blog->category->name ?? ''),
            'canonical' => route('blog.details', $slug),
        ]);
    }

    public function youtubePresenter()
    {
        return $this->renderWithSeo('Website/YouTubePresenter', [], [
            'title' => "We’re Hiring: YouTube Presenter",
            'description' => 'Join UDC Africa as our YouTube Presenter and help us bring our vision to life on-screen through powerful video content. Apply now to be the face and voice of our brand!',
            'keywords' => 'YouTube presenter job, media jobs Rwanda, digital media careers, UDC Africa careers',
            'canonical' => url('/careers/youtube-presenter'),
        ]);
    }
}
