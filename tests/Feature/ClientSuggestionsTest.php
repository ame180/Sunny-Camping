<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ClientSuggestionsTest extends TestCase
{
    use RefreshDatabase;

    private const FIXTURE_SURNAME = 'Zzzsuggest';
    private const SUGGESTIONS_URL = '/api/clients/suggestions';

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function unauthenticatedRequestRedirectsToLogin()
    {
        $this->withoutMix();
        $response = $this->get(self::SUGGESTIONS_URL . '?query=' . self::FIXTURE_SURNAME);

        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function queryMatchingNothingReturnsEmptyList()
    {
        $response = $this->getSuggestions(self::FIXTURE_SURNAME);

        $response->assertOk();
        $response->assertExactJson([]);
    }

    /** @test */
    public function suggestionResponseExposesOnlyNamePostcodeCountry()
    {
        $this->createFixtureClient(['postcode' => '00-950', 'country' => 'Polska']);

        $response = $this->getSuggestions(self::FIXTURE_SURNAME);

        $response->assertOk();
        $response->assertExactJson([
            [
                'name' => 'Anna ' . self::FIXTURE_SURNAME,
                'postcode' => '00-950',
                'country' => 'Polska',
            ],
        ]);
    }

    /**
     * @test
     *
     * @dataProvider queryLengthCases
     */
    public function queriesAreAcceptedOnlyWhenTrimmedToAtLeastTwoCharacters(string $searchQuery, int $expectedCount)
    {
        $this->createFixtureClient(['name' => 'Zz ' . self::FIXTURE_SURNAME]);

        $this->assertCount($expectedCount, $this->getSuggestions($searchQuery)->json());
    }

    public static function queryLengthCases(): array
    {
        return [
            'single character' => ['Z', 0],
            'exactly two characters' => ['Zz', 1],
            'single character padded with whitespace' => ['  A  ', 0],
            'match padded with whitespace' => ['  ' . self::FIXTURE_SURNAME . '  ', 1],
        ];
    }

    /** @test */
    public function repeatStaysWithSamePostcodeCollapseToOneSuggestion()
    {
        $this->createFixtureClient(['postcode' => '00-950']);
        $this->createFixtureClient(['postcode' => '00-950']);

        $suggestions = $this->getSuggestions(self::FIXTURE_SURNAME)->json();

        $this->assertCount(1, $suggestions);
        $this->assertSame('00-950', $suggestions[0]['postcode']);
    }

    /** @test */
    public function mostRecentStayIsSuggestedFirst()
    {
        $this->createFixtureClient(['postcode' => '00-950']);
        $this->createFixtureClient(['postcode' => '31-002']);

        $suggestions = $this->getSuggestions(self::FIXTURE_SURNAME)->json();

        $this->assertCount(2, $suggestions);
        $this->assertSame('31-002', $suggestions[0]['postcode']);
        $this->assertSame('00-950', $suggestions[1]['postcode']);
    }

    /** @test */
    public function clientsFromPastSeasonsAreSuggested()
    {
        $this->createFixtureClient([
            'arrival_date' => now()->subYears(2)->format('Y-m-d'),
            'departure_date' => now()->subYears(2)->addDays(5)->format('Y-m-d'),
            'postcode' => '80-180',
        ]);

        $suggestions = $this->getSuggestions(self::FIXTURE_SURNAME)->json();

        $this->assertCount(1, $suggestions);
        $this->assertSame('80-180', $suggestions[0]['postcode']);
    }

    /** @test */
    public function nameWithNoPostcodeOrCountryAnywhereIsStillSuggested()
    {
        $this->createFixtureClient(['postcode' => null, 'country' => null]);

        $suggestions = $this->getSuggestions(self::FIXTURE_SURNAME)->json();

        $this->assertCount(1, $suggestions);
        $this->assertSame('Anna ' . self::FIXTURE_SURNAME, $suggestions[0]['name']);
        $this->assertNull($suggestions[0]['postcode']);
        $this->assertNull($suggestions[0]['country']);
    }

    /**
     * @test
     *
     * @dataProvider locationVariants
     */
    public function bareRowIsSuppressedWhenSameNameHasLocationElsewhere(?string $postcode, ?string $country)
    {
        $this->createFixtureClient(['postcode' => null, 'country' => null]);
        $this->createFixtureClient(['postcode' => $postcode, 'country' => $country]);

        $suggestions = $this->getSuggestions(self::FIXTURE_SURNAME)->json();

        $this->assertCount(1, $suggestions);
        $this->assertSame($postcode, $suggestions[0]['postcode']);
        $this->assertSame($country, $suggestions[0]['country']);
    }

    public static function locationVariants(): array
    {
        return [
            'postcode only' => ['00-950', null],
            'country only' => [null, 'Niemcy'],
            'postcode and country' => ['00-950', 'Polska'],
        ];
    }

    /** @test */
    public function suppressionAppliesPerNameOnly()
    {
        $this->createFixtureClient(['postcode' => null, 'country' => null]);
        $this->createFixtureClient(['postcode' => '00-950', 'country' => 'Polska']);
        $this->createFixtureClient(['name' => 'Without ' . self::FIXTURE_SURNAME, 'postcode' => null, 'country' => null]);

        $suggestions = $this->getSuggestions(self::FIXTURE_SURNAME)->json();
        $names = collect($suggestions)->pluck('name');

        $this->assertCount(2, $suggestions);
        $this->assertContains('Without ' . self::FIXTURE_SURNAME, $names);
        $this->assertContains('Anna ' . self::FIXTURE_SURNAME, $names);
    }

    /** @test */
    public function suppressionHoldsWhenSuppressingRowFallsOutsideReturnedPage()
    {
        $suppressedName = 'Old ' . self::FIXTURE_SURNAME;

        $this->createFixtureClient(['name' => $suppressedName, 'postcode' => '99-999']);
        foreach (range(1, 60) as $offset) {
            $this->createFixtureClient(['postcode' => sprintf('00-%03d', $offset)]);
        }
        $this->createFixtureClient(['name' => $suppressedName, 'postcode' => null, 'country' => null]);

        $suggestions = collect($this->getSuggestions(self::FIXTURE_SURNAME)->json());
        $bareRows = $suggestions->filter(
            fn ($suggestion) => $suppressedName === $suggestion['name'] && null === $suggestion['postcode']
        );

        $this->assertNotEmpty($suggestions);
        $this->assertCount(0, $bareRows);
    }

    /** @test */
    public function suggestionsAreLimitedToTwenty()
    {
        foreach (range(1, 21) as $offset) {
            $this->createFixtureClient(['postcode' => sprintf('00-%03d', $offset)]);
        }

        $suggestions = $this->getSuggestions(self::FIXTURE_SURNAME)->json();

        $this->assertCount(20, $suggestions);
    }

    /** @test */
    public function namesAreMatchedAtWordBoundariesOnly()
    {
        $this->createFixtureClient(['name' => self::FIXTURE_SURNAME . ' First']);
        $this->createFixtureClient(['name' => 'Jan ' . self::FIXTURE_SURNAME]);
        $this->createFixtureClient(['name' => 'Ewa Kowalska-' . self::FIXTURE_SURNAME]);
        $this->createFixtureClient(['name' => 'Prefix' . self::FIXTURE_SURNAME . ' Jan']);

        $names = collect($this->getSuggestions(self::FIXTURE_SURNAME)->json())->pluck('name');

        $this->assertCount(3, $names);
        $this->assertContains(self::FIXTURE_SURNAME . ' First', $names);
        $this->assertContains('Jan ' . self::FIXTURE_SURNAME, $names);
        $this->assertContains('Ewa Kowalska-' . self::FIXTURE_SURNAME, $names);
        $this->assertNotContains('Prefix' . self::FIXTURE_SURNAME . ' Jan', $names);
    }

    /** @test */
    public function namePrefixMatchesOutrankMoreRecentWordMatches()
    {
        $this->createFixtureClient(['name' => self::FIXTURE_SURNAME . ' Older']);
        $this->createFixtureClient(['name' => 'Newer ' . self::FIXTURE_SURNAME]);

        $names = collect($this->getSuggestions(self::FIXTURE_SURNAME)->json())->pluck('name');

        $this->assertSame(self::FIXTURE_SURNAME . ' Older', $names->first());
    }

    private function createFixtureClient(array $attributes = []): Client
    {
        return Client::factory()->create(array_merge([
            'name' => 'Anna ' . self::FIXTURE_SURNAME,
            'postcode' => '00-950',
            'country' => 'Polska',
        ], $attributes));
    }

    private function getSuggestions(string $searchQuery): TestResponse
    {
        return $this->actingAs($this->user)->getJson(self::SUGGESTIONS_URL . '?query=' . urlencode($searchQuery));
    }
}
