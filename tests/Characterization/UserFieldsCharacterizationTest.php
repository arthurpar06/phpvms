<?php

namespace Tests\Characterization;

use App\Models\User;
use App\Models\UserField;
use App\Models\UserFieldValue;
use App\Repositories\UserRepository;
use Tests\TestCase;

/**
 * Locks in current UserRepository::getUserFields behavior.
 *
 * Purpose: Phase 0 safety net for the repository-removal refactor.
 * Phase 4 will absorb this method into UserService::getUserFields().
 * Assertions must stay identical.
 *
 * Delete this file in Phase 4 after UserService is in production and
 * these same assertions have been migrated into the UserService tests.
 */
final class UserFieldsCharacterizationTest extends TestCase
{
    private UserRepository $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = app(UserRepository::class);
    }

    /**
     * Build a fresh user with its `fields` relation eager-loaded so the
     * method's internal `$user->fields` / `$userFieldValue->field` walk
     * does not trip preventLazyLoading in tests.
     */
    private function userWithFields(): User
    {
        /** @var User $user */
        $user = User::factory()->create();

        return $user->fresh(['fields.field']);
    }

    public function test_returns_only_public_fields_when_only_public_true(): void
    {
        /** @var UserField $public */
        $public = UserField::create([
            'name'     => 'Discord Username',
            'private'  => false,
            'internal' => false,
        ]);
        UserField::create([
            'name'     => 'Home Address',
            'private'  => true,
            'internal' => false,
        ]);

        $user = $this->userWithFields();

        $results = $this->repo->getUserFields($user, true);

        $this->assertCount(1, $results);
        /** @var UserField $first */
        $first = $results->first();
        $this->assertEquals($public->slug, $first->slug);
    }

    public function test_returns_only_private_fields_when_only_public_false(): void
    {
        UserField::create([
            'name'     => 'Discord Username',
            'private'  => false,
            'internal' => false,
        ]);
        /** @var UserField $private */
        $private = UserField::create([
            'name'     => 'Home Address',
            'private'  => true,
            'internal' => false,
        ]);

        $user = $this->userWithFields();

        $results = $this->repo->getUserFields($user, false);

        $this->assertCount(1, $results);
        /** @var UserField $first */
        $first = $results->first();
        $this->assertEquals($private->slug, $first->slug);
    }

    public function test_returns_all_non_internal_fields_when_only_public_null(): void
    {
        UserField::create([
            'name'     => 'Discord Username',
            'private'  => false,
            'internal' => false,
        ]);
        UserField::create([
            'name'     => 'Home Address',
            'private'  => true,
            'internal' => false,
        ]);
        UserField::create([
            'name'     => 'Internal Notes',
            'private'  => false,
            'internal' => true,
        ]);

        $user = $this->userWithFields();

        $results = $this->repo->getUserFields($user);

        // Both non-internal fields (one public, one private) regardless of `private`.
        $this->assertCount(2, $results);
        foreach ($results as $field) {
            $this->assertFalse((bool) $field->internal);
        }
    }

    public function test_with_internal_fields_true_includes_internal(): void
    {
        UserField::create([
            'name'     => 'Discord Username',
            'private'  => false,
            'internal' => false,
        ]);
        UserField::create([
            'name'     => 'Internal Notes',
            'private'  => false,
            'internal' => true,
        ]);

        $user = $this->userWithFields();

        $results = $this->repo->getUserFields($user, null, true);

        $this->assertCount(2, $results);
    }

    public function test_populates_field_value_from_user_field_values(): void
    {
        /** @var UserField $field */
        $field = UserField::create([
            'name'     => 'Discord Username',
            'private'  => false,
            'internal' => false,
        ]);

        /** @var User $user */
        $user = User::factory()->create();

        UserFieldValue::create([
            'user_field_id' => $field->id,
            'user_id'       => $user->id,
            'value'         => 'pilot#1234',
        ]);

        // Reload with the relations the method walks so preventLazyLoading
        // doesn't trip on $user->fields or $userFieldValue->field.
        $user = $user->fresh(['fields.field']);

        $results = $this->repo->getUserFields($user, true);

        $this->assertCount(1, $results);
        /** @var UserField $first */
        $first = $results->first();
        $this->assertEquals('pilot#1234', $first->value);
    }
}
