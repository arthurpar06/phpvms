<?php

use App\Models\FlightField;

/*
|--------------------------------------------------------------------------
| Trait Testing: HasSlug
|--------------------------------------------------------------------------
|
| While the tests below specifically use the Post model, the intent is to
| verify the global behavior of the HasSlug trait. By confirming the logic
| here, we ensure that any model using this trait—whether it's a Category,
| Product, or Tag—will handle slugging and uniqueness consistently.
|
*/

it('generates a slug from the name on creation', function () {
    $flightField = FlightField::create(['name' => 'Pest is Awesome']);

    expect($flightField->slug)->toBe('pest-is-awesome');
});

it('updates the slug when the name changes', function () {
    $flightField = FlightField::create(['name' => 'Old Title']);

    $flightField->update(['name' => 'New Title']);

    expect($flightField->refresh()->slug)->toBe('new-title');
});

it('does not change the slug if the name is unchanged', function () {
    $flightField = FlightField::create(['name' => 'Fixed Title']);
    $originalSlug = $flightField->slug;

    $flightField->update(['content' => 'Just updating some other field']);

    expect($flightField->slug)->toBe($originalSlug);
});

it('handles duplicate names by appending a counter', function () {
    FlightField::create(['name' => 'Duplicate']);

    $flightField2 = FlightField::create(['name' => 'Duplicate']);
    $flightField3 = FlightField::create(['name' => 'Duplicate']);

    expect($flightField2->slug)->toBe('duplicate-1')
        ->and($flightField3->slug)->toBe('duplicate-2');
});

it('keeps the slug unique even when updating to an existing name', function () {
    FlightField::create(['name' => 'First Post']); // slug: first-post
    $secondPost = FlightField::create(['name' => 'Second Post']); // slug: second-post

    // Try to rename "Second Post" to "First Post"
    $secondPost->update(['name' => 'First Post']);

    expect($secondPost->slug)->toBe('first-post-1');
});
