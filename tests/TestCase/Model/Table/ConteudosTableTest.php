<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConteudosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConteudosTable Test Case
 */
class ConteudosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConteudosTable
     */
    protected $Conteudos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Conteudos',
        'app.Playlists',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Conteudos') ? [] : ['className' => ConteudosTable::class];
        $this->Conteudos = $this->getTableLocator()->get('Conteudos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Conteudos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ConteudosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ConteudosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
