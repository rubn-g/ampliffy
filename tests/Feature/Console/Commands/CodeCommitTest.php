<?php

namespace Tests\Feature\Console\Commands;

use Tests\TestCase;

class CodeCommitTest extends TestCase {

    public function testNotOwnedRepo()
    {
        $this->artisan('code:commit testlib 3 dev')->expectsOutputToContain('not owned by the company');
    }
}
