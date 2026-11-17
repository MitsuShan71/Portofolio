<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Feedback;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortfolioFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_user_profile_and_persisted_experience(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Shan Favian Efendy')
            ->assertSee('Kelas XII A')
            ->assertSee('PPLG')
            ->assertSee('Fokus & minat')
            ->assertSee('UI/UX Design')
            ->assertSee('pengembangan web')
            ->assertSee('PLK — Periode 1')
            ->assertSee('aria-label="Portofolio - Beranda"', false)
            ->assertSee('>Portofolio</span>', false)
            ->assertSee('>Beranda</a>', false)
            ->assertDontSee('brand__mark', false)
            ->assertSee('Unduh CV');
    }

    public function test_homepage_shows_contact_links_and_guestbook_without_contact_form(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('mailto:shanfavianeffendy@gmail.com')
            ->assertSee('id="feedback"', false)
            ->assertSee(route('feedback.store'))
            ->assertDontSee('id="contact-form"', false)
            ->assertDontSee('contact-message-input', false);
    }

    public function test_homepage_uses_public_cv_when_uploaded_resume_is_missing(): void
    {
        $this->get('/')->assertOk();
        PortfolioProfile::firstOrFail()->update(['resume_file' => 'resumes/missing-cv.pdf']);

        $this->get('/')
            ->assertOk()
            ->assertSee('cv-digital-shan-favian-efendy.pdf')
            ->assertDontSee('storage/resumes/missing-cv.pdf');
    }

    public function test_homepage_keeps_using_an_existing_uploaded_resume(): void
    {
        $this->get('/')->assertOk();
        Storage::fake('public');
        Storage::disk('public')->put('resumes/current-cv.pdf', 'PDF contents');
        PortfolioProfile::firstOrFail()->update(['resume_file' => 'resumes/current-cv.pdf']);

        $this->get('/')
            ->assertOk()
            ->assertSee('storage/resumes/current-cv.pdf')
            ->assertDontSee('cv-digital-shan-favian-efendy.pdf');
    }

    public function test_homepage_hero_tools_omit_html_without_removing_it_from_skills(): void
    {
        Skill::create([
            'name' => 'Figma',
            'category' => 'hard',
            'percentage' => 80,
            'sort_order' => 1,
        ]);
        Skill::create([
            'name' => 'HTML',
            'category' => 'hard',
            'percentage' => 80,
            'sort_order' => 2,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertDontSee('Figma · HTML')
            ->assertSee('Figma')
            ->assertSee('HTML')
            ->assertDontSee('skills-mini-tags', false);
    }

    public function test_skill_group_headers_hide_item_count_badges(): void
    {
        Skill::create(['name' => 'Hard skill test', 'category' => 'hard', 'percentage' => 80]);
        Skill::create(['name' => 'Soft skill test', 'category' => 'soft', 'percentage' => 60]);

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Hard skill')
            ->assertSee('Soft skill');
        $this->assertStringNotContainsString('item</span>', $response->getContent());
    }

    public function test_skill_forms_do_not_show_icon_image_upload(): void
    {
        $skill = Skill::create([
            'name' => 'Admin UI skill',
            'category' => 'hard',
            'percentage' => 70,
        ]);

        $this->withSession(['admin_logged_in' => true])
            ->get(route('admin.skills.create'))
            ->assertOk()
            ->assertDontSee('name="icon_image"', false)
            ->assertSee('Nama keahlian');

        $this->withSession(['admin_logged_in' => true])
            ->get(route('admin.skills.edit', $skill))
            ->assertOk()
            ->assertDontSee('name="icon_image"', false)
            ->assertSee('Nama keahlian');
    }

    public function test_about_section_lists_plk_and_organization_experiences(): void
    {
        Experience::create([
            'category' => 'organization',
            'title' => 'OSIS',
            'organization' => 'SMK Negeri 2 Banjarmasin',
            'start_date' => '2025-01-01',
        ]);

        $response = $this->get('/');
        $response->assertOk()
            ->assertSeeInOrder([
                'Tujuan karir',
                'Pengalaman PLK',
                'PLK — Periode 1',
                'PLK — Periode 2',
                'Organisasi & Kepanitiaan',
                'OSIS',
            ]);

        $this->assertSame(
            ['PLK — Periode 1', 'PLK — Periode 2'],
            $response->viewData('experiences')->get('plk')->pluck('title')->all(),
        );
    }

    public function test_homepage_renders_percentage_skills_and_clickable_project_links(): void
    {
        Skill::create([
            'name' => 'Figma',
            'category' => 'hard',
            'percentage' => 73,
            'sort_order' => 1,
        ]);

        Project::create([
            'title' => 'Portfolio test project',
            'description' => 'Short summary',
            'problem_solved' => 'Problem statement',
            'objective' => 'Project objective',
            'technologies' => 'Laravel',
            'role' => 'Designer',
            'features' => 'Search and filters',
            'demo_link' => 'https://example.com/demo',
            'github_link' => 'https://github.com/example/repo',
            'process_documentation' => 'Research then prototype',
            'user_feedback' => 'Users found the flow clear',
            'details' => 'Full project context',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSeeInOrder(['Halo, saya', 'Keahlian', 'Figma', 'Portfolio test project', 'Lihat demo', 'GitHub'])
            ->assertSee('Figma')
            ->assertSee('73%')
            ->assertSee('role="progressbar"', false)
            ->assertSee('href="https://example.com/demo"', false)
            ->assertSee('href="https://github.com/example/repo"', false)
            ->assertSee('Pratinjau detail')
            ->assertSee('Problem statement');
    }

    public function test_projects_can_be_searched_and_filtered_by_category(): void
    {
        $project = Project::create([
            'title' => 'Portfolio search test',
            'category' => 'Website',
            'description' => 'A searchable project',
            'role' => 'Designer',
            'technologies' => 'Laravel, MySQL',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('aria-label="Cari proyek"', false)
            ->assertSee('data-project-filter="website"', false)
            ->assertSee('data-project-search-text="portfolio search test website a searchable project designer laravel, mysql"', false)
            ->assertSee('Laravel')
            ->assertSee('MySQL');

        $this->withSession(['admin_logged_in' => true])
            ->get(route('admin.projects.edit', $project))
            ->assertOk()
            ->assertSee('name="category"', false)
            ->assertSee('value="Website"', false)
            ->assertSee('name="technologies"', false)
            ->assertSee('value="Laravel, MySQL"', false);
    }

    public function test_published_article_page_renders_with_owner_profile(): void
    {
        $this->get('/')->assertOk();

        $article = Article::create([
            'title' => 'Catatan desain',
            'slug' => 'catatan-desain',
            'excerpt' => 'Ringkasan catatan desain.',
            'body' => 'Isi lengkap catatan desain.',
            'published_at' => now()->subMinute(),
        ]);

        $this->get(route('articles.show', $article->slug))
            ->assertOk()
            ->assertSee('Catatan desain')
            ->assertSee('Ringkasan catatan desain.')
            ->assertSee('Isi lengkap catatan desain.')
            ->assertSee('Shan Favian Efendy')
            ->assertSee('PPLG')
            ->assertSee('Kembali ke blog');

        $draft = Article::create([
            'title' => 'Draf artikel',
            'slug' => 'draf-artikel',
            'body' => 'Belum terbit.',
            'published_at' => null,
        ]);

        $this->get(route('articles.show', $draft->slug))->assertNotFound();
    }

    public function test_feedback_form_persists_submission(): void
    {
        $this->post('/feedback', [
            'name' => 'Portfolio visitor',
            'message' => 'The portfolio is easy to use.',
        ])->assertRedirect();

        $this->assertDatabaseHas((new Feedback)->getTable(), [
            'name' => 'Portfolio visitor',
            'message' => 'The portfolio is easy to use.',
        ]);
    }

    public function test_contact_message_feature_is_removed(): void
    {
        $this->post('/contact')->assertNotFound();
        $this->get('/admin/messages')->assertNotFound();

        $this->withSession(['admin_logged_in' => true])
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Kesan & pesan', false)
            ->assertDontSee('Pesan kontak');
    }

    public function test_admin_content_routes_require_session_and_can_save_content(): void
    {
        $this->get('/admin/skills')->assertRedirect(route('admin.login'));

        $this->withSession(['admin_logged_in' => true])
            ->post(route('admin.skills.store'), [
                'name' => 'Communication',
                'category' => 'soft',
                'percentage' => 82,
                'sort_order' => 1,
            ])->assertRedirect(route('admin.skills.index'));

        $this->assertDatabaseHas('skills', [
            'name' => 'Communication',
            'category' => 'soft',
            'percentage' => 82,
        ]);

        $this->withSession(['admin_logged_in' => true])
            ->post(route('admin.certificates.store'), ['title' => 'Portfolio certificate'])
            ->assertRedirect(route('admin.certificates.index'));

        $this->assertDatabaseHas('certificates', ['title' => 'Portfolio certificate']);
    }

    public function test_admin_login_accepts_the_configured_gmail_address(): void
    {
        config([
            'admin.email' => 'Owner@gmail.com',
            'admin.password' => 'secret',
        ]);

        $this->post(route('admin.login.submit'), [
            'email' => 'owner@gmail.com',
            'password' => 'secret',
        ])->assertRedirect(route('admin.dashboard'))
            ->assertSessionHas('admin_logged_in', true);
    }

    public function test_admin_login_rejects_non_gmail_addresses(): void
    {
        config([
            'admin.email' => 'owner@gmail.com',
            'admin.password' => 'secret',
        ]);

        $this->post(route('admin.login.submit'), [
            'email' => 'owner@example.com',
            'password' => 'secret',
        ])->assertSessionHasErrors('email')
            ->assertSessionMissing('admin_logged_in');
    }

    public function test_admin_can_update_profile_and_create_complete_project(): void
    {
        Storage::fake('public');

        $this->withSession(['admin_logged_in' => true])
            ->patch(route('admin.profile.update'), [
                'full_name' => 'Updated Portfolio Owner',
                'class_name' => 'XII A',
                'competency' => 'PPLG',
                'summary' => 'Updated summary',
                'bio' => 'Updated bio',
                'education' => 'SMK Negeri 2 Banjarmasin',
                'technology_interests' => 'Accessibility and frontend development',
                'career_goal' => 'UI/UX Designer',
                'email' => 'owner@example.test',
                'github_url' => 'https://github.com/owner',
                'instagram_url' => 'https://instagram.com/owner',
                'resume_file' => UploadedFile::fake()->create('owner-resume.pdf', 20, 'application/pdf'),
            ])->assertRedirect(route('admin.profile.edit'));

        $this->assertDatabaseHas('portfolio_profiles', [
            'id' => 1,
            'full_name' => 'Updated Portfolio Owner',
            'email' => 'owner@example.test',
        ]);
        $profile = PortfolioProfile::findOrFail(1);
        Storage::disk('public')->assertExists($profile->resume_file);
        $this->get(route('home'))->assertSee(Storage::disk('public')->url($profile->resume_file));

        $this->withSession(['admin_logged_in' => true])
            ->post(route('admin.projects.store'), [
                'title' => 'Admin-created project',
                'description' => 'Project summary',
                'problem_solved' => 'Problem',
                'objective' => 'Objective',
                'technologies' => 'Laravel',
                'role' => 'Designer',
                'features' => 'Accessible navigation',
                'demo_link' => 'https://example.test/demo',
                'github_link' => 'https://github.com/owner/project',
                'process_documentation' => 'Research and prototype',
                'user_feedback' => 'Clear and easy to use',
                'image' => UploadedFile::fake()->createWithContent(
                    'project.png',
                    base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/i8sAAAAASUVORK5CYII=')
                ),
            ])->assertRedirect(route('admin.projects.index'));

        $project = Project::where('title', 'Admin-created project')->firstOrFail();
        Storage::disk('public')->assertExists($project->image);

        $this->withSession(['admin_logged_in' => true])
            ->put(route('admin.projects.update', $project), ['title' => $project->title])
            ->assertRedirect(route('admin.projects.index'));

        Storage::disk('public')->assertExists($project->image);
    }

    public function test_new_projects_can_be_created_without_a_screenshot(): void
    {
        $this->withSession(['admin_logged_in' => true])
            ->post(route('admin.projects.store'), ['title' => 'Project without screenshot'])
            ->assertRedirect(route('admin.projects.index'));

        $project = Project::where('title', 'Project without screenshot')->firstOrFail();
        $this->assertDatabaseHas('projects', [
            'title' => 'Project without screenshot',
            'image' => null,
        ]);

        $this->withSession(['admin_logged_in' => true])
            ->put(route('admin.projects.update', $project), ['title' => 'Project without screenshot updated'])
            ->assertRedirect(route('admin.projects.index'));

        $this->assertDatabaseHas('projects', [
            'title' => 'Project without screenshot updated',
            'image' => null,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Project without screenshot updated');
    }

    public function test_admin_can_upload_and_delete_certificate_documentation(): void
    {
        Storage::fake('public');

        $this->withSession(['admin_logged_in' => true])
            ->post(route('admin.certificates.store'), [
                'title' => 'Certificate with documentation',
                'description' => 'Achievement description',
                'date' => '2026-10-01',
                'documentation' => UploadedFile::fake()->create('certificate.pdf', 20, 'application/pdf'),
            ])->assertRedirect(route('admin.certificates.index'));

        $certificate = Certificate::where('title', 'Certificate with documentation')->firstOrFail();
        Storage::disk('public')->assertExists($certificate->documentation);

        $this->withSession(['admin_logged_in' => true])
            ->delete(route('admin.certificates.destroy', $certificate))
            ->assertRedirect(route('admin.certificates.index'));

        $this->assertDatabaseMissing('certificates', ['id' => $certificate->id]);
        Storage::disk('public')->assertMissing($certificate->documentation);
    }

    public function test_all_admin_content_screens_render_for_authenticated_admin(): void
    {
        $project = Project::create(['title' => 'Admin UI project']);
        $certificate = Certificate::create(['title' => 'Admin UI certificate']);
        $experience = Experience::create([
            'category' => 'organization',
            'title' => 'Admin UI experience',
            'organization' => 'School',
            'start_date' => '2025-01-01',
        ]);
        $skill = Skill::create([
            'name' => 'Admin UI skill',
            'category' => 'hard',
            'percentage' => 70,
        ]);
        $feedback = Feedback::create([
            'name' => 'Admin UI visitor',
            'message' => 'Admin UI feedback',
        ]);

        $routes = [
            route('admin.dashboard'),
            route('admin.projects.index'),
            route('admin.projects.create'),
            route('admin.projects.show', $project),
            route('admin.projects.edit', $project),
            route('admin.certificates.index'),
            route('admin.certificates.create'),
            route('admin.certificates.show', $certificate),
            route('admin.certificates.edit', $certificate),
            route('admin.experiences.index'),
            route('admin.experiences.create'),
            route('admin.experiences.edit', $experience),
            route('admin.skills.index'),
            route('admin.skills.create'),
            route('admin.skills.edit', $skill),
            route('admin.profile.edit'),
            route('admin.feedback.index'),
            route('admin.feedback.show', $feedback),
        ];

        $this->withSession(['admin_logged_in' => true]);

        foreach ($routes as $route) {
            $this->get($route)->assertOk();
        }
    }
}
