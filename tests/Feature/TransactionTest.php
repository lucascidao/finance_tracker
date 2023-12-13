<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndexIncome(): void
    {
        $response = $this->get('api/transaction/indexIncome');
        
        $response->assertStatus(200);
    }
    public function testIndexExpense(): void
    {
        $response = $this->get('api/transaction/indexExpense');

        $response->assertStatus(200);
    }
    public function testStore(): void
    {
        $data =[
            'amount' => $this->faker->numberBetween(1, 1000),
            'description' => $this->faker->text(100),
            'transaction_date' => $this->faker->date(),
            'type' => $this->faker->randomElement(['income', 'expense']),
        ];
        $response = $this->post('api/transaction/store', $data);

        $response->assertSuccessful();
    }
    public function testUpdate()
    {
        $transaction = Transaction::factory()->create();
        $updateData = [
            'amount' => $this->faker->numberBetween(1, 1000),
            'description' => $this->faker->text(100),
            'transaction_date' => $this->faker->date(),
            'type' => $this->faker->randomElement(['income', 'expense']),
        ];
        $response = $this->post("api/transaction/update/" . $transaction->id, $updateData);
        $response->assertSuccessful();
        $this->assertDatabaseHas('transactions', $updateData);
    }
    public function testDelete(): void
    {
        $transaction = Transaction::factory()->create();
        $response = $this->delete('api/transaction/' . $transaction->id);
        $response->assertSuccessful();
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }
    public function testExpenseData(): void
    {
        $response = $this->get('api/transaction/expenseData');

        $response->assertStatus(200);
    }
    public function testTransactionByMonth(): void
    {
        $response = $this->get('api/transaction/transactionByMonth');

        $response->assertStatus(200);
    }
    public function testLastMonths(): void
    {
        $response = $this->get('api/transaction/lastMonths');

        $response->assertStatus(200);
    }
}
