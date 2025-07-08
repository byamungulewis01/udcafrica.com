# SeoMeta Component Documentation

The `SeoMeta` component is a reusable SEO component that provides comprehensive meta tags for better search engine optimization and social media sharing.

## Basic Usage

```vue
<script setup>
import SeoMeta from '@/Components/SeoMeta.vue'
</script>

<template>
    <SeoMeta 
        title="Your Page Title"
        description="Your page description"
    />
</template>
```

## All Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | String | 'Resilience Rwanda' | Page title |
| `description` | String | 'Building resilience and sustainable development in Rwanda...' | Meta description |
| `keywords` | String | 'resilience, rwanda, sustainable development...' | Meta keywords |
| `author` | String | 'Resilience Rwanda' | Page author |
| `ogTitle` | String | null (falls back to title) | Open Graph title |
| `ogDescription` | String | null (falls back to description) | Open Graph description |
| `ogType` | String | 'website' | Open Graph type |
| `ogUrl` | String | null (current URL) | Open Graph URL |
| `ogImage` | String | '/admin-panel.png' | Open Graph image |
| `twitterCard` | String | 'summary_large_image' | Twitter card type |
| `twitterTitle` | String | null (falls back to title) | Twitter title |
| `twitterDescription` | String | null (falls back to description) | Twitter description |
| `twitterImage` | String | '/admin-panel.png' | Twitter image |
| `canonicalUrl` | String | null (current URL) | Canonical URL |
| `noIndex` | Boolean | false | Whether to add noindex |
| `noFollow` | Boolean | false | Whether to add nofollow |

## Usage Examples

### Home Page
```vue
<SeoMeta 
    title="Home | Resilience Rwanda"
    description="Welcome to Resilience Rwanda - Building sustainable communities and fostering innovation for a resilient future."
    keywords="resilience, rwanda, sustainable development, community empowerment, innovation, home"
    ogTitle="Home | Resilience Rwanda"
    ogDescription="Welcome to Resilience Rwanda - Building sustainable communities and fostering innovation for a resilient future."
/>
```

### Blog Post
```vue
<SeoMeta 
    title="Blog Post Title | Resilience Rwanda"
    description="This is a detailed description of the blog post content."
    keywords="blog, resilience, rwanda, sustainable development"
    ogType="article"
    ogImage="/path/to/blog-image.jpg"
    twitterImage="/path/to/blog-image.jpg"
/>
```

### Contact Page
```vue
<SeoMeta 
    title="Contact Us | Resilience Rwanda"
    description="Get in touch with Resilience Rwanda. We're here to help with your questions about sustainable development and community empowerment in Rwanda."
    keywords="contact, resilience rwanda, get in touch, support"
    ogTitle="Contact Us | Resilience Rwanda"
    ogDescription="Get in touch with Resilience Rwanda. We're here to help with your questions about sustainable development and community empowerment in Rwanda."
/>
```

### Admin/Private Page (No Index)
```vue
<SeoMeta 
    title="Admin Dashboard | Resilience Rwanda"
    description="Admin dashboard for managing Resilience Rwanda content."
    noIndex="true"
    noFollow="true"
/>
```

## Features

- **Automatic Fallbacks**: If you don't provide `ogTitle`, it will use the `title`. Same for descriptions and URLs.
- **Current URL Detection**: Automatically uses the current page URL for canonical and Open Graph URLs if not specified.
- **Robots Meta**: Automatically generates robots meta tag based on `noIndex` and `noFollow` props.
- **Complete SEO Coverage**: Includes all essential meta tags for SEO and social media sharing.
- **Favicon Support**: Automatically includes favicon links.
- **Responsive Meta**: Includes viewport meta tag for responsive design.

## Best Practices

1. **Always provide a unique title** for each page
2. **Write compelling descriptions** (150-160 characters recommended)
3. **Use relevant keywords** naturally in your content
4. **Provide high-quality images** for social media sharing
5. **Use appropriate Open Graph types** (website, article, etc.)
6. **Set noIndex/noFollow** for admin or private pages 
