<?php

declare(strict_types=1);

use App\Models\Root;
use DragonCode\LaravelDeployOperations\Operation;

return new class extends Operation
{
    /**
     * Executes the operations to apply changes during deployment.
     * Implement the logic for the "up" operation here.
     */
    public function up(): void
    {
        Root::solid('root')->create([
            'title' => 'New website',
        ]);
    }

    /**
     * Reverts the changes made in the "up" operation.
     * Implement the logic for the "down" operation here.
     */
    public function down(): void
    {
        Root::query()->delete();
    }
};
