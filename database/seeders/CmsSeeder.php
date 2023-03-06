<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Aimeos\Cms\Models\Content;
use Aimeos\Cms\Models\Page;
use Aimeos\Cms\Models\Ref;


class CmsSeeder extends Seeder
{
    /**
     * Seed the CMS database.
     *
     * @return void
     */
    public function run()
    {
        Page::truncate();
        File::truncate();
        Content::truncate();

        $home = $this->home();

        $this->addBlog( $home )
            ->addDev( $home )
            ->addHidden( $home )
            ->addDisabled( $home );
    }


    protected function home()
    {
        $page = Page::create([
            'name' => 'Home',
            'title' => 'Home | LaravelCMS',
            'slug' => '',
            'tag' => 'root',
            'status' => 1,
            'editor' => 'seeder',
        ]);
        $page->save();

        $content = Content::create([
            'data' => [
                ['type' => 'cms::heading', 'text' => 'Welcome to Laravel CMS'],
            ],
            'editor' => 'seeder',
        ]);
        $content->save();

        $ref = Ref::create([
            'page_id' => $page->id,
            'content_id' => $content->id,
            'position' => 0,
            'status' => 1,
            'editor' => 'seeder',
        ]);
        $ref->save();

        return $page;
    }


    protected function addBlog( Page $home )
    {
        $page = Page::create([
            'name' => 'Blog',
            'title' => 'Blog | LaravelCMS',
            'slug' => 'blog',
            'tag' => 'blog',
            'status' => 1,
            'editor' => 'seeder',
        ]);
        $page->appendToNode( $home )->save();

        $content = Content::create([
            'data' => ['type' => 'cms::heading', 'text' => 'Blog example'],
            'editor' => 'seeder',
        ]);
        $content->save();

        $ref = Ref::create([
            'page_id' => $page->id,
            'content_id' => $content->id,
            'position' => 0,
            'status' => 1,
            'editor' => 'seeder',
        ]);
        $ref->save();

        $content = Content::create([
            'data' => ['type' => 'cms::blog'],
            'editor' => 'seeder',
        ]);
        $content->save();

        $ref = Ref::create([
            'page_id' => $page->id,
            'content_id' => $content->id,
            'position' => 1,
            'status' => 1,
            'editor' => 'seeder',
        ]);
        $ref->save();

        return $this->addBlogArticle( $page );
    }


    protected function addBlogArticle( Page $blog )
    {
        $page = Page::create([
            'name' => 'Welcome to LaravelCMS',
            'title' => 'Welcome to LaravelCMS | LaravelCMS',
            'slug' => 'welcome-to-laravelcms',
            'tag' => 'article',
            'status' => 1,
            'editor' => 'seeder',
        ]);
        $page->appendToNode( $blog )->save();

        $content = Content::create([
            'data' => [
                'type' => 'cms::article',
                'title' => 'Welcome to LaravelCMS',
                'cover' => [
                    'type' => 'cms::image',
                    'name' => 'Welcome to LaravelCMS',
                    'path' => 'https://aimeos.org/tips/wp-content/uploads/2023/01/ai-ecommerce-2.jpg',
                    'previews' => [
                        1000 => 'https://aimeos.org/tips/wp-content/uploads/2023/01/ai-ecommerce-2.jpg'
                    ],
                ],
                'intro' => 'LaravelCMS is lightweight, lighting fast, easy to use, fully customizable and scalable from one-pagers to millions of pages',
                'content' => [
                    ['type' => 'cms::heading', 'level' => 2, 'text' => 'Rethink content management!'],
                    ['type' => 'cms::text', 'text' => 'LaravelCMS is exceptional in every way. Headless and API-first!'],
                    ['type' => 'cms::heading', 'level' => 2, 'text' => 'API first!'],
                    ['type' => 'cms::text', 'text' => 'Use GraphQL for editing the pages, contents and files:'],
                    ['type' => 'cms::code', 'language' => 'graphql', 'text' => 'mutation {
  cmsLogin(email: "editor@example.org", password: "secret") {
    name
    email
  }
}'                  ],
                ]
            ],
            'editor' => 'seeder',
        ]);
        $content->save();

        $ref = Ref::create([
            'page_id' => $page->id,
            'content_id' => $content->id,
            'position' => 0,
            'status' => 1,
            'editor' => 'seeder',
        ]);
        $ref->save();

        return $this;
    }


    protected function addDev( Page $home )
    {
        $page = Page::create([
            'name' => 'Dev',
            'title' => 'For Developer | LaravelCMS',
            'slug' => 'dev',
            'status' => 1,
            'editor' => 'seeder',
        ]);
        $page->appendToNode( $home )->save();

        $content = Content::create([
            'data' => [
                'type' => 'cms::markdown',
                'text' => '# For Developers

This is content created by GitHub-flavored markdown syntax',
            ],
            'editor' => 'seeder',
        ]);
        $content->save();

        $ref = Ref::create([
            'page_id' => $page->id,
            'content_id' => $content->id,
            'position' => 0,
            'status' => 1,
            'editor' => 'seeder',
        ]);
        $ref->save();

        return $this;
    }


    protected function addDisabled( Page $home )
    {
        $page = Page::create([
            'name' => 'Disabled',
            'title' => 'Disabled page | LaravelCMS',
            'slug' => 'disabled',
            'tag' => 'disabled',
            'status' => 0,
            'editor' => 'seeder',
        ]);
        $page->appendToNode( $home )->save();

        $child = Page::create([
            'name' => 'Disabled child',
            'title' => 'Disabled child | LaravelCMS',
            'slug' => 'disabled-child',
            'tag' => 'disabled-child',
            'status' => 1,
            'editor' => 'seeder',
        ]);
        $child->appendToNode( $page )->save();

        return $this;
    }


    protected function addHidden( Page $home )
    {
        $page = Page::create([
            'name' => 'Hidden',
            'title' => 'Hidden page | LaravelCMS',
            'slug' => 'hidden',
            'tag' => 'hidden',
            'status' => 2,
            'editor' => 'seeder',
        ]);
        $page->appendToNode( $home )->save();

        return $this;
    }
}
