<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\StockController
 */
final class StockControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $stocks = Stock::factory()->count(3)->create();

        $response = $this->get(route('stocks.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StockController::class,
            'store',
            \App\Http\Requests\StockStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();
        $symbol = $this->faker->word();
        $open = $this->faker->randomFloat(/** decimal_attributes **/);
        $high = $this->faker->randomFloat(/** decimal_attributes **/);
        $low = $this->faker->randomFloat(/** decimal_attributes **/);
        $close = $this->faker->randomFloat(/** decimal_attributes **/);

        $response = $this->post(route('stocks.store'), [
            'name' => $name,
            'symbol' => $symbol,
            'open' => $open,
            'high' => $high,
            'low' => $low,
            'close' => $close,
        ]);

        $stocks = Stock::query()
            ->where('name', $name)
            ->where('symbol', $symbol)
            ->where('open', $open)
            ->where('high', $high)
            ->where('low', $low)
            ->where('close', $close)
            ->get();
        $this->assertCount(1, $stocks);
        $stock = $stocks->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $stock = Stock::factory()->create();

        $response = $this->get(route('stocks.show', $stock));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\StockController::class,
            'update',
            \App\Http\Requests\StockUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $stock = Stock::factory()->create();
        $name = $this->faker->name();
        $symbol = $this->faker->word();
        $open = $this->faker->randomFloat(/** decimal_attributes **/);
        $high = $this->faker->randomFloat(/** decimal_attributes **/);
        $low = $this->faker->randomFloat(/** decimal_attributes **/);
        $close = $this->faker->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('stocks.update', $stock), [
            'name' => $name,
            'symbol' => $symbol,
            'open' => $open,
            'high' => $high,
            'low' => $low,
            'close' => $close,
        ]);

        $stock->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $stock->name);
        $this->assertEquals($symbol, $stock->symbol);
        $this->assertEquals($open, $stock->open);
        $this->assertEquals($high, $stock->high);
        $this->assertEquals($low, $stock->low);
        $this->assertEquals($close, $stock->close);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $stock = Stock::factory()->create();

        $response = $this->delete(route('stocks.destroy', $stock));

        $response->assertNoContent();

        $this->assertModelMissing($stock);
    }
}
