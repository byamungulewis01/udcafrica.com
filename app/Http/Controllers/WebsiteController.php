<?php

namespace App\Http\Controllers;

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
        return $this->renderWithSeo('Website/Projects', [], [
            'title' => "Our Projects | Residential, Commercial, Cultural, Urban Planning - " . config('app.name'),
            'description' => 'Explore our diverse portfolio of architectural projects spanning residential, commercial, cultural, and urban design spaces.',
            'keywords' => "Residential projects, Commercial projects, Cultural projects, Urban planning projects",
            'canonical' => route('projects'),
        ]);
    }

    public function about()
    {
        return $this->renderWithSeo('Website/About', [], [
            'title' => "About " . config('app.name') . " | Empowering Rwanda’s Workforce Through Technical Innovation",
            'description' => 'Learn the story of how 23 IPRC Kigali graduates launched a company to revolutionize Rwanda’s furniture, construction, and HR industries through practical skills and innovation.',
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
        return $this->renderWithSeo('Website/Blog', [], [
            'title' => "Blog | UDC Africa",
            'description' => "Explore our thoughts on architecture, design trends, sustainability, and behind-the-scenes insights into our projects.",
            'keywords' => "Architecture blog, Design trends, Sustainability, Project insights",
            'canonical' => route('blog'),
        ]);
    }
}
