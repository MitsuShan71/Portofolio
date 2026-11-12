<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Feedback;
use App\Models\Message;
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
            ->assertSee('PLK — Periode 1')
            ->assertSee('Lihat CV');
    }

    public function test_homepage_renders_percentage_skills_and_project_preview_details(): void
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
            ->assertSee('Figma')
            ->assertSee('73%')
            ->assertSee('role="progressbar"', false)
            ->assertSee('Problem statement')
            ->assertSee('Project objective')
            ->assertSee('Research then prototype')
            ->assertSee('Users found the flow clear')
            ->assertSee('https://github.com/example/repo');
    }

    public function test_contact_and_feedback_forms_persist_submissions(): void
    {
        $this->postJson('/contact', [
            'name' => 'Portfolio visitor',
            'email' => 'visitor@example.test',
            'message' => 'Please contact me.',
        ])->assertOk();

        $this->post('/feedback', [
            'name' => 'Portfolio visitor',
            'message' => 'The portfolio is easy to use.',
        ])->assertRedirect();

        $this->assertDatabaseHas((new Message)->getTable(), [
            'email' => 'visitor@example.test',
            'message' => 'Please contact me.',
        ]);
        $this->assertDatabaseHas((new Feedback)->getTable(), [
            'name' => 'Portfolio visitor',
            'message' => 'The portfolio is easy to use.',
        ]);
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
                'details' => 'Project background',
            ])->assertRedirect(route('admin.projects.index'));

        $this->assertDatabaseHas('projects', [
            'title' => 'Admin-created project',
            'problem_solved' => 'Problem',
            'github_link' => 'https://github.com/owner/project',
        ]);
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
        $message = Message::create([
            'name' => 'Admin UI sender',
            'email' => 'sender@example.test',
            'message' => 'Admin UI message',
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
            route('admin.messages.index'),
            route('admin.messages.show', $message),
            route('admin.feedback.index'),
            route('admin.feedback.show', $feedback),
        ];

        $this->withSession(['admin_logged_in' => true]);

        foreach ($routes as $route) {
            $this->get($route)->assertOk();
        }
    }
}
