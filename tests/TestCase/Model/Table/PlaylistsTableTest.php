<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlaylistsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlaylistsTable Test Case
 */
class PlaylistsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlaylistsTable
     */
    protected $Playlists;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Playlists',
        'app.Conteudos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Playlists') ? [] : ['className' => PlaylistsTable::class];
        $this->Playlists = $this->getTableLocator()->get('Playlists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Playlists);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PlaylistsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
